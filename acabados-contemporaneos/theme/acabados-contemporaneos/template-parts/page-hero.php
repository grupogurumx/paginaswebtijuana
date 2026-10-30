<?php
/**
 * Encabezado de páginas internas con imagen panorámica y migas de pan.
 *
 * @package Acabados
 */

$ac_id   = get_queried_object_id();
$ac_slug = get_post_meta( $ac_id, '_ac_image', true );
$ac_bg   = has_post_thumbnail( $ac_id ) ? get_the_post_thumbnail_url( $ac_id, 'full' ) : ( $ac_slug ? ac_img_url( $ac_slug, 'full' ) : ac_img_url( 'textura-marmol', 'full' ) );
$ac_sub  = get_post_meta( $ac_id, '_ac_subtitle', true );
$ac_crumbs = ac_breadcrumbs();
?>
<header class="page-hero">
	<div class="page-hero__bg" data-parallax="0.3" style="background-image:url('<?php echo esc_url( $ac_bg ); ?>')"></div>
	<div class="page-hero__shade" aria-hidden="true"></div>
	<div class="page-hero__inner container">
		<nav class="breadcrumbs" aria-label="Breadcrumb">
			<ol>
				<?php foreach ( $ac_crumbs as $i => $crumb ) : ?>
					<li><?php if ( $i < count( $ac_crumbs ) - 1 ) : ?><a href="<?php echo esc_url( $crumb[1] ); ?>"><?php echo esc_html( $crumb[0] ); ?></a><?php else : ?><span aria-current="page"><?php echo esc_html( $crumb[0] ); ?></span><?php endif; ?></li>
				<?php endforeach; ?>
			</ol>
		</nav>
		<h1 class="page-hero__title" data-split><?php echo esc_html( get_the_title( $ac_id ) ); ?></h1>
		<?php if ( $ac_sub ) : ?>
			<p class="page-hero__sub"><?php echo esc_html( $ac_sub ); ?></p>
		<?php endif; ?>
	</div>
</header>
