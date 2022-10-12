<?php
// PLUGIN_PATH is defined in the entry file
include( PLUGIN_PATH . 'php/determine-manifest-type.php' );

function embed_html_factory($atts) {
    $id = 'id="video" '; // ID is always video
    $uriBase = $atts['source'] . '/';
    $manifestUri = 'manifestUri='.$uriBase.determine_manifest_type($atts['custom_video_file']).' ';

    // Handle base attributes
    $width = $atts['width'] ? 'width=' . $atts['width'] . ' ' : '';
    $poster = $atts['poster'] ? 'poster=' . $atts['poster'] . ' ' : '';
    $attributes = $atts['attributes'] ?: '';


    $subs = $atts['subs'];
    $subs_label = ($atts['subs_label'] != NULL) ? $atts['subs_label'] : 'Frances:fr-CA';
     list($sub_lang, $sub_label) = explode(':', $subs_label);

    // Handle subtitle attributes
    $subtitleAttributes = '';
    if ( $atts['subtitles'] === TRUE ) {
        $subtitleArr = array(
            'subtitles_uri' => $subs,
            'subtitle_lang' => $sub_lang,
            'subtitleKind' => 'subtitles',
            'subtitleMime' => 'vtt',
            'subtitleCodec' => '',
            'subtitle_label' => $sub_label,
        );
        foreach ($subtitleArr as $key => $value) {
            if ( $value === NULL ) continue;
            $subtitleAttributes .= $key . '="' . $value . '" ';
        }
    }


    $embedHtml  = '<div data-shaka-player-container style="max-width:40em">';
    $embedHtml .= '<video autoplay data-shaka-player ' . $id . $manifestUri . $width . $poster . $subtitleAttributes . $attributes . ' controlsList=nodownload crossorigin=anonymous>';
    //if($subs != null) {
    //    $embedHtml .= '<track kind="captions" label="'.$sub_label.'" srclang="'.$sub_lang.'" src="'.$subs.'">';
   // }
    $embedHtml .= '</video></div>';


  return $embedHtml;
}