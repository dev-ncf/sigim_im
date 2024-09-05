<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>SIGIM</title>
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
				<a href="{{ route('home-admin') }}" class="logo">
					<img src="{{ asset('img/logo.png') }}" alt="Logo">

					<span style="font-weight: bold; margin-left: 15px; font-size: 20pt">Unirovuma</span>

					<span style="font-size: 12pt;display: block;margin-left: 60px; margin-top:-43px; color: rgb(231, 72, 14)">Registo
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
							<img class="rounded-circle"
								src="{{ $dadosUsuario->first_name == 'Ntwali Chance' ? asset('assets/img/profiles/avatar-01.jpg') : asset('img/logo.jpg') }}"
								width="31" alt="NCF">
							<div class="user-text">
								<h6>{{ $dadosUsuario->first_name . ' ' . $dadosUsuario->last_name }}</h6>
								<p class="text-muted mb-0">{{ $dadosUsuario->funcao }}</p>
							</div>
						</span>
					</a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm">
								<img
									src="{{ $dadosUsuario->first_name == 'Ntwali Chance' ? asset('assets/img/profiles/avatar-01.jpg') : asset('img/logo.jpg') }}"
									alt="User Image" class="avatar-img rounded-circle">
							</div>
							<div class="user-text">
								<h6>{{ $dadosUsuario->first_name . ' ' . $dadosUsuario->last_name }}</h6>
								<p class="text-muted mb-0">{{ $dadosUsuario->funcao }}</p>
							</div>
						</div>
						<a class="dropdown-item" href="{{ route('user-show') }}">Meu Perfil</a>
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
						<li class="submenu {{ request()->routeIs('home-admin') || request()->routeIs('user-show') ? 'active' : '' }}">
							<a href="{{ route('home-admin') }}"><i class="feather-grid"></i> <span> Dashboard</span> <span
									class="menu-arrow"></span></a>

						</li>
						@if ($dadosUsuario->nivel == 'A')
							<li
								class="submenu {{ request()->routeIs('manager-list') || request()->routeIs('manager-add') || request()->routeIs('manager-edit') || request()->routeIs('manager-show') || request()->routeIs('manager-search') ? 'active' : '' }}">
								<a href="#"><i class="fas fa-chalkboard-teacher"></i> <span>
										Gestores</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('manager-list') }}" class="{{ request()->routeIs('manager-list') ? 'active' : '' }}">
											Lista</a></li>
									<li><a href="{{ route('manager-add') }}"
											class="{{ request()->routeIs('manager-add') ? 'active' : '' }}">Add</a></li>
								</ul>
							</li>
						@endif
						<li
							class="submenu {{ request()->routeIs('student-list') || request()->routeIs('student-add') || request()->routeIs('student-edit') || request()->routeIs('student-show') || request()->routeIs('student-search') ? 'active' : '' }}">
							<a href="#"><i class="fas fa-graduation-cap"></i> <span> Estudantes</span>
								<span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('student-list') }}" class="{{ request()->routeIs('student-list') ? 'active' : '' }}">
										Lista</a></li>
								<li><a href="{{ route('student-add') }}" class="{{ request()->routeIs('student-add') ? 'active' : '' }}">
										Add</a></li>
							</ul>
						</li>

						<li
							class="submenu {{ request()->routeIs('enrollment-list') || request()->routeIs('enrollment-add') || request()->routeIs('enrollment-edit') || request()->routeIs('enrollment-search') ? 'active' : '' }}">
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

						<li
							class="submenu {{ request()->routeIs('propina-list') || request()->routeIs('propina-add') || request()->routeIs('propina-edit') || request()->routeIs('propina-search') ? 'active' : '' }}">
							<a href="#"><i class="fas fa-coins"></i> <span> Propinas</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="{{ route('propina-list') }}"
										class="{{ request()->routeIs('propina-list') ? 'active' : '' }}">List</a>
								</li>
							</ul>
						</li>
						@if ($dadosUsuario->nivel == 'A')
							<li
								class="submenu {{ request()->routeIs('faculty-list') || request()->routeIs('faculty-add') || request()->routeIs('faculty-edit') || request()->routeIs('faculty-search') || request()->routeIs('faculty-show') ? 'active' : '' }}">
								<a href="#"><i class="fa fa-school"></i> <span> Faculdades</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('faculty-list') }}"
											class="{{ request()->routeIs('faculty-list') ? 'active' : '' }}">List</a>
									</li>
									<li><a href="{{ route('faculty-add') }}"
											class="{{ request()->routeIs('faculty-add') ? 'active' : '' }}">Add</a>
									</li>
								</ul>
							</li>
							<li
								class="submenu {{ request()->routeIs('course-list') || request()->routeIs('course-add') || request()->routeIs('course-edit') || request()->routeIs('course-search') || request()->routeIs('course-show') ? 'active' : '' }}">
								<a href="#"><i class="fa fa-book"></i> <span> Cursos</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('course-list') }}"
											class="{{ request()->routeIs('course-list') ? 'active' : '' }}">List</a>
									</li>
									<li><a href="{{ route('course-add') }}"
											class="{{ request()->routeIs('course-add') ? 'active' : '' }}">Add</a>
									</li>
								</ul>
							</li>
							<li
								class="submenu {{ request()->routeIs('periodo-list') || request()->routeIs('periodo-add') || request()->routeIs('periodo-edit') ? 'active' : '' }}">
								<a href="#"><i class="fa fa-book"></i> <span> Periodos de Inscrições</span> <span
										class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('periodo-list') }}"
											class="{{ request()->routeIs('periodo-list') ? 'active' : '' }}">List</a>
									</li>
									<li><a href="{{ route('periodo-add') }}"
											class="{{ request()->routeIs('periodo-add') ? 'active' : '' }}">Add</a>
									</li>
								</ul>
							</li>
						@endif

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
