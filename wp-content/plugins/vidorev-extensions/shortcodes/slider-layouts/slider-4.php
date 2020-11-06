<article class="post-item">
	<div class="post-item-wrap" style="background-image:url(<?php do_action('vidorev_thumbnail', 'full', 'class-16x9', 4, NULL, NULL);?>);">
		
		<div class="absolute-gradient"></div>
		
		<div class="listing-content dark-background overlay-background">
			
			<?php 
			if($lightbox_video_enb=='on' && get_post_format()=='video'){				
				$video_lightbox_gallery = trim(vidorev_get_redux_option('video_lightbox_gallery', 'gallery'));
				$video_icon_html 		= '<span class="video-icon video-popup-control" data-id="'.esc_attr(get_the_ID()).'"></span>';
				
				if($video_lightbox_gallery != 'gallery'){					
					$video_icon_html 	= '<a class="video-icon" data-post-id="'.esc_attr(get_the_ID()).'" href="'.esc_url(vidorev_get_post_url(get_the_ID())).'" title="'.esc_attr(the_title_attribute(array('echo'=>0, 'post'=>get_the_ID()))).'">'.esc_html__('icon', 'vidorev-extensions').'</a>';
				}
				
				echo $video_icon_html;				
			}	
			
			if($display_categories=='yes'){
				do_action( 'vidorev_category_element', NULL, 'archive' );
			}
			?>
			<h3 class="entry-title h-font-size-40 h1-small-desktop h5-mobile post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>	
			<?php
			do_action( 'vidorev_posted_on', $post_metas, 'shortcode' );
			
			?>				
		</div>
	
	</div>
</article>
<?php 
	$small_sync.='<div class="sync-item sync-item-control"><div class="sync-item-text sync-item-control"><h4 class="entry-title h6 post-title">'.get_the_title().'</h4></div></div>';
?>