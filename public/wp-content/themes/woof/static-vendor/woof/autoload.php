<?php

spl_autoload_register(function ($calledClassName) {

    $normalizedClassName = preg_replace('`^\\\\`', '', $calledClassName);

    if(strpos($normalizedClassName, 'DelJDLX\Woof\Theme') === 0) {

        $relativeClassName = str_replace('DelJDLX\Woof\Theme', '', $normalizedClassName);
        $relativePath = str_replace('\\', '/', $relativeClassName);
        $definitionClass = __DIR__.'/Theme/'.$relativePath.'.php';
        if(is_file($definitionClass)) {
            include($definitionClass);
        }
    }
});