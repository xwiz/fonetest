<meta charset="utf-8"/>
<meta name="description" content="Fonenode Demo"/>
<meta name="author" content="Opata Chibueze"/>
<title>@yield('title')</title>
<!-- bootstrap and jquery from cdn 
<link href="//netdna.bootstrapcdn.com/bootswatch/3.0.3/yeti/bootstrap.min.css" rel="stylesheet"/>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
-->

{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/font-awesome.css') }}
{{ HTML::style('css/main.css') }}

{{ HTML::script('js/jquery.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}

@yield('head')