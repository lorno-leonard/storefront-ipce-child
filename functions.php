<?php
add_action( 'wp_enqueue_scripts', 'ipce_theme_enqueue_styles' );
function ipce_theme_enqueue_styles() {
	$parent_style = 'storefront-style'; // This is 'storefront-style' for the Storefront theme.

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'storefront-ipce-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get('Version')
	);
}

// Remove actions/filters
add_action( 'init', 'ipce_remove_sf_actions' );
function ipce_remove_sf_actions() {
	remove_action( 'storefront_header', 'storefront_site_branding' );
	remove_action( 'storefront_content_top', 'woocommerce_breadcrumb' );
	// remove_action( 'storefront_header', 'storefront_header_cart' );
	// remove_action( 'storefront_header', 'storefront_product_search' );
}

// Override Header
function storefront_site_branding() {
	?>
	<div class="site-branding">
		<?php storefront_site_title_or_logo(); ?>
	</div>
	<div class="ipce_header_site_motto">
		<div class="content">Engineering Excellence Is Our Standard</div>
	</div>
	<div class="ipce_header_site_contact">
		<div class="content">
			<div>
				<strong><i class="fa fa-phone"></i> 00441332496117</strong>
			</div>
			<div>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/blank.gif" class="flag flag-gb" alt="Great Britain" />
				<small>United Kingdom</small>
			</div>
		</div>
	</div>
	<?php
}

// Register Sidebars
add_action( 'widgets_init', 'ipce_register_sidebars' );
add_action( 'ipce_action_second_sidebar', 'ipce_render_second_sidebar' );
function ipce_register_sidebars(){
	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'storefront' ),
		'id' => 'sidebar-2',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<span class="gamma widget-title">',
		'after_title' => '</span>'
	) );
}
function ipce_render_second_sidebar() {
	if ( ! is_active_sidebar( 'sidebar-2' ) || is_user_logged_in() ) {
		return;
	}
	?>
	<div id="secondary-2" class="widget-area-2" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #secondary-2 -->
	<?php
}

// Add two-sidebar class if not logged in
add_filter( 'body_class', 'ipce_layout_class', 20 );
function ipce_layout_class( $classes ) {
	if ( !is_user_logged_in() ) {
		$classes[] = 'two-sidebar';
	}

	return $classes;
}

// Hide Page title
add_filter( 'post_class', 'ipce_hidetitle_class' );
function ipce_hidetitle_class( $classes ) {
	$pages = array(
		'Home'
	);
	if ( in_array( get_the_title(), $pages ) ) {
		$classes[] = 'ipce-hide-title';
	}

	return $classes;
}

// Footer
add_action( 'storefront_ipce_footer', 'ipce_footer_credit', 10 );
add_action( 'storefront_ipce_footer', 'ipce_footer_menu', 20 );
function ipce_footer_credit() {
	?>
	<div class="ipce-site-info">
		<p class="company"><?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = get_bloginfo( 'name' ) . ' &copy; ' . ' ' . date( 'Y' ) . ', All Rights Reserved' ) ); ?></p>
		<p>London Office: <em><strong>71 - 75, Shelton Street, Covent Garden, London, WC2H 9JQ, UNITED KINGDOM</strong></em></p>
		<p>Derby Office: 31 Bemrose Road, Allenton, Derby, DE24 8LP, United Kingdom</p>
		<p>Registered in England and Wales | Company No. 10467995 | Tel: 00447872925763 | Fax: 01332117496 | Email: <a href="mailto:sales@industrialprocessescontrol.co.uk" class="ipce-link">sales@industrialprocessescontrol.co.uk</a></p>
	</div><!-- .site-info -->
	<?php
}
function ipce_footer_menu() {
	$menu_items = wp_get_nav_menu_items( 'IPCE Footer Menu' );
	?>
	<ul class="ipce-footer-menu">
		<?php foreach( $menu_items as $menu_item ): ?>
		<li><a href="<?php echo $menu_item->url ?>"><?php echo $menu_item->title ?></a></li>
		<?php endforeach; ?>
	</ul><!-- .site-info -->
	<?php
}

// Rewrite Rules
add_action( 'init', 'ipce_rewrite_rules' );
add_filter( 'query_vars', 'ipce_register_query_vars' );
function ipce_rewrite_rules() {
	$page = get_posts( array(
		'post_type' => 'page',
		'fields' => 'ids',
		'nopaging' => true,
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-product-manufacturer.php'
	) );
	if ( !empty( $page ) ) {
		$page_id = $page[0];
		add_rewrite_rule( '^product-category/([^/]+)$', 'index.php?page_id=' . $page_id . '&ipce_prod_cat=$matches[1]', 'top' );
	}

	$page = get_posts( array(
		'post_type' => 'page',
		'fields' => 'ids',
		'nopaging' => true,
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-manufacturer-product.php'
	) );
	if ( !empty( $page ) ) {
		$page_id = $page[0];
		add_rewrite_rule( '^manufacturer/([^/]+)$', 'index.php?page_id=' . $page_id . '&ipce_prod_man=$matches[1]', 'top' );
		add_rewrite_rule( '^brand/([^/]+)$', 'index.php?page_id=' . $page_id . '&ipce_prod_man=$matches[1]', 'top' );
	}

	$page = get_posts( array(
		'post_type' => 'page',
		'fields' => 'ids',
		'nopaging' => true,
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-parts.php'
	) );
	if ( !empty( $page ) ) {
		$page_id = $page[0];
		add_rewrite_rule( '^parts/([^/]+)/([^/]+)$', 'index.php?page_id=' . $page_id . '&ipce_prod_cat=$matches[1]&ipce_prod_man=$matches[2]', 'top' );
	}
}
function ipce_register_query_vars( $vars ) {
	$vars[] = 'ipce_prod_cat';
	$vars[] = 'ipce_prod_man';
	return $vars;
}

// Shortcodes
add_shortcode( 'ipce_sc_user_info', 'ipce_sc_user_info_handler' );
function ipce_sc_user_info_handler( $atts ) {
	global $current_user;
	get_currentuserinfo();

	if ( !$atts['field'] || $current_user->ID == 0 || !( $atts['field'] && $current_user->data->{$atts['field']} ) ) {
		return '';
	}

	return $current_user->data->{$atts['field']};
}