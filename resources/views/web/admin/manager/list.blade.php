@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Managers</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Manager</a></li>
						<li class="breadcrumb-item active">All Managers</li>
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
							<div class="col">

							</div>
							<div class="float-end download-grp col-auto ms-auto text-end">
								<a href="students.html" class="btn btn-outline-gray active me-2"><i
										class="feather-list"></i></a>
								<a href="students-grid.html" class="btn btn-outline-gray me-2"><i
										class="feather-grid"></i></a>
								<a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i>
									Download</a>
								<a href="{{ route('student-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table
							class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>Id</th>
									<th>Name</th>
									<th>Issue place</th>
									<th>Mobile Number</th>
									<th>E-mail</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($managers as $manager)
									<tr>

										<td>
											# {{ $manager->id }}
										</td>
										<td>
											<h2 class="table-avatar">
												<a href="student-details.html" class="avatar avatar-sm me-2"><img
														class="avatar-img rounded-circle"
														src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" alt="User Image"></a>
												<a href="student-details.html">{{ $manager->first_name . ' ' . $manager->last_name }}</a>
											</h2>
										</td>
										<td>{{ $manager->issue_place }}</td>
										<td>{{ $manager->phone }}</td>
										<td>{{ $manager->email }}</td>
										<td class="text-end">
											<div class="actions">
												<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('manager-edit') }}" class="btn btn-sm bg-danger-light">
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
