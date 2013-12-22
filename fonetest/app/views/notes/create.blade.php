@extends('layouts.master');
@section('title', 'Notes >> Create')
@section('head')
    {{ HTML::script('js/monkeypatch.js'); }}
	{{ HTML::script('js/audiodisplay.js'); }}
    {{ HTML::script('js/recorder.js'); }}    
    
    @section('content')
    <style type='text/css'>
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
    </style>

    <div class="notes-main">
    <form id="noteform" action="{{ url('notes/create') }}" enctype="multipart/form-data">
    <h2>Send Fone Notes</h2>
    <hr />    
    <p>Use the form below to send a voice note to any of your contacts or simply enter a new number of your choice.</p>
    <div id="voice-note">
    <label for="user-type">User Type</label>
    <div id="controls">
    @if(isset($contacts) && count($contacts) > 0) 
    <?php
    $usecontacts = 'checked="true"';
    $usenumber = '';
    $contactshide = '';
    $numberhide = 'display: none;';    
     ?>
     @else
     <?php
    $usecontacts = '';
    $usenumber = 'checked = "true"';
    $contactshide = 'display: none;';
    $numberhide = '';
     ?>
     @endif
    <label for="user-type">Contact</label>
    <input name="user-type" id="user-type" type="radio" value="contact" onchange="changeUserType(this);" {{ $usecontacts }} />
    <label for="user-type">Number</label>
    <input name="user-type" id="user-type" type="radio" value="number" onchange="changeUserType(this);" {{ $usenumber }} />
    </div>
    <div id="number-div" style="{{ $numberhide }}">
    <label for="number">User Mobile No: </label>
    <input id="number" name="number" placeholder="e.g. 08023456789" />
    </div>
    <div id="contact-div" style="{{ $contactshide }}">
    Select a contact:
    <select class="contact-list" id="contact" name="contact">
    @if(isset($contacts))
    @foreach($contacts as $contact)
    <option value="{{ $contact->contact_number }}">{{ $contact->contact_name }}</option>
    @endforeach
    @endif        
    </select>
    </div>
    <div id="writevoice">
    <h5>Enter a voice note</h5>
    <textarea id="voice-text" name="voice-text" rows="6" cols="38" class="note-text"></textarea>
    </div>
    </div>
    <h4>Want to use your natural voice?</h4>
    <button id="sendnote" class="btn btn-success btn-sm" onclick="sendNote();">Send Note</button>
    <button id="showrecord" class="btn btn-primary btn-sm" onclick="toggleRecord();">Record Voice</button>
    <div id="voice-record" style="display: none;">
    <input type="hidden" id="voice-url" name="voice-url" value="" />
	<div id="viz" style="display: none;">
		<canvas id="analyser" class="note-record"></canvas>
	</div>
	<div id="controls">
    <input type="file" style="display: none;" name="file" id="file"/>
		<button class="btn btn-success recording" id="record" onclick="startRecording(this);"><i class="icon-white fa-bullhorn"></i>Start Recording</button>
		<button id="audioupload" class="btn btn-primary recording" id="save"><i class="icon-white fa-cloud-upload"></i>Upload &amp; Send</button>
	</div>
    </div>
    </form>
    <ul id="recordingslist" class="list-group"></ul>
    </div>
    <script type="text/javascript">
    var audio_context;
    var recorder;
    var analyserContext = null;
    
    function startUserMedia(stream) {
    inputPoint = audio_context.createGain();

    // Create an AudioNode from the stream.
    realAudioInput = audio_context.createMediaStreamSource(stream);
    audioInput = realAudioInput;
    audioInput.connect(inputPoint);
    //audioInput = convertToMono( input );
    analyserNode = audio_context.createAnalyser();
    analyserNode.fftSize = 2048;
    inputPoint.connect( analyserNode );

    recorder = new Recorder( inputPoint );

    zeroGain = audio_context.createGain();
    zeroGain.gain.value = 0.0;
    inputPoint.connect( zeroGain );
    zeroGain.connect( audio_context.destination );
    updateAnalysers();
  }

  function startRecording(button) {
    event.preventDefault();
    var rdiv = $('#record');
    if(rdiv.text() == 'Start Recording')
    {
        $('audio').remove();
        recorder && recorder.record();    rdiv.text('Stop Recording');
        $('#viz').show();
    }
    else{
        rdiv.text('Start Recording');
        $('#viz').hide();    recorder && recorder.stop();
        
        // create WAV download link using audio data blob
        createDownloadLink();
        recorder.clear();
    }
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
      var url = URL.createObjectURL(blob);
      var li = document.createElement('li');
      var au = document.createElement('audio');
      var bt = document.getElementById('audioupload');
	  
      au.controls = true;
      au.src = url;
      li.appendChild(au);
      recordingslist.appendChild(li);
      bt.onclick =  function(){ sendWaveToPost(blob); }
    });
  }
  
  function sendWaveToPost(blob) {
    event.preventDefault();
	var file2 = new FileReader();
	file2.onloadend = function(e){				 
				$.ajax({
					url: "/audio/receive.php",
					type: "POST",
					data: file2.result,
					processData: false,
					contentType : "text/plain"
				}).done(completeHandler)
                .fail(errorHandler);
			};
            file2.readAsDataURL( blob );
            return false;
    }
  
    function completeHandler(data)
    {
        var url = '/audio/' + data.substring(data.lastIndexOf('record_'));
        document.getElementById('voice-url').value = url;
        document.getElementById('noteform').submit();
    }
    
    function sendNote()
    {
        document.getElementById('noteform').submit();
    }
    
    function errorHandler(data)
    {
        alert('An error occurred while trying to upload your recording. Please try again.');
    }
        
    function toggleRecord()
    {
        event.preventDefault();
        $('#voice-record').toggle();
        $('#writevoice').toggle();
        return false;
    }
    
    function changeUserType(e)
    {
        if(e.value == "number")
        {
            $('#number-div').show();
            $('#contact-div').hide();
        }
        else{
            $('#contact-div').show();
            $('#number-div').hide();
        }        
    }
    
    function cancelAnalyserUpdates() {
    window.cancelAnimationFrame( rafID );
    rafID = null;
}

function updateAnalysers(time) {
    if (!analyserContext) {
        var canvas = document.getElementById("analyser");
        canvasWidth = canvas.width;
        canvasHeight = canvas.height;
        analyserContext = canvas.getContext('2d');
    }

    // analyzer draw code here
    {
        var SPACING = 3;
        var BAR_WIDTH = 1;
        var numBars = Math.round(canvasWidth / SPACING);
        var freqByteData = new Uint8Array(analyserNode.frequencyBinCount);

        analyserNode.getByteFrequencyData(freqByteData); 

        analyserContext.clearRect(0, 0, canvasWidth, canvasHeight);
        analyserContext.fillStyle = '#F6D565';
        analyserContext.lineCap = 'round';
        var multiplier = analyserNode.frequencyBinCount / numBars;

        // Draw rectangle for each frequency bin.
        for (var i = 0; i < numBars; ++i) {
            var magnitude = 0;
            var offset = Math.floor( i * multiplier );
            // gotta sum/average the block, or we miss narrow-bandwidth spikes
            for (var j = 0; j< multiplier; j++)
                magnitude += freqByteData[offset + j];
            magnitude = magnitude / multiplier;
            var magnitude2 = freqByteData[i * multiplier];
            analyserContext.fillStyle = "hsl( " + Math.round((i*360)/numBars) + ", 100%, 50%)";
            analyserContext.fillRect(i * SPACING, canvasHeight, BAR_WIDTH, -magnitude);
        }
    }
    
    rafID = window.requestAnimationFrame( updateAnalysers );
}

    window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      
      audio_context = new AudioContext;
    } catch (e) {
      alert('No web audio support in this browser!');
    }
    
    navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
      alert('No live audio input: ' + e);
    });
  };

  </script>
    @stop