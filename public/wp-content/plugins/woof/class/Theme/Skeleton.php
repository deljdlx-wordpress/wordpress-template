<?php
namespace Woof\Theme;


use Woof\Theme\Customizer\Section;
use Woof\Theme\Customizer\ThemeParameter;

use function Woof\slugify;

class Skeleton
{
    protected $css = [];

    protected $view;
    protected $model;

    // https://developer.wordpress.org/reference/functions/add_theme_support/
    protected $features = [
        'title-tag',
        'post-thumbnails',
        'menus'
    ];

    protected $parameters = [];

    protected $customizerSections = [];

    protected $customizers = [];

    //===========================================================
    //
    //===========================================================
    public static function getInstance()
    {
        return $GLOBALS['WOOF_THEME'];
    }

    public function __construct()
    {
        $this->view = new Template();
        $this->model = new Loop();
    }

    public function getView() {
        return $this->view;
    }

    public function getModel() {
        return $this->model;
    }

    public function partial($file, $slug = null, $data = [])
    {
        if($slug === null) {
            $slug = slugify($file);
        }
        return get_template_part($file, $slug, $data);
    }


    public function register()
    {
        $GLOBALS['WOOF_THEME'] = $this;

        $this->enableFeatures();
        $this->registerParameters();
        $this->registerCustomizersSections();
        $this->registerCustomizers();
        add_action('wp_enqueue_scripts', [$this, 'registerAssets']);

    }


    public function registerAssets()
    {
        return $this;
    }


    public function registerCustomizersSections()
    {
        foreach($this->customizerSections as $sectionId => &$descriptor) {
            $section = new Section(
                $sectionId,
                $descriptor['caption'],
                $descriptor['order'],
                $descriptor['description']
            );
            $this->customizerSections[$sectionId]['instance'] = $section;
            $section->register();
        }

        return $this;
    }

    public function getParameters()
    {
        $parameters = [];
        foreach($this->parameters as $index => $descriptor) {
            $parameters[$index] = $descriptor['instance'];
        }
        return $parameters;
    }

    public function getParameter($name)
    {
        return $this->parameters[$name]['instance'];
    }

    public function registerParameters()
    {


        foreach($this->parameters as $paramenterName => $descriptor) {
            $parameter = new ThemeParameter($paramenterName, $descriptor['defaultValue']);
            $this->parameters[$paramenterName]['instance'] = $parameter;
        }

        return $this;
    }


    protected function registerCustomizers()
    {
        foreach($this->customizers as $parameterName => $descriptor) {
            $control = $descriptor['type'];
            $customizer = new $control(
                $this->parameters[$parameterName]['instance'],
                $descriptor['caption']
            );
            $customizer->setSection($this->customizerSections[$descriptor['section']]['instance']);
            $customizer->register();
        }
        return $this;
    }



    protected function registerScript($name, $path, $dependencies = [], $version = null, $inFooter = true)
    {
        wp_enqueue_script(
            $name,
            get_theme_file_uri($path),
            $dependencies,
            $version,
            $inFooter
        );
    }



    protected function registerCSS($name, $path, $dependencies = [], $version = '1')
    {
        wp_enqueue_style(
            $name,
            get_theme_file_uri($path),
            $dependencies,
            $version
        );
    }


    protected function enableFeatures()
    {
        foreach($this->features as $feature) {
            add_theme_support($feature);
        }
    }
}