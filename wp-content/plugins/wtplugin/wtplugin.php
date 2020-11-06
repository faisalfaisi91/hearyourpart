<?php
/*
	Plugin Name: WT Plugin
	Plugin URI: http://kreativewebteam.com/
	Description: Kreative Web Team
	Version: 1.0.1
	Author: Kreative Web Team
	Author URI: http://kreativewebteam.com/
*/


function generetepassword($length = 8){
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $pass = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $pass .= mb_substr($chars, $index, 1);
    }
    return $pass;
}

function webtop_scripts_styles() {
    wp_enqueue_script('wt-script',   plugins_url( '/js/scripts.js', __FILE__ ),    array('jquery') );
    wp_enqueue_style('wt-style',   plugins_url( '/css/style.css', __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'webtop_scripts_styles' );


add_action( 'wp_ajax_invite_people_send_email',        'invite_people_send_email' ); // For logged in users
//add_action( 'wp_ajax_nopriv_invite_people_send_email', 'invite_people_send_email' ); // For anonymous users

function invite_people_send_email(){

    $levels_user_count = array(
        1 => 1,
        2 => 5,
        3 => 10,
        4 => 20,
        5 => 35,
    );
    $to  = $_POST['invite_email'];

    $current_user = wp_get_current_user();
    $invation_user = get_user_by('email', $to);






    //get current user level PMP pro
    $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);


    if($invation_user){
        $invation_user->membership_level = pmpro_getMembershipLevelForUser($invation_user->ID);
        if($invation_user->membership_level){
            $result = array('error' => true, 'message' => 'This email address belongs to another group.');
        }else{




            $userdata = array(
                'ID' => $invation_user->ID,
                'user_login'  =>  $to,
                'user_email'  =>  $to,
                'invite' => true
            );
            if(get_user_meta($invation_user->ID, 'activated_invition', true) != 'yes'){
                $pass = generetepassword();
                $userdata['user_pass'] = $pass;
            }

            $user_id = wp_update_user( $userdata ) ;

        }
    }else{

        $pass = generetepassword();
        $userdata = array(
            'user_login'  =>  $to,
            'user_email'  =>  $to,
            'user_pass'   =>  $pass
        );

        $user_id = wp_insert_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $invation_user = get_user_by('email', $to);
        }
    }

    $hash = password_hash($invation_user->ID.$to.'_trulala', PASSWORD_DEFAULT);

    update_user_meta($invation_user->ID, 'autologin_hash', $hash);

    $current_user_invition_count =  $levels_user_count[$current_user->membership_level->ID];


    $invited_peoples = array();
    $invited_peoples = get_user_meta( $current_user->ID, 'invited_peoples', true );


    if($to == $current_user->user_email){
        $result = array('error' => true, 'message' => 'You can not invite yourself');
    }elseif(!in_array($to, $invited_peoples)){
        $exist = false;
        if($current_user_invition_count > count($invited_peoples)){
            $invited_peoples[] = $to;
            update_user_meta( $current_user->ID, 'invited_peoples', $invited_peoples );
        }else{
            $result = array('error' => true, 'message' => 'Limit invitations exhausted');
        }
    }else{
        $exist = true;
    }


    if(!$result['error']) {

        if ($invation_user) {
            $link = '<a href="'.get_site_url().'/author/'.$invation_user->user_login.'/?invited=true&inviter='.$current_user->ID.'&email='.$to.'&hash='.$hash.'">Click here to accept this invitation.</a>';
        } else {
            $link = '<a href="#registration">Click here to accept this invitation.</a>';
        }


        $subject = "Hear Your Part Invite";

        $message = ' 
        <html> 
            <head> 
                <title>Congratulations! You’ve been invited to become a member on HearYourPart.com.</title> 
            </head> 
            <body> 
                <p>Congratulations! You’ve been invited to become a member on HearYourPart.com.</p>
                <p>You can accept the invite and create your personal profile by clicking on the link below.</p>';
        if(!empty($pass)){
            $message .='<p>Login : '.$to.'</p>';
            $message .='<p>Password : '.$pass.'</p>';
        }
        $message .='<p>' . $link . '</p>
                <p>Your account will not be created until you access the link above and create a password.</p>
            </body> 
        </html>';

        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From:  hearyourpart.com <invite@hearyourpart.com>\r\n";
        if (mail($to, $subject, $message, $headers)) {
            $result = array('success' => true, 'exist' => $exist, 'message' => 'Invitation sent successfully',  'emails' => $invited_peoples);
        }
    }
    echo json_encode($result);

    exit;
}

add_action('init', 'invite_confirmation');

function invite_confirmation(){
    if(!empty($_GET['invited']) && !empty($_GET['inviter'])) {

        if (!is_user_logged_in()) {
            $logged_in = false;
            $login_user = get_user_by('email', $_GET['email']);

            if (password_verify($login_user->ID . $_GET['email'] . '_trulala', $_GET['hash'])) {
                wp_set_auth_cookie($login_user->ID, false);

                $result = ['success' => true, 'Success Activation!'];
                $logged_in = true;

            } else {
                $result = ['error' => true, 'Login error'];

            }

        } else {
            $logged_in = true;
        }
        $inviter = $_GET['inviter'];


        if ($logged_in) {
            if(!is_user_logged_in()){
                wp_redirect( home_url().'?invited='.$_GET['invited'].'&inviter='.$_GET['inviter'].'&email='.$_GET['email'].'&hash='.$_GET['hash'] );
                exit;
            }
            $invited_peoples = get_user_meta($inviter, 'invited_peoples', true);


            $invation_user = wp_get_current_user();

            $invation_user->membership_level = pmpro_getMembershipLevelForUser($inviter);

            if ($invation_user->membership_level && !pmpro_getMembershipLevelForUser($invation_user->ID)) {
                if (in_array($invation_user->user_email, $invited_peoples)) {
                    global $wpdb;
                    $startdate = date('Y-m-d H:i:s');
                    //$enddate = date('Y-m-d H:i:s', $invation_user->membership_level->enddate);
                    $enddate = date('Y-m-d H:i:s',strtotime('+30 days',strtotime($startdate))) . PHP_EOL;
                    $modified = date('Y-m-d H:i:s');

                    $wpdb->query(
                        $wpdb->prepare(
                            "INSERT INTO wp_pmpro_memberships_users 
                                    ( user_id, membership_id, code_id, initial_payment, billing_amount, cycle_number, cycle_period, billing_limit, trial_amount, trial_limit, status, startdate, enddate, modified)
                             VALUES ( %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %s, %s, %s, %s )",
                            $invation_user->ID,
                            $invation_user->membership_level->ID,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            'active',
                            $startdate,
                            $enddate,
                            $modified
                        )
                    );

                    update_user_meta($invation_user->ID, 'invited', $inviter);
                    update_user_meta($invation_user->ID, 'activated_invition', 'yes');
                } else {
                    $result = ['error' => true, 'You removed from group'];
                }
            } else {
                $result = ['error' => true, 'Group closed'];
            }
            if($logged_in){
                wp_redirect('/author/'.$_GET['email'].'?inv=true');
                exit;
            }
        }
    }
}

add_action('pmpro_after_change_membership_level', 'remove_user_is_invited', 15, 2);

function remove_user_is_invited($level_id, $user_id){
    $old_level_id = get_user_meta($user_id, 'old_level_id', true);


    $current_user = get_userdata( $user_id );

    $inviter = get_user_meta($user_id, 'invited', true);

    $old_group = get_user_meta($inviter, 'invited_peoples', true);

     if(!empty($old_group) && is_array($old_group)){
        if(($key = array_search($current_user->user_email, $old_group)) !== false) {
            unset($old_group[$key]);
        }
    }
    update_user_meta($inviter, 'invited_peoples', $old_group);

    delete_user_meta($user_id, 'invited');

    //if user group shef
    $group_users = get_user_meta($user_id, 'invited_peoples', true);
    if(!empty($group_users) && is_array($group_users) && $old_level_id > $level_id){
        foreach ($group_users as $group_user) {
            $usr = get_user_by('email', $group_user);

            delete_user_meta($usr->ID, 'invited');

            global $wpdb;
            $wpdb->update( 'wp_pmpro_memberships_users',
                array( 'status' => 'cancelled'),
                array( 'user_id' => $usr->ID ),
                array( '%s'),
                array( '%d' )
            );
        }
        delete_user_meta($user_id, 'invited_peoples');
    }elseif(!empty($group_users) && is_array($group_users) && $old_level_id <= $level_id){
        foreach ($group_users as $group_user) {
            $usr = get_user_by('email', $group_user);
            global $wpdb;
            $wpdb->update( 'wp_pmpro_memberships_users',
                array( 'membership_id' => $level_id),
                array( 'user_id' => $usr->ID ),
                array( '%d'),
                array( '%d' )
            );
        }
    }
    update_user_meta($user_id, 'old_level_id', $level_id);

}



add_filter('wp_handle_upload_prefilter', 'mp3_tag_remove_cutter', 10 );
function mp3_tag_remove_cutter($file){

    if($file['type'] == 'audio/mpg' || $file['type'] == 'audio/mpeg' || $file['type'] == 'audio/mp3') {
        require_once plugin_dir_path(__FILE__) . 'getid3/getid3.php';
        require_once plugin_dir_path(__FILE__) . 'getid3/write.php';


        $upload_dir = wp_upload_dir();
        $new_tmp_name  = $upload_dir['basedir'] . '/' . md5_file($file['tmp_name']).'.mp3';

        copy($file['tmp_name'], $new_tmp_name);

        //remove file ags
        $tagwriter = new getid3_writetags;
        $tagwriter->filename = $new_tmp_name;
        $tagwriter->overwrite_tags = true;
        $tagwriter->remove_other_tags = true;
        $tagwriter->tag_encoding = 'UTF-8';
        $tagwriter->remove_other_tags = true;


        if(!$tagwriter->WriteTags()){
            return null;
        }else{
            rename($new_tmp_name, $file['tmp_name']);

        }

    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'mp3_cutter', 15 );

function mp3_cutter( $file ){
    $upload_dir = wp_upload_dir();
    if($file['type'] == 'audio/mpg' || $file['type'] == 'audio/mpeg' || $file['type'] == 'audio/mp3'){

        require_once plugin_dir_path(__FILE__) . 'getid3/getid3.php';


        $path = $upload_dir['basedir'].'/short_musics/';
        if(file_exists($file['tmp_name'])) {
            $filename = md5_file($file['tmp_name']) . '.mp3';
            update_option('mp3', $filename);

            require_once plugin_dir_path(__FILE__) . 'MP3/class.mp3.php';


            //cut and copy file
            $mp3 = new mp3;
            $fileinf = $mp3->get_mp3($file['tmp_name']);
            if($fileinf['data']['length'] >= 120){

                $mp3->cut_mp3($file['tmp_name'], $path . $filename, 90, 120, 'second', false);
            }else if($fileinf['data']['length'] >= 60){
              
                $mp3->cut_mp3($file['tmp_name'], $path . $filename, 30, 60, 'second', false);
            }
        }
    }
    return $file;
}


function replaceMusic($music){

    if(!is_user_logged_in()){

        if(is_array($music)) {
            $_music = $music;
            $upload_dir = wp_upload_dir();
            $url = $upload_dir['baseurl'] . '/short_musics';
            $post_id = get_the_ID();
            $playlist = get_post_meta($post_id, 'playlist', true);
            $stripMusic = $playlist;

            $contents = file_get_contents($music['mp3']);
            $_music['mp3'] = $url . '/' . md5($contents) . '.mp3';
            //$_music['title'] = $music['mp3'];
            unset($contents);

            return $_music;
        }else{
            $upload_dir = wp_upload_dir();
            $url = $upload_dir['baseurl'] . '/short_musics';
            $post_id = get_the_ID();
            $playlist = get_post_meta($post_id, 'playlist', true);
            $stripMusic = $playlist;

                $contents = file_get_contents(trim($music));
                $_music = $url . '/' . md5($contents) . '.mp3';
                //$_music['title'] = $music['mp3'];
                unset($contents);

                return $_music;


        }
    }else{
        return $music;
    }
}


add_action( 'wp_ajax_update_playlist', 'update_playlist' ); // For logged in users
function update_playlist(){

    if(get_user_meta(get_current_user_id(), 'invited', true)){
        exit;
    }

    $playlist = get_user_meta(get_current_user_id(), 'user_playlist', true);
    if(empty($playlist) || !is_array($playlist)){
        $playlist = [];
    }
    $invited_peoples = get_user_meta( get_current_user_id(), 'invited_peoples', true );

    if($_POST['type'] == 'add') {
        $playlist[$_POST['song-id']] = $_POST['song-id'];
        //update_user_meta(get_current_user_id(), 'user_playlist', '');
        //update_user_meta(get_current_user_id(), 'user_playlist', $playlist);
        $logged_in_user = get_current_user_id();
        global $wpdb;
        if(!empty($_POST['old_playlist'])) {
            // Update user playlist and add playlist id
            $get_old_playlist = get_user_meta(get_current_user_id(),'user_playlist');
            if (strpos($get_old_playlist[0], $_POST['old_playlist']) === false) {
                update_user_meta(get_current_user_id(), 'user_playlist', $get_old_playlist[0].'|'.$_POST['old_playlist']);
            }
            //update User Playlist table to update songs
            $playlists = $wpdb->get_row("SELECT * FROM wp_users_playlist WHERE user_id = '".$logged_in_user."' and id = '".$_POST['old_playlist']."'");
            if (strpos($playlists->song_ids, $_POST['song-id']) === false) {
                $songs_playlist = $playlists->song_ids . '|'.$_POST['song-id'];
                $wpdb->query($wpdb->prepare("UPDATE wp_users_playlist SET song_ids='$songs_playlist' WHERE id='".$_POST['old_playlist']."'"));
            }
        }
        if(!empty($_POST['new_playlist'])) {
            // First create new playlist, add song to that playlist, then update the Usermeta table
            $wpdb->query("INSERT INTO wp_users_playlist (playlist_title, user_id, song_ids) VALUES ('".$_POST['new_playlist']."', '$logged_in_user', '".$_POST['song-id']."')"  );
            $lastid = $wpdb->insert_id;
            // Update Usermeta playlist
            $get_playlist = get_user_meta(get_current_user_id(),'user_playlist');
            $update_user_playlist = $get_playlist[0].'|'.$lastid;
            update_user_meta(get_current_user_id(), 'user_playlist', $update_user_playlist);
        }
        $link = site_url().'/playlist';
//        foreach($invited_peoples as $people) {
//            $subject = "Hear Your Part New Song Added to Playlist";
//
//            $message = '
//        <html>
//            <head>
//                <title>New song added to playlist on HearYourPart.com.</title>
//            </head>
//            <body>
//                <p>Dear Hear Your Part Team Member,</p>
//                <p>A new song has been added to your playlist on Hearyourpart.com. Please use the link below to access your playlist and listen to the song.</p>';
//            $message .='<p>' . $link . '</p>
//            <p>Thanks</p>
//            </body>
//        </html>';
//
//            $headers = "Content-type: text/html; charset=utf-8 \r\n";
//            $headers .= "From:  hearyourpart.com <invite@hearyourpart.com>\r\n";
//            mail($people, $subject, $message, $headers);
//        }
        echo json_encode(['success' => true, 'song' => $_POST['song-id']]);
    }elseif($_POST['type'] == 'remove'){
        unset($playlist[$_POST['song-id']]);
        update_user_meta(get_current_user_id(), 'user_playlist', $playlist);
        echo json_encode(['success' => true]);

    }
    exit;
}

add_action( 'wp_ajax_create_playlist', 'create_playlist' ); // For logged in users
function create_playlist() {
    global $wpdb;
    $logged_in_user = get_current_user_id();
    $wpdb->query("INSERT INTO wp_users_playlist (playlist_title, user_id, song_ids) VALUES ('".$_POST['new_playlist']."', '$logged_in_user', '')"  );
    $lastid = $wpdb->insert_id;
    // Update Usermeta playlist
    $get_playlist = get_user_meta(get_current_user_id(),'user_playlist');
    $update_user_playlist = $get_playlist[0].'|'.$lastid;
    update_user_meta(get_current_user_id(), 'user_playlist', $update_user_playlist);
    echo json_encode(['success' => true]);
    exit;
}

add_action( 'wp_ajax_notify_members', 'notify_members' ); // For logged in users
function notify_members() {
    $invited_peoples = get_user_meta( get_current_user_id(), 'invited_peoples', true );
    foreach($invited_peoples as $people) {
        $subject = "Hear Your Part New Song Added to Playlist";
        $message = '
        <html>
            <head>
                <title>New song added to playlist on HearYourPart.com.</title>
            </head>
            <body>
                <p>Dear Hear Your Part Team Member,</p>
                <p>A playlist has been created and/or updated on Hearyourpart.com.  Please log in to access your playlists.</p>
            <p>Thank you,</p>
            <p>Hear Your Part</p>
            </body>
        </html>';

        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From:  hearyourpart.com <hearyourpart@gmail.com>\r\n";
        wp_mail($people, $subject, $message, $headers);
    }
    echo json_encode(['success' => true]);
    exit;
}

add_action ( 'wp_ajax_remove_playlist', 'remove_playlist' ); // For logged in users
function remove_playlist() {
    global $wpdb;
    $wpdb->query('DELETE  FROM '.$wpdb->prefix.'users_playlist WHERE id = "'.$_POST['song-id'].'"');
    $get_playlist = get_user_meta(get_current_user_id(),'user_playlist');
    $replaced_string = str_replace('|'.$_POST['song-id'],'',$get_playlist[0]);
    update_user_meta(get_current_user_id(), 'user_playlist', $replaced_string);
    echo json_encode(['success' => true]);
    exit;
}

add_action ( 'wp_ajax_remove_song', 'remove_song' ); // For logged in users
function remove_song() {
    global $wpdb;
    $songs = $wpdb->get_row("SELECT * FROM wp_users_playlist WHERE id = '".$_POST['playlist-id']."'");
    $replaced_string = str_replace($_POST['song-id'],'',$songs->song_ids);
    $wpdb->query($wpdb->prepare("UPDATE wp_users_playlist SET song_ids='$replaced_string' WHERE id='".$_POST['playlist-id']."'"));
    echo json_encode(['success' => true]);
    exit;
}
// Apply filter
add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );

function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {


    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if ( $user && is_object( $user ) ) {


        $data =  get_user_meta($user->data->ID, 'ava',  true);
        if($data) {
            $avatar = "<img alt='{$alt}' src='data:$data' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }


    }


        return $avatar;


}

add_action('init', 'update_user_avatar');
add_action('admin_init', 'update_user_avatar');
//add_action('show_user_profile', 'update_user_avatar');

function update_user_avatar(){
    $id = get_current_user_id();
    if(!empty($_FILES['avatar']['tmp_name']) ){
        $path = $_FILES['avatar']['tmp_name'];
        $type = $_FILES['avatar']['type'];
        $data = file_get_contents($path);
        $base64 = $type . ';base64,' . base64_encode($data);

        update_user_meta($id, 'ava', $base64);
    }
}



add_action('wp_ajax_remove_people_send_email', 'remove_people_send_email');
function remove_people_send_email(){
    $current_user = wp_get_current_user();
    $group = get_user_meta($current_user->ID, 'invited_peoples', true);
    $key = array_search($_POST['remove_email'], $group);
    if($key !== false){
        unset($group[$key]);
    }
    update_user_meta($current_user->ID, 'invited_peoples',$group );


    $invation_user = get_user_by('email', $_POST['remove_email']);

    global $wpdb;
    $wpdb->update( 'wp_pmpro_memberships_users',
        array( 'status' => 'cancelled' ),
        array( 'user_id' => $invation_user->ID )
    );
    delete_user_meta($invation_user->ID, 'invited');
    wp_delete_user( $invation_user->ID );

    echo json_encode($group);
    exit;
}

//LOGIN REDIRECT

function user_page_login_redirect( $redirect_to, $request, $user ) {
    return $redirect_to->user_login;
}

add_filter( 'login_redirect', 'user_page_login_redirect', 10, 3 );



function new_modify_user_table( $column ) {
    $column['member_type'] = 'Member type';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'member_type' :
            if( get_the_author_meta( 'invited', $user_id ) && pmpro_getMembershipLevelForUser($user_id)){
                return 'Who was invited';
            }elseif(pmpro_getMembershipLevelForUser($user_id)){
                return 'Who subscribed';
            }
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );