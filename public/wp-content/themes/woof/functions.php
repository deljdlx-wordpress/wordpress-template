<?php
use Woof\Theme;

require __DIR__.'/vendor/woof/autoload.php';
require __DIR__.'/source/autoload.php';


$theme = new Theme();
$theme->register();

$GLOBALS['WOOF_THEME'] = $theme;



