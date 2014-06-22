@extends('krafthaus/bauhaususer::layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">

			@if (Session::has('message.error'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Whoops</strong>
				{{ Session::get('message.error') }}
			</div>
			@endif

			<div class="panel panel-default">
				<div class="panel-heading">
					{{ Config::get('bauhaus::admin.title') }}
				</div>
				<div class="panel-body">
					{{ Form::open(['method' => 'POST', 'route' => 'admin.sessions.store', 'class' => 'form-horizontal']) }}

						<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
							<label for="f-email" class="col-sm-4 control-label">Email</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="f-email" name="email" value="{{ Input::old('email') }}" placeholder="Email">
							</div>
						</div>

						<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
							<label for="f-password" class="col-sm-4 control-label">Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="f-password" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember">
										Remember me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<input type="submit" class="btn btn-default btn-red btn-rounded" value="Sign-in">
							</div>
						</div>

					{{ Form::close() }}
				</div>
			</div>

		</div>
	</div>
@stop