<?php

/**
 * Template Name: Artist Album
 */

get_header();
?>
<?php
$artist_id = get_page_by_path($_GET['art'], OBJECT, 'artists');
global $wpdb;

$metas = $wpdb->get_results(
    $wpdb->prepare("SELECT meta_value,post_id FROM $wpdb->postmeta where meta_key = %s", 'artist')
);
$songs_postIDs = array();
$songs_tracksIDS = array();
$album_songs = array();
foreach ($metas as $value) {
    if (in_array($artist_id->ID, unserialize($value->meta_value))) {
        array_push($songs_postIDs, $value->post_id);
    }
}

foreach ($songs_postIDs as $album) {
    $songs = $wpdb->get_results(
        $wpdb->prepare("SELECT meta_value, meta_key FROM $wpdb->postmeta where post_id = " . $album . " and meta_key = 'tracks'")
    );
    $songsTracks = array(
        'tracks' => $songs[0]->meta_value,
        'post_id' => $album
    );
    $songs_tracksIDS[] = $songsTracks;
}
?>
<div id="primary-content-wrap" class="primary-content-wrap" style="transform: none;">
    <div class="primary-content-control" style="transform: none;">
        <div class="site__container fullwidth-vidorev-ctrl container-control" style="transform: none;">
            <div class="site__row nav-breadcrumbs-elm">
                <div class="site__col">
                    <div class="nav-breadcrumbs navigation-font nav-font-size-12">
                        <div class="nav-breadcrumbs-wrap">
                            <a class="neutral" href="<?php echo site_url() ?>">Home</a>
                            <i class="fa fa-angle-right icon-arrow"></i>
                            <span><a href="<?php echo site_url() ?>/artists">Artists</a></span>
                            <i class="fa fa-angle-right icon-arrow"></i>
                            <span class="current">Artist Albums</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site__row sidebar-direction" style="transform: none;">
                <main id="main-content" class="site__col main-content">
                    <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
                        <div class="archive-heading">
                            <div class="archive-content">
                                <div class="archive-img-lev"></div>
                                <div class="archive-text">
                                    <h1 class="archive-title h2 extra-bold">Artist Albums</h1>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($songs_postIDs)) { ?>
                            <div class="blog-items blog-items-control site__row movie-grid">
                                <?php
                                foreach ($songs_tracksIDS as $song) {
                                    $song_post = get_post($song['post_id']);
                                    $featured_img_url = wp_get_attachment_url(get_post_thumbnail_id($artist_id));
                                ?>
                                    <article id="post-<?php echo $song_post->ID; ?>" class="post-item site__col post-<?php echo $song_post->ID; ?> vid_actor type-vid_actor status-publish has-post-thumbnail hentry pmpro-has-access">
                                        <div class="post-item-wrap">
                                            <div class="blog-pic">
                                                <div class="blog-pic-wrap">
                                                    <a href="<?php echo site_url() ?>/songs?song=<?php echo $song_post->post_name ?>&count=<?php echo $song['tracks'] ?>" title="<?php echo $song_post->post_title ?>" class="blog-img">
                                                        <img class="blog-picture ul-lazysizes-effect ls-is-cached ul-lazysizes-loaded" src="<?php echo $featured_img_url; ?>" alt="hosien-azour-447571-unsplash">
                                                        <span class="ul-placeholder-bg class-2x3"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="listing-content">
                                                <h3 class="entry-title h5 h6-mobile post-title">
                                                    <a href="<?php the_permalink(); ?>" title="<?php echo $song_post->post_title ?>"><?php echo $song_post->post_title ?></a>
                                                </h3>
                                                <span><?php echo $song['tracks']  ?> Songs</span>
                                            </div>
                                        </div>
                                    </article>
                                <?php
                                } ?>
                            </div>
                        <?php } else {
                            echo 'No albums added by this author!';
                        } ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
