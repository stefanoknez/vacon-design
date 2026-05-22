<?php
/**
 * Template for displaying search forms in Architecture Building
 *
 * @subpackage Architecture Building
 * @since 1.0
 */
?>

<?php $architecture_building_unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'architecture-building' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'submit button', 'architecture-building' ); ?></button>
</form>