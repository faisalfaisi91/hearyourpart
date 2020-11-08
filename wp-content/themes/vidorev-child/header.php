<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php do_action('vidorev_meta_tags'); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class('close-side-menu'); ?>>

	<?php
	wp_body_open();
	$header_style = vidorev_header_style();
	?>

	<div id="site-wrap-parent" class="site-wrap-parent site-wrap-parent-control">

		<?php
		if ($header_style == 'side') {
			get_template_part('template-parts/header-navigation-styles/header', $header_style . '-menu');
		}
		?>

		<div id="site-wrap-children" class="site-wrap-children site-wrap-children-control">

			<?php if (!beeteam368_return_embed()) { ?>

				<?php do_action('vidorev_instagram_feed', 'header'); ?>

				<header id="site-header" class="site-header header-<?php echo esc_attr($header_style); ?> site-header-control">
					<?php
					get_template_part('template-parts/header-navigation-styles/header', $header_style);
					?>

					<?php do_action('vidorev_page_slider'); ?>
				</header>

			<?php } ?>