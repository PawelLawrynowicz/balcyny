<?php
/**
 * Strona /doswiadczenia/ (Doświadczenia i UWM): zdjęcie w nagłówku, sekcje z formularza
 * (tekst po lewej, film albo zdjęcie po prawej) i na dole aktualności z tego działu.
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$zdjecie = get_field( 'zdjecie_naglowka' );
	$tlo     = $zdjecie ? wp_get_attachment_image_url( $zdjecie, 'full' ) : get_theme_file_uri( 'images/pola-z-lotu.jpg' );
	?>
	<section class="hero hero-zdjecie" style="background-image: linear-gradient(to bottom, rgba(0,0,0,.05), rgba(20,45,28,.8)), url('<?php echo esc_url( $tlo ); ?>');">
		<div class="kontener">
			<h1><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="kontener">
		<?php foreach ( (array) get_field( 'sekcje' ) as $sekcja ) : ?>
			<?php $ma_media = ! empty( $sekcja['film'] ) || ! empty( $sekcja['zdjecie'] ); ?>
			<section class="sekcja<?php echo $ma_media ? ' sekcja-z-media' : ''; ?>">
				<h2 class="sekcja-tytul"><?php echo esc_html( $sekcja['tytul'] ); ?></h2>
				<div class="sekcja-kolumny">
					<div class="tekst"><?php echo do_shortcode( wp_kses_post( $sekcja['tresc'] ) ); ?></div>

					<?php if ( ! empty( $sekcja['film'] ) ) : ?>
						<div class="sekcja-media film"><?php echo $sekcja['film']; // kod odtwarzacza z YouTube, generuje go WordPress ?></div>
					<?php elseif ( ! empty( $sekcja['zdjecie'] ) ) : ?>
						<div class="sekcja-media"><?php echo wp_get_attachment_image( $sekcja['zdjecie'], 'large', false, array( 'class' => 'sekcja-zdjecie' ) ); ?></div>
					<?php endif; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<?php $aktualnosci = balcyny_aktualnosci( 5, 'doswiadczenia' ); ?>
		<?php if ( $aktualnosci->have_posts() ) : ?>
			<h2 class="sekcja-tytul">Aktualizacje</h2>
			<?php while ( $aktualnosci->have_posts() ) : $aktualnosci->the_post(); ?>
				<?php get_template_part( 'template-parts/wpis-aktualnosci' ); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php if ( $aktualnosci->found_posts > 5 ) : ?>
				<p><a class="przycisk" href="<?php echo esc_url( balcyny_link_aktualnosci( 'doswiadczenia' ) ); ?>">Wszystkie aktualizacje z działu →</a></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endwhile; ?>

<?php get_footer();
