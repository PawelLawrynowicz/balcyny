<?php
/**
 * Strona /o-nas/: profil działalności i osoby zarządzające (wszystko z formularza).
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	// Osoby pogrupowane: [ 'Zarząd' => [ osoba, ... ], 'Księgowość' => [...], ... ]
	$grupy = array();
	foreach ( (array) get_field( 'osoby' ) as $osoba ) {
		$grupy[ $osoba['grupa'] ][] = $osoba;
	}
	?>

	<section class="hero hero-podstrona">
		<div class="kontener">
			<h1><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="kontener">
		<?php if ( get_field( 'profil' ) ) : ?>
			<h2 class="sekcja-tytul">Profil działalności</h2>
			<div class="tekst"><?php echo do_shortcode( wp_kses_post( get_field( 'profil' ) ) ); ?></div>
		<?php endif; ?>

		<?php if ( $grupy ) : ?>
			<h2 class="sekcja-tytul">Zarządzanie Spółką</h2>
			<?php echo wp_kses_post( get_field( 'zarzad_wstep' ) ); ?>

			<?php foreach ( $grupy as $nazwa_grupy => $osoby ) : ?>
				<h3 class="grupa-tytul"><?php echo esc_html( $nazwa_grupy ); ?></h3>
				<div class="osoby">
					<?php foreach ( $osoby as $osoba ) : ?>
						<?php get_template_part( 'template-parts/osoba', null, $osoba ); ?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php endwhile; ?>

<?php get_footer();
