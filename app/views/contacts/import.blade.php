@extends('layouts.master')
@section('title', 'Contacts >> Import')
@section('content')

<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId:'441082479326928',
cookie:true,
status:true,
xfbml:true
});

function FacebookInviteFriends()
{
FB.ui({
method: 'apprequests',
message: 'Invite your friends to Fonenotes'
});
}
</script>


<h1>Import Contacts</h1>
<p>You can import your existing contacts from Google or upload CSV files. Simply authenticate with your Google account and we'll handle the rest for you.</p>
<p class="well panel-info panel">Please note that csv files must be be in the format: [Name | Number] and may not contain any column titles.</p>
<div class="span6" style="margin: 20px auto; float: none;">
<a href="{{ $google }}" class="btn btn-danger btn-other" type="submit"><i class="icon-white fa-google-plus fa-fw"></i>Invite Google Contacts</a>
<div id="fb-root"></div>
<a href="#" onclick="FacebookInviteFriends();" class="btn btn-primary btn-other" type="submit"><i class="icon-white fa-facebook fa-fw"></i>Invite Facebook Friends</a>

<div class="progress progress-striped active">
        <div class="progress-bar"></div >
        <div class="percent">0%</div >
    </div>
    
    <div id="status"></div>    
</div>
{{ HTML::script('js/jquery.form.js') }}
<script>
function uploadAll()
{
    document.uploadContact.submit();
    return false;
}

(function() {
    
var bar = $('.progress-bar');
var percent = $('.percent');
var status = $('#status');
   
$('form').ajaxForm({
    beforeSend: function() {
        status.empty();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	complete: function(xhr) {
		status.html(xhr.responseText);
	}
}); 

})();      
</script>
@stop