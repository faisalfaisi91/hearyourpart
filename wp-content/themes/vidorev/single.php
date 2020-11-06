<?php
get_header();
$sidebarControl = vidorev_sidebar_control();

do_action( 'vidorev_single_element_format', 'full-width');
if(!beeteam368_return_embed()){
?>

    <div id="primary-content-wrap" class="primary-content-wrap">
        <div class="primary-content-control">
            
            <div class="site__container fullwidth-vidorev-ctrl container-control">
            
                <?php 
                do_action( 'vidorev_single_post_breadcrumbs', 'basic' );			
                do_action( 'vidorev_single_element_format', 'special');
                ?>
                
                <div class="site__row sidebar-direction">							
                    <main id="main-content" class="site__col main-content">	
                        
                        <div class="single-post-wrapper global-single-wrapper">
                                
                            <?php
                            while ( have_posts() ) : the_post();
                
                                get_template_part( 'template-parts/single-post/content', get_post_format());
                
                                if ( (comments_open() || get_comments_number()) && vidorev_get_redux_option('single_post_comment', 'on', 'switch')=='on' && vidorev_detech_comment_type() == 'wp' && get_post_type()!='vid_channel') :
                                    comments_template();
                                endif;
                                
                                if ( vidorev_get_redux_option('single_post_comment', 'on', 'switch')=='on' && vidorev_detech_comment_type() == 'facebook' && get_post_type()!='vid_channel') :
                                    do_action('vidorev_facebook_comment');
                                endif;
                
                            endwhile;
                            ?>
                                
                        </div>
                        
                    </main>
                    
                    <?php				
                    if($sidebarControl!='hidden'){
                        get_sidebar();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
get_footer();