<?php
namespace Configuration\Deploy;

class RemotSample extends Common
{


    public function initialize()
    {
        parent::initialize();
        $this->host
            ->hostname('somewhere.com')
            ->set('branch', 'master')


            ->set('application', static::APPLICATION_NAME)

            // Project repository
            ->set('repository', static::GIT_REPOSITORY)




            ->set('current_release_filepath', '{{deploy_path}}/current/' . static::WORDPRESS_PUBLIC_FOLDER)
            ->set('site_filepath', '{{deploy_path}}/' . static::WORDPRESS_PUBLIC_FOLDER)


            ->set('rsync_src', __DIR__ . '/' . static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/themes/sample/assets/dist')
            ->set('rsync_dest','{{release_path}}/' . static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/themes/sample/assets/dist')



            ->set('shared_dirs', [
                static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/uploads',
                static::WORDPRESS_PUBLIC_FOLDER . '/vendor',
            ])

            ->set('shared_dirs', [
                static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/uploads',
                static::WORDPRESS_PUBLIC_FOLDER . '/vendor',
            ])

            ->set('writable_mode', 'chgrp')
            ->set('http_group', 'www-data')
            ->set('http_user', 'www-data')

            ->set('writable_dirs', [
                '{{release_path}}/' . static::WORDPRESS_PUBLIC_FOLDER . '/vendor',
                '{{release_path}}/' . static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/uploads',
                '{{deploy_path}}/shared/' . static::WORDPRESS_PUBLIC_FOLDER . '/wp-content/uploads',
            ]);
        ;
        return $this->host;
    }



}