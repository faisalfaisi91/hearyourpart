<div class="post-listing-item">
    <div class="post-img"><?php do_action('vidorev_thumbnail', 'vidorev_thumb_1x1_1x', 'class-1x1', 5, NULL); ?></div>
    <div class="post-content">
        <h3 class="h6 post-title"> 
            <a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
        </h3>
        <?php do_action( 'vidorev_posted_on', array('author', '', '', 'view-count', 'like-count', ''), 'widget' ); ?>												
    </div>
</div>