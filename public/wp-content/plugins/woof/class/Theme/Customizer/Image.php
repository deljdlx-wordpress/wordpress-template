<?php

namespace Woof\Theme\Customizer;
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/
 * @since MyTheme 1.0
 */

class Image extends Customizer
{
    const MOD_NAME = 'image';


    protected $caption = 'Choose an image';


    public function register()
    {
        parent::register();
        add_action('wp_footer', [$this, 'generateJS'], 100);
    }


    /**
     * This hooks into 'customize_register' (available as of WP 3.4) and allows
     * you to add new sections and controls to the Theme Customize screen.
     *
     * Note: To enable instant preview, we have to actually write a bit of custom
     * javascript. See live_preview() for more.
     *
     * @see add_action('customize_register',$func)
     * @param \WP_Customize_Manager $wp_customize
     * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
     * @since MyTheme 1.0
     */
    public function hookRegister($wp_customizer)
    {
        // parent::hookRegister($wp_customizer);


        //2. Register new settings to the WP database...
        $this->customizer->add_setting(
            $this->getName(), //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
            [
                'default' => $this->getDefaultValue(), //Default setting/value to save
                'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            ]
        );


        //$test = new \WP_Customize_Widgets()

        $this->customizer->add_control(new \WP_Customize_Image_Control( //Instantiate the color control class
            $this->customizer, //Pass the $wp_customize object (required)
            $this->getName(), //Set a unique ID for the control
            [
                'label' => __($this->getCaption()), //Admin-visible name of the control
                'settings' => $this->getName(), //Which setting to load and manipulate (serialized is okay)
                'priority' => 10, //Determines the order this control appears in for the specified section
                'section' => $this->getSectionId(), //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            ]
        ));


        $this->customizer->selective_refresh->add_partial(
            $this->getName(), [
            'selector' => $this->getPreviewQuerySelector(),
            'container_inclusive' => true,
            'fallback_refresh'    => false,  // Prevents refresh loop when document does not contain selector
           /*
           'render_callback' => function() {

                // return 'hello world';
               // return get_theme_mod(static::MOD_NAME);
           },
           */
            ]
        );
    }

    public function generateJS()
    {
        echo '<script>' . PHP_EOL;
        echo 'document.addEventListener("DOMContentLoaded", function() {' . PHP_EOL;
            echo 'wp.customize( "' . $this->getName() . '", function( value ) {' . PHP_EOL;
                echo 'value.bind( function( newValue ) {' . PHP_EOL;
                    // echo "console.log(newValue);" . PHP_EOL;
                    echo $this->getPreviewUpdateCode();
                    //echo "document.querySelector('.hero__item.set-bg').style.backgroundImage = 'url(' + newValue + ')';"  . PHP_EOL;
                echo "});" . PHP_EOL;
            echo "});" . PHP_EOL;
        echo "});" . PHP_EOL;
        echo '</script>' . PHP_EOL;
    }



}
