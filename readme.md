=== shaka-player ===

Adds shortcodes that can be used to embed Shaka Player videos

Example Usage:

``
[shaka_player source="wp-content/videos/movie" poster="wp-content/videos/movie.jpg" subs="wp-content/videos/movie/subs.vtt" subs_label="fr-CA:French" custom_video_file="main"]
``

== Description ==
# Use
Add the [shaka_player] shortcode that will automatically embed the Shaka Player
Required Attributes:
- "source" - The location of the main video manifest. This value will be appended to the
             "Manifest Base" setting, and the correct manifest file format will be appended,
             depending on the platform (Dash vs HLS). For example, if a manifest can be found
             at the address "https://test.com/videos/test/dash.mpd", you would use set the
             source attribute to "videos/test"

# Optional Attributes
- "width" - The width to make the video player
- "poster" - Url of the image to show when loading video
- "attributes" - Any additional attributes you may wish to add to the video element
- "custom_video_file" - set the default name for the file mpd or m3u8: default is: "dash"
# Require for subtitles:
- "subs" - Uri for Subs vtt file
- "subs_label" - Label for subtitles, example: fr-CA:French or en-US:English
