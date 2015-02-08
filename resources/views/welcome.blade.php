@extends('public')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="jumbotron">
					<h1>Welcome To Fadich.com</h1>
					<p>Thanks for stopping by, but you'll need to log in to go any further.</p>
					<p>If you're part of the family please login or register.</p>
					<p class="">
						<a class="btn btn-primary btn-lg" href="register" role="button">Register</a>
						<a class="btn btn-primary btn-lg" href="login" role="button">Login</a>
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection
