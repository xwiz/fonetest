@extends('layouts.master')
@section('title', 'User >> Welcome')
@section('content')

Bienvenue!

<p>[Intro Video Here]</p>
<div class="panel well panel-success">
<p>Head over to {{ HTML::link('notes/create', 'Create Note') }} to create your first noe.</p>
</div>
@stop