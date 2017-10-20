<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">
		
			<?php
			/**
			 * Functions hooked in to storefront_ipce_footer action
			 *
			 * @hooked ipce_footer_credit - 10
			 * @hooked ipce_footer_menu   - 20
			 */
			do_action( 'storefront_ipce_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
