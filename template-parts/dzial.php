<?php
/**
 * Strona działu: nagłówek z opisem i liczbami, pod nim aktualizacje z tego działu.
 * Używają go page-produkcja-roslinna.php i page-hodowla.php.
 */
$dzial  = get_post_field( 'post_name' );
$zdjecie = get_field( 'zdjecie_naglowka' );
$tlo     = $zdjecie ? wp_get_attachment_image_url( $zdjecie, 'full' ) : get_theme_file_uri( 'images/pola-z-lotu.jpg' );
$liczby  = get_field( 'liczby' );
$pozycje = get_field( 'pozycje' );
$tytul_pozycji = ( $dzial === 'hodowla' ) ? 'Co hodujemy' : 'Co uprawiamy';
?>

<section class="hero hero-dzial" style="background-image: linear-gradient(to bottom, rgba(0,0,0,.1), rgba(20,45,28,.8)), url('<?php echo esc_url( $tlo ); ?>');">
	<div class="kontener">
		<h1><?php the_title(); ?></h1>
		<?php echo do_shortcode( wp_kses_post( get_field( 'wstep' ) ) ); ?>
	</div>
</section>

<div class="kontener">
	<?php if ( $liczby ) : ?>
		<div class="liczby">
			<?php foreach ( $liczby as $liczba ) : ?>
				<div class="liczba">
					<strong><?php echo esc_html( $liczba['wartosc'] ); ?></strong>
					<span><?php echo esc_html( $liczba['opis'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $pozycje ) : ?>
		<h2 class="sekcja-tytul"><?php echo esc_html( $tytul_pozycji ); ?></h2>
		<div class="pozycje">
			<?php foreach ( $pozycje as $pozycja ) : ?>
				<div class="pozycja">
					<div class="pozycja-naglowek">
						<h3><?php echo esc_html( $pozycja['nazwa'] ); ?></h3>
						<?php if ( $pozycja['ilosc'] ) : ?>
							<span class="pozycja-ilosc"><?php echo esc_html( $pozycja['ilosc'] ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( $pozycja['opis'] ) : ?>
						<p><?php echo esc_html( $pozycja['opis'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<h2 class="sekcja-tytul">Aktualizacje</h2>
	<?php $aktualnosci = balcyny_aktualnosci( 5, $dzial ); ?>
	<?php if ( $aktualnosci->have_posts() ) : ?>
		<?php while ( $aktualnosci->have_posts() ) : $aktualnosci->the_post(); ?>
			<?php get_template_part( 'template-parts/wpis-aktualnosci' ); ?>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php if ( $aktualnosci->found_posts > 5 ) : ?>
			<p><a class="przycisk" href="<?php echo esc_url( balcyny_link_aktualnosci( $dzial ) ); ?>">Wszystkie aktualizacje z działu →</a></p>
		<?php endif; ?>
	<?php else : ?>
		<p>Wkrótce pojawią się tu aktualizacje z działu.</p>
	<?php endif; ?>
</div>
