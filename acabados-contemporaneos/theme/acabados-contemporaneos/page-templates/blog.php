<?php
/**
 * Template Name: Blog (por idioma)
 *
 * Lista las entradas de la categoría «blog» (ES) o «blog-en» (EN).
 *
 * @package Acabados
 */

get_header();
the_post();
get_template_part( 'template-parts/page-hero' );

$ac_cat   = get_category_by_slug( 'en' === ac_lang() ? 'blog-en' : 'blog' );
$ac_paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$ac_query = new WP_Query(
	array(
		'cat'            => $ac_cat ? $ac_cat->term_id : 0,
		'paged'          => $ac_paged,
		'posts_per_page' => 9,
	)
);
?>
<section class="section">
	<div class="container">
		<?php if ( get_the_content() ) : ?>
			<div class="entry-content container--narrow blog-intro"><?php the_content(); ?></div>
		<?php endif; ?>
		<div class="posts-grid">
			<?php
			while ( $ac_query->have_posts() ) :
				$ac_query->the_post();
				get_template_part( 'template-parts/post-card' );
			endwhile;
			?>
		</div>
		<nav class="pagination">
			<?php
			echo paginate_links( // phpcs:ignore
				array(
					'total'     => $ac_query->max_num_pages,
					'current'   => $ac_paged,
					'prev_text' => ac_icon( 'arrow-l' ),
					'next_text' => ac_icon( 'arrow' ),
				)
			);
			wp_reset_postdata();
			?>
		</nav>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
