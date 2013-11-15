<?php
/**
 * Header
 *
 * Setup the header for our theme
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />

<title>
	<?php if (is_home () ) {
			bloginfo('name');
		}
		 
		elseif ( is_category() ) {
			single_cat_title(); echo ' | ' ;
			bloginfo('name');
		}
		 
		elseif (is_single() ) {
			single_post_title(); echo ' | ' ;
			bloginfo('name');
		}
		 
		elseif (is_page() ) {
			bloginfo('name');
			echo ': ';
			single_post_title();
		}
		elseif ('vendor' == get_post_type() ) {
			echo 'Vendors';
			echo ' | ';
			bloginfo('name');
		}
		elseif ('event' == get_post_type() ) {
			echo 'Events';
			echo ' | ';
			bloginfo('name');
		}
		else {
			wp_title('',true);
		} 
	?>
</title>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="row" id="arla_header">
		<!-- BEGIN BRANDING  -->
		<div class="large-6 columns">
			<a href="<?php bloginfo('url'); ?>"><div id="branding"><img <?php $header_image = get_header_image(); if ( ! empty( $header_image ) ) : ?> src="<?php echo esc_url( $header_image ); ?>" <?php endif; ?>></div></a>
		</div>
		<!-- END BRANDING -->
		<!-- BEGIN NAV -->
		<nav class="large-6 columns" id="arla_nav">
			<?php wp_nav_menu( 
				array( 
					'theme_location' => 'header-menu', 
					'menu_class' => 'small-block-grid-4', 
					'container' => '', 
					'fallback_cb' => 'foundation_page_menu', 
					'walker' => new foundation_navigation() 
					) 
				); 
			?>
		</nav>
		<!-- END NAV -->
	</div>

<!-- Begin Page -->
<div class="row">