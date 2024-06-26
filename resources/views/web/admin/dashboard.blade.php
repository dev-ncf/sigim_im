@extends('template.template4')
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Bem vindo Sr(a). {{ $dadosUsuario->last_name }}!</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html">Home</a></li>
						<li class="breadcrumb-item active">Admin</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-3 col-sm-6 col-12 d-flex">
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
		</div>
		<div class="col-xl-3 col-sm-6 col-12 d-flex">
			<div class="card bg-comman w-100">
				<div class="card-body">
					<div class="db-widgets d-flex justify-content-between align-items-center">
						<div class="db-info">
							<h6>Gestores</h6>
							<h3>
								{{ $totalManagers = count($managers) }}</h3>
						</div>
						<div class="db-icon">
							<img src="{{ asset('assets/img/icons/admin-svgrepo-com.svg') }}" alt="Dashboard Icon">
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-md-12 col-lg-6">

			<div class="card card-chart">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-6">
							<h5 class="card-title">Numero de Estudantes </h5>
						</div>
						<div class="col-6">
							<ul class="chart-list-out">
								<li><span class="circle-blue"></span>Homens</li>
								<li><span class="circle-green"></span>Mulheres</li>
								<li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
								</li>
							</ul>
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
					<h5 class="card-title">Ultimos Estuddantes</h5>
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
									<th>ID</th>
									<th>Nome</th>
									<th class="text-center">Faculdade</th>
									<th class="text-center">Curso</th>
									<th class="text-end">Linha de pesquisa</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($students->reverse()->take(5) as $student)
									<tr>
										<td class="text-nowrap">
											<div>#{{ $student->code }}</div>
										</td>
										<td class="text-nowrap">
											<a href="#">

												{{ $student->first_name . ' ' . $student->last_name }}
											</a>
										</td>
										<td class="text-center">
											@foreach ($student->studentEnrollment as $studentEnrollment)
												{{ $studentEnrollment->faculty->label }}
											@endforeach
										</td>
										<td class="text-center">
											@foreach ($student->studentEnrollment as $studentEnrollment)
												{{ $studentEnrollment->course->label }}
											@endforeach
										</td>
										<td class="text-center">
											@foreach ($student->studentEnrollment as $studentEnrollment)
												{{ $studentEnrollment->sewingLine->label }}
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
