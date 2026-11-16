<?php
/**
 * Section shortcodes used by the imported pages.
 * Every section can be dropped into any page with a Shortcode block.
 *
 * @package sws
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [sws_slider] — 3D panoramic hero slider with motion effects.
 * Slides are filterable via 'sws_slides'.
 */
function sws_sc_slider( $atts ) {
	$a = shortcode_atts( array( 'interval' => 7000 ), $atts );
	$slides = apply_filters(
		'sws_slides',
		array(
			array(
				'img'     => 'training-launcher',
				'eyebrow' => array( 'POST-Certified · AB 48 Compliant', 'Certificación POST · Cumple AB 48' ),
				'title'   => array( 'Train the <em>Trainers</em><br>Who Hold the Line', 'Formamos a los <em>Instructores</em><br>que Sostienen la Línea' ),
				'text'    => array( 'Elite Chemical Agent and Less Lethal Instructor courses taught by former and current tactical operators with over 50 years of experience — built for law enforcement agencies.', 'Cursos de Instructor en Agentes Químicos y Armas Menos Letales impartidos por operadores tácticos activos y retirados con más de 50 años de experiencia, diseñados para agencias de California.' ),
				'cta'     => array( 'Explore Courses', 'Ver Cursos', '/courses/' ),
				'cta2'    => array( 'Request a Seat', 'Reservar Lugar', '/contact/' ),
			),
			array(
				'img'     => 'night-ops',
				'eyebrow' => array( 'Instructor Certification', 'Certificación de Instructores' ),
				'title'   => array( 'Policy. Practice.<br><em>Proficiency.</em>', 'Política. Práctica.<br><em>Dominio.</em>' ),
				'text'    => array( 'Classroom precision meets range-day realism. Graduates return to their agency ready to teach, document and defend every deployment decision.', 'La precisión del aula se une al realismo del campo. Tus instructores regresan listos para enseñar, documentar y justificar cada despliegue.' ),
				'cta'     => array( 'Chemical Agent Course', 'Curso de Agentes Químicos', '/chemical-agent-instructor-course/' ),
				'cta2'    => array( 'Less Lethal Course', 'Curso Menos Letal', '/less-lethal-instructor-course/' ),
			),
			array(
				'img'     => 'hero-3',
				'eyebrow' => array( 'AB 48 · Penal Code 13652', 'AB 48 · Código Penal 13652' ),
				'title'   => array( 'Compliance Built<br>Into Every <em>Rep</em>', 'El Cumplimiento en<br>Cada <em>Repetición</em>' ),
				'text'    => array( 'Crowd-management instruction aligned with AB 48 — so your instructors, your officers and your agency stand on solid legal ground.', 'Instrucción en control de multitudes alineada con la ley de California, para que tu agencia opere sobre una base legal sólida.' ),
				'cta'     => array( 'AB 48 Compliance', 'Cumplimiento AB 48', '/ab-48-compliance/' ),
				'cta2'    => array( 'Training Schedule', 'Calendario', '/training-schedule/' ),
			),
		)
	);

	$count = count( $slides );
	ob_start();
	?>
	<section class="pano" data-pano data-interval="<?php echo esc_attr( (int) $a['interval'] ); ?>" aria-roledescription="carousel" aria-label="Southwestern Solutions highlights" tabindex="0">
		<div class="pano__stage">
			<?php foreach ( $slides as $i => $s ) : ?>
				<article class="pano__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of ' . $count ); ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
					<div class="pano__bg" style="background-image:url('<?php echo esc_url( sws_img( $s['img'] . '.jpg' ) ); ?>');background-image:image-set(url('<?php echo esc_url( sws_img( $s['img'] . '.webp' ) ); ?>') type('image/webp'), url('<?php echo esc_url( sws_img( $s['img'] . '.jpg' ) ); ?>') type('image/jpeg'))" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $s['title'][0] ) ); ?>"></div>
					<div class="pano__smoke" aria-hidden="true"></div>
					<div class="pano__shade" aria-hidden="true"></div>
					<div class="pano__content">
						<div class="wrap"><div class="inner">
							<span class="eyebrow"><?php echo esc_html( $s['eyebrow'][0] ); ?></span>
							<?php
							$tag   = 0 === $i ? 'h1' : 'h2';
							$lines = explode( '<br>', $s['title'][0] );
							echo '<' . $tag . ' class="pano__title">';
							foreach ( $lines as $k => $line ) {
								echo '<span class="line"><span>' . wp_kses( $line, array( 'em' => array() ) ) . '</span></span>';
							}
							echo '</' . $tag . '>';
							?>
							<p class="pano__text"><?php echo esc_html( $s['text'][0] ); ?></p>
							<div class="btn-row">
								<a class="btn" href="<?php echo esc_url( home_url( $s['cta'][2] ) ); ?>"><span><?php echo esc_html( $s['cta'][0] ); ?></span> <span class="arrow">→</span></a>
								<a class="btn btn--ghost" href="<?php echo esc_url( home_url( $s['cta2'][2] ) ); ?>"><span><?php echo esc_html( $s['cta2'][0] ); ?></span></a>
							</div>
						</div></div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="pano__ui">
			<div class="wrap">
				<div class="pano__dots" role="tablist">
					<?php for ( $i = 0; $i < $count; $i++ ) : ?>
						<button class="pano__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( 'Go to slide ' . ( $i + 1 ) ); ?>"><i></i></button>
					<?php endfor; ?>
				</div>
				<div class="pano__count"><b>01</b> / <?php echo esc_html( sprintf( '%02d', $count ) ); ?></div>
				<div class="pano__arrows">
					<button class="pano__arrow" data-pano-prev aria-label="Previous slide">←</button>
					<button class="pano__arrow" data-pano-next aria-label="Next slide">→</button>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sws_slider', 'sws_sc_slider' );

/** [sws_trustbar items="A|B|C"] — animated marquee. */
function sws_sc_trustbar( $atts ) {
	$a = shortcode_atts( array( 'items' => 'POST Certified|AB 48 Compliant|Plan IV Reimbursable|Chemical Agent Instructor|Less Lethal Instructor|San Diego|Taught by Tactical Operators' ), $atts );
	$items = array_map( 'trim', explode( '|', $a['items'] ) );
	$row   = '';
	foreach ( $items as $it ) {
		$row .= '<span>' . esc_html( $it ) . '</span>';
	}
	return '<div class="trustbar" aria-label="Credentials"><div class="marquee">' . $row . $row . '</div></div>';
}
add_shortcode( 'sws_trustbar', 'sws_sc_trustbar' );

/** [sws_stats] — four animated stat tiles. Format: "value|suffix|label" separated by ;; */
function sws_sc_stats( $atts ) {
	$a = shortcode_atts( array( 'items' => '50|+|Years of combined tactical experience;;40|HR|Chemical Agent Instructor course;;30|HR|Less Lethal Instructor course;;100|%|POST-certified curriculum' ), $atts );
	$out = '<div class="stats" data-reveal>';
	foreach ( explode( ';;', $a['items'] ) as $row ) {
		$p = array_map( 'trim', explode( '|', $row ) );
		if ( count( $p ) < 3 ) {
			continue;
		}
		$out .= sprintf( '<div class="stat"><b data-count="%1$s" data-suffix="%2$s">%1$s%2$s</b><span>%3$s</span></div>', esc_attr( $p[0] ), esc_attr( $p[1] ), esc_html( $p[2] ) );
	}
	return $out . '</div>';
}
add_shortcode( 'sws_stats', 'sws_sc_stats' );

/** [sws_courses] — course cards. */
function sws_sc_courses() {
	$courses = array(
		array(
			'img'   => 'chemical-agent',
			'badge' => 'POST Certified',
			'title' => 'Chemical Agent Instructor Course',
			'text'  => 'Use-of-force law, deployment techniques, APR use, munitions, decontamination and instructor development — with full AB 48 / PC 13652 coverage.',
			'meta'  => array( '40 Hours', 'Instructor Level', 'Plan IV' ),
			'price' => '1,881',
			'url'   => '/chemical-agent-instructor-course/',
		),
		array(
			'img'   => 'training-launcher',
			'badge' => 'AB 48 Compliant',
			'title' => 'Less Lethal Instructor Course',
			'text'  => 'Kinetic energy projectile platforms, target areas, documentation and teaching methodology that prepares your instructors.',
			'meta'  => array( '30 Hours', 'Instructor Level', 'Plan IV' ),
			'price' => '1,200',
			'url'   => '/less-lethal-instructor-course/',
		),
	);
	$out = '<div class="grid grid-2">';
	foreach ( $courses as $i => $c ) {
		$meta = '';
		foreach ( $c['meta'] as $m ) {
			$meta .= '<li>' . esc_html( $m ) . '</li>';
		}
		$out .= sprintf(
			'<article class="card course-card" data-tilt="5" data-reveal style="--d:%7$ss"><div class="course-card__media">%1$s<span class="course-card__badge">%2$s</span></div><div class="course-card__body"><h3>%3$s</h3><ul class="course-meta">%4$s</ul><p>%5$s</p><p class="price" style="margin:24px 0">$%8$s <small>tuition / student</small></p><a class="btn" href="%6$s">View Course <span class="arrow">→</span></a></div></article>',
			sws_picture( $c['img'], $c['title'] . ' — Southwestern Solutions San Diego', array( 'width' => 900, 'height' => 560 ) ),
			esc_html( $c['badge'] ),
			esc_html( $c['title'] ),
			$meta,
			esc_html( $c['text'] ),
			esc_url( home_url( $c['url'] ) ),
			esc_attr( $i * 0.15 ),
			esc_html( $c['price'] )
		);
	}
	return $out . '</div>';
}
add_shortcode( 'sws_courses', 'sws_sc_courses' );

/** [sws_features] — "why us" icon cards. items="icon|Title|Text;;..." */
function sws_sc_features( $atts ) {
	$a = shortcode_atts(
		array(
			'cols'  => 3,
			'items' => 'mask|Operators, Not Lecturers|Our instructors are former and current law enforcement tactical operators with over 50 years of experience. Every lesson is grounded in real deployments.;;scale|AB 48 Built In|Curriculum aligned with Penal Code 13652 so your agency can train, deploy and document with confidence.;;badge|POST Certified|POST-certified instructor courses, eligible for Plan IV tuition reimbursement.;;target|Scenario-Driven|Range time, live scenarios and practical evaluations — not just slides.;;users|Train-the-Trainer|Graduates leave ready to teach, certify and maintain proficiency within their own agency.;;shield|Defensible Decisions|Policy, report writing and use-of-force review that hold up to scrutiny.',
		),
		$atts
	);
	$out = '<div class="grid grid-' . (int) $a['cols'] . '">';
	foreach ( explode( ';;', $a['items'] ) as $i => $row ) {
		$p = array_map( 'trim', explode( '|', $row ) );
		if ( count( $p ) < 3 ) {
			continue;
		}
		$out .= sprintf( '<div class="card" data-tilt="8" data-reveal style="--d:%4$ss"><div class="icon">%1$s</div><h3>%2$s</h3><p>%3$s</p></div>', sws_icon( $p[0] ), esc_html( $p[1] ), esc_html( $p[2] ), esc_attr( ( $i % 3 ) * 0.12 ) );
	}
	return $out . '</div>';
}
add_shortcode( 'sws_features', 'sws_sc_features' );

/** [sws_process] — numbered steps. items="Title|Text;;..." */
function sws_sc_process( $atts ) {
	$a = shortcode_atts( array( 'items' => 'Choose Your Course|Select Chemical Agent or Less Lethal Instructor certification — or both.;;Reserve Seats|Contact us to secure seats for your officers and confirm Plan IV eligibility.;;Train & Certify|Classroom, range and scenario work with tactical instructors.' ), $atts );
	$steps = explode( ';;', $a['items'] );
	$out   = '<div class="grid grid-' . min( 4, max( 2, count( $steps ) ) ) . ' steps">';
	foreach ( $steps as $i => $row ) {
		$p = array_map( 'trim', explode( '|', $row ) );
		$out .= sprintf( '<div class="card step" data-reveal style="--d:%3$ss"><span class="num"></span><h3>%1$s</h3><p>%2$s</p></div>', esc_html( $p[0] ), esc_html( isset( $p[1] ) ? $p[1] : '' ), esc_attr( $i * 0.12 ) );
	}
	return $out . '</div>';
}
add_shortcode( 'sws_process', 'sws_sc_process' );

/** [sws_split img="instructor-scope" alt="" reverse="0" badge="" badge_num=""]content[/sws_split] */
function sws_sc_split( $atts, $content = '' ) {
	$a = shortcode_atts( array( 'img' => 'instructor-scope', 'alt' => '', 'reverse' => '0', 'badge' => '', 'badge_num' => '' ), $atts );
	$float = $a['badge'] ? '<div class="floating"><b>' . esc_html( $a['badge_num'] ) . '</b>' . esc_html( $a['badge'] ) . '</div>' : '';
	return sprintf(
		'<div class="split%1$s"><div class="frame-wrap" data-reveal="%5$s"><div class="frame" data-tilt="6">%2$s</div>%3$s</div><div data-reveal="%6$s">%4$s</div></div>',
		'1' === $a['reverse'] ? ' split--rev' : '',
		sws_picture( $a['img'], $a['alt'] ),
		$float,
		do_shortcode( trim( $content ) ),
		'1' === $a['reverse'] ? 'right' : 'left',
		'1' === $a['reverse'] ? 'left' : 'right'
	);
}
add_shortcode( 'sws_split', 'sws_sc_split' );

/** [sws_img name="hero-1" alt="..."] */
function sws_sc_img( $atts ) {
	$a = shortcode_atts( array( 'name' => 'hero-1', 'alt' => '' ), $atts );
	return '<figure class="frame" data-reveal="zoom">' . sws_picture( $a['name'], $a['alt'] ) . '</figure>';
}
add_shortcode( 'sws_img', 'sws_sc_img' );

/** [sws_cta title="" text="" button="" url=""] */
function sws_sc_cta( $atts ) {
	$a = shortcode_atts(
		array(
			'title'  => 'Your Next Instructor Starts Here',
			'text'   => 'Seats are limited and classes fill fast. Reserve your agency’s spots or ask about Plan IV reimbursement today.',
			'button' => 'Reserve Your Seat',
			'url'    => '/contact/',
		),
		$atts
	);
	return sprintf(
		'<div class="cta-band" data-reveal="zoom"><span class="eyebrow">Ready When You Are</span><h2>%1$s</h2><p class="lead">%2$s</p><div class="btn-row" style="margin-top:30px"><a class="btn" href="%3$s">%4$s <span class="arrow">→</span></a><a class="btn btn--ghost" href="%5$s">Call %6$s</a></div></div>',
		esc_html( $a['title'] ),
		esc_html( $a['text'] ),
		esc_url( home_url( $a['url'] ) ),
		esc_html( $a['button'] ),
		esc_attr( sws_tel( sws_opt( 'phone' ) ) ),
		esc_html( sws_opt( 'phone' ) )
	);
}
add_shortcode( 'sws_cta', 'sws_sc_cta' );

/** [sws_contact_info] */
function sws_sc_contact_info( $atts = array() ) {
	$atts = (array) $atts;
	$rows = array(
		array( 'phone', 'Call', '<a href="' . esc_attr( sws_tel( sws_opt( 'phone' ) ) ) . '">' . esc_html( sws_opt( 'phone' ) ) . '</a>' ),
		array( 'mail', 'Email', '<a href="mailto:' . esc_attr( sws_opt( 'email' ) ) . '">' . esc_html( sws_opt( 'email' ) ) . '</a>' ),
		array( 'pin', 'Based in', esc_html( sws_opt( 'city' ) . ', CA ' . sws_opt( 'zip' ) ) ),
		array( 'clock', 'Office Hours', esc_html( sws_opt( 'hours' ) ) ),
	);
	if ( isset( $atts['hours'] ) && '0' === (string) $atts['hours'] ) {
		array_pop( $rows );
	}
	$out = '<ul class="contact-list">';
	foreach ( $rows as $r ) {
		$out .= '<li><span class="icon">' . sws_icon( $r[0] ) . '</span><div><small>' . esc_html( $r[1] ) . '</small>' . $r[2] . '</div></li>';
	}
	return $out . '</ul>';
}
add_shortcode( 'sws_contact_info', 'sws_sc_contact_info' );

/** [sws_latest_posts count="3"] */
function sws_sc_latest_posts( $atts ) {
	$a = shortcode_atts( array( 'count' => 3 ), $atts );
	$q = new WP_Query( array( 'posts_per_page' => (int) $a['count'], 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
	if ( ! $q->have_posts() ) {
		return '';
	}
	ob_start();
	echo '<div class="post-grid">';
	while ( $q->have_posts() ) {
		$q->the_post();
		get_template_part( 'template-parts/card', 'post' );
	}
	echo '</div>';
	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'sws_latest_posts', 'sws_sc_latest_posts' );

/** [sws_section class="" eyebrow="" title="" lead="" center="0"]content[/sws_section] */
function sws_sc_section( $atts, $content = '' ) {
	$a = shortcode_atts( array( 'class' => '', 'eyebrow' => '', 'title' => '', 'lead' => '', 'center' => '0', 'tag' => 'h2' ), $atts );
	$tag  = in_array( $a['tag'], array( 'h1', 'h2', 'h3' ), true ) ? $a['tag'] : 'h2';
	$head = '';
	if ( $a['eyebrow'] || $a['title'] || $a['lead'] ) {
		$head .= '<header class="' . ( '1' === $a['center'] ? 'center ' : '' ) . '" style="margin-bottom:56px" data-reveal>';
		$head .= $a['eyebrow'] ? '<span class="eyebrow">' . esc_html( $a['eyebrow'] ) . '</span>' : '';
		$head .= $a['title'] ? '<' . $tag . '>' . wp_kses( $a['title'], array( 'em' => array( 'class' => array() ), 'span' => array( 'class' => array() ), 'br' => array() ) ) . '</' . $tag . '>' : '';
		$head .= $a['lead'] ? '<p class="lead">' . esc_html( $a['lead'] ) . '</p>' : '';
		$head .= '</header>';
	}
	return '<section class="section ' . esc_attr( $a['class'] ) . '"><div class="wrap">' . $head . do_shortcode( shortcode_unautop( trim( $content ) ) ) . '</div></section>';
}
add_shortcode( 'sws_section', 'sws_sc_section' );


/**
 * [sws_experience] — real-world experience section with the SWAT cutout (parallax + float).
 * items="Label;;Label;;..." (defaults to the specialties listed on the original site).
 */
function sws_sc_experience( $atts ) {
	$a = shortcode_atts(
		array(
			'eyebrow' => 'Real-World Experience',
			'title'   => 'Over 50 Years<br>on the <span class="text-amber">Line</span>',
			'lead'    => 'Our instructors are former and current Law Enforcement Tactical Operators with over 50 years of experience. We bring that experience to every class we teach.',
			'items'   => 'Critical response tactics;;Mobile Field Force;;Basic to advanced Chemical Agent deployments;;Long Rifle utilization in urban and rural environments;;Close Quarter Techniques;;High Risk Warrant Planning',
		),
		$atts
	);
	$list = '';
	foreach ( explode( ';;', $a['items'] ) as $i => $it ) {
		$list .= sprintf( '<li data-reveal style="--d:%2$ss"><span>%3$s</span>%1$s</li>', esc_html( trim( $it ) ), esc_attr( 0.08 * $i ), esc_html( sprintf( '%02d', $i + 1 ) ) );
	}
	return sprintf(
		'<div class="xp"><div class="xp__text"><span class="eyebrow" data-reveal>%1$s</span><h2 data-reveal>%2$s</h2><p class="lead" data-reveal>%3$s</p><ul class="xp__list">%4$s</ul><div class="btn-row" data-reveal><a class="btn" href="%5$s">Meet Southwestern <span class="arrow">→</span></a></div></div><div class="xp__media" aria-hidden="true"><div class="xp__ring"></div><div class="xp__compass"></div><picture class="xp__cutout" data-depth="0.12"><source srcset="%6$s" type="image/webp"><img src="%7$s" alt="" width="570" height="777" loading="lazy" decoding="async"></picture></div></div>',
		esc_html( $a['eyebrow'] ),
		wp_kses( $a['title'], array( 'br' => array(), 'span' => array( 'class' => array() ) ) ),
		esc_html( $a['lead'] ),
		$list,
		esc_url( home_url( '/about-us/' ) ),
		esc_url( sws_img( 'swat-cutout.webp' ) ),
		esc_url( sws_img( 'swat-cutout.png' ) )
	);
}
add_shortcode( 'sws_experience', 'sws_sc_experience' );

/** [sws_notice title="" ]text[/sws_notice] — highlighted legal/important notice. */
function sws_sc_notice( $atts, $content = '' ) {
	$a = shortcode_atts( array( 'title' => 'Important' ), $atts );
	return '<div class="legal-notice" data-reveal><span class="icon">' . sws_icon( 'scale' ) . '</span><div><strong>' . esc_html( $a['title'] ) . '</strong><p>' . wp_kses_post( $content ) . '</p></div></div>';
}
add_shortcode( 'sws_notice', 'sws_sc_notice' );
