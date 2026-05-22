<?php
/**
 * The template for displaying the footer
 *
 * @subpackage Architecture Building
 * @since 1.0
 */

?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if( get_option('architecture_building_footer_widgets_show_hide', false) !== 'off'){ ?>
			<div class="copyright">
				<div class="container footer-content wow slideInDown">
					<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>			
				</div>
			</div>
		<?php }?>
		<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
		<div class="scroll-top">
			<button type=button id="architecture-building-scroll-to-top" class="scrollup">
				<i class="<?php echo esc_attr(get_theme_mod('architecture_building_scroll_top_icon','fas fa-chevron-up')); ?>"></i>
			</button>
		</div>
	</footer>

	<?php if (get_option('architecture_building_enable_custom_cursor', false) !== 'off') : ?>
	    <!-- Custom cursor -->
	    <div class="custom-cursor"></div>
	    <!-- .Custom cursor -->
	<?php endif; ?>
	
<?php wp_footer(); ?>

</body>
</html>
