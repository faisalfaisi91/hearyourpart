<?php
if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
	$post_id = get_the_ID();
	?>    
    <figure class="amp-wp-article-featured-image wp-caption">
    	<amp-iframe width="666" height="375" sandbox="allow-scripts allow-same-origin allow-popups allow-presentation" layout="responsive" frameborder="0" allowfullscreen src="<?php echo esc_url(add_query_arg(array('video_embed' => $post_id, 'vidorev_amp' => 1), str_replace(home_url(), trim(get_option( 'vidorev_amp_url_settings', '' )), get_permalink($post_id))));?>">
        	<amp-img layout="fill" src="<?php echo esc_url(get_template_directory_uri().'/img/placeholder-video.png');?>" placeholder></amp-img>
        </amp-iframe>
    </figure>   
    <?php
	return;
}

$featured_image = $this->get( 'featured_image' );

if ( empty( $featured_image ) ) {
	return;
}

$amp_html = $featured_image['amp_html'];
$caption  = $featured_image['caption'];
?>
<figure class="amp-wp-article-featured-image wp-caption">
	<?php echo apply_filters('vidorev_amp_custom_html_feature_image', $amp_html);?>
	<?php if ( $caption ) : ?>
		<p class="wp-caption-text">
			<?php echo wp_kses_data( $caption ); ?>
		</p>
	<?php endif; ?>
</figure>
