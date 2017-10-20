<?php
/* Template Name: IPCE - Product List page */
get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header><h1><?php echo $post->post_title ?></h1></header>
			<p><?php echo $post->description ?></p>

			<div class="row">
				<?php
				$terms = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false
				) );
				usort( $terms, function($a, $b) { return $b->term_id < $a->term_id; } );
				foreach ( $terms as $cat ) {
					$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
					$thumbnail_url = wp_get_attachment_thumb_url( $thumbnail_id );
					?>
					<a href="/product-category/<?php echo $cat->slug ?>" class="col-md-4 col-sm-6 col-xs-12 ipce-category-link" title="<?php echo $cat->name ?>">
						<div class="content">
							<img src="<?php echo $thumbnail_url ?>" alt="<?php echo $cat->name ?>">
							<div class="name">
								<span><?php echo $cat->name ?></span>
							</div>
						</div>
					</a>
					<?php
				}
				?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
do_action( 'ipce_action_second_sidebar' );
get_footer();