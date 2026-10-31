<?php
/**
 * Strona Kontakt (WordPress używa tego pliku dla strony o adresie /kontakt/).
 * Adres i mapa są w szablonie, żeby redaktor ich przypadkiem nie zepsuł.
 */
get_header(); ?>

<div class="kontener">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>

		<div class="kontakt">
			<div class="kontakt-dane">
				<h2>Nasz adres</h2>
				<p>
					Bałcyny 15<br>
					14-100 Ostróda<br>
					Tel. <?php echo balcyny_telefon(); ?><br>
					E-mail: <a href="mailto:<?php echo esc_attr( BALCYNY_EMAIL ); ?>"><?php echo esc_html( BALCYNY_EMAIL ); ?></a>
				</p>
				<p>
					<a class="przycisk" href="https://www.google.com/maps/dir/?api=1&amp;destination=<?php echo esc_attr( BALCYNY_GPS ); ?>" target="_blank" rel="noopener">Wyznacz trasę</a>
				</p>

				<?php the_content(); // dodatkowy tekst wpisany w panelu (opcjonalnie) ?>
			</div>

			<div class="kontakt-mapa">
				<iframe
					src="https://maps.google.com/maps?q=<?php echo esc_attr( BALCYNY_GPS ); ?>&amp;z=14&amp;output=embed"
					title="Mapa dojazdu do ZPD Bałcyny"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					allowfullscreen></iframe>
			</div>
		</div>

		<?php
		// Osoby wpisane w formularzu strony O nas – tu się ich nie edytuje.
		$o_nas = get_page_by_path( 'o-nas' );
		$osoby = $o_nas ? get_field( 'osoby', $o_nas->ID ) : array();
		?>
		<?php if ( $osoby ) : ?>
			<h2 class="sekcja-tytul">Osoby kontaktowe</h2>
			<div class="osoby">
				<?php foreach ( $osoby as $osoba ) : ?>
					<?php get_template_part( 'template-parts/osoba', null, $osoba ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
</div>

<?php get_footer();
