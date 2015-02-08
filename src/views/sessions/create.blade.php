@extends('krafthaus/bauhaususer::layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">

			<div class="account-wall">
				<img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
					 alt="">

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

				{{ Form::open(['method' => 'POST', 'route' => 'admin.sessions.store', 'class' => 'form-signin']) }}

				{{ Form::text('email',null,['placeholder'=>trans('bauhaususer::form.field.email.title'),'required','autofocus','class'=>'form-control'])}}
				{{ Form::password('password',['placeholder'=>trans('bauhaususer::form.field.password.title'),'required','class'=>'form-control'])}}

				{{Form::submit(trans('bauhaususer::form.field.submit.title'),['class'=>'btn btn-lg btn-primary btn-block'])}}
					<label class="checkbox pull-left">
						<input type="checkbox" value="remember-me">
						{{ trans('bauhaususer::form.remember-me') }}
					</label>
				{{ Form::close() }}


				<div class="clearfix"></div>
			</div>

		</div>
	</div>
@stop
