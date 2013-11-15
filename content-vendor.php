<?php 
/**
 * Single post page for Vendors custom post type
 * @package WordPress
 * @subpackage Arts Restore LA
 * @since Arts Restore LA 1.0
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('panel'); ?>>
	<header>
			<h2><?php the_title(); ?></h2>
	</header>

		<?php  
			$key = 'vendor_secondary-image_thumbnail_id';
			$themeta = get_post_meta($post->ID, $key, TRUE);
			if ($themeta != '')	:?>
				<!--Begin Orbit -->
				<ul data-orbit="" data-options="bullets:false;" id="vendor_slider">
					<li><?php the_post_thumbnail('xlarge'); ?>
						<div class="orbit-caption">
							<div class="row">
								<div class="large-12 columns">
									<p class="arla_caption">
										<?php
											the_post_thumbnail_caption();
										?>
									</p>
								</div>
							</div>
						</div>
					</li>
					<li><?php if (class_exists('MultiPostThumbnails')) : MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image'); endif; ?>
						<div class="orbit-caption">
							<div class="row">
								<div class="large-12 columns">
									<p class="arla_caption">
										<?php
											$second_thumbnail_id = get_post_meta(get_the_ID(), 'vendor_secondary-image_thumbnail_id', false);
											$second_id = $second_thumbnail_id[0];

											// The thumbnail caption:
											echo get_post($second_id)->post_excerpt;
										?>
									</p>
								</div>
							</div>
						</div>
					</li><?php 
								$key = 'vendor_tertiary-image_thumbnail_id';
								$themeta = get_post_meta($post->ID, $key, TRUE);
								if ($themeta != '') {
									echo '<li><?php if (class_exists("MultiPostThumbnails")) : MultiPostThumbnails::the_post_thumbnail(get_post_type(), "tertiary-image"); endif; ?>
												<div class="orbit-caption">
													<div class="row">
														<div class="large-12 columns">
															<p class="arla_caption">
																<?php
																	$third_thumbnail_id = get_post_meta(get_the_ID(), "vendor_tertiary-image_thumbnail_id", false);
																	$third_id = $third_thumbnail_id[0];
																	// The thumbnail caption:
																	echo get_post($third_id)->post_excerpt;
																?>
															</p>
														</div>
													</div>
												</div>
											</li>';
										}
							?>
				</ul>
				<!-- End Orbit -->
		<?php elseif ( has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('fullwidth'); ?>
		<?php endif; ?>
	<div class="article_content">	
		
		<?php the_content(); ?>

		<footer>

			<p><?php wp_link_pages(); ?></p>

			<?php the_tags('<span class="radius secondary label">','</span><span class="radius secondary label">','</span>'); ?>

			<?php get_template_part('author-box'); ?>
			<?php comments_template(); ?>

		</footer>
	</div>
</article>