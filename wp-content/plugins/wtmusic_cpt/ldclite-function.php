<?php
global $ldc_like_text, $ldc_dislike_text;
$ldc_options = get_option('ldclite_options');
$ldc_like_text = $ldc_options['ldc_like_text'];
$ldc_dislike_text = $ldc_options['ldc_dislike_text'];
$ldc_deactivate = $ldc_options['ldc_deactivate'];

function ldc_like_counter_p($text="Likes: ",$post_id=NULL)
{
	global $post;
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$like_ico = ot_get_option('like_ico'); 
	} else { 
		$like_ico = 'heart'; 
	}
	if(empty($post_id))
	{
	$post_id=$post->ID;
	}
	$ldc_return = "<span class='ldc-ul_cont' onclick=\"alter_ul_post_values(this,'$post_id','like')\" ><i class='fa fa-".$like_ico." mi'></i><span class='mid'>".get_post_ul_meta($post_id,"like")."</span></span>";
	return $ldc_return;
}

function ldc_dislike_counter_p($text="dislikes: ",$post_id=NULL)
{
	global $post;
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$dislike_ico = ot_get_option('dislike_ico'); 
	} else { 
		$dislike_ico = 'heart-o'; 
	}
	if(empty($post_id))
	{
	$post_id=$post->ID;
	}
	$ldc_return = "<span class='ldc-ul_cont' onclick=\"alter_ul_post_values(this,'$post_id','dislike')\" ><i class='fa fa-".$dislike_ico." mi'></i><span>".get_post_ul_meta($post_id,"dislike")."</span></span>";
	return $ldc_return;
}

function ldc_like_counter_c($text="Likes: ",$post_id=NULL)
{
	global $comment;
	if(empty($post_id))
	{
	$post_id=get_comment_ID();
	}
	$ldc_return = "<span class='ldc-ul_cont' onclick=\"alter_ul_post_values(this,'$post_id','c_like')\" ><i class='fa fa-thumbs-up mi'></i><span class='mid'>".get_post_ul_meta($post_id,"c_like")."</span></span>";
	return $ldc_return;
}

function ldc_dislike_counter_c($text="dislikes: ",$post_id=NULL)
{
	global $comment;
	if(empty($post_id))
	{
	$post_id=get_comment_ID();
	}
	$ldc_return = "<span class='ldc-ul_cont' onclick=\"alter_ul_post_values(this,'$post_id','c_dislike')\" ><i class='fa fa-thumbs-down mi'></i><span>".get_post_ul_meta($post_id,"c_dislike")."</span></span>";
	return $ldc_return ;
}
function get_post_ul_meta($post_id,$up_type)
{
	global $wpdb;
	$table_name = $wpdb->prefix."like_dislike_counters"; 
	$sql="select ul_value from $table_name where post_id=$post_id and ul_key='$up_type' ;";
	$to_ret=$wpdb->get_var($sql);
	if(empty($to_ret))
	{
	$to_ret=0;
	}
	return $to_ret;
}

add_filter( 'comment_text', 'ldclite_addCommentLike' );

function ldclite_addPostLike ( $content ) 
{
	global $ldc_like_text, $ldc_dislike_text;
	$ldc_return = '';
	if(is_page()){
		$ldc_return .= ldc_like_counter_p($ldc_like_text);
		$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		//$ldc_return = '<div class="clearfix">'.$ldc_return.'</div>';
		//return $content.$ldc_return;
	}
	else{

		$ldc_return = '';
		if(is_home()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else if( is_category()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else if( is_tag()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else if(is_tax()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else if(is_author()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else if(is_date()){
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		else{
			$ldc_return .= ldc_like_counter_p($ldc_like_text);
			$ldc_return .= ldc_dislike_counter_p($ldc_dislike_text);
		}
		//return 'Tikendra maitry';
	}
	$ldc_return = '<div class="clearfix">'.$ldc_return.'</div>';
	return $content.$ldc_return;
}

function ldclite_addCommentLike( $mytext ) {
	global $comment, $ldc_like_text, $ldc_dislike_text;
	$mytext = get_comment_text( $comment );
	$mytext .= "\n";
	$mytext .= '<div class="ldc-cmt-box mb clearfix">';
	$mytext .= ldc_like_counter_c($ldc_like_text);
	$mytext .= ldc_dislike_counter_c($ldc_dislike_text);
	$mytext .= '</div>';
	$mytext .= '<div style="clear:both;"></div>';
	return $mytext;
}

function update_post_ul_meta($post_id,$up_type)
{
	global $wpdb;
	$table_name = $wpdb->prefix."like_dislike_counters";
	$lnumber=get_post_ul_meta($post_id,$up_type);
	if($up_type=='c_like'||$up_type=='c_dislike')
	{
	$for_com='c_';
	}
	else
	{
	$for_com='';
	}
	if($lnumber)
	{ 
	$sql="update $table_name set ul_value=".($lnumber+1)." where post_id='$post_id' and ul_key='$up_type';";
		if(isset($_COOKIE['ul_post_cnt']))
		{
			$posts=$_COOKIE['ul_post_cnt'];
			array_push($posts,$for_com.$post_id);
			foreach($posts as $key=>$value)
			{
			setcookie("ul_post_cnt[$key]",$value, time()+(7 * 24 * 60 * 60));
			}
		}
		else
		{
		setcookie("ul_post_cnt[0]",$for_com.$post_id, time()+(7 * 24 * 60 * 60));
		}
		$wpdb->query($sql);
	}
	else
	{
		$sql="insert into $table_name(post_id,ul_key,ul_value) values('$post_id','$up_type',".($lnumber+1).");";
		if(isset($_COOKIE['ul_post_cnt']))
		{
			$posts=$_COOKIE['ul_post_cnt'];
			array_push($posts,$post_id);
			foreach($posts as $key=>$value)
			{
			setcookie("ul_post_cnt[$key]",$for_com.$value, time()+(7 * 24 * 60 * 60));
			}
		}
		else
		{
		setcookie("ul_post_cnt[0]",$for_com.$post_id, time()+(7 * 24 * 60 * 60));
		}
	$wpdb->query($sql);
	}
}

function like_counter_p($text="Likes: ",$post_id=NULL){
	global $ldc;
	global $post_id;
	echo ldc_like_counter_p($text);
}
function dislike_counter_p($text="dislikes: ",$post_id=NULL){
	global $ldc;
	global $post_id;
	echo ldc_dislike_counter_p($text);
}
function like_counter_c($text="Likes: ",$post_id=NULL){
	global $ldc;
	global $post_id;
	echo ldc_like_counter_c($text);
}
function dislike_counter_c($text="dislikes: ",$post_id=NULL){
	global $ldc;
	global $post_id;
	echo ldc_dislike_counter_c($text);
}
