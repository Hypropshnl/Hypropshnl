
@extends('layouts.app')

@section('content')

@include('lms_course.my_courses_page',['mainData' => $mainData])

@endsection