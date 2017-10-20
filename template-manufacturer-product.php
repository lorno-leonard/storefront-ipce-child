<?php
/* Template Name: IPCE - Manufacturer - Product Page */
get_header();
global $wp_query; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="ipce-product-manufacturer-page">

				<?php
				$product_manufacturer = get_terms( array(
					'slug' => $wp_query->query['ipce_prod_man'],
					'taxonomy' => 'pwb-brand',
					'hide_empty' => false
				) );
				?>

				<!-- IF THERE'S A MANUFACTURER -->
				<?php if ( !empty( $product_manufacturer ) ): ?>
					<?php
						$product_manufacturer = $product_manufacturer[0];
						$term_meta = get_term_meta( $product_manufacturer->term_id );
						$image_url = wp_get_attachment_url( $term_meta['pwb_brand_image'][0] );
						$banner_url = wp_get_attachment_url( $term_meta['pwb_brand_banner'][0] );

						// Get Product Categories
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => -1, // Show all
							'post_status' => 'publish',
							'tax_query' => array(
								array(
									'taxonomy' => 'pwb-brand',
									'field' => 'slug',
									'terms' => $wp_query->query['ipce_prod_man'],
								),
							)
						);
						$query = new WP_Query( $args ); // Get Posts
						$posts = $query->posts;
						$post_ids = array();
						if ( !empty($posts) ) {
							foreach( $posts as $p ) {
								$post_ids[] = $p->ID;
							}
							$product_categories = wp_get_object_terms( $post_ids, 'product_cat' );
						}
					?>
					<header><h1 class="text-center"><?php echo $product_manufacturer->name ?></h1></header>
					<img src="<?php echo $image_url ?>" alt="<?php echo $product_manufacturer->name ?>">
					<p class="text-justify"><?php echo $product_manufacturer->description ?></p>
					<?php if ( !empty( $post_ids ) ): ?>
						<div class="row">
							<?php foreach( $product_categories as $c ): ?>
								<?
									$thumbnail_id = get_woocommerce_term_meta( $c->term_id, 'thumbnail_id', true );
									$thumbnail_url = wp_get_attachment_thumb_url( $thumbnail_id );
								?>
								<a href="/parts/<?php echo $c->slug ?>/<?php echo $wp_query->query['ipce_prod_man'] ?>" class="col-md-4 col-sm-6 col-xs-12 ipce-category-link" title="<?php echo $c->name ?>">
									<div class="content">
										<img src="<?php echo $thumbnail_url ?>" alt="<?php echo $c->name ?>">
										<div class="name">
											<span><?php echo $c->name ?></span>
										</div>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<p>No Product Categories found.</p>
					<?php endif; ?>
					<p class="p-return">
						<a href="/manufacturer" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Manufacturers</a>
					</p>

				<!-- NO MANUFACTURER FOUND -->
				<?php else: ?>
					<header><h2>Manufacturer Not Found.</h2></header>
					<p class="p-return">
						<a href="/manufacturer" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Manufacturers</a>
					</p>

				<?php endif; ?>

			</div><!-- .ipce-product-manufacturer-page -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
do_action( 'ipce_action_second_sidebar' );
get_footer();