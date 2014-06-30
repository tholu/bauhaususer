@extends('krafthaus/bauhaususer::layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">

			@if (Session::has('message.success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>{{ trans('bauhaususer::messages.success.title') }}</strong>
					{{ Session::get('message.success') }}
				</div>
			@endif

			@if (Session::has('message.error'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>{{ trans('bauhaususer::messages.error.title') }}</strong>
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
							<label for="f-email" class="col-sm-4 control-label">{{ trans('bauhaususer::form.field.email.title') }}</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="f-email" name="email" value="{{ Input::old('email') }}" placeholder="{{ trans('bauhaususer::form.field.email.title') }}">
							</div>
						</div>

						<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
							<label for="f-password" class="col-sm-4 control-label">{{ trans('bauhaususer::form.field.password.title') }}</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="f-password" name="password" placeholder="{{ trans('bauhaususer::form.field.password.placeholder') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember">
										{{ trans('bauhaususer::form.remember-me') }}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
								<input type="submit" class="btn btn-default btn-red btn-rounded" value="{{ trans('bauhaususer::form.field.submit.title') }}">
							</div>
						</div>

					{{ Form::close() }}
				</div>
			</div>

		</div>
	</div>
@stop