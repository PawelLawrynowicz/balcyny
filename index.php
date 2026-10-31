<?php
/**
 * Szablon awaryjny – WordPress używa go, gdy nie znajdzie lepszego.
 */
get_header(); ?>

<div class="kontener">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="wpis">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="wpis-data"><?php echo get_the_date(); ?></div>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p>Brak treści.</p>
	<?php endif; ?>
</div>

<?php get_footer();
