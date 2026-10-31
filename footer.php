</main>

<footer class="stopka">
	<div class="kontener">
		<div>
			<h3>Zakład Produkcyjno-Doświadczalny „Bałcyny” Sp. z o.o.</h3>
		</div>
		<div>
			<h3>Kontakt</h3>
			Bałcyny 15<br>
			14-100 Ostróda<br>
			Tel. <?php echo balcyny_telefon(); ?><br>
			E-mail: <a href="mailto:<?php echo esc_attr( BALCYNY_EMAIL ); ?>"><?php echo esc_html( BALCYNY_EMAIL ); ?></a>
		</div>
		<div>
			<h3>Dane spółki</h3>
			NIP: 7411002234<br>
			KRS: 0000175886<br>
			REGON: 510287969<br>
			Kapitał zakładowy: 2,8 mln zł
			<?php
			wp_nav_menu( array(
				'theme_location' => 'stopka',
				'container'      => false,
				'fallback_cb'    => false,
			) );
			?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
