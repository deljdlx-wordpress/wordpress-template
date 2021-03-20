<?php
namespace Woof;
use Woof\Theme\Skeleton;

use DelJDLX\Woof\Theme\Customizer\Section;
use DelJDLX\Woof\Theme\Customizer\ThemeParameter;

class Theme extends Skeleton
{

    protected $parameters = [
        'typography-font-family-default' => [
            'defaultValue' => 'verdana, helvetica, sans-serif',
            'instance' => null,
        ],
        'typography-font-size-default' => [
            'defaultValue' => '16px',
        ],
        'typography-font-size-biggest' => [
            'defaultValue' => '2rem',
        ],
        'typography-font-size-big' => [
            'defaultValue' => '1.5rem',
            'instance' => null,
        ],
        'typography-font-size-small' => [
            'defaultValue' => '0.75rem',
            'instance' => null,
        ],
        'typography-font-size-smallest' => [
            'defaultValue' => '0.5rem',
            'instance' => null,
        ],

        'layout-gutter-default' => [
            'defaultValue' => '16px',
            'instance' => null,
        ],

        'layout-padding-default' => [
            'defaultValue' => '1rem',
            'instance' => null,
        ],

        'layout-border-default-width' => [
            'defaultValue' => '1px',
            'instance' => null,
        ],


        'layout-border-default-color' => [
            'defaultValue' => '#000',
            'instance' => null,
        ],

        'color-background-default' => [
            'defaultValue' => '#ccc',
            'instance' => null,
        ],
        'color-foreground-default' => [
            'defaultValue' => '#000',
            'instance' => null,
        ],

        'color-background-00' => [
            'defaultValue' => 'transparent',
            'instance' => null,
        ],
        'color-foreground-00' => [
            'defaultValue' => '#000',
            'instance' => null,
        ],


        'color-background-header-00' => [
            'defaultValue' => '#ccc',
            'instance' => null,
        ],
        'color-foreground-header-00' => [
            'defaultValue' => '#000',
            'instance' => null,
        ],

    ];

    protected $customizerSections = [
        'layout' => [
            'caption' => 'Layout',
            'order' => 10,
            'description' => 'Layout rules',
        ],
        'typography' => [
            'caption' => 'Typography',
            'order' => 10,
            'description' => 'Typography rules',
        ],
        'color' => [
            'caption' => 'Colors',
            'order' => 10,
            'description' => 'Theme colors',
        ],
    ];

    protected $customizers = [
        'typography-font-family-default' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Default font family',
            'section' => 'typography',
        ],
        'typography-font-size-default' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Default font size',
            'section' => 'typography',
        ],
        'typography-font-size-biggest' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Biggest font size',
            'section' => 'typography',
        ],
        'typography-font-size-big' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Big font size',
            'section' => 'typography',
        ],

        'typography-font-size-small' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Small font size',
            'section' => 'typography',
        ],
        'typography-font-size-smallest' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Smallest font size',
            'section' => 'typography',
        ],

        //===========================================================
        // Layout
        //===========================================================

        'layout-gutter-default' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Gutter default size',
            'section' => 'layout',
        ],

        'layout-padding-default' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Default padding',
            'section' => 'layout',
        ],

        'layout-border-default-width' => [
            'type' => \Woof\Theme\Customizer\CSSVariable::class,
            'caption' => 'Border default width',
            'section' => 'layout',
        ],

        'layout-border-default-color' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Border default color',
            'section' => 'layout',
        ],

        //===========================================================
        // Colors
        //===========================================================

        'color-background-default' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Background default color',
            'section' => 'color',
        ],
        'color-foreground-default' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Foreground default color',
            'section' => 'color',
        ],

        'color-background-00' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Background 00 color',
            'section' => 'color',
        ],
        'color-foreground-00' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Foreground 00 color',
            'section' => 'color',
        ],


        'color-background-header-00' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Background header color',
            'section' => 'color',
        ],
        'color-foreground-header-00' => [
            'type' => \Woof\Theme\Customizer\Color::class,
            'caption' => 'Foreground header color',
            'section' => 'color',
        ],
    ];

    public function registerAssets()
    {

        $this->registerScript(
            'woof-js',
            'assets/javascript/woof.js'
        );
        $this->registerCSS(
            'reset-css',
            'assets/css/reset.css'
        );

        $this->registerCSS(
            'woof-css',
            'assets/css/woof.css',
            ['reset-css']
        );
        return $this;
    }


}