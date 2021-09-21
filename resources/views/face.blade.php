@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="./assets/fonts.css" charset="utf-8">
    <title>Interface</title>
  </head>
  <body>
  <div class="container">
  
  <form method="POST" action="{{route('convert')}}" enctype="multipart/form-data">
  @csrf
  <div class="Input_Box">
  <label for="formFileLg" class="form-label">اختر الملف</label>
  <input class="form-control form-control-lg" id="formFileLg" type="file" name="filename"  accept="file/*,.docx">
  @error('filename')
  <small class="form-text text-danger">{{$message}} </small>
  @enderror
  <input class="form-control form-control-lg" id="formFileLg" type="text" name="lesson" placeholder="ادخل كود الدورة اوالدرس" >
  @error('lesson')
  <small class="form-text text-danger">{{$message}} </small>
  @enderror

  <div class="form-group mt-3">
  <button type="submit"  style="color: #3e368e;" class="btn btn-outline-info" name="click">تحويل</button>
   
  </div>
</div>
</form>
</div>
  
@endsection
