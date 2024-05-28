<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Universidade Rovuma | Registo Acadêmico</title>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
	<link rel="shortcut icon" href="{{ asset('img/logo.png') }}">

</head>

<body>
	@yield('content')

	<script src="{{ asset('js/axios.min.js') }}"></script>

	@yield('javascript')
</body>

</html>
