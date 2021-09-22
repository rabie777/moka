@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="./assets/fonts.css" charset="utf-8">
    <title>Interface</title>
  </head>
  <body>
  <div class="container">
  
  <div class="d-grid gap-2 col-6 mx-auto" style="text-align: center;">
  <button type="submit"  style="color: #3e368e;" class="btn btn-outline-info btn-lg" name="click" onclick="window.location='{{ url("mokahome") }}'">المقررات</button>
  <button type="submit"  style="color: #3e368e;" class="btn btn-outline-info btn-lg" name="click" onclick="window.location='{{ url("home") }}'">الدورات</button>
  
</div>
  </div>
</div>

</div>
  
@endsection
