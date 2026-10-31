<?php
/**
 * Strona /hodowla/ – wygląd wspólny dla działów, patrz template-parts/dzial.php.
 */
get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/dzial' );
endwhile;
get_footer();
