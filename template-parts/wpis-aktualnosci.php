<?php
/**
 * Cała aktualność pokazana w miejscu (bez przechodzenia na osobną stronę):
 * data, tytuł, tekst po lewej, film albo zdjęcie po prawej.
 * Używana na stronach działów i na liście wszystkich aktualności.
 */
$zdjecie = get_field( 'zdjecie' );
$film    = get_field( 'film' );
$dzialy  = balcyny_dzialy();
$dzial   = get_field( 'dzial' );
?>
<article class="wpis-akt<?php echo ( $zdjecie || $film ) ? ' wpis-akt-z-media' : ''; ?>" id="aktualnosc-<?php the_ID(); ?>">
	<div class="wpis-akt-tekst">
		<div class="wpis-data">
			<?php echo get_the_date(); ?>
			<?php if ( ! empty( $args['pokaz_dzial'] ) && isset( $dzialy[ $dzial ] ) && $dzial !== 'ogolne' ) : ?>
				· <?php echo esc_html( $dzialy[ $dzial ] ); ?>
			<?php endif; ?>
		</div>
		<h3><?php the_title(); ?></h3>
		<?php echo do_shortcode( wp_kses_post( get_field( 'tresc' ) ) ); ?>
	</div>

	<?php if ( $film ) : ?>
		<div class="film"><?php echo $film; // kod odtwarzacza z YouTube, generuje go WordPress ?></div>
	<?php elseif ( $zdjecie ) : ?>
		<?php echo wp_get_attachment_image( $zdjecie, 'large', false, array( 'class' => 'wpis-akt-zdjecie' ) ); ?>
	<?php endif; ?>
</article>
