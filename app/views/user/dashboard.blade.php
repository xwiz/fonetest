@extends('layouts.master')
@section('title', 'User >> Dashboard')
@section('content')

Bienvenue!

<p>Head over to your {{ HTML::link('/notes', 'Notes') }} to Create a note.
</p>

<p>OR Click {{ HTML::link('/contacts/import', 'Invite Friends') }} to invite your friends.
</p>


@stop