<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content global-single-content'); ?>>
	
	<?php 	
	do_action( 'vidorev_single_post_title', 'basic', 'h-font-size-30 h1-tablet');
	do_action('vidorev_above_single_content_ads');
	do_action( 'vidorev_single_element_format', 'basic');
	?>
	
	<div class="entry-content"><?php the_content(); wp_link_pages( array('before' => '<div class="page-links navigation-font"><span class="page-links-title">' . esc_html__( 'Pages:', 'vidorev') .'</span>', 'after'  => '</div>', 'pagelink' => '<span>%</span>') );?></div>
	
	<?php get_template_part('template-parts/single-post/content-footer');?>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(							
							esc_html__( 'Edit Post', 'vidorev'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<div class="edit-link">',
					'</div>'
				);
			?>
		</footer>
	<?php endif; ?>
	
</article>