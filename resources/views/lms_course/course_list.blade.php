@extends('layouts.app')

@section('content')

@include('lms_course.course_list_page',['mainData' => $mainData,
'dept' => $dept,'lmsCourseCategory' => $lmsCourseCategory,'courseArr' => $courseArr])

@endsection