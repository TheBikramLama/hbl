<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>@yield('title', 'Himalayan Bank Limited - Processing Payment')</title>

	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	@yield('css')

</head>
<body>

	<div class="main-wrapper">
		<div class="content">
			@yield('content')
		</div>
		<div class="copyright">
			<ul>
				<li>
					<a href="https://himalayanbank.com/" class="link" target="_blank" rel="noreferrer">HBL</a>
				</li>
				<li>
					<a href="https://bikramlama.com.np" class="link" target="_blank" rel="noreferrer">Bikram Lama</a>
				</li>
			</ul>
			<ul>
				<li>
					Copyright &copy; {{ date('Y') }}
				</li>
			</ul>
		</div>
	</div>

	@yield('javascript')

</body>
</html>