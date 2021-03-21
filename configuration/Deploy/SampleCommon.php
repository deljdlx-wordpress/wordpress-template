<?php

namespace Configuration\Deploy;

use Deljdlx\DeployConfiguration;

class CommonSample extends DeployConfiguration
{
    const GIT_REPOSITORY = 'git@github.com:deljdlx/wordpress-template.git';
    const GIT_BRANCH = 'master';

    const APPLICATION_NAME = 'WP Sample';
    const SITE_NAME = 'WP Sample - minimal Wordpress installation with vuejs';
    const BO_USER = 'WP_ADMIN_USER';
    const BO_PASSWORD = 'WP_ADMIN_PASSWORD';
    const BO_EMAIL = 'WP_ADMIN_EMAIL@mail.com';
    const WORDPRESS_PUBLIC_FOLDER = 'public';
}