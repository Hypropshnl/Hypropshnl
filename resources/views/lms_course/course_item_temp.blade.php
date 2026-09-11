
@extends('layouts.temp_app')

@section('content')

@include('lms_course.course_item_page',['mainData' => $mainData,'myTopics' => $myTopics,
'lesson' => $lessons,'percentage' => $percentage])

@endsection