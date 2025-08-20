<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="bg-white border-b border-gray-300 p-5">
        <div class="max-w-screen-lg mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <?php
                if (function_exists("the_custom_logo")) {
                    add_filter('get_custom_logo', 'add_logo_classes');
                    function add_logo_classes($html)
                    {
                        $html = str_replace('class="custom-logo"', 'class="custom-logo w-12"', $html);
                        return $html;
                    }
                    the_custom_logo();
                }
                wp_nav_menu([
                    "theme_location" => "header-right",
                    "menu_class" => "flex gap-3",
                    "container" => false,
                ])
                ?>
            </div>
            <div class="flex items-center gap-3">
                <?php
                wp_nav_menu([
                    "theme_location" => "header-left",
                    "menu_class" => "flex gap-3",
                    "container" => false,
                ])
                ?>
                <i class="ri-shopping-cart-2-line text-2xl"></i>
            </div>
        </div>
    </header>