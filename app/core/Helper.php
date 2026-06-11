<?php

class Helper
{
    public static function getPageTitle(): string
    {
        $script = $_SERVER['SCRIPT_NAME'];
        $page = ucfirst(basename($script, '.php'));
        return 'Zay Shop - ' . $page;
    }
//Zay Shop eCommerce HTML CSS Template
}