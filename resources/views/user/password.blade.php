@extends('layouts.main')

@section('content')
<div class="login-box">
	<div class="register-box">
      <div class="register-logo">
        <a href="/"><b>Deploy</b></a>
      </div>
      <div class="register-box-body">
        <p class="login-box-msg">Find my password</p>
        <form action="/FindPass/Send" method="post">
          <div class="form-group has-feedback">
			<input type="email" name='email' class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
			<div class="col-xs-8">
			<a href="/login" class="text-center">Return to login</a>
            </div><!-- /.col -->
            <div class="col-xs-4">
				{!! csrf_field() !!}
              <button type="submit" class="btn btn-primary btn-block btn-flat">Find</button>
            </div><!-- /.col -->
          </div>
        </form>

		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

@endsection
