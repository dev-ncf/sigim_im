@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col">
				<h3 class="page-title">Perfil</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Estudante</a></li>
					<li class="breadcrumb-item active">Perfil</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="profile-header">
				<div class="row align-items-center">
					<div class="profile-image col-auto">
						<a href="#">
							<img class="rounded-circle" alt="User Image" src="assets/img/profiles/avatar-02.jpg">
						</a>
					</div>
					@foreach ($student->studentEnrollment as $enrollment)
						<div class="col ms-md-n2 profile-user-info">
							<h4 class="user-name mb-0">{{ $student->first_name . ' ' . $student->last_name }}</h4>
							<h6 class="text-muted">{{ $enrollment->course->label }}</h6>
							<div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $enrollment->faculty->label }}</div>
							<div class="about-text">{{ $enrollment->sewingLine->label }}</div>
						</div>
					@endforeach

					<div class="profile-btn col-auto">
						<a href="" class="btn btn-primary">
							Edit
						</a>
					</div>
				</div>
			</div>
			<div class="profile-menu">
				<ul class="nav nav-tabs nav-tabs-solid">

					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#enrollments_tab">Iscrições</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#movements_tab">Propinas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#per_details_tab">Sobre</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
					</li>
				</ul>
			</div>
			<div class="tab-content profile-tab-cont">

				<div class="tab-pane fade" id="per_details_tab">

					<div class="row">
						<div class="col-lg-9">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
										<span>Dados Pessoais</span>
										<a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i
												class="far fa-edit me-1"></i>Edit</a>
									</h5>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Name</p>
										<p class="col-sm-9">John Doe</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Date of Birth</p>
										<p class="col-sm-9">24 Jul 1983</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Email ID</p>
										<p class="col-sm-9"><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
												data-cfemail="a1cbcec9cfc5cec4e1c4d9c0ccd1cdc48fc2cecc">[email&#160;protected]</a>
										</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Mobile</p>
										<p class="col-sm-9">305-310-5857</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
										<p class="col-sm-9 mb-0">4663 Agriculture Lane,<br>
											Miami,<br>
											Florida - 33165,<br>
											United States.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3">

							<div class="card">
								<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
										<span>Account Status</span>
										<a class="edit-link" href="#"><i class="far fa-edit me-1"></i> Edit</a>
									</h5>
									<button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i>
										Active</button>
								</div>
							</div>

							<div class="card">
								<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
										<span>Skills </span>
										<a class="edit-link" href="#"><i class="far fa-edit me-1"></i> Edit</a>
									</h5>
									<div class="skill-tags">
										<span>Html5</span>
										<span>CSS3</span>
										<span>WordPress</span>
										<span>Javascript</span>
										<span>Android</span>
										<span>iOS</span>
										<span>Angular</span>
										<span>PHP</span>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
				<div class="tab-pane fade show active" id="enrollments_tab">

					<div class="card">
						<div class="card-body">
							<h5 class="card-title d-flex justify-content-between">
								<span>Inscrições</span>
								<a class="btn btn-primary" data-bs-toggle="modal" href="#enrollments_tab"><i class="fa fa-plus me-1"></i>Add</a>
							</h5>
							<div class="table-responsive">
								<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
									<thead class="student-thread">
										<tr>

											<th>Nome</th>
											<th>Local de Estudo</th>
											<th>Curso</th>
											<th>Semestre</th>
											<th>Estado</th>

											<th class="text-end">Action</th>
										</tr>
									</thead>
									<tbody>

										@foreach ($student->studentEnrollment as $enrollment)
											<tr>

												<td>
													<h2 class="table-avatar">

														<a href="">{{ $student->truncateName($student->first_name . ' ' . $student->last_name) }}</a>
													</h2>

												</td>
												<td>

													{{ $enrollment->extension->city }}

												</td>
												<td>
													{{ $enrollment->course->label }}

												</td>

												<td>{{ $enrollment->semestre }}</td>
												<td><span
														style="padding: 3px 8px; {{ $enrollment->enrollment_status == 2 ? 'background-color: #0080004a; color: #009000' : ($enrollment->enrollment_status == 1 ? 'background-color: #ffa5004a; color: #ffa500' : 'background-color: #ff08004a; color: #ff0800') }}">
														{{ $enrollment->enrollment_status == 2 ? 'Aprovada' : ($enrollment->enrollment_status == 1 ? 'Pendente' : 'Cancelada') }}
													</span>

												</td>
												<td class="text-end">
													<div class="actions">
														<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
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
				<div class="tab-pane fade" id="movements_tab">

					<div class="card">
						<div class="card-body">
							<h5 class="card-title d-flex justify-content-between">
								<span>Propinas</span>
								<a class="btn btn-primary" href="{{ route('propina-add', ['student_id' => $student->id]) }}"><i
										class="fa fa-plus me-1"></i>Add</a>
							</h5>
							<div class="table-responsive">
								<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
									<thead class="student-thread">
										<tr>

											<th>Nome</th>
											<th>Recibo</th>
											<th>Valor</th>
											<th>Semestre</th>
											<th>Mes</th>
											<th>Ano</th>

											<th class="text-end">Action</th>
										</tr>
									</thead>
									<tbody>

										@foreach ($student->studentMovement as $propina)
											<tr>

												<td>
													<h2 class="table-avatar">

														<a
															href="">{{ $propina->student->truncateName($propina->student->first_name . ' ' . $propina->student->last_name) }}</a>
													</h2>

												</td>
												<td>

													{{ $propina->receipt_number }}

												</td>
												<td>{{ $propina->total_amount }}</td>
												<td>{{ $propina->semestre }}</td>
												<td>
													{{ $propina->month }}
												</td>
												<td>
													{{ $propina->year }}
												</td>

												<td class="text-end">
													<div class="actions">
														<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
															<i class="feather-eye"></i>
														</a>
														<a href="{{ route('student-edit', ['studente_code' => $propina->id]) }}"
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

				<div id="password_tab" class="tab-pane fade">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Change Password</h5>
							<div class="row">
								<div class="col-md-10 col-lg-6">
									<form>
										<div class="form-group">
											<label>Old Password</label>
											<input type="password" class="form-control">
										</div>
										<div class="form-group">
											<label>New Password</label>
											<input type="password" class="form-control">
										</div>
										<div class="form-group">
											<label>Confirm Password</label>
											<input type="password" class="form-control">
										</div>
										<button class="btn btn-primary" type="submit">Save Changes</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
