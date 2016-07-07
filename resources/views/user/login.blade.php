@extends('layouts.main')

@section('content')
<div class="login-box">
	<div class="login-logo">
        <a href="/"><b>Deploy</b></a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="{{ url('/toLogin') }}" method="post">
			<div class="form-group has-feedback">
				<input type="email" name="email" class="form-control" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="remember" value="1"> Remember Me
						</label>
					</div>
				</div><!-- /.col -->
				<div class="col-xs-4">
					{!! csrf_field() !!}
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div><!-- /.col -->
			</div>
        </form>

<!--        <div class="social-auth-links text-center">
			<p>- OR -</p>
			<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
			<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div> /.social-auth-links -->
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

        <a href="#">I forgot my password</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ url('/register') }}" class="text-center">Register a new membership</a>

	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
