<?php
/**
 * Directorio de sucursales con filtro por ciudad.
 *
 * @package Acabados
 */

$ac_en       = 'en' === ac_lang();
$ac_branches = ac_branches();
?>
<div class="branches" data-branches>
	<div class="branches__filter" role="tablist" aria-label="<?php echo esc_attr( $ac_en ? 'Filter by city' : 'Filtrar por ciudad' ); ?>">
		<button type="button" class="chip is-active" data-city="all" role="tab" aria-selected="true"><?php echo esc_html( $ac_en ? 'All' : 'Todas' ); ?> <span><?php echo (int) ac_branch_count(); ?></span></button>
		<?php foreach ( $ac_branches as $city => $data ) : ?>
			<button type="button" class="chip" data-city="<?php echo esc_attr( sanitize_title( $city ) ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $city ); ?> <span><?php echo count( $data[1] ); ?></span></button>
		<?php endforeach; ?>
	</div>

	<?php foreach ( $ac_branches as $city => $data ) : ?>
		<?php list( $state, $list ) = $data; ?>
		<section class="branches__city" data-city-group="<?php echo esc_attr( sanitize_title( $city ) ); ?>">
			<h2 class="branches__title"><?php echo esc_html( $city ); ?> <small><?php echo esc_html( $state ); ?></small></h2>
			<div class="branches__grid">
				<?php foreach ( $list as $b ) : ?>
					<article class="branch-card">
						<p class="branch-card__name"><?php echo esc_html( $b[0] ); ?></p>
						<p class="branch-card__addr"><?php echo ac_icon( 'pin' ); // phpcs:ignore ?><span><?php echo esc_html( $b[1] ); ?><br><?php echo esc_html( $b[2] . ', ' . $city . ', ' . $state ); ?></span></p>
						<p class="branch-card__tel"><?php echo ac_icon( 'phone' ); // phpcs:ignore ?><span>
							<?php foreach ( $b[3] as $k => $tel ) : ?>
								<?php echo $k ? ' · ' : ''; ?><a href="tel:+52<?php echo esc_attr( preg_replace( '/\D+/', '', $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a>
							<?php endforeach; ?>
						</span></p>
						<a class="ac-link" href="<?php echo esc_url( ac_branch_map_url( $b, $city, $state ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ac_en ? 'Get directions' : 'Cómo llegar' ); ?> <?php echo ac_icon( 'arrow' ); // phpcs:ignore ?></a>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endforeach; ?>
</div>
