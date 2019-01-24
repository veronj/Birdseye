@extends('layouts.app')

@section('content')
        <h1>{{ $project->title }}</h1>
       <div>
            {{ $project->description }}     
            
       </div>
       <div><a href="/projects">Back to projects</a></div>
@endsection
