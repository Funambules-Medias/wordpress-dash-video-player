<?php

/**
 * Uses available client information to determine what manifest type to use. The default
 * manifest type is 'dash.mpd' - however, certain Apple environments don't support dash, and
 * must instead use 'hls.m3u8'
 * 
 * HLS must always be used on iOS devices, and on Macs that are _not_ using Chrome
 */
function determine_manifest_type($custom_video_file = 'dash') {
  $custom_video_file = ($custom_video_file != NULL) ? $custom_video_file : 'dash';
  $manifestType = $custom_video_file.'.mpd';

  // Try to determine if the user is on Mac
  $isMac = false;
  if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false ) {
      $isMac = true;
    }
  }

  // Get the pre-defined iPhone and Chrome detectors
  global $is_iphone, $is_chrome;

  // Determine if we should use HLS
  if ($is_iphone || ($isMac && !$is_chrome)) {
    $manifestType = $custom_video_file.'.m3u8';
  }

  return $manifestType;
}
