<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compitable" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" user-scalable="no">

	<title>{{ Config::get('bauhaus::admin.title') }}</title>

	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ asset('packages/krafthaus/bauhaus/stylesheets/application.css') }}">
	<link rel="stylesheet" type="text/css" href="http://eonasdan.github.io/bootstrap-datetimepicker/content/bootstrap-datetimepicker.css">

</head>
<body>

	<div class="container">
		@yield('content')
	</div>

	<script src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
	<script src="{{ asset('packages/krafthaus/bauhaus/javascripts/application.min.js') }}"></script>
	@yield('scripts')

</body>
</html>