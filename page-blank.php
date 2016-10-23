<?php
/*
	Template Name: Blank
*/

// Only adding the "entry-content" post class on non-woocommerce pages to avoid CSS conflicts
$post_class = ( nm_is_woocommerce_page() ) ? '' : 'entry-content';

get_header(); ?>

<style>
.nm-page-overflow {
	> *:not(.nm-page-wrap) {
		display: none;
	}

	.nm-page-wrap {
		> *:not(.nm-page-wrap-inner) {
			display: none;
		}

		.nm-page-wrap-inner {
			> *:not(.nm-page-full) {
				display: none;
			}
		}
	}
}
</style>

    <div class="nm-page-full blank-page">

        <?php while ( have_posts() ) : the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
                <?php the_content(); ?>
            </div>

        <?php endwhile; ?>

    </div>

<?php get_footer(); ?>
