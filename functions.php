<?php
/**
 * Funkcje motywu Bałcyny.
 */

// Dane kontaktowe – zmień tutaj, a zmienią się w całej stronie.
define( 'BALCYNY_TEL', '(89) 647 10 14' );
define( 'BALCYNY_EMAIL', 'sekretariat@balcyny.pl' );
define( 'BALCYNY_GPS', '53.59744492392278,19.857973738705116' ); // znacznik na mapie w Kontakcie

// Strony działów: adres strony => nazwa działu. Te same klucze ma pole „Dział” w aktualnościach.
function balcyny_dzialy() {
	return array(
		'produkcja-roslinna' => 'Produkcja roślinna',
		'hodowla'            => 'Hodowla zwierzęca',
		'doswiadczenia'      => 'Doświadczenia i UWM',
		'ogolne'             => 'Ogólne',
	);
}

/* ---------- Ustawienia motywu ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );        // WordPress sam ustawia <title>
	add_theme_support( 'post-thumbnails' );  // obrazki wyróżniające
	register_nav_menus( array(
		'glowne' => 'Menu główne',
		'stopka' => 'Menu w stopce',
	) );
} );

/* ---------- CSS i JS ---------- */
add_action( 'wp_enqueue_scripts', function () {
	// Data zmiany pliku jako wersja – przeglądarka zawsze pobierze świeży CSS po edycji.
	$wersja = filemtime( get_stylesheet_directory() . '/style.css' );
	wp_enqueue_style( 'balcyny', get_stylesheet_uri(), array(), $wersja );
	// Skrypt menu (wymaga jQuery wbudowanego w WordPressa)
	$plik_menu = get_stylesheet_directory() . '/js/menu.js';
	wp_enqueue_script( 'balcyny-menu', get_theme_file_uri( 'js/menu.js' ), array( 'jquery' ), filemtime( $plik_menu ), true );
} );

/* ---------- Typy treści ---------- */
add_action( 'init', function () {
	// Wspólne ustawienia: tylko tytuł (bez edytora bloków), reszta to pola SCF.
	$wspolne = array(
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => false,
		'supports'     => array( 'title' ),
	);

	register_post_type( 'aktualnosc', $wspolne + array(
		'labels'    => array(
			'name'          => 'Aktualności',
			'singular_name' => 'Aktualność',
			'add_new'       => 'Dodaj aktualność',
			'add_new_item'  => 'Dodaj nową aktualność',
			'edit_item'     => 'Edytuj aktualność',
			'all_items'     => 'Wszystkie aktualności',
		),
		'menu_icon' => 'dashicons-megaphone',
		'rewrite'   => array( 'slug' => 'aktualnosci', 'with_front' => false ),
	) );
} );

// Po zmianie adresów typów treści odśwież reguły adresów (raz, przy kolejnym wczytaniu).
add_action( 'init', function () {
	if ( get_option( 'balcyny_adresy' ) !== '3' ) {
		flush_rewrite_rules();
		update_option( 'balcyny_adresy', '3' );
	}
}, 99 );

/* ---------- Strony edytowane samym formularzem SCF, bez edytora bloków ---------- */
add_filter( 'use_block_editor_for_post', function ( $uzyj, $post ) {
	$strony_z_formularzem = array( 'produkcja-roslinna', 'hodowla', 'o-nas', 'doswiadczenia' );
	if ( $post->post_type === 'page' && in_array( $post->post_name, $strony_z_formularzem, true ) ) {
		return false;
	}
	return $uzyj;
}, 10, 2 );

/* ---------- Secure Custom Fields: zapis definicji pól do motywu ---------- */
add_filter( 'acf/settings/save_json', function () {
	return get_stylesheet_directory() . '/acf-json';
} );
add_filter( 'acf/settings/load_json', function ( $sciezki ) {
	$sciezki[] = get_stylesheet_directory() . '/acf-json';
	return $sciezki;
} );

/* ---------- Pomocnicze ---------- */

// Klikalny telefon: <a href="tel:+48896471014">(89) 647 10 14</a>
function balcyny_telefon( $numer = BALCYNY_TEL ) {
	$do_linku = preg_replace( '/[^0-9+]/', '', $numer );
	if ( strpos( $do_linku, '+' ) !== 0 ) {
		$do_linku = '+48' . $do_linku; // numer bez kierunkowego kraju – dodaj Polskę
	}
	return '<a href="tel:' . esc_attr( $do_linku ) . '">' . esc_html( $numer ) . '</a>';
}

// Liczba lat, która sama rośnie co roku. W polu tekstowym wpisz: [lat_od rok="1967"] → „59 lat”.
add_shortcode( 'lat_od', function ( $atrybuty ) {
	$lata = (int) wp_date( 'Y' ) - (int) $atrybuty['rok'];
	return $lata . ' ' . balcyny_odmiana_lat( $lata );
} );

// Polska odmiana: 1 rok, 2–4 lata, 5–21 lat, 22–24 lata, 25 lat...
function balcyny_odmiana_lat( $liczba ) {
	if ( $liczba === 1 ) {
		return 'rok';
	}
	$jednosci = $liczba % 10;
	$dziesiatki = $liczba % 100;
	if ( $jednosci >= 2 && $jednosci <= 4 && ( $dziesiatki < 12 || $dziesiatki > 14 ) ) {
		return 'lata';
	}
	return 'lat';
}

// Dział wybrany w adresie listy aktualności (/aktualnosci/?dzial=hodowla) albo '' gdy wszystkie.
function balcyny_wybrany_dzial() {
	$dzial = isset( $_GET['dzial'] ) ? sanitize_key( $_GET['dzial'] ) : '';
	return isset( balcyny_dzialy()[ $dzial ] ) ? $dzial : '';
}

// Adres listy aktualności jednego działu.
function balcyny_link_aktualnosci( $dzial ) {
	return add_query_arg( 'dzial', $dzial, get_post_type_archive_link( 'aktualnosc' ) );
}

// Lista aktualności: filtr po dziale z adresu.
add_action( 'pre_get_posts', function ( $zapytanie ) {
	if ( is_admin() || ! $zapytanie->is_main_query() || ! $zapytanie->is_post_type_archive( 'aktualnosc' ) ) {
		return;
	}
	$dzial = balcyny_wybrany_dzial();
	if ( $dzial ) {
		$zapytanie->set( 'meta_key', 'dzial' );
		$zapytanie->set( 'meta_value', $dzial );
	}
} );

// Adres miniatury filmu z YouTube (do kafelków bez zdjęcia) albo '' gdy to nie link do YouTube.
function balcyny_miniatura_youtube( $link ) {
	if ( preg_match( '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|shorts/|embed/)|youtu\.be/)([\w-]{11})~', (string) $link, $dopasowanie ) ) {
		return 'https://img.youtube.com/vi/' . $dopasowanie[1] . '/hqdefault.jpg';
	}
	return '';
}

// Najnowsze aktualności; podaj dział (np. 'hodowla'), żeby pokazać tylko jego wpisy.
function balcyny_aktualnosci( $ile = 6, $dzial = '' ) {
	$zapytanie = array(
		'post_type'      => 'aktualnosc',
		'posts_per_page' => $ile,
	);
	if ( $dzial ) {
		$zapytanie['meta_key']   = 'dzial';
		$zapytanie['meta_value'] = $dzial;
	}
	return new WP_Query( $zapytanie );
}
