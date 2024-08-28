@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Inscrições</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Inscrição</a></li>
						<li class="breadcrumb-item active">Todas Inscrições</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" action="{{ route('enrollment-search') }}" method="POST">
			@csrf
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar por Nome ..." name="nome">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="course_id">
						<option value="">Selecione o Curso ...</option>
						@foreach ($cursos as $curso)
							<option value="{{ $curso->id }}">{{ $curso->label }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="semestre">
						<option value="">Selecione o Semestre ...</option>
						<option value="1">1º</option>
						<option value="2">2º</option>
						<option value="3">3º</option>
						<option value="4">4º</option>
					</select>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="submit" class="btn btn-primary">Pesquisar</button>
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

								<a href="{{ route('enrollment-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

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

								@foreach ($enrollments as $student)
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
												{{ $student->truncateName($enrollment->course->label) }}

											</td>

											<td>{{ $enrollment->semestre }}</td>
											<td><span
													style="padding: 3px 8px; {{ $enrollment->enrollment_status == 2 ? 'background-color: #0080004a; color: #009000' : ($enrollment->enrollment_status == 1 ? 'background-color: #ffa5004a; color: #ffa500' : 'background-color: #ff08004a; color: #ff0800') }}">
													{{ $enrollment->enrollment_status == 2 ? 'Aprovada' : ($enrollment->enrollment_status == 1 ? 'Pendente' : 'Cancelada') }}
												</span>

											</td>
											<td class="text-end">
												<div class="actions">
													@if ($enrollment->enrollment_status == 1)
														<a href="{{ route('enrollment-approve', $enrollment->id) }}" class="btn btn-sm bg-success-light me-2">
															<i class="{{ 'feather-check' }}"></i>
														</a>
													@endif

													<a href="{{ route('student-show', $student->id) }}" class="btn btn-sm bg-success-light me-2">
														<i class="feather-eye"></i>
													</a>
													<a href="{{ route('enrollment-edit', $enrollment->id) }}" class="btn btn-sm bg-danger-light">

														<i class="feather-edit"></i>
													</a>
													@if ($dadosUsuario->nivel == 'A')
														<a href="#" id="delete-{{ $enrollment->id }}" onclick="return confirmDeletion(event)"
															class="btn btn-sm bg-danger" enrollment-id='{{ $enrollment->id }}'>
															<i class="feather-delete"></i>
														</a>
													@endif
												</div>
											</td>
										</tr>
									@endforeach
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div id="modal"
		style="width: 100%; height:100%; top: 0; left:0; background-color: #00000030; display: none; position: fixed; z-index: 100; justify-content: center; align-items: center;">
		<div style="background-color: white; padding:40px; box-shadow: 1px 5px 10px white; border-radius: 10px">

			<h3>Queres mesmo apagar esta Inscrição?</h3>
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
			var enrollmentId = event.currentTarget.getAttribute('enrollment-id');
			var confirmLink = document.getElementById('confirm-delete');
			confirmLink.href = "{{ route('enrollment-delete', '') }}/" + enrollmentId;

			// Define o código no campo do modal
			document.getElementById('enrollment-id').value = enrollmentId;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
