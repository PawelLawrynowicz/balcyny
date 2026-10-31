<?php
/**
 * Karta jednej osoby (dane z formularza strony O nas).
 * Używana na stronach O nas i Kontakt: get_template_part( 'template-parts/osoba', null, $osoba ).
 */
$osoba = $args;
?>
<div class="osoba">
	<?php if ( $osoba['funkcja'] ) : ?>
		<div class="osoba-funkcja"><?php echo esc_html( $osoba['funkcja'] ); ?></div>
	<?php endif; ?>
	<div class="osoba-nazwa"><?php echo esc_html( $osoba['nazwa'] ); ?></div>
	<?php if ( $osoba['telefon'] ) : ?>
		<div>Tel. <?php echo balcyny_telefon( $osoba['telefon'] ); ?></div>
	<?php endif; ?>
	<?php if ( $osoba['email'] ) : ?>
		<div><a href="mailto:<?php echo esc_attr( $osoba['email'] ); ?>"><?php echo esc_html( $osoba['email'] ); ?></a></div>
	<?php endif; ?>
</div>
