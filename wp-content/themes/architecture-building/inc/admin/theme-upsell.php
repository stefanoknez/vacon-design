<?php
/**
 * Theme Get Started / Upsell Page
 *
 * @package ARCHITECTURE_BUILDING
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add theme page to admin menu
 */
add_action( 'admin_menu', 'architecture_building_add_theme_page' );
function architecture_building_add_theme_page() {
    add_theme_page(
        __( 'Upgrade to PRO', 'architecture-building' ),
        __( 'Upgrade to PRO', 'architecture-building' ),
        'manage_options',
        'architecture-building-pro',
        'architecture_building_pro_page_callback'
    );
}

/**
 * Render theme Get Started page
 */
function architecture_building_pro_page_callback() {
	$architecture_building_theme_name_clean = strtolower( preg_replace( '#[^a-zA-Z]#', '', wp_get_theme()->get( 'Name' ) ) );
	$architecture_building_wizard_page_slug = apply_filters( $architecture_building_theme_name_clean . '_theme_setup_wizard_architecture_building_page_slug', $architecture_building_theme_name_clean . '-wizard' );
	$architecture_building_demo_url         = admin_url( 'themes.php?page=' . $architecture_building_wizard_page_slug );
	?>
	<div class="wrap ot-pro-wrap">
		<h1><?php esc_html_e( 'Get Started with Architecture Building 🚀', 'architecture-building' ); ?></h1>

		<div class="ot-pro-hero">
			<div class="hero-content">
				<div class="hero-left">
					<h2><?php esc_html_e( 'Build Your Professional Website Today', 'architecture-building' ); ?></h2>
					<p class="subtitle"><?php esc_html_e( 'Get access to premium features, advanced layouts, demo import, and priority support', 'architecture-building' ); ?></p>
					<div class="button-group">
						<a class="button button-hero theme-install" href="<?php echo esc_url( $architecture_building_demo_url ); ?>">
							<span class="dashicons dashicons-download"></span>
							<?php esc_html_e( 'Demo Import', 'architecture-building' ); ?>
						</a>
						<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_LIVE_DEMO ); ?>" target="_blank" class="button button-hero button-demo">
							<span class="dashicons dashicons-visibility"></span>
							<?php esc_html_e( 'Live Demo', 'architecture-building' ); ?>
						</a>
						<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUY_PRO ); ?>" target="_blank" class="button button-primary button-hero button-pro">
							<span class="dashicons dashicons-star-filled"></span>
							<?php esc_html_e( 'Get Pro Theme', 'architecture-building' ); ?>
						</a>
						<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_FREE_DOC ); ?>" target="_blank" class="button button-hero button-docs">
							<span class="dashicons dashicons-book"></span>
							<?php esc_html_e( 'Documentation', 'architecture-building' ); ?>
						</a>
						<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUNDLE_LINK ); ?>" target="_blank" class="button button-hero button-bundle">
							<span class="dashicons dashicons-cart"></span>
							<?php esc_html_e( 'WordPress Theme Bundle', 'architecture-building' ); ?>
						</a>
					</div>
				</div>
				<div class="hero-right">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_attr_e( 'Architecture Building Theme Screenshot', 'architecture-building' ); ?>" class="theme-screenshot">
				</div>
			</div>
		</div>

		<div class="ot-pro-features">
			<h2><?php esc_html_e( 'Why Upgrade to Pro?', 'architecture-building' ); ?></h2>

			<div class="feature-grid">
				<div class="feature-box">
					<span class="dashicons dashicons-layout"></span>
					<h3><?php esc_html_e( 'Different Styling Options', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Choose from multiple color schemes and styling options to match your brand identity.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-admin-customizer"></span>
					<h3><?php esc_html_e( 'Section Reordering Option', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Rearrange homepage sections in any order to best showcase your services.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-editor-table"></span>
					<h3><?php esc_html_e( 'Footer Builder', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Create custom footers with advanced widgets and flexible column layouts.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-art"></span>
					<h3><?php esc_html_e( 'Typography Controls', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Full control over fonts, sizes, and text styling across all sections of your site.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-cart"></span>
					<h3><?php esc_html_e( 'WooCommerce Styling', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Advanced WooCommerce integration with custom product and service page layouts.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-admin-tools"></span>
					<h3><?php esc_html_e( 'Advanced Options', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Access advanced theme settings to achieve greater customization and control.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-performance"></span>
					<h3><?php esc_html_e( 'Performance Optimized', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( '3X faster loading with optimized code, minified assets, and clean markup.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-sos"></span>
					<h3><?php esc_html_e( 'Priority Support', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Get expert help within 24 hours through our dedicated priority support system.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-admin-appearance"></span>
					<h3><?php esc_html_e( 'Unlimited Color Schemes', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Customize every color to match your brand identity with unlimited color options.', 'architecture-building' ); ?></p>
				</div>

				<div class="feature-box">
					<span class="dashicons dashicons-download"></span>
					<h3><?php esc_html_e( 'One-Click Demo Import', 'architecture-building' ); ?></h3>
					<p><?php esc_html_e( 'Import the complete demo content with one click and get your site ready instantly.', 'architecture-building' ); ?></p>
				</div>
			</div>
		</div>

		<div class="ot-pro-comparison">
			<h2><?php esc_html_e( 'Free vs Pro Comparison', 'architecture-building' ); ?></h2>

			<table class="comparison-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Feature', 'architecture-building' ); ?></th>
						<th><?php esc_html_e( 'Free', 'architecture-building' ); ?></th>
						<th class="pro-col"><?php esc_html_e( 'Pro', 'architecture-building' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php esc_html_e( 'WordPress Customizer Support', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Demo Importer', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Responsive Design', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Color Options', 'architecture-building' ); ?></td>
						<td><?php esc_html_e( 'Limited', 'architecture-building' ); ?></td>
						<td class="pro-col"><?php esc_html_e( 'Unlimited', 'architecture-building' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Typography Controls (Heading &amp; Body Font)', 'architecture-building' ); ?></td>
						<td><?php esc_html_e( 'Basic', 'architecture-building' ); ?></td>
						<td class="pro-col"><?php esc_html_e( 'Advanced', 'architecture-building' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Sticky Header', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Preloader / Loader', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Scroll-to-Top Button', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Homepage Slider Section', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Social Media Links', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'WooCommerce Support', 'architecture-building' ); ?></td>
						<td><?php esc_html_e( 'Basic', 'architecture-building' ); ?></td>
						<td class="pro-col"><?php esc_html_e( 'Advanced Styling', 'architecture-building' ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Section Reordering', 'architecture-building' ); ?></td>
						<td>&#10060;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Boxed / Full-Width Layout', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Left / Right Sidebar', 'architecture-building' ); ?></td>
						<td>&#9989;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Priority Support', 'architecture-building' ); ?></td>
						<td>&#10060;</td>
						<td class="pro-col">&#9989;</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="ot-pro-testimonials">
			<h2><?php esc_html_e( 'What Our Users Say', 'architecture-building' ); ?></h2>

			<div class="testimonial-grid">
				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"I was looking for a clean and professional theme for my business and this theme delivered exactly that. Setup was quick and the layout looks very modern."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- John D.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"The theme design is professional and easy to customize. The documentation helped me set up my Architecture Building website without any issues."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Sarah M.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"Very flexible and beginner-friendly. I was able to adjust colors, sections, and layouts directly from the Customizer. Highly recommended."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Michael R.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"The mobile responsive design works perfectly. Most of my clients visit from their phones, and the site looks clean and professional."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Emily T.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"Great theme for professionals. The service sections and homepage layout helped me present my services clearly to potential clients."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- David L.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"Customer support is very helpful and responsive. They guided me during setup and solved my issue quickly."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Jennifer K.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"Fast loading and SEO friendly. After launching my website with this theme, I started receiving more inquiries from clients."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Robert H.', 'architecture-building' ); ?></span>
				</div>

				<div class="testimonial-box">
					<div class="stars">&#11088;&#11088;&#11088;&#11088;</div>
					<p><?php esc_html_e( '"A very good theme with useful features for Architecture Building businesses. Easy to install and the demo import was a real time-saver."', 'architecture-building' ); ?></p>
					<span class="author"><?php esc_html_e( '- Lisa P.', 'architecture-building' ); ?></span>
				</div>
			</div>
		</div>

		<div class="ot-pro-cta">
			<h2><?php esc_html_e( 'Ready to Upgrade?', 'architecture-building' ); ?></h2>
			<p><?php esc_html_e( 'Join hundreds of satisfied customers who upgraded to Pro', 'architecture-building' ); ?></p>
			<?php
			$architecture_building_theme = wp_get_theme();
			$architecture_building_theme_name = $architecture_building_theme->get( 'Name' );
			?>

			<a href="<?php echo esc_url( ARCHITECTURE_BUILDING_BUY_PRO ); ?>" target="_blank" class="button button-primary button-hero">
				<?php echo esc_html( sprintf( __( 'Get %s Pro Now', 'architecture-building' ), $architecture_building_theme_name ) ); ?> &rarr;
			</a>
		</div>

		<div class="ot-pro-footer">
			<p>
				<?php
				printf(
					/* translators: %s: Support URL */
					__( 'Need help? Contact our <a href="%s" target="_blank">support</a> team anytime.', 'architecture-building' ),
					esc_url( ARCHITECTURE_BUILDING_SUPPORT )
				);
				?>
			</p>
		</div>
	</div>
	<?php
}
