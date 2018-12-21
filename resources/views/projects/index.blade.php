<!DOCTYPE html>
<html>
    <head>
       <title>BirdsEye</title>
    </head>
    <body>
        <h1>Board</h1>
       <div>
           <ul>
            @foreach($projects as $project)
            <li>
            <a href="{{ $project->path() }}">{{ $project->title }}</a>     
            </li>
            @endforeach
           </ul>
       </div>
    </body>
</html>
