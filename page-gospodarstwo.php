<?php
/**
 * Strona /gospodarstwo/: wybór działu – kafelki Produkcja roślinna i Hodowla zwierzęca.
 * Opis i liczby na kafelkach pochodzą z formularzy stron działów.
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<section class="hero hero-podstrona">
		<div class="kontener">
			<h1><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="kontener">
		<?php the_content(); // opcjonalny tekst wstępny wpisany w panelu ?>

		<div class="dzialy">
			<?php foreach ( array( 'produkcja-roslinna', 'hodowla' ) as $slug ) : ?>
				<?php
				$strona = get_page_by_path( $slug );
				if ( ! $strona ) {
					continue;
				}
				$zdjecie = get_field( 'zdjecie_naglowka', $strona->ID );
				$liczby  = array_slice( (array) get_field( 'liczby', $strona->ID ), 0, 2 );
				$opis    = wp_trim_words( wp_strip_all_tags( do_shortcode( (string) get_field( 'wstep', $strona->ID ) ) ), 30 );
				?>
				<a class="dzial-kafel" href="<?php echo esc_url( get_permalink( $strona ) ); ?>">
					<div class="dzial-kafel-gora"<?php if ( $zdjecie ) : ?> style="background-image: linear-gradient(to bottom, rgba(0,0,0,.05), rgba(20,45,28,.75)), url('<?php echo esc_url( wp_get_attachment_image_url( $zdjecie, 'large' ) ); ?>');"<?php endif; ?>>
						<h2><?php echo esc_html( get_the_title( $strona ) ); ?></h2>
					</div>
					<div class="dzial-kafel-tresc">
						<?php if ( $opis ) : ?>
							<p><?php echo esc_html( $opis ); ?></p>
						<?php endif; ?>
						<?php if ( $liczby ) : ?>
							<div class="dzial-kafel-liczby">
								<?php foreach ( $liczby as $liczba ) : ?>
									<div><strong><?php echo esc_html( $liczba['wartosc'] ); ?></strong> <?php echo esc_html( $liczba['opis'] ); ?></div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<span class="dzial-kafel-link">Zobacz →</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
<?php endwhile; ?>

<?php get_footer();
