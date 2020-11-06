<?php
if ( is_home()&&current_user_can('publish_posts')):?>
	<p>
		<?php
			printf(
				wp_kses(
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'vidorev'),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
		?>
	</p>	
	
<?php elseif(is_search()):?>

	<div class="none-content-info search-df">
		<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vidorev'); ?>
	</div>	

<?php else:?>
	
	<div class="none-content-info archive-df">
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'vidorev'); ?></p>
	
		<div class="search-form-page">
			<div class="header-search-page-wrapper">
				<form action="<?php echo esc_url(home_url('/'));?>" method="get">					
					<input class="search-terms-textfield search-terms-textfield-control" type="text" placeholder="<?php esc_attr_e('Search...', 'vidorev');?>" name="s" value="<?php echo esc_attr(get_search_query());?>">		
					<i class="fa fa-search" aria-hidden="true"></i>					
					<input type="submit" value="<?php esc_attr_e('Search', 'vidorev');?>">							
				</form>
			</div>
		</div>
	</div>
	
<?php endif;?>