<?php
/**
 * Zwykła podstrona (np. Historia, Doświadczenia i UWM).
 */
get_header(); ?>

<div class="kontener">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php get_footer();
