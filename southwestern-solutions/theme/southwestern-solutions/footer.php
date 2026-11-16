<?php
/**
 * Footer.
 *
 * @package sws
 */
?>
</main>

<footer class="site-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div>
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-bottom:20px">
					<?php echo sws_logo_mark(); // phpcs:ignore ?>
					<span class="brand-text">Southwestern<small>Solutions · Training</small></span>
				</a>
				<p>POST-certified Chemical Agent and Less Lethal Instructor training for law enforcement — taught by tactical operators, built around AB 48 compliance.</p>
			</div>
			<div>
				<h4>Courses</h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/chemical-agent-instructor-course/' ) ); ?>">Chemical Agent Instructor</a></li>
					<li><a href="<?php echo esc_url( home_url( '/less-lethal-instructor-course/' ) ); ?>">Less Lethal Instructor</a></li>
					<li><a href="<?php echo esc_url( home_url( '/ab-48-compliance/' ) ); ?>">AB 48 Compliance</a></li>
					<li><a href="<?php echo esc_url( home_url( '/training-schedule/' ) ); ?>">Training Schedule</a></li>
				</ul>
			</div>
			<div>
				<h4>Company</h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => function () {
							echo '<ul><li><a href="' . esc_url( home_url( '/about-us/' ) ) . '">About Us</a></li><li><a href="' . esc_url( home_url( '/host-a-course/' ) ) . '">Host a Course</a></li><li><a href="' . esc_url( home_url( '/faq/' ) ) . '">FAQ</a></li><li><a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '">Privacy Policy</a></li></ul>';
						},
					)
				);
				?>
			</div>
			<div>
				<h4>Contact</h4>
				<?php echo do_shortcode( '[sws_contact_info hours="0"]' ); // phpcs:ignore ?>
			</div>
		</div>
		<div class="footer-bottom">
			<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Southwestern Solutions · San Diego. All rights reserved.</span>
			<span>Law Enforcement Instructor Training · POST Certified · AB 48</span>
		</div>
	</div>
	<div class="giant" aria-hidden="true">Southwestern</div>
</footer>

<a class="float-cta" href="<?php echo esc_attr( sws_tel( sws_opt( 'phone' ) ) ); ?>" aria-label="Call Southwestern Solutions"><?php echo sws_icon( 'phone' ); // phpcs:ignore ?></a>

<?php wp_footer(); ?>
</body>
</html>
