@extends('template.template4')
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Bem vindo Sr(a). {{ $dadosUsuario->last_name }}!</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home-admin')}}">Home</a></li>
						<li class="breadcrumb-item active">Admin</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<a href="{{ route('student-list') }}" class="col-xl-3 col-sm-6 col-12 d-flex">
			<div class="card bg-comman w-100">
				<div class="card-body">
					<div class="db-widgets d-flex justify-content-between align-items-center">
						<div class="db-info">
							<h6>Estudantes</h6>

							<h3>{{ $totalStudents = count($students) }}
							</h3>
						</div>
						<div class="db-icon">
							<img src="{{ asset('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon">
						</div>
					</div>
				</div>
			</div>
		</a>
		<a href="{{ route('manager-list') }}" class="col-xl-3 col-sm-6 col-12 d-flex">
			<div class="card bg-comman w-100">
				<div class="card-body">
					<div class="db-widgets d-flex justify-content-between align-items-center">
						<div class="db-info">
							<h6>Gestores</h6>
							<h3>
								{{ $totalManagers = count($managers) }}</h3>
						</div>
						<div class="db-icon">
							<svg xmlns="http://www.w3.org/2000/svg" height="40" width="48"
								viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
								<path fill="#63E6BE"
									d="M208 352c-2.4 0-4.8 .4-7.1 1.1C188 357.3 174.4 360 160 360c-14.4 0-28-2.7-41-6.9-2.3-.7-4.7-1.1-7.1-1.1C49.9 352-.3 402.5 0 464.6 .1 490.9 21.7 512 48 512h224c26.3 0 47.9-21.1 48-47.4 .3-62.1-49.9-112.6-112-112.6zm-48-32c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zM592 0H208c-26.5 0-48 22.3-48 49.6V96c23.4 0 45.1 6.8 64 17.8V64h352v288h-64v-64H384v64h-76.2c19.1 16.7 33.1 38.7 39.7 64H592c26.5 0 48-22.3 48-49.6V49.6C640 22.3 618.5 0 592 0z" />
							</svg>
						</div>
					</div>
				</div>
			</div>
		</a>
		<a href="{{ route('course-list') }}" class="col-xl-3 col-sm-6 col-12 d-flex">
			<div class="card bg-comman w-100">
				<div class="card-body">
					<div class="db-widgets d-flex justify-content-between align-items-center">
						<div class="db-info">
							<h6>Cursos</h6>
							<h3>
								{{ $totalManagers = count($courses) }}</h3>
						</div>
						<div class="db-icon">
							<img src="{{ asset('assets/img/icons/student-icon-01.svg') }}" alt="Dashboard Icon">
						</div>
					</div>
				</div>
			</div>
		</a>
		<a href="{{ route('faculty-list') }}" class="col-xl-3 col-sm-6 col-12 d-flex">
			<div class="card bg-comman w-100">
				<div class="card-body">
					<div class="db-widgets d-flex justify-content-between align-items-center">
						<div class="db-info">
							<h6>Faculdades</h6>
							<h3>
								{{ $totalManagers = count($faculties) }}</h3>
						</div>
						<div class="db-icon">
							<svg xmlns="http://www.w3.org/2000/svg" height="40" width="48"
								viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
								<path fill="#74C0FC"
									d="M337.8 5.4C327-1.8 313-1.8 302.2 5.4L166.3 96 48 96C21.5 96 0 117.5 0 144L0 464c0 26.5 21.5 48 48 48l208 0 0-96c0-35.3 28.7-64 64-64s64 28.7 64 64l0 96 208 0c26.5 0 48-21.5 48-48l0-320c0-26.5-21.5-48-48-48L473.7 96 337.8 5.4zM96 192l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM96 320l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM232 176a88 88 0 1 1 176 0 88 88 0 1 1 -176 0zm88-48c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-16 0 0-16c0-8.8-7.2-16-16-16z" />
							</svg>
						</div>
					</div>
				</div>
			</div>
		</a>

	</div>

	<div class="row">
		<div class="col-md-12 col-lg-6">

			<div class="card card-chart">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-6">
							<h5 class="card-title">Faixas Etárias </h5>
						</div>

					</div>
				</div>
				<div class="card-body">
					<div id="s-bar" students="{{ json_encode($students) }}"></div>
				</div>
			</div>

		</div>
		<div class="col-md-12 col-lg-6">

			<div class="card card-chart">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-6">
							<h5 class="card-title">Numero de Estudantes </h5>
						</div>

					</div>
				</div>
				<div class="card-body">
					<div id="bar" estudantes="{{ json_encode($studentsByYear) }}"></div>
				</div>
			</div>

		</div>
		<div class="col-md-12 col-lg-6">
			<div class="card flex-fill student-space comman-shadow">
				<div class="card-header d-flex align-items-center">
					<h5 class="card-title">Ultimos Estudantes</h5>
					<ul class="chart-list-out student-ellips">
						<li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="star-student table-hover table-center table-borderless table-striped table">
							<thead class="thead-light">
								<tr>
									<th>Código de Estudante</th>
									<th>Nome</th>
									<th>Curso</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($students->reverse()->take(5) as $student)
									<tr>
										<td class="text-nowrap">
											<div>{{ $student->code }}</div>
										</td>
										<td class="text-nowrap">
											<a href="#">

												{{ $student->first_name . ' ' . $student->last_name }}
											</a>
										</td>

										<td class="text-nowrap">
											@foreach ($student->studentEnrollment as $studentEnrollment)
												{{ $student->truncateName($studentEnrollment->course->label) }}
											@endforeach
										</td>

									</tr>
								@endforeach

							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
@endsection
