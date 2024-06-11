<?php

/*
Theme Name: Calculator Theme
Description: A simple calculator theme with Gutenberg block.
Author: Your Name
Version: 1.0
*/

function calculator_theme_setup() {
    // Enqueue styles and scripts
    wp_enqueue_style('calculator-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('calculator-script', get_template_directory_uri() . '/calculator.js', array('jquery'), null, true);

    // Register ACF block
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'calculator',
            'title'             => __('Calculator'),
            'render_callback'   => 'calculator_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'calculator',
            'keywords'          => array('calculator', 'math', 'block'),
        ));
    }
}
add_action('init', 'calculator_theme_setup');

function calculator_block_render_callback($block) {
    include get_theme_file_path('/template-parts/block-calculator.php');
}

// Save calculation to CSV
function save_calculation() {
    if(isset($_POST['calculation'])) {
        $calculation = sanitize_text_field($_POST['calculation']);
        $result = sanitize_text_field($_POST['result']); 
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $file = fopen(get_template_directory() . '/calculations.csv', 'a');
        fputcsv($file, array($date, $ip, $calculation, $result));
        fclose($file);
    }
    wp_die();
}
add_action('wp_ajax_save_calculation', 'save_calculation');
add_action('wp_ajax_nopriv_save_calculation', 'save_calculation');
?>