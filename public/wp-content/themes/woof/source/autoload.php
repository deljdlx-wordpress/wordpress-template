<?php

spl_autoload_register(function ($calledClassName) {

    $normalizedClassName = preg_replace('`^\\\\`', '', $calledClassName);

    if(strpos($normalizedClassName, 'Woof') === 0) {

        $relativeClassName = str_replace('Woof', '', $normalizedClassName);
        $relativePath = str_replace('\\', '/', $relativeClassName);
        $definitionClass = __DIR__.''.$relativePath.'.php';
        if(is_file($definitionClass)) {
            include($definitionClass);
        }
    }
});