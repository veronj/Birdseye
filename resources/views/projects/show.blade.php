@extends('layouts.app')

@section('content')
        <h1>{{ $project->title }}</h1>
       <div>
            {{ $project->description }}     
            
       </div>
       <div><h3>Tasks</h3>
       @foreach($project->tasks as $task)
          <div>{{ $task->body }}</div>
       @endforeach
     </div>
       <div><a href="/projects">Back to projects</a></div>
@endsection
