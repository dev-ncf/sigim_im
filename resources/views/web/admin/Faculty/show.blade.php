@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col">
				<h3 class="page-title">Perfil</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Faculdade</a></li>
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
							<img class="rounded-circle" alt="User Image" src="{{ asset('img/logo.jpg') }}">
						</a>
					</div>

					<div class="col ms-md-n2 profile-user-info">
						<h4 class="user-name mb-0">{{ $faculty->label }}</h4>
						<div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $faculty->extensao->city }}</div>
						<h6 class="user-name mb-0"><i class="fas fa-book"></i> {{ count($courses) }} Cursos</h6>
						<h6 class="user-name mb-0"> <i class="fas fa-graduation-cap"></i> {{ count($students) }} Estudantes</h6>
					</div>

					<div class="profile-btn col-auto">
						<a href="{{ route('faculty-edit', $faculty->id) }}" class="btn btn-primary">
							Edit
						</a>
					</div>
				</div>
			</div>

			<div class="profile-menu">
				<ul class="nav nav-tabs nav-tabs-solid">

					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#courses">Cursos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#students_tab">Estudantes</a>
					</li>

				</ul>
			</div>
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
			<div class="tab-content profile-tab-cont">

				<div class="tab-pane fade show active" id="courses">
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-table comman-shadow">
								<div class="card-body">

									<div class="page-header">
										<div class="row align-items-center">

											<div class="float-start w-100 col-auto">
												<h4 style="display: inline">Lista de Cursos</h4>
												<a href="{{ route('course-add') }}" class="btn btn-primary float-end text-end"><i
														class="fas fa-plus"></i></a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
											<thead class="student-thread">
												<tr>

													<th>Nome</th>
													<th>Faculdade</th>
													<th>Extensao</th>

													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody>

												@foreach ($courses as $course)
													<tr>

														<td>
															<h2 class="table-avatar">

																<a href="">{{ $course->label }}</a>
															</h2>

														</td>
														<td>

															{{ $course->faculty->label }}

														</td>
														<td>

															{{ $course->faculty->extensao->city }}

														</td>

														<td class="text-end">
															<div class="actions">

																<a href="{{ route('course-show', $course->id) }}" class="btn btn-sm bg-success-light me-2">
																	<i class="feather-eye"></i>
																</a>
																<a href="{{ route('course-edit', $course->id) }}" class="btn btn-sm bg-danger-light">

																	<i class="feather-edit"></i>
																</a>
																@if ($dadosUsuario->nivel == 'A')
																	<a href="javascript:;" id="delete-{{ $course->id }}" onclick="return confirmDeletion(event)"
																		class="btn btn-sm bg-danger" course-id='{{ $course->id }}'>
																		<i class="feather-delete"></i>
																	</a>
																@endif
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
				</div>

				<div id="students_tab" class="tab-pane fade">
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-table comman-shadow">
								<div class="card-body">
									@if (session('success'))
										<div class="alert alert-success">
											{{ session('success') }}
										</div>
									@endif
									@if ($errors->any())
										<div class="alert alert-danger">
											<ul>
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									@endif

									<div class="page-header">
										<div class="row align-items-center">

											<div class="float-start w-100 col-auto">
												<h4 style="display: inline">Lista de Estudantes</h4>
												<a href="{{ route('student-add') }}" class="btn btn-primary float-end text-end"><i
														class="fas fa-plus"></i></a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
											<thead class="student-thread">
												<tr>

													<th>Code</th>
													<th>Name</th>
													<th>Mobile Number</th>

													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody>
												@php
													$count = 1;
												@endphp
												@foreach ($students as $student)
													<tr>

														<td>
															[ {{ $student->student->code }} ]
														</td>
														<td>
															<h2 class="table-avatar">

																<a
																	href="{{ route('student-show', ['student_id' => $student->student->id]) }}">{{ $student->student->first_name . ' ' . $student->student->last_name }}</a>
															</h2>
														</td>

														<td>{{ $student->student->phone }}</td>

														<td class="text-end">
															<div class="actions">
																<a href="{{ route('student-show', ['student_id' => $student->student->id]) }}"
																	class="btn btn-sm bg-success-light me-2">
																	<i class="feather-eye"></i>
																</a>
																<a href="{{ route('student-edit', ['studente_code' => $student->student->code]) }}"
																	class="btn btn-sm bg-danger-light">

																	<i class="feather-edit"></i>
																</a>
																<a href="{{ route('student-active-deactive', $student->student->id) }}"
																	class="btn btn-sm bg-success-light me-2">
																	<i class="{{ $student->student->estado == 'Activo' ? 'feather-slash' : 'feather-check' }}"></i>
																</a>
																@if ($dadosUsuario->nivel == 'A')
																	<a href="#" id="delete-{{ $student->id }}" onclick="return confirmDeletion(event)"
																		class="btn btn-sm bg-danger" student-code='{{ $student->student->id }}'>
																		<i class="feather-delete"></i>
																	</a>
																@endif
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

				</div>

			</div>
		</div>
	</div>
	<div id="modal"
		style="width: 100%; height:100%; top: 0; left:0; background-color: #00000030; display: none; position: fixed; z-index: 100; justify-content: center; align-items: center;">
		<div style="background-color: white; padding:40px; box-shadow: 1px 5px 10px white; border-radius: 10px">

			<h3>Queres mesmo apagar este Curso?</h3>
			<div style="display: flex; justify-content: space-between">
				<a href="#" id="confirm-delete" class="btn btn-primary">Confirmar</a>
				<button class="btn btn-danger" onclick="closeModal()">Cancelar</button>
			</div>
		</div>
	</div>
	<script>
		function confirmDeletion(event) {
			event.preventDefault(); // Previne o comportamento padrão do link

			// Exibe o modal
			document.getElementById('modal').style.display = 'flex';

			// Obtém o código do estudante a partir do botão clicado
			var enrollmentId = event.currentTarget.getAttribute('course-id');
			var confirmLink = document.getElementById('confirm-delete');
			confirmLink.href = "{{ route('course-delete', '') }}/" + enrollmentId;

			// Define o código no campo do modal
			document.getElementById('course-id').value = enrollmentId;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
