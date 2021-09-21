@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <br>
                    <a  style="cursor:progress" href="{{$data}}" > أضغط لتحميل الملف </a>
                </div>
                
            </div>
            <button type="submit" style="color: #3e368e;" class="btn btn-outline-info" onclick="window.location='{{ url("home") }}'">اضافة درس اخر</button>
             
        </div>
    </div>
</div>
@endsection
