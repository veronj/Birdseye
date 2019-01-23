@extends('layouts.app')

@section('content')
    <h1>Board {{ auth()->user()->id }}</h1>
       <div>
           <ul>
            @forelse($projects as $project)
                <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>     
                </li>
            @empty
                No project yet.

            @endforelse
           </ul>
           
            
           
       </div>
@endsection
