<?php
/**
 * Jedna aktualność jako karta (zdjęcie, data, tytuł, początek treści).
 * Używana na stronach działów, na liście aktualności i na stronie głównej.
 */
$zdjecie  = get_field( 'zdjecie' );
$miniatura = $zdjecie ? '' : balcyny_miniatura_youtube( get_field( 'film', false, false ) ); // sam link, bez odtwarzacza
?>
<article class="karta">
	<a href="<?php the_permalink(); ?>">
		<?php if ( $zdjecie ) : ?>
			<?php echo wp_get_attachment_image( $zdjecie, 'medium_large', false, array( 'class' => 'karta-zdjecie' ) ); ?>
		<?php elseif ( $miniatura ) : ?>
			<div class="karta-film">
				<img class="karta-zdjecie" src="<?php echo esc_url( $miniatura ); ?>" alt="" loading="lazy">
			</div>
		<?php endif; ?>
		<div class="karta-tresc">
			<div class="wpis-data"><?php echo get_the_date(); ?></div>
			<h3><?php the_title(); ?></h3>
			<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_field( 'tresc' ) ), 25 ) ); ?></p>
		</div>
	</a>
</article>
