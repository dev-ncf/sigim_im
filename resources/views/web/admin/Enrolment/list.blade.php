@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Enrollments</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Enrollment</a></li>
						<li class="breadcrumb-item active">All Enrollments</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by ID ...">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Name ...">
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Phone ...">
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="btn" class="btn btn-primary">Search</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-table comman-shadow">
				<div class="card-body">

					<div class="page-header">
						<div class="row align-items-center">

							<div class="float-end download-grp col-auto ms-auto text-end">
								<a href="students.html" class="btn btn-outline-gray active me-2"><i
										class="feather-list"></i></a>
								<a href="students-grid.html" class="btn btn-outline-gray me-2"><i
										class="feather-grid"></i></a>
								<a href="#" class="btn btn-outline-primary me-2"><i
										class="fas fa-download"></i>
									Download</a>
								<a href="{{ route('student-add') }}" class="btn btn-primary"><i
										class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table
							class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>Code</th>
									<th>Name</th>
									<th>Date of Enrolment</th>
									<th>Local of study</th>
									<th>Status</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enrollments as $student)
									<tr>

										<td>
											[ {{ $student->code }} ]
										</td>
										<td>
											<h2 class="table-avatar">

												<a
													href="student-details.html">{{ $student->first_name . ' ' . $student->last_name }}</a>
											</h2>
										</td>
										<td>{{ $student->studentEnrollment->created_at }}</td>
										<td>{{ $student->studentEnrollment->extension->city }}</td>
										<td><span
												style="padding: 3px 8px; {{ $student->registration_status == 2 ? 'background-color: #0080004a; color: #009000' : ($student->registration_status == 1 ? 'background-color: #ffa5004a; color: #ffa500' : 'background-color: #ff08004a; color: #ff0800') }}">
												{{ $student->registration_status == 2 ? 'Aprovada' : ($student->registration_status == 1 ? 'Pendente' : 'Cancelada') }}
											</span>

										</td>
										<td class="text-end">
											<div class="actions">
												<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('student-edit', ['studente_code' => $student->code]) }}"
													class="btn btn-sm bg-danger-light">

													<i class="feather-printer"></i>
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
