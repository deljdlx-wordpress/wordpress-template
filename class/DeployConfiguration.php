<?php

namespace Deljdlx;

class DeployConfiguration
{


    const GIT_REPOSITORY = '';
    const GIT_BRANCH = 'master';

    const APPLICATION_NAME = '';
    const SITE_NAME = '';
    const BO_USER = '';
    const BO_PASSWORD = '';
    const BO_EMAIL = '';
    const WORDPRESS_PUBLIC_FOLDER = '';


    protected $local;
    protected $name;
    protected $host;

    public function __construct($name, $local = false)
    {
        $this->name = $name;
        $this->local = $local;
        if(!$this->local) {
            $this->host = \Deployer\host($name);
        }
        else {
            $this->host = \Deployer\localhost($name);
        }

        $this->initialize();
    }

    public function initialize()
    {
        $this->host
            // [Optional] Allocate tty for git clone. Default value is false.
            ->set('git_tty', true)
            ->set('allow_anonymous_stats', false)

            ->set('application', static::APPLICATION_NAME)
            // Project repository
            ->set('repository', static::GIT_REPOSITORY)

            ->set('APPLICATION_NAME', static::APPLICATION_NAME)
            ->set('SITE_NAME', static::SITE_NAME)
            ->set('BO_USER', static::BO_USER)
            ->set('BO_PASSWORD', static::BO_PASSWORD)
            ->set('BO_EMAIL', static::BO_EMAIL)
            ->set('WORDPRESS_PUBLIC_FOLDER', static::WORDPRESS_PUBLIC_FOLDER)
        ;

        return $this->host;
    }


    public function __call($method, $arguments)
    {
        return call_user_func_array([$this, $method], $arguments);
    }

    public function enableSudo()
    {
        $this->host
            ->set('clear_use_sudo', true)
            ->set('writable_use_sudo', true)
        ;
    }



}