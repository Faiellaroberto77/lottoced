<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
require("fnc_lotto/global.php");
function hello_elementor_child_enqueue_scripts()
{
	wp_enqueue_style('hello-elementor-child-style', get_stylesheet_directory_uri() . '/style.css',['hello-elementor-theme-style',],'1.0.0');
	wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/master.min.js', array( 'jquery' ));
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);

function ele_disable_page_title($return)
{
	return false;
}
add_filter('hello_elementor_page_title', 'ele_disable_page_title');



// Inserisce titolo e descrizione nella pagina.
function seo_head()
{
	$id = get_the_ID();
	$post = get_post($id, ARRAY_A);
	$yoast_title = get_post_meta($id, '_yoast_wpseo_title', true);
	$yoast_desc = get_post_meta($id, '_yoast_wpseo_metadesc', true);
	$metatitle_val = wpseo_replace_vars($yoast_title, $post);
	$metatitle_val = apply_filters('wpseo_title', $metatitle_val);
	$metadesc_val = wpseo_replace_vars($yoast_desc, $post);
	$metadesc_val = apply_filters('wpseo_metadesc', $metadesc_val);
	$metatitle_val = str_replace("| LottoCED", "", $metatitle_val);
	return '
			<h1>'. $metatitle_val .'</h1>
			<p>'. $metadesc_val .'</p>';
}
add_shortcode("seo_head","seo_head" );
?>