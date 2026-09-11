@extends('mail_views.mail_layout')

@section('content')

    @if(count($data['birthdayPhotos']) > 0)
    
    @foreach($data['birthdayPhotos'] as $photo)
    <img class="pull-right" src="{{ asset('images/birthday-frames/'.$photo)}}"><br/>
    
    @endforeach
    
    @endif
    
    {{$data['message']}}

@endsection