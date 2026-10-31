<?php
/**
 * Lista wszystkich aktualności (/aktualnosci/), w całości, po 10 na stronę.
 * Z ?dzial=produkcja-roslinna pokazuje tylko jeden dział (filtr w functions.php).
 */
$dzialy = balcyny_dzialy();
$wybrany = balcyny_wybrany_dzial();
get_header(); ?>

<div class="kontener">
	<h1>Aktualności<?php echo $wybrany ? ': ' . esc_html( $dzialy[ $wybrany ] ) : ''; ?></h1>

	<nav class="filtry">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'aktualnosc' ) ); ?>" class="<?php echo $wybrany ? '' : 'aktywny'; ?>">Wszystkie</a>
		<?php foreach ( $dzialy as $klucz => $nazwa ) : ?>
			<?php if ( $klucz === 'ogolne' ) continue; ?>
			<a href="<?php echo esc_url( balcyny_link_aktualnosci( $klucz ) ); ?>" class="<?php echo $wybrany === $klucz ? 'aktywny' : ''; ?>"><?php echo esc_html( $nazwa ); ?></a>
		<?php endforeach; ?>
	</nav>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/wpis-aktualnosci', null, array( 'pokaz_dzial' => ! $wybrany ) ); ?>
		<?php endwhile; ?>
		<?php the_posts_pagination( array( 'prev_text' => '← Nowsze', 'next_text' => 'Starsze →' ) ); ?>
	<?php else : ?>
		<p>Brak aktualności.</p>
	<?php endif; ?>
</div>

<?php get_footer();
