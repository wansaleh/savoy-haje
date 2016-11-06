<?php get_header(); ?>

<div class="nm-row">
    <div class="col-xs-12">
        <div class="nm-page-not-found">
          <svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
          	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 380 500"
          	 style="enable-background:new 0 0 380 500;" xml:space="preserve">

          <g id="Page-1">
          	<path id="Polygon-2" class="st0" d="M35.6,253l31.1,18.2v35.9l-31.1,17.6L4.5,307.1v-35.9L35.6,253z"/>
          	<path id="Polygon-3" class="st1" d="M350.9,97.2l24.5,14.3v28.2l-24.5,13.8l-24.5-13.8v-28.2
          		L350.9,97.2z"/>
          	<path id="Polygon-4" class="st2" d="M290.1,253l60.8,35.8v70.5l-60.8,34.5l-60.8-34.5v-70.5L290.1,253z
          		"/>
          	<path id="Polygon-5" class="st3" d="M127.6,376.4l46.3,27.3v53.7l-46.3,26.2l-46.3-26.2v-53.7
          		L127.6,376.4z"/>
          </g>
          <g>
          	<polygon class="st4" points="284.4,98.9 284.4,93.2 160.3,19 36.2,92.9 36.2,98.9 36,98.9 36,124.1 160.3,195.8 284.5,124.1
          		284.5,98.9 	"/>
          	<polygon class="st4" points="268.8,150.8 268.8,221.3 160.3,284 51.7,221.3 51.7,150.8 36,141.7 36,230.4 160.3,302.1 284.5,230.4
          		284.5,141.7 	"/>
          </g>
          </svg>

            <div class="nm-page-not-found-icon"></div>
            <h2><?php esc_html_e( 'Oops, page not found.', 'savoy-haje' ); ?></h2>
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Click the link below to return home.', 'savoy-haje' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="nm-font nm-font-arrow-left"></i><?php esc_html_e( '&nbsp;&nbsp;Homepage', 'savoy-haje' ); ?></a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
