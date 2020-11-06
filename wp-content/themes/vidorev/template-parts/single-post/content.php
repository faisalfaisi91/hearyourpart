<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content global-single-content'); ?>>
	
	<?php 
	do_action( 'vidorev_single_element_format', 'basic');
	do_action( 'vidorev_single_post_title', 'basic', 'h-font-size-30 h1-tablet');
	$showmore_btn_class = '';
	$showmore_btn_elms = '';
	if(get_post_format()!='video'){
		do_action('vidorev_above_single_content_ads');
	}else{
		if(vidorev_get_redux_option('sv_show_more_btn', 'off', 'switch') == 'on'){
			$showmore_btn_class = 'hidden-content hidden-content-control';
			$showmore_btn_elms 	= '<div class="showmore_wrapper"><span class="showmore_button showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>';
		}		
	}
	if(get_post_type()!='vid_channel'){
	?>	
		<div class="entry-content <?php echo esc_attr($showmore_btn_class);?>"><?php the_content(); wp_link_pages( array('before' => '<div class="page-links navigation-font"><span class="page-links-title">' . esc_html__( 'Pages:', 'vidorev') .'</span>', 'after'  => '</div>', 'pagelink' => '<span>%</span>') );?></div><?php echo apply_filters('beeteam368_showmore_element', $showmore_btn_elms);?>	
	<?php 
	}
	
	do_action('vidorev_single_custom_listing');
	
	if(get_post_type()!='vid_channel'){
		get_template_part('template-parts/single-post/content-footer');
	}
	?>

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