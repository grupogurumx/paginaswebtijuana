<?php
/**
 * Encabezado interior con migas de pan.
 *
 * @package hospital-nova
 */

$args  = isset( $args ) ? $args : array();
$title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$lead  = isset( $args['lead'] ) ? $args['lead'] : '';
?>
<section class="page-hero">
	<div class="hero__mesh" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="container">
		<nav class="breadcrumbs" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( nova_t( 'Inicio', 'Home' ) ); ?></a>
			<?php if ( is_single() ) : ?> / <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' ) ); ?>">Blog</a><?php endif; ?>
			/ <span><?php echo esc_html( wp_strip_all_tags( $title ) ); ?></span>
		</nav>
		<h1 data-split><?php echo esc_html( wp_strip_all_tags( $title ) ); ?></h1>
		<?php if ( $lead ) : ?><p class="lead" style="color:#b9d2d9;max-width:40em"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		<?php if ( is_single() ) : ?>
			<p style="font-size:.9rem;margin:0"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( nova_t( 'Equipo médico Hospital Nova', 'Hospital Nova medical team' ) ); ?></p>
		<?php endif; ?>
	</div>
</section>
