(function() {
  async function init() {
    // Install built-in polyfills to patch browser incompatibilities.
   // shaka.polyfill.installAll();

    // Check to see if the browser supports the basic APIs Shaka needs.
    if (shaka.Player.isBrowserSupported()) {
console.log('Support video');
      // Everything looks good!

      	var video = document.getElementById('video');
 	const ui = video['ui'];
 	const controls = ui.getControls();
        const config = {
            'controlPanelElements': [
                'time_and_duration',
                'play_pause',
                'mute',
                'volume',
                'airplay',
                'cast',
                'fullscreen',
                'captions',
                'quality'
            ],
        };
        ui.configure(config);
 	const player = controls.getPlayer();

 window.player = player;
  window.ui = ui;
  player.addEventListener('error', onPlayerErrorEvent);
  controls.addEventListener('error', onUIErrorEvent);
   var manifestUri = video.getAttribute('manifestUri');
   
  try {
    await player.load(manifestUri);
    var subtitles = video.getAttribute('subtitles_uri');
	var subtitle_label = video.getAttribute('subtitle_label');
	var subtitle_lang = video.getAttribute('subtitle_lang');
	
	 player.addTextTrackAsync(subtitles, subtitle_lang, 'subtitles');
     player.setTextTrackVisibility(true);
            await player.configure({
                preferredTextLanguage: subtitle_lang,
                streaming: {
                    bufferingGoal: 120,
                    rebufferingGoal: 0.5,
                    bufferBehind: 5,
                    lowLatencyMode: true,
                },
                manifest: {
                    dash: {
                        ignoreMinBufferTime: true
                    }
                },
                abr: {
                    defaultBandwidthEstimate: 50000,
                    switchInterval: 1
                }
            });


    // This runs if the asynchronous load is successful.
    console.log('The video has now been loaded!');
  } catch (error) {
    onPlayerError(error);
  }
//      initPlayer(video);
    } else {
      // This browser does not have the minimum set of APIs we need.
      console.error('Browser not supported!');
    }
  }

function onPlayerErrorEvent(errorEvent) {
  // Extract the shaka.util.Error object from the event.
  onPlayerError(event.detail);
}

function onPlayerError(error) {
  // Handle player error
  console.error('Error code', error.code, 'object', error);
}

function onUIErrorEvent(errorEvent) {
  // Extract the shaka.util.Error object from the event.
  onPlayerError(event.detail);
}

function initFailed(errorEvent) {
  // Handle the failure to load; errorEvent.detail.reasonCode has a
  // shaka.ui.FailReasonCode describing why.
  console.error('Unable to load the UI library!');
}

// Listen to the custom shaka-ui-loaded event, to wait until the UI is loaded.
document.addEventListener('shaka-ui-loaded', init);
// Listen to the custom shaka-ui-load-failed event, in case Shaka Player fails
// to load (e.g. due to lack of browser support).
document.addEventListener('shaka-ui-load-failed', initFailed)

  function initPlayer(video) {
    // Create a Player instance.
    var manifestUri = video.getAttribute('manifestUri');
    var subtitleUri = video.getAttribute('subtitleUri');
    var player = new shaka.Player(video);

    // Attach player to the window to make it easy to access in the JS console.
    window.player = player;

    // Listen for error events.
    player.addEventListener('error', onErrorEvent);

    // Try to load a manifest.
    // This is an asynchronous process.
    player.load(manifestUri).then(function() {
      // This runs if the asynchronous load is successful.
      console.log('The video has now been loaded!');
    }).then(function() {
      console.log('success');
    }).catch(onError);  // onError is executed if the asynchronous load fails.
  }

  function onErrorEvent(event) {
    // Extract the shaka.util.Error object from the event.
    onError(event.detail);
  }

  function onError(error) {
    // Log the error.
    console.error('Error code', error.code, 'object', error);
  }

  //document.addEventListener('DOMContentLoaded', initApp);
})();