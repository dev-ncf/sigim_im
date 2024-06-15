<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Admin Dashboard</title>
	<link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
	<link
		href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}"> --}}
</head>

<body>

	<div class="main-wrapper">

		<div class="header">

			<div class="header-left">
				<a href="index.html" class="logo">
					<img src="{{ asset('img/logo.png') }}" alt="Logo">

					<span style="font-weight: bold; margin-left: 15px; font-size: larger">Unirovuma</span>

					<span
						style="font-size: xx-small;display: block;margin-left: 60px; margin-top:-47px; color: rgb(231, 72, 14)">Registo
						Académico</span>

				</a>

				<a href="index.html" class="logo logo-small">
					<img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30">
				</a>
			</div>
			<div class="menu-toggle">
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fas fa-bars"></i>
				</a>
			</div>

			<div class="top-nav-search">

			</div>
			<a class="mobile_btn" id="mobile_btn">
				<i class="fas fa-bars"></i>
			</a>

			<ul class="nav user-menu">

				<li class="nav-item dropdown has-arrow new-user-menus">
					<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<span class="user-img">
							<img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" width="31"
								alt="NCF">
							<div class="user-text">
								<h6>{{ $dadosUsuario->first_name . ' ' . $dadosUsuario->last_name }}</h6>
								<p class="text-muted mb-0">{{ $dadosUsuario->funcao }}</p>
							</div>
						</span>
					</a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm">
								<img src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
							</div>
							<div class="user-text">
								<h6>{{ $dadosUsuario->first_name . ' ' . $dadosUsuario->last_name }}</h6>
								<p class="text-muted mb-0">{{ $dadosUsuario->funcao }}</p>
							</div>
						</div>
						<a class="dropdown-item" href="">Meu Perfil</a>
						<form action="{{ route('logout') }}" method="POST">
							@csrf
							<button type="submit" class="dropdown-item">Logout</button>
						</form>
					</div>
				</li>

			</ul>

		</div>

		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="menu-title">
							<span>Main Menu</span>
						</li>
						<li class="submenu active">
							<a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('home-admin') }}"
										class="{{ request()->routeIs('home-admin') ? 'active' : '' }}">Admin</a></li>

							</ul>

						</li>
						<li class="submenu">
							<a href="#"><i class="fas fa-chalkboard-teacher"></i> <span>
									Gestores</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('manager-list') }}" class="{{ request()->routeIs('manager-list') ? 'active' : '' }}">
										Lista</a></li>
								<li><a href="{{ route('manager-add') }}"
										class="{{ request()->routeIs('manager-add') ? 'active' : '' }}">Add</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fas fa-graduation-cap"></i> <span> Estudantes</span>
								<span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('student-list') }}" class="{{ request()->routeIs('student-list') ? 'active' : '' }}">
										Lista</a></li>
								<li><a href="{{ route('student-add') }}" class="{{ request()->routeIs('student-add') ? 'active' : '' }}">
										Add</a></li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-sticky-note"></i> <span>Inscrições</span>
								<span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('enrollment-list') }}"
										class="{{ request()->routeIs('enrollment-list') ? 'active' : '' }}">
										Lista</a>
								</li>
								<li><a href="{{ route('enrollment-add') }}"
										class="{{ request()->routeIs('enrollment-add') ? 'active' : '' }}">
										Add</a>
								</li>
							</ul>
						</li>
						{{-- <li class="submenu">
							<a href="#"><i class="fas fa-cogs"></i> <span> Admins</span> <span
									class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('admin-list') }}"
										class="{{ request()->routeIs('admin-list') ? 'active' : '' }}">Admin List</a>
								</li>
								<li><a href="{{ route('admin-add') }}"
										class="{{ request()->routeIs('admin-add') ? 'active' : '' }}">Admin Add</a>
								</li>
							</ul>
						</li> --}}
						<li class="submenu">
							<a href="#"><i class="fas fa-coins"></i> <span> Propinas</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('propina-list') }}"
										class="{{ request()->routeIs('propina-list') ? 'active' : '' }}">List</a>
								</li>
							</ul>
						</li>

					</ul>
				</div>
			</div>
		</div>

		<div class="page-wrapper">
			<div class="content container-fluid">
				@yield('content')
			</div>
		</div>
		<footer>
			<p>Copyright © 2024 DTIC`s.</p>
		</footer>
	</div>
	</div>

	<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/js/feather.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
	<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/script.js') }}"></script>
	<script src="{{ asset('assets/js/form-validation.js') }}"></script>

</body>

</html>
