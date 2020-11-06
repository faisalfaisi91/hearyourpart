<footer class="amp-wp-footer">
	<div>
		<?php
        $footer_copyright = trim(vidorev_get_redux_option('footer_copyright', ''));
        if($footer_copyright!=''){
        	echo wp_kses_post($footer_copyright);
        }else{
			echo esc_html__('Copyright &copy; 2019. Created by BeeTeam368. Powered by WordPress', 'vidorev');
		}
        ?>
	</div>
</footer>
