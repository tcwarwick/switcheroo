<?php

function Switcheroo_SettingsMenu()
{
    add_options_page(
        __('Switcheroo Settings'),
        __('Switcheroo'),
        'manage_options',
        'switcheroo_settings',
        function () {

            if (!current_user_can('manage_options')) {
                wp_die(__('You are not allowed to make changes to the settings.'));
            }

            require_once 'settings-page.php';

        }
    );
}
add_action('admin_menu', 'Switcheroo_SettingsMenu');

function Switcheroo_SettingsOptions()
{
    register_setting(
        'switcheroo_settings',
        'switcheroo_words',
        function ($value) {

            $data = [];

            $lines = explode(PHP_EOL, $value);

            foreach ($lines as $line) {
                $words = explode(',', $line);
                $data[] = [
                    'original' => trim($words[0]),
                    'replacement' => trim($words[1]),
                ];
            }

            return $data;
        }
    );

    add_settings_section(
        'switcheroo_settings_general',
        __('Words'),
        function () {
            echo
                '<p>' .
                __('The word to replace and their replacements. Place each word and its replacement on an individual line, separated by a comma. For example;') .
                '<br>jerky,biltong<br>ketchup,tomato sauce<br>jelly,jam' .
                '</p>';
        },
        'switcheroo_settings'
    );

    add_settings_field(
        'switcheroo_words',
        __('Words'),
        function () {

            $value = '';

            $data = maybe_unserialize(get_option( 'switcheroo_words' )) ?? [];

            foreach ($data as $datum) {
                $value .= sprintf("%s,%s%s", $datum['original'], $datum['replacement'], PHP_EOL);
            }

            echo '<textarea name="switcheroo_words" id="switcheroo_words" class="regular-text" rows="10">' . $value . '</textarea>';

        },
        'switcheroo_settings',
        'switcheroo_settings_general'
    );
}
add_action('admin_init', 'Switcheroo_SettingsOptions');
