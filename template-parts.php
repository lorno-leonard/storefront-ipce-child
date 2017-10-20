<?php
/* Template Name: IPCE - Parts Page */
get_header();
do_action( 'storefront_sidebar' );
global $wp_query; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="ipce-product-manufacturer-page">

				<header><h1><?php echo $post->post_title ?></h1></header>
				<?php
					$valid = true;
					$product_category = get_terms( array(
						'slug' => $wp_query->query['ipce_prod_cat'],
						'taxonomy' => 'product_cat',
						'hide_empty' => false
					) );
					$product_manufacturer = get_terms( array(
						'slug' => $wp_query->query['ipce_prod_man'],
						'taxonomy' => 'pwb-brand',
						'hide_empty' => false
					) );

					if ( empty( $product_category ) ) {
						$valid = false;
						?><h2>Product Category Not Found.</h2><?php
					}
					if ( empty( $product_manufacturer ) ) {
						$valid = false;
						?><h2>Manufacturer Not Found.</h2><?php
					}

					if ( !$valid ) {
						?>
						<p class="p-return">
							<a href="/product-category" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Products Categories</a><br>
							<a href="/manufacturer" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Manufacturers</a>
						</p>
						<?php
					} else {
						$product_category = $product_category[0];
						$product_manufacturer = $product_manufacturer[0];
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => -1, // Show all
							'post_status' => 'publish',
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $wp_query->query['ipce_prod_cat'],
								),
								array(
									'taxonomy' => 'pwb-brand',
									'field' => 'slug',
									'terms' => $wp_query->query['ipce_prod_man'],
								)
							)
						);
						$query = new WP_Query( $args ); // Get Posts
						$posts = $query->posts;
						?>
						<div class="row">
							<div class="col-md-6">
								<h4>Product Category<br><a href="/product-category/<?php echo $wp_query->query['ipce_prod_cat'] ?>" class="ipce-link"><?php echo $product_category->name ?></a></h4>
							</div>
							<div class="col-md-6">
								<h4>Manufacturer<br><a href="/manufacturer/<?php echo $wp_query->query['ipce_prod_man'] ?>" class="ipce-link"><?php echo $product_manufacturer->name ?></a></h4>
							</div>
						</div>
						<hr>
						<table class="table table-bordered">
							<thead>
								<th>Part Number</th>
								<th>Description</th>
							</thead>
							<tbody>
								<?php if( count($posts) == 0 ): ?>
								<tr>
									<td colspan="2">No Parts found.</td>
								</tr>
								<?php else: ?>
									<?php foreach( $posts as $p ): ?>
										<?php
											// $thumbnail_id = get_woocommerce_term_meta( $c->term_id, 'thumbnail_id', true );
											// $thumbnail_url = wp_get_attachment_thumb_url( $thumbnail_id );
										?>
										<tr>
											<td width="40%">
												<a href="/part/<?php echo $p->post_name ?>" class="ipce-link">
													<span><?php echo $p->post_title ?></span>
												</a>
											</td>
											<td width="60%">
												<span><?php echo $p->post_excerpt ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
						<p class="p-return">
							<a href="/product-category" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Products Categories</a><br>
							<a href="/manufacturer" class="ipce-link"><i class="fa fa-long-arrow-left"></i> Return to Manufacturers</a>
						</p>
						<?php
					}
				?>

			</div><!-- .ipce-product-manufacturer-page -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'ipce_action_second_sidebar' );
get_footer();