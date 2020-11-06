<?php
/* Template Name: Artists */

get_header();
$query = new WP_Query(array('post_type' => 'artists', 'posts_per_page' => -1));
$total_artists = $query->found_posts;
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
                            <span class="current">ARTISTS</span>
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
                                    <h1 class="archive-title h2 extra-bold">Artists</h1>
                                    <div class="entry-meta post-meta meta-font">
                                        <div class="post-meta-wrap">
                                            <div class="archive-found-post">
                                                <i class="fa fa-rss" aria-hidden="true"></i>
                                                <span><?php echo $total_artists . ' Artists'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="alphabet-filter-icon alphabet-filter-control">
                                <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                            </div> -->
                        </div>
                        <?php
                        //$archive_style = vidorev_archive_style();
                        //do_action('vidorev_archive_alphabet_filter', $archive_style);
                        ?>
                        <div class="blog-items blog-items-control site__row movie-grid">
                            <?php
                            while ($query->have_posts()) : $query->the_post();
                                global $post;
                                $featured_img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                            ?>
                                <article id="post-<?php echo $post->ID; ?>" class="post-item site__col post-<?php echo $post->ID; ?> vid_actor type-vid_actor status-publish has-post-thumbnail hentry pmpro-has-access">
                                    <div class="post-item-wrap">
                                        <div class="blog-pic">
                                            <div class="blog-pic-wrap">
                                                <a href="<?php echo site_url() ?>/albums?art=<?php echo $post->post_name ?>" title="<?php the_title() ?>" class="blog-img">
                                                    <img class="blog-picture ul-lazysizes-effect ls-is-cached ul-lazysizes-loaded" src="<?php echo $featured_img_url; ?>" alt="hosien-azour-447571-unsplash">
                                                    <span class="ul-placeholder-bg class-2x3"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="listing-content">
                                            <h3 class="entry-title h5 h6-mobile post-title">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title() ?></a>
                                            </h3>
                                        </div>
                                    </div>
                                </article>
                            <?php
                            endwhile; ?>
                        </div>
                        <div class="blog-pagination blog-pagination-control">
                            <nav class="pagination-infinite">
                                <div class="infinite-scroll-style infinite-scroll-control" data-template="template-parts/content" data-style="movie-grid">
                                    <div class="infinite-la-fire">
                                        <div>
                                        </div>
                                        <div>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
