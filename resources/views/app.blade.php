<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <title>Student Grading System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    
    <div id="app">
      
        <app>
        </app>
        <!-- @if(Session::has('internalError'))
         <p class="alert alert-danger">{{ Session::get('internalError') }}</p>
        @endif -->
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>