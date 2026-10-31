<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="naglowek">
	<div class="kontener">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( get_theme_file_uri( 'images/logo.png' ) ); ?>" alt="" width="60" height="56">
			<span><?php bloginfo( 'name' ); ?></span>
		</a>
		<nav class="menu-glowne">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'glowne',
				'container'      => false,
				'fallback_cb'    => false,
			) );
			?>
		</nav>
	</div>
</header>

<main class="tresc">
