<?php
/*
Plugin Name: Switcheroo
Plugin URI:  https://warwickanderson.com/plugins/switcheroo
Description: Plugin for replacing certain words with others.
Version:     0.1.0
Author:      Warwick Anderson
Author URI:  https://warwickanderson.com/
License:     Copyright 2021 Warwick Anderson
License URI: https://warwickanderson.com/legal/
*/

require_once 'settings.php';

function Switcheroo_Activate()
{
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'Switcheroo_Activate');

function Switcheroo_Deactivate()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'Switcheroo_Deactivate');

function Switcheroo_Replace($content) {

    $words = maybe_unserialize(get_option( 'switcheroo_words' )) ?? [];

    foreach ($words as $word) {
        $expression = sprintf('/%s/m', $word['original']);
        $content = preg_replace($expression, $word['replacement'], $content);
    }

    return $content;

}
add_filter('the_content', 'Switcheroo_Replace', 1);
