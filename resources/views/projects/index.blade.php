<!DOCTYPE html>
<html>
    <head>
       <title>BirdsEye</title>
    </head>
    <body>
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
    </body>
</html>
