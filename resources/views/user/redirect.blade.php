@extends('layouts.main')

@section('content')
<div>
	<h2>{{$message}}</h2>
	<p><span class="fred" id="wait">{{$waitSecond}}</span> 秒后 页面<span class="fblue"><a href="{{$jumpUrl}}"  id="href">自动跳转</a></span></p>
	<a class="rt" href="{{url('/')}}">返回首页</a>
</div>
<script>
(function(){
	var wait = document.getElementById('wait'),href = document.getElementById('href').href;
	var interval = setInterval(function(){
		var time = --wait.innerHTML;
		if(time <= 0) {
			location.href = href;
			clearInterval(interval);
		};
	}, 1000);
})();
</script>
@endsection
