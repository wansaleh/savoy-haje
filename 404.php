<?php get_header(); ?>

<div class="nm-row">
    <div class="col-xs-12">
        <div class="nm-page-not-found">
            <div class="nm-page-not-found-icon"></div>
            <h2><?php esc_html_e( 'Oops, page not found.', 'savoy-haje' ); ?></h2>
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Click the link below to return home.', 'savoy-haje' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="nm-font nm-font-arrow-left"></i><?php esc_html_e( '&nbsp;&nbsp;Homepage', 'savoy-haje' ); ?></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
