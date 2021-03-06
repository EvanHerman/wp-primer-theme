<?php

/**
 * Enable support for WooCommerce.
 *
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @action after_setup_theme
 */
function primer_woocommerce_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_woocommerce_setup' );

/**
 * Remove the default WooCommerce page wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 */
function primer_woo_wrapper_start() {

	?>
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<article class="primer-woocommerce hentry">
	<?php

}
add_action( 'woocommerce_before_main_content', 'primer_woo_wrapper_start', 10 );

/**
 * Markup for page wrapper end.
 *
 * @action woocommerce_after_main_content
 */
function primer_woo_wrapper_end() {

	?>
	</article></main></div>
	<?php

}
add_action( 'woocommerce_after_main_content', 'primer_woo_wrapper_end', 10 );

/**
 * Filter the layout for the WooCommerce shop page.
 *
 * @param  string $layout
 *
 * @return string
 */
function primer_woo_shop_layout( $layout ) {

	if ( function_exists( 'wc_get_page_id' ) && function_exists( 'is_shop' ) && is_shop() ) {

		remove_filter( 'theme_mod_layout', __FUNCTION__ ); // Prevent infinite loop

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'theme_mod_layout', 'primer_woo_shop_layout' );

/**
 * Display the shop messages on the page
 *
 * @return mixed
 *
 * @since 1.0.0
 */
function primer_woo_shop_messages() {

	if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {

		echo wp_kses_post( do_shortcode( '[woocommerce_messages]' ) );

	}

}
add_action( 'primer_before_page_content', 'primer_woo_shop_messages' );
add_action( 'primer_before_post_content', 'primer_woo_shop_messages' );

/**
 * Filter the page title for the WooCommerce shop page.
 *
 * @filter primer_the_page_title
 *
 * @param  string $title
 *
 * @return string
 *
 * @since 1.0.0
 */
function primer_woo_shop_title( $title ) {

	if ( function_exists( 'wc_get_page_id' ) && function_exists( 'is_shop' ) && is_shop() ) {

		$title = get_the_title( wc_get_page_id( 'shop' ) );

		// Remove the WooCommerce shop loop title
		add_filter( 'woocommerce_page_title', '__return_null' );

	}

	return $title;

}
add_filter( 'primer_the_page_title', 'primer_woo_shop_title' );
