		<?php if(!beeteam368_return_embed()){?>
                    <footer id="site-footer" class="site-footer">
                        
                        <?php do_action('vidorev_popular_videos_footer');?>
                        
                        <?php do_action('vidorev_above_footer_content_ads');?>
                        
                        <?php do_action('vidorev_instagram_feed', 'footer');?>
                        
                        <div class="footer-wrapper dark-background">
                            <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
                                <div class="footer-sidebar">
                                    <div class="site__container fullwidth-vidorev-ctrl">                        	
                                        <div class="site__row">
                                            <?php dynamic_sidebar( 'footer-sidebar' ); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endif;
                            ?>
                            
                            <?php 
                            $footer_copyright = trim(vidorev_get_redux_option('footer_copyright', ''));
                            ?>
                            <div class="footer-copyright">							
                                <div class="site__container fullwidth-vidorev-ctrl">                        	
                                    <div class="site__row">
                                        <div class="site__col font-size-12">
                                            <?php 
                                            if($footer_copyright!=''){
                                                echo wp_kses_post($footer_copyright);
                                            }else{
                                            ?>
                                                <div class="default-copyright">	
                                                    <?php echo esc_html__('Copyright &copy; 2018. Created by BeeTeam368. Powered by WordPress', 'vidorev');?>
                                                </div>
                                            <?php	
                                            }
                                            ?>
                                        </div>
                                    </div>								
                                </div>
                            </div>
                        </div>
                    </footer>
                
                </div>
            </div>
            
            <?php 
            $scroll_to_top_button = vidorev_get_redux_option('scroll_to_top_button', 'off', 'switch');
            if($scroll_to_top_button == 'on'){
            ?>
                <div class="scroll-to-top-button scroll-to-top-button-control">
                    <a class="basic-button basic-button-default" href="#"><?php echo esc_html__('Top', 'vidorev')?><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></a>
                </div>
            <?php	
            }
            ?>
            
            <?php do_action('vidorev_display_mobile_menu');?>
         <?php }?> 
            
         <?php wp_footer();?>       	 
	</body>
</html>