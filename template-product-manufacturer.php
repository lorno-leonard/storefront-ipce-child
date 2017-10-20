<?php
/* Template Name: IPCE - Product - Manufacturer Page */
get_header();
global $wp_query; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="ipce-product-manufacturer-page">

				<?php
				$product_category = get_terms( array(
					'slug' => $wp_query->query['ipce_prod_cat'],
					'taxonomy' => 'product_cat',
					'hide_empty' => false
				) );
				?>

				<!-- IF THERE'S A PRODUCT CATEGORY -->
				<?php if ( !empty( $product_category ) ): ?>
					<?php
						$product_category = $product_category[0];
						$thumbnail_id = get_woocommerce_term_meta( $product_category->term_id, 'thumbnail_id', true );
						$thumbnail_url = wp_get_attachment_thumb_url( $thumbnail_id );

						// Get Manufacturers
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => -1, // Show all
							'post_status' => 'publish',
							'tax_query' => array(
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $wp_query->query['ipce_prod_cat'],
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
							$manufacturers = wp_get_object_terms( $post_ids, 'pwb-brand' );
						}
					?>
					<header><h1 class="text-center"><?php echo $product_category->name ?></h1></header>
					<img src="<?php echo $thumbnail_url ?>" alt="<?php echo $product_category->name ?>">
					<p class="text-justify"><?php echo $product_category->description ?></p>
					<?php if ( !empty( $post_ids ) ): ?>
						<div class="row">
							<?php foreach( $manufacturers as $m ): ?>
								<a href="/parts/<?php echo $wp_query->query['ipce_prod_cat'] ?>/<?php echo $m->slug ?>" class="col-md-4 col-sm-6 col-xs-6 ipce-link">
									<span><?php echo $m->name ?></span>
								</a>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<p>No Manufacturers found.</p>
					<?php endif; ?>
					<p class="p-return">
						<a href="/product-category" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Products Categories</a>
					</p>

				<!-- NO PRODUCT CATEGORY FOUND -->
				<?php else: ?>
					<header><h2>Product Category Not Found.</h2></header>
					<p class="p-return">
						<a href="/product-category" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Products Categories</a>
					</p>

				<?php endif; ?>

			</div><!-- .ipce-product-manufacturer-page -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
do_action( 'ipce_action_second_sidebar' );
get_footer();