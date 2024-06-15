@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Estudantes</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Estudante</a></li>
						<li class="breadcrumb-item active">Todos Estudantes</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" method="GET" action="{{ route('student-search') }}">
			@csrf
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Code ..." name="student_code">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Name ..." name="student_name">
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Email ..." name="student_email">
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="submit" class="btn btn-primary">Search</button>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-table comman-shadow">
				<div class="card-body">
					@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif

					<div class="page-header">
						<div class="row align-items-center">

							<div class="float-end download-grp col-auto ms-auto text-end">

								<a href="{{ route('student-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>Code</th>
									<th>Name</th>
									<th>Local of study</th>
									<th>Mobile Number</th>
									<th>E-mail</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($students as $student)
									<tr>

										<td>
											[ {{ $student->code }} ]
										</td>
										<td>
											<h2 class="table-avatar">

												<a
													href="{{ route('student-show', ['student_id' => $student->id]) }}">{{ $student->first_name . ' ' . $student->last_name }}</a>
											</h2>
										</td>
										<td>
											@foreach ($student->studentEnrollment as $enrollment)
												{{ $enrollment->extension->city }} <!-- Acessando a propriedade 'city' de 'extension' -->
											@endforeach
										</td>
										<td>{{ $student->phone }}</td>
										<td>{{ $student->email }}</td>
										<td class="text-end">
											<div class="actions">
												<a href="{{ route('student-show', ['student_id' => $student->id]) }}"
													class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('student-edit', ['studente_code' => $student->code]) }}"
													class="btn btn-sm bg-danger-light">

													<i class="feather-edit"></i>
												</a>
											</div>
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
