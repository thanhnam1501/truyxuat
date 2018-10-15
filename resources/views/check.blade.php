@extends('layouts.check')
@section('content')
 <div>
 	<div class="form-control">
 		<h2>{{$product->name}}</h2>
 	</div>
 	<div class="form-control">
 		<img  src="/{{$product->image}}" alt="">
 	</div>
 	<div class="form-control">
 		<span>{{$product->sort_content}}</span>
 	</div>
 	<div class="form-control">
 		<span>{{$product->content}}</span>
 	</div>
 </div>
@endsection
@section('footer')
@endsection