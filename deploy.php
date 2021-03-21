<?php
// DOC php deployer https://deployer.org/
/* DOC installer php deployer
curl -LO https://deployer.org/deployer.phar
sudo mv deployer.phar /usr/local/bin/dep
sudo chmod +x /usr/local/bin/dep
*/

namespace Deployer;
require 'recipe/common.php';
require __DIR__ . '/static-vendor/autoload.php';
require 'recipe/rsync.php';



if(!is_file(__DIR__. '/deploy-configuration.php')) {

    echo 'You have to create a "deploy-configuration.php" at the root of your project. You can use "deploy-configuration-sample.php" as a template file' . "\n";
    exit();
}

require __DIR__. '/deploy-configuration.php';

// ===========================================================================
// fin configuration
// ===========================================================================
// Project name
// set('application', APPLICATION_NAME);

// Project repository
// set('repository', GIT_REPOSITORY);

// [Optional] Allocate tty for git clone. Default value is false.
// set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server
set('writable_dirs', []);



// Tasks =====================================================================

task('build', [
    'loadConfiguration',
    'deploy:info',
    'deploy:prepare',
    // 'deploy:lock',
    'deploy:release',
    'deploy:update_code',

    'deploy:shared',
    'deploy:writable',

    // 'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    // 'deploy:unlock',
    'cleanup',
    'success',

    'makeSymlink',
    'composer',
    'createConfiguration',
]);

desc('Deploy your project');

task('deploy', [
    'build',
    'createConfiguration',
    // 'sendAssets',
    'buildHtaccess',
    // 'chmod',
    'uploads',
    'informations'
]);
// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


task('install', [
    'build',
    'installWordpress',
    'buildHtaccess',
    // 'chmod',
    'activatePlugins',
    // 'sendAssets',
    'informations',
]);


task('installAll', [
    'installRequirements',
    'build',

    'createBDD',
    'installWordpress',
    'buildHtaccess',
    'chmod',
    'activatePlugins',
    // 'sendAssets',
    'informations',
]);



task('reinstallAll', [
    'loadConfiguration',
    'dropDatabase',
    'installAll'
]);



task('reset', [
    'loadConfiguration',
    'removeFiles',
    'dropDatabase',
    'installAll'
]);


//===========================================================
// tâches de dev local
//===========================================================
task('installDevelopment', [
    'installRequirements',
    'loadConfiguration',
    'composer',
    'createConfiguration',
    'createBDD',
    'installWordpress',
    'chmod',
    'buildHtaccess',
    'activatePlugins',
    'informations',
]);

task('resetDevelopment', [
    'loadConfiguration',
    'localUninstall',
    'dropDatabase',
    'composer',

    'createConfiguration',
    'createBDD',
    'installWordpress',
    'chmod',
    'buildHtaccess',
    'activatePlugins',
    'informations',
]);


task('localUninstall', function() {
    cd('{{site_filepath}}');
    run('sudo rm -rf vendor wp composer.lock');
});

//===========================================================
// tâches communes
//===========================================================

task('uploads', function() {
    // cd('{{site_filepath}}');
    // run('sudo chmod -R 775 wp-content/themes');
    foreach(get('uploads') as $source) {
        upload($source, '{{release_path}}' . dirname($source));
    }


});
// before('sendAssets', 'rsync');


task('loadConfiguration', function() {
    if(!defined('WP_CONFIGURATION_FILE')) {
        define('WP_CONFIGURATION_FILE', get('wp_configuration'));
        require __DIR__ . '/configuration/' . WP_CONFIGURATION_FILE;
    }
});

task('composer', function() {
    cd('{{site_filepath}}');
    run('composer install');
});


task('createConfiguration', function() {
    upload(__DIR__ . '/configuration/' . WP_CONFIGURATION_FILE, '{{site_filepath}}/configuration-current.php');
});
before('createConfiguration', 'loadConfiguration');


task('makeSymlink', function () {
    writeln('Create symlink : "{{current_release_filepath}}" to "{{site_filepath}}"' );
    run('ln -s {{current_release_filepath}} {{site_filepath}}');
});

task('chmod', function() {
    cd('{{site_filepath}}');
    run('composer run chmod');
    run('sudo chmod -R 775 wp-content');
});

task('buildHtaccess', function() {
    cd('{{site_filepath}}');
    run('composer run activate-htaccess');
    run ("echo 'RewriteCond %{HTTP:Authorization} ^(.*)' >> ./.htaccess");
    run ("echo 'RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]' >> ./.htaccess");
    run ("echo 'SetEnvIf Authorization \"(.*)\" HTTP_AUTHORIZATION=$1' >> ./.htaccess");
});

task('downloadUploads', function() {
    download('{{site_filepath}}/wp-content/uploads/', __DIR__ . '/public/wp-content/uploads');
    cd('{{site_filepath}}');
    run('sudo chmod -R 775 {{site_filepath}}/wp-content/uploads');
    upload(__DIR__ . '/public/wp-content/uploads/', '{{site_filepath}}/wp-content/uploads');
});

task('sendUploads', function() {
    cd('{{site_filepath}}');
    run('sudo chmod -R 775 {{site_filepath}}/wp-content/uploads');
    upload(__DIR__ . '/public/wp-content/uploads/', '{{site_filepath}}/wp-content/uploads');
});



//===========================================================
// tâches d'installation
//===========================================================

task('installRequirements', function() {
    if(test('[ ! -f "/usr/local/bin/wp" ]')) {
        run('curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && sudo mv wp-cli.phar /usr/local/bin/wp');
    }
    if(test('[ ! -f "/usr/local/bin/composer" ]')) {
        run('cd /tmp && php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');" && php composer-setup.php --quiet && sudo mv composer.phar /usr/local/bin/composer');
    }
});


task('createBDD', function() {
    run('mysql -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' --execute="CREATE DATABASE '.DB_NAME.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"');
});
before('createBDD', 'loadConfiguration');

task('dropTables', function() {
    run('mysql -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' --execute='.
        'use '.DB_NAME.';' .
        'DROP TABLE `' . WP_TABLE_PREFIX . 'term_relationships`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'terms`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'termmeta`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'users`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'usermeta`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'term_taxonomy`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'links`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'comments`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'commentmeta`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'posts`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'postmeta`;'.
        'DROP TABLE `' . WP_TABLE_PREFIX . 'options`;'.
    '"');
});

before('dropTables', 'loadConfiguration');




task('installWordpress', function() {
    cd('{{site_filepath}}');
    run('wp core install --url="' . WP_HOME . '" --title="'.SITE_NAME.'" --admin_user="'.BO_USER.'" --admin_password="'.BO_PASSWORD.'" --admin_email="'.BO_EMAIL.'" --skip-email;');
});
before('installWordpress', 'loadConfiguration');


task('activatePlugins', function() {
    cd('{{site_filepath}}');
    // run('sudo chown -R $USER wp-content/uploads');
    run('composer run activate-plugins');
    // run('composer run activate-theme benouze');
});

task('informations', function() {
    writeln('Wordpress installed : ' . WP_HOME);
    writeln('Backoffice : ' . WP_SITEURL . '/wp-admin');
});
before('informations', 'loadConfiguration');

//===========================================================

task('synchronizeProduction', function() {
    cd('{{site_filepath}}');
    run('composer run chmod');
    run('sudo chown -R {{user}} wp-content/uploads');
    run('git add . && git commit -m "synchronize production" && git push');
    runLocally('git pull');
});


task('parcel', function() {
    // runLocally('cd {{site_filepath}}/wp-content/themes/benouze/assets && parcel build --no-minify --public-url . javascript/main.js');
});


task('yoloMep', [
    'prepareMep',
    'deploy'
]);

task('ls', function() {
    cd('{{site_filepath}}');
    run('ls -al', [
        'tty' => true
    ]);
});


task('prepareMep', function() {
    runLocally('dep parcel development && git checkout production && git merge develop && git checkout develop');
});




task('removeFiles', function() {
    cd('{{deploy_path}}');
    run('sudo rm -rf .dep back releases/ shared/ current');
});


task('dropDatabase', function() {
    run('mysql -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' --execute="DROP DATABASE '.DB_NAME.' "');
});
before('dropDatabase', 'loadConfiguration');
