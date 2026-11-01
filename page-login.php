<?php
/**
 * Strona /login/: logowanie i formularz aktualności dla pracowników, bez wchodzenia do panelu WordPressa.
 * Niezalogowany widzi logowanie, zalogowany – formularz i listę swoich ostatnich wpisów.
 * ?edytuj=ID otwiera istniejącą aktualność do poprawki, ?zapisano=ID pokazuje potwierdzenie,
 * ?usun=ID przenosi aktualność do kosza (administrator może ją przywrócić przez 30 dni).
 */

// Zapis formularza musi się odbyć, zanim strona zacznie się wyświetlać.
if ( function_exists( 'acf_form_head' ) ) {
	acf_form_head();
}

$adres_strony = get_permalink();
$moze_dodawac = current_user_can( 'publish_posts' );

// Usuwanie: tylko aktualność, z ważnym zabezpieczeniem linku i uprawnieniem do usunięcia.
if ( isset( $_GET['usun'] ) ) {
	$usun = absint( $_GET['usun'] );
	if ( get_post_type( $usun ) === 'aktualnosc'
		&& current_user_can( 'delete_post', $usun )
		&& wp_verify_nonce( $_GET['_wpnonce'] ?? '', 'usun-aktualnosc-' . $usun )
	) {
		$tytul = get_the_title( $usun );
		wp_trash_post( $usun );
		wp_safe_redirect( add_query_arg( 'usunieto', rawurlencode( $tytul ), $adres_strony ) );
		exit;
	}
}
$usunieto = isset( $_GET['usunieto'] ) ? sanitize_text_field( wp_unslash( $_GET['usunieto'] ) ) : '';

// Poprawka istniejącego wpisu – tylko aktualność, którą ten użytkownik może edytować.
$edytuj = isset( $_GET['edytuj'] ) ? absint( $_GET['edytuj'] ) : 0;
if ( $edytuj && ( get_post_type( $edytuj ) !== 'aktualnosc' || ! current_user_can( 'edit_post', $edytuj ) ) ) {
	$edytuj = 0;
}
$zapisano = isset( $_GET['zapisano'] ) ? absint( $_GET['zapisano'] ) : 0;

get_header(); ?>

<div class="kontener kontener-waski panel-redaktora">

	<?php if ( ! is_user_logged_in() ) : ?>

		<h1>Zaloguj się</h1>
		<p>Ta strona służy pracownikom do dodawania aktualności. Zaloguj się, żeby przejść do formularza.</p>
		<?php
		wp_login_form( array(
			'redirect'       => $adres_strony,
			'label_username' => 'Login lub e-mail',
			'label_password' => 'Hasło',
			'label_remember' => 'Zapamiętaj mnie na tym urządzeniu',
			'label_log_in'   => 'Zaloguj się',
			'value_remember' => true,
		) );
		?>

	<?php elseif ( ! $moze_dodawac ) : ?>

		<h1>Brak uprawnień</h1>
		<p>Twoje konto nie może dodawać aktualności. Skontaktuj się z administratorem strony.</p>

	<?php else : ?>

		<?php if ( $zapisano && get_post_type( $zapisano ) === 'aktualnosc' ) : ?>
			<?php $dzial = get_field( 'dzial', $zapisano ); ?>
			<div class="komunikat">
				<strong>Gotowe! Aktualność „<?php echo esc_html( get_the_title( $zapisano ) ); ?>” jest na stronie.</strong><br>
				<?php if ( $dzial && $dzial !== 'ogolne' ) : ?>
					<a href="<?php echo esc_url( home_url( '/' . $dzial . '/' ) ); ?>">Zobacz na stronie działu</a> ·
				<?php endif; ?>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'aktualnosc' ) ); ?>">Zobacz wszystkie aktualności</a>
			</div>
		<?php endif; ?>

		<?php if ( $usunieto ) : ?>
			<div class="komunikat">
				<strong>Usunięto aktualność „<?php echo esc_html( $usunieto ); ?>”.</strong><br>
				Gdyby to była pomyłka, administrator strony może ją przywrócić z kosza przez 30 dni.
			</div>
		<?php endif; ?>

		<h1><?php echo $edytuj ? 'Popraw aktualność' : 'Dodaj aktualność'; ?></h1>
		<?php if ( $edytuj ) : ?>
			<p><a href="<?php echo esc_url( $adres_strony ); ?>">← Zamiast tego dodaj nową</a></p>
		<?php endif; ?>

		<?php
		acf_form( array(
			'post_id'            => $edytuj ? $edytuj : 'new_post',
			'new_post'           => array(
				'post_type'   => 'aktualnosc',
				'post_status' => 'publish',
			),
			'post_title'         => true,
			'field_groups'       => array( 'group_balcyny_aktualnosc' ),
			'uploader'           => 'basic', // zwykłe „Wybierz plik” – na telefonie otwiera aparat lub galerię
			'submit_value'       => $edytuj ? 'Zapisz zmiany' : 'Opublikuj',
			'return'             => add_query_arg( 'zapisano', '%post_id%', $adres_strony ),
			'html_submit_button' => '<input type="submit" class="przycisk przycisk-duzy" value="%s">',
			'updated_message'    => false,
		) );
		?>

		<?php
		$moje = new WP_Query( array(
			'post_type'      => 'aktualnosc',
			'author'         => get_current_user_id(),
			'posts_per_page' => 10,
		) );
		?>
		<?php if ( $moje->have_posts() ) : ?>
			<h2 class="sekcja-tytul">Twoje ostatnie aktualności</h2>
			<ul class="moje-wpisy">
				<?php while ( $moje->have_posts() ) : $moje->the_post(); ?>
					<li>
						<span class="wpis-data"><?php echo get_the_date(); ?></span>
						<?php the_title(); ?>
						<a href="<?php echo esc_url( add_query_arg( 'edytuj', get_the_ID(), $adres_strony ) ); ?>">Popraw</a>
						<?php if ( current_user_can( 'delete_post', get_the_ID() ) ) : ?>
							<a class="usun"
								href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'usun', get_the_ID(), $adres_strony ), 'usun-aktualnosc-' . get_the_ID() ) ); ?>"
								data-tytul="<?php the_title_attribute(); ?>">Usuń</a>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<p class="wyloguj"><a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">Wyloguj się</a></p>

	<?php endif; ?>
</div>

<?php get_footer();
