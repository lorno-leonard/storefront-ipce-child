<?php
/* Template Name: IPCE - Manufacturer List page */
get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header><h1><?php echo $post->post_title ?></h1></header>
			<p><?php echo $post->description ?></p>

			<div class="row">
				<?php
				$terms = get_terms( array(
					'taxonomy' => 'pwb-brand',
					'hide_empty' => false
				) );
				usort( $terms, function($a, $b) { return $b->term_id < $a->term_id; } );
				foreach ( $terms as $cat ) {
					?>
					<a href="/manufacturer/<?php echo $cat->slug ?>" class="col-md-4 col-sm-6 col-xs-6 ipce-link">
						<span><?php echo $cat->name ?></span>
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