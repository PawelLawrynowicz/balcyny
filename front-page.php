<?php
/**
 * Strona główna.
 */
get_header(); ?>

<section class="hero">
	<div class="kontener">
		<h1>Zakład Produkcyjno-Doświadczalny „Bałcyny”</h1>
		<p>Gospodarstwo rolne Uniwersytetu Warmińsko-Mazurskiego w Olsztynie. Produkujemy mleko, żywiec
		i zboża, prowadzimy doświadczenia polowe dla katedr UWM – w tym Bałcyńskie monokultury, prowadzone nieprzerwanie od 1967 roku.</p>
	</div>
</section>

<div class="kontener">
	<div class="kafelki">
		<a class="kafelek" href="<?php echo esc_url( home_url( '/produkcja-roslinna/' ) ); ?>">
			<h2>Produkcja roślinna</h2>
			<p>Pszenica, rzepak, burak cukrowy – uprawy i odmiany w kolejnych sezonach.</p>
		</a>
		<a class="kafelek" href="<?php echo esc_url( home_url( '/hodowla/' ) ); ?>">
			<h2>Hodowla zwierzęca</h2>
			<p>Bydło mleczne i opasowe, trzoda, owce. Aktualny stan stada i oferta.</p>
		</a>
		<a class="kafelek" href="<?php echo esc_url( home_url( '/doswiadczenia/' ) ); ?>">
			<h2>Doświadczenia i UWM</h2>
			<p>Bałcyńskie monokultury, doświadczenia dla katedr, praktyki studenckie, dni pola.</p>
		</a>
	</div>

	<?php $aktualnosci = balcyny_aktualnosci( 3 ); ?>
	<?php if ( $aktualnosci->have_posts() ) : ?>
		<h2 class="sekcja-tytul">Aktualności</h2>
		<div class="karty">
			<?php while ( $aktualnosci->have_posts() ) : $aktualnosci->the_post(); ?>
				<?php get_template_part( 'template-parts/karta-aktualnosci' ); ?>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
</div>

<?php get_footer();
