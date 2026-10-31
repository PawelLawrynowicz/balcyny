<?php
/**
 * Pojedyncza aktualność.
 */
get_header(); ?>

<div class="kontener kontener-waski">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$dzialy = balcyny_dzialy();
		$dzial  = get_field( 'dzial' );
		$zdjecie = get_field( 'zdjecie' );
		$film    = get_field( 'film' );
		?>
		<article>
			<div class="wpis-data">
				<?php echo get_the_date(); ?>
				<?php if ( isset( $dzialy[ $dzial ] ) && $dzial !== 'ogolne' ) : ?>
					· <a href="<?php echo esc_url( home_url( '/' . $dzial . '/' ) ); ?>"><?php echo esc_html( $dzialy[ $dzial ] ); ?></a>
				<?php endif; ?>
			</div>
			<h1><?php the_title(); ?></h1>

			<?php if ( $zdjecie ) : ?>
				<?php echo wp_get_attachment_image( $zdjecie, 'large', false, array( 'class' => 'wpis-zdjecie' ) ); ?>
			<?php endif; ?>

			<?php echo wp_kses_post( get_field( 'tresc' ) ); ?>

			<?php if ( $film ) : ?>
				<div class="film"><?php echo $film; // kod odtwarzacza z YouTube, generuje go WordPress ?></div>
			<?php endif; ?>
		</article>

		<p><a href="<?php echo esc_url( get_post_type_archive_link( 'aktualnosc' ) ); ?>">← Wszystkie aktualności</a></p>
	<?php endwhile; ?>
</div>

<?php get_footer();
