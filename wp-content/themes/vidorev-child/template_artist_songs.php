<?php

/**
 * Template Name: Artist Songs
 */

get_header();
?>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<?php
$song_slug = $_GET['song'];
$song_count = $_GET['count'];
$song_post_id = get_page_by_path($song_slug, OBJECT, 'songs');

$artists = $wpdb->get_results(
    $wpdb->prepare("SELECT meta_value, meta_key FROM $wpdb->postmeta where post_id = " . $song_post_id->ID . " and meta_key = 'artist'")
);
$artist_id = unserialize($artists[0]->meta_value);
$artist_id = $artist_id[0];
$artists_name = get_the_title($artist_id);
$artist_slug  = get_post($artist_id);
$artist_slug = $artist_slug->post_name;
$featured_img_url = wp_get_attachment_url(get_post_thumbnail_id($artist_id));
$album_title = get_the_title($song_post_id);
global $wpdb;

$album_songs = array();

for ($i = 0; $i < $song_count; $i++) {
    $tracks = $wpdb->get_results(
        $wpdb->prepare("SELECT meta_value, meta_key FROM $wpdb->postmeta where post_id = " . $song_post_id->ID . " and meta_key = 'tracks_" . $i . "_song'")
    );
    $song_track_title = 'tracks_' . $i . '_title';
    $song_title  = get_post_meta($song_post_id->ID, $song_track_title);

    $song_tracks = array(
        'post_id' => $song_post_id->ID,
        'track_id' => $tracks[0]->meta_value,
        'track_title' => $song_title[0]
    );
    $album_songs[] = $song_tracks;
}
$track_count = 1;
$playlist = '';
$playlist_songs = array();
foreach ($album_songs as $song) {
    $audio_src = wp_get_attachment_url($song['track_id']);
    $song_title = get_the_title($song['post_id']);
    $track_title = $song['track_title'];
    $playlist_songs[] = array(
        'track' => $track_count,
        'name' => $track_title,
        'file' => $audio_src,
    );
    $track_count++;
}
$playlist = json_encode($playlist_songs);
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
                            <span><a href="<?php echo site_url() ?>/albums?art=<?php echo $artist_slug ?>"><?php echo $artists_name ?></a></span>
                            <i class="fa fa-angle-right icon-arrow"></i>
                            <span class="current">SONGS</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site__row sidebar-direction" style="transform: none;">
                <aside id="main-sidebar" class="site__col main-sidebar main-sidebar-control" style="transform:none">
                    <div class="sidebar-content sidebar-content-control">
                        <div class="theiaStickySidebar">
                            <div class="sidebar-content-inner sidebar-content-inner-control">
                                <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
                                    <div class="archive-heading">
                                        <div class="archive-content">
                                            <div class="archive-img-lev"></div>
                                            <div class="archive-text">
                                                <h1 class="archive-title h2 extra-bold"><?php echo $album_title; ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?php echo $featured_img_url ?>">
                            </div>
                        </div>
                    </div>
                </aside>
                <main id="main-content" class="site__col main-content">
                    <div class="single-post-wrapper global-single-wrapper">
                        <article class="single-post-content global-single-content post-524 post type-post status-publish format-video has-post-thumbnail hentry category-music tag-152 tag-animation tag-dreamworks tag-spain tag-stereo tag-tv-series post_format-post-format-video pmpro-has-access">
                            <div class="entry-content">
                                <div class="column add-bottom">
                                    <div id="mainwrap">
                                        <div id="nowPlay">
                                            <span id="npAction">Paused...</span><span id="npTitle"></span>
                                        </div>
                                        <div id="audiowrap">
                                            <div id="audio0">
                                                <audio id="audio1" preload controls>Your browser does not support HTML5 Audio! 😢</audio>
                                            </div>
                                            <div id="tracks">
                                                <a id="btnPrev">&vltri;</a><a id="btnNext">&vrtri;</a>
                                            </div>
                                        </div>
                                        <div id="plwrap">
                                            <ul id="plList"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(function($) {
        var playlist = <?php echo $playlist ?>;
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var player = new Plyr('#audio1', {
                controls: [
                    'restart',
                    'play',
                    'progress',
                    'current-time',
                    'mute',
                    'volume',
                ]
            });
            // initialize playlist and controls
            var index = 0,
                playing = false,
                //mediaPath = 'https://archive.org/download/mythium/',
                extension = '',
                tracks = playlist,
                buildPlaylist = $.each(tracks, function(key, value) {
                    var trackNumber = value.track,
                        trackName = value.name,
                        trackDuration = value.duration;
                    if (trackNumber.toString().length === 1) {
                        trackNumber = '0' + trackNumber;
                    }
                    $('#plList').append('<li> \
                    <div class="plItem"> \
                        <span class="plNum">' + trackNumber + '.</span> \
                        <span class="plTitle">' + trackName + '</span> \
                    </div> \
                </li>');
                }),
                trackCount = tracks.length,
                npAction = $('#npAction'),
                npTitle = $('#npTitle'),
                audio = $('#audio1').on('play', function() {
                    playing = true;
                    npAction.text('Now Playing...');
                }).on('pause', function() {
                    playing = false;
                    npAction.text('Paused...');
                }).on('ended', function() {
                    npAction.text('Paused...');
                    if ((index + 1) < trackCount) {
                        index++;
                        loadTrack(index);
                        audio.play();
                    } else {
                        audio.pause();
                        index = 0;
                        loadTrack(index);
                    }
                }).get(0),
                btnPrev = $('#btnPrev').on('click', function() {
                    if ((index - 1) > -1) {
                        index--;
                        loadTrack(index);
                        if (playing) {
                            audio.play();
                        }
                    } else {
                        audio.pause();
                        index = 0;
                        loadTrack(index);
                    }
                }),
                btnNext = $('#btnNext').on('click', function() {
                    if ((index + 1) < trackCount) {
                        index++;
                        loadTrack(index);
                        if (playing) {
                            audio.play();
                        }
                    } else {
                        audio.pause();
                        index = 0;
                        loadTrack(index);
                    }
                }),
                li = $('#plList li').on('click', function() {
                    var id = parseInt($(this).index());
                    if (id !== index) {
                        playTrack(id);
                    }
                }),
                loadTrack = function(id) {
                    $('.plSel').removeClass('plSel');
                    $('#plList li:eq(' + id + ')').addClass('plSel');
                    npTitle.text(tracks[id].name);
                    index = id;
                    audio.src = tracks[id].file;
                    updateDownload(id, audio.src);
                },
                updateDownload = function(id, source) {
                    player.on('loadedmetadata', function() {
                        $('a[data-plyr="download"]').attr('href', source);
                    });
                },
                playTrack = function(id) {
                    loadTrack(id);
                    audio.play();
                };
            extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
            loadTrack(index);
        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>
<style>
    /* Audio Player Style */
    /* Font Family
================================================== */

    @import url('https://fonts.googleapis.com/css?family=Oxygen:300,400,700');

    /* Audio Player Styles
================================================== */

    audio {
        display: none;
    }

    #audiowrap,
    #plwrap {
        margin: 0 auto;
    }

    #tracks {
        font-size: 0;
        position: relative;
        text-align: center;
    }

    #nowPlay {
        display: block;
        font-size: 0;
    }

    #nowPlay span {
        display: inline-block;
        font-size: 1.05rem;
        vertical-align: top;
    }

    #nowPlay span#npAction {
        /* padding: 21px; */
        width: 30%;
    }

    #nowPlay span#npTitle {
        /* padding: 21px; */
        text-align: right;
        width: 70%;
    }

    #plList {
        padding-left: 0px;
    }

    #plList li {
        cursor: pointer;
        display: block;
        margin: 0;
        padding: 21px 0;
    }

    #plList li:hover {
        background-color: rgba(0, 0, 0, .1);
    }

    .plItem {
        position: relative;
    }

    .plTitle {
        left: 50px;
        overflow: hidden;
        position: absolute;
        right: 65px;
        text-overflow: ellipsis;
        top: 0;
        white-space: nowrap;
    }

    .plNum {
        padding-left: 21px;
        width: 25px;
    }

    .plLength {
        padding-left: 21px;
        position: absolute;
        right: 21px;
        top: 0;
    }

    .plSel,
    .plSel:hover {
        background-color: rgba(0, 0, 0, .5);
        color: #fff;
        cursor: default !important;
    }

    #tracks a {
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-size: 2.3rem;
        height: 35px;
        line-height: .175;
        margin: 0 5px 30px;
        padding: 10px 15px;
        text-decoration: none;
        transition: background .3s ease;
    }

    #tracks a:last-child {
        margin-left: 0;
    }

    #tracks a:hover,
    #tracks a:active {
        background-color: rgba(0, 0, 0, .1);
        color: #fff;
    }

    #tracks a::-moz-focus-inner {
        border: 0;
        padding: 0;
    }


    /* Plyr Overrides
================================================== */

    .plyr--audio .plyr__controls {
        background-color: rgba(0, 0, 0.4);
        border: none;
        color: #fff;
        padding: 20px 20px 20px 13px;
        width: 100%;
    }

    a.plyr__controls__item.plyr__control:hover,
    .plyr--audio .plyr__controls button:hover,
    .plyr--audio .plyr__controls button.tab-focus:focus,
    .plyr__play-large {
        background-color: rgba(0, 0, 0, .1);
    }

    .plyr__progress--played,
    .plyr__volume--display {
        color: rgba(0, 0, 0, .1);
    }

    .plyr--audio .plyr__progress--buffer,
    .plyr--audio .plyr__volume--display {
        background: rgba(0, 0, 0, .1);
    }

    .plyr--audio .plyr__progress--buffer {
        color: rgba(0, 0, 0, .1);
    }

    .plyr__controls button {
        min-width: 20px;
    }

    /* Media Queries
================================================== */

    @media only screen and (max-width:600px) {
        #nowPlay span#npAction {
            display: none;
        }

        #nowPlay span#npTitle {
            display: block;
            text-align: center;
            width: 100%;
        }
    }

    /* Audio Player Style Ends */
</style>
<?php
get_footer();
