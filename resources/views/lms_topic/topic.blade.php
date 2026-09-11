
@extends('layouts.app')

@section('content')

    @include('lms_topic.topic_page',['edit' => $mainData, 'course' => $course,
    'lesson' => $lesson, 'category' => $topicCategory])

@endsection