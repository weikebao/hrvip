@extends('layout.layout')
@section('con')
<div class="container">
            	<div id="mws-error-page">
                    <h1>欢迎您<span>{{session('user')['name']}}</span></h1>
                </div>
            </div>
@endsection