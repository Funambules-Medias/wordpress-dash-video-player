<?php
/*
  Plugin Name: Shaka Player
  description: WordPress plugin that allows embedding of the Shaka player via shortcode
  Version: 1.0.0
  Author: Funambules médias
  Author URI: https://funambulesmedias.org/
*/

define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
include( PLUGIN_PATH . 'php/embed-html-factory.php' );
/**
 * Shortcode used for embedding the Shaka Player
 */
function shaka_player_shortcode( $atts ) {
  $a = shortcode_atts( array(
    'source' => NULL,
    'width' => NULL,
    'poster' => get_option('shaka_default_poster_url'),
    'attributes' => NULL,
    'subtitles' => 'true',
    'subs' => NULL,
    'subs_label' => NULL,
  ), $atts );
  $a['subtitles'] = filter_var($a['subtitles'], FILTER_VALIDATE_BOOLEAN);

  if ( $a['source'] === NULL ) {
    print( 'Shaka Player Shortcode Error: No video source provided' );
    return;
  }

  // Enqueue scripts
  // Shaka player libraries
  wp_enqueue_script( 'compiled-shaka-player', 'https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.2.2/shaka-player.ui.min.js');

  // Video initialization script
  
  wp_enqueue_script( 'init-mux-js', 'https://cdnjs.cloudflare.com/ajax/libs/mux.js/5.10.0/mux.min.js' );

  wp_enqueue_script( 'init-shaka-player-js', plugin_dir_url(__FILE__) . 'js/init-shaka-player.js' );
  wp_enqueue_style('shaka-player-controls', 'https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.2.2/controls.min.css');

  // Return the generated embed code
  return embed_html_factory( $a );
}
add_shortcode( 'shaka_player', 'shaka_player_shortcode' );