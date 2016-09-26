<?php

add_action('wp_logout', create_function('', 'wp_redirect(home_url()); exit();'));

class Haje
{
  private $version = '1.0';

  function __construct() {
    // add_action( 'wp_enqueue_scripts', array( $this, 'styles' ), 10000 );
    add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 20000 );
    add_action( 'wp_head', array( $this, 'styles' ), 10000 );
    add_action( 'wp_footer', array( $this, 'last_scripts' ), 10000 );
    add_filter( 'nm_myaccount_title', array( $this, 'myaccount_title' ) );
    add_action( 'login_enqueue_scripts', array( $this, 'login' ) );
    add_filter( 'login_headerurl', array( $this, 'login_logo_url' ) );
    // add_action( 'admin_head', 'admin_styles' );
  }

  static function uri($relative_uri = "") {
    return get_stylesheet_directory_uri() . $relative_uri;
  }

  function styles() {
    if ( is_admin() ) return;

    // wp_enqueue_style( 'haje', Haje::uri('/assets/css/haje.css') );

    echo "<link rel='stylesheet' href='" . Haje::uri('/assets/css/haje.css') . "' type='text/css' media='all'>";
  }

  function scripts() {
    if ( nm_woocommerce_activated() ) {
      wp_enqueue_script('nm-shop-quickview', Haje::uri('/assets/js/haje-nm-shop-quickview.js'), array( 'jquery', 'nm-shop', 'wc-add-to-cart-variation' ), NM_THEME_VERSION);

      if ( is_woocommerce() ) {
        wp_enqueue_script('nm-shop-filters', Haje::uri('/assets/js/haje-nm-shop-filters.js'), array( 'jquery', 'nm-shop' ), NM_THEME_VERSION);

        if ( is_product() ) {
          // wp_enqueue_script( 'nm-shop-single-product', Haje::uri('/assets/js/haje-nm-shop-single-product.js'), array( 'jquery', 'nm-shop', 'slick-slider', 'easyzoom' ), NM_THEME_VERSION );
        }
      }
    }
  }

  function last_scripts() {
    if ( is_admin() ) return;

    // echo "<script type='text/javascript' src='" . Haje::uri('/assets/js/haje-nm-single-product.js') . "'></script>\n";
    echo "<script type='text/javascript' src='" . Haje::uri('/assets/js/vendor.js') . "'></script>\n";
    echo "<script type='text/javascript' src='" . Haje::uri('/assets/js/haje.js') . "'></script>\n";
  }

  function myaccount_title($title) {
    return 'Account';
  }

  function login() {
    echo '<link href="/wp-content/uploads/2016/09/haje-icon-accented-512.png" rel="shortcut icon">';
    echo "<link rel='stylesheet' href='" . Haje::uri('/assets/css/login.css') . "' type='text/css' media='all'>";
    wp_enqueue_script('haje-login', Haje::uri('/assets/js/login.js'), array('jquery'), $this->version);
  }

  function login_logo_url() {
    return home_url();
  }

  function admin_styles() {
    echo '<style>
      .menu-item-settings:after {
        content: "";
        display: table;
        clear: both;
      }
    </style>';
  }
}


class Haje_Misc {
  function __construct() {
    add_shortcode( 'haje_address', array( $this, 'address' ) );
    add_filter( 'widget_title', array( $this, 'html_widget_title' ) );
    add_filter( 'get_terms_args', array( $this, 'convert_include' ), 10, 2 );
  }

  function address( $atts ) {
    $a = shortcode_atts( array(
      'phone_email' => false
    ), $atts );

    $phone_email = "";
    if ($a['phone_email'])
      $phone_email = "<p><i class='fa fa-paper-plane'></i> <a href='/contact'>hello@haje.my</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i class='fa fa-phone'></i> +603 7733 1297</p>";

    return "
    <address>
      <p><b>Haje, Mikraj Concept</b><br>F-LG-07, Neo Damansara<br>Jalan PJU 8/1, Damansara Perdana<br>47820 Petaling Jaya, Selangor, Malaysia</p>
      $phone_email
    </address>
    ";
  }

  function html_widget_title( $var) {
    $var = (str_replace( '[', '<', $var ));
    $var = (str_replace( ']', '>', $var ));
    return $var;
  }

  function convert_include($query, $taxonomies) {
    if ($query['include'] && is_string($query['include']) && strpos($query['include'], ',') !== false) {
      $query['include'] = explode(',', $query['include']);
    }

    return $query;
  }
}

class Haje_Savoy {
  function __construct() {
    add_action( 'redux/options/nm_theme_options/saved', array( $this, 'custom_styles' ), 100 );
  }

  function custom_styles() {
    global $nm_theme_options;

    ob_start();
?>

$accent: <?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;

$main: <?php echo esc_attr( $nm_theme_options['main_font_color'] ); ?>;
$black: <?php echo esc_attr( $nm_theme_options['heading_color'] ); ?>;

<?php

    file_put_contents( get_stylesheet_directory() . '/assets/_source/css/modules/_colors-settings.scss', ob_get_clean() );
  }
}


new Haje;
new Haje_Misc;
new Haje_Savoy;
