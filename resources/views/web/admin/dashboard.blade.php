@extends('template.template4')
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Bem vindo Admin!</h3>
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
							<img src="{{ asset('assets/img/icons/admin-svgrepo-com.svg') }}"
								alt="Dashboard Icon">
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
						<table
							class="star-student table-hover table-center table-borderless table-striped table">
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
											<a href="profile.html">
												<img class="rounded-circle"
													src="{{ asset('assets/img/profiles/avatar-0' . rand(1, 3) . '.jpg') }}"
													width="25" alt="Star Students">
												{{ $student->first_name . ' ' . $student->last_name }}
											</a>
										</td>
										<td class="text-center">{{ $student->studentEnrollment->faculty->label }}</td>
										<td class="text-center">{{ $student->studentEnrollment->course->label }}</td>
										<td class="text-center">{{ $student->studentEnrollment->sewingLine->label }}
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

	<div class="row">
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card flex-fill fb sm-box">
				<div class="social-likes">
					<p>Seguidores no facebook</p>
					<h6>50,095</h6>
				</div>
				<div class="social-boxs">
					<img src="{{ asset('assets/img/icons/social-icon-01.svg') }}" alt="Social Icon">
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card flex-fill twitter sm-box">
				<div class="social-likes">
					<p>Seguidores no twitter</p>
					<h6>48,596</h6>
				</div>
				<div class="social-boxs">
					<img src="{{ asset('assets/img/icons/social-icon-02.svg') }}" alt="Social Icon">
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card flex-fill insta sm-box">
				<div class="social-likes">
					<p>Seguidores no instagram</p>
					<h6>52,085</h6>
				</div>
				<div class="social-boxs">
					<img src="{{ asset('assets/img/icons/social-icon-03.svg') }}" alt="Social Icon">
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card flex-fill linkedin sm-box">
				<div class="social-likes">
					<p>Seguidores no linkedin</p>
					<h6>69,050</h6>
				</div>
				<div class="social-boxs">
					<img src="{{ asset('assets/img/icons/social-icon-04.svg') }}" alt="Social Icon">
				</div>
			</div>
		</div>
	@endsection
