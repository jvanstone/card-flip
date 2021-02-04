<?php
// add the admin options page
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() {
add_options_page('Card Flip', 'Card Flip Menu', 'manage_options', 'card-flip', 'cf_options_page');
}


function cf_options_page() { ?>
<div>
<h2>Card Flip plugin</h2>
Options relating to the Custom Plugin.
<form action="options.php" method="post">
<?php settings_fields('cf_plugin_options'); ?>
<?php do_settings_sections('plugin'); ?>
 
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form></div>
 
<?php } ?>

<?php

// add the admin settings and such
add_action('admin_init', 'plugin_admin_init');
function cf_admin_init(){
register_setting( 'cf_plugin_options', 'cf_plugin_options', 'plugin_options_validate' );
add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'plugin');
add_settings_field('plugin_text_string', 'Plugin Text Input', 'plugin_setting_string', 'plugin', 'plugin_main');
}

function plugin_setting_string() {
    $options = get_option('cf_plugin_options');
    echo "<input id='plugin_text_string' name='cf_plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
} 

// validate our options
function plugin_options_validate($input) {
    $newinput['text_string'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
    $newinput['text_string'] = '';
    }
    return $newinput;
    }
?>