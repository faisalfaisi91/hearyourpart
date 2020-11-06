<article id="post-<?php the_ID(); ?>" <?php post_class('single-page-content global-single-content'); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title extra-bold">', '</h1>' ); ?>
	</header>
	
	<div class="entry-content"><?php the_content(); wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vidorev'),	'after'  => '</div>') );?></div>
	
	<?php do_action('vidorev_single_page_custom_listing');?>

	<?php if ( get_edit_post_link() && !is_page_template('template/blog-page-template.php') && !is_page_template('page-templates/front-page-template.php')) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(							
							esc_html__( 'Edit Page', 'vidorev'),
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