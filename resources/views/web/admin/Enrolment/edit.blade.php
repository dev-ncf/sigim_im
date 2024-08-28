@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Inscrição</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('enrollment-list') }}">Inscrições</a></li>
						<li class="breadcrumb-item active">Editar Inscrição</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card comman-shadow">
				<div class="card-body">
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form method="post" action="{{ route('admin-enrollment-update') }}" enctype="multipart/form-data"
						class="needs-validation" novalidate>
						@csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações da inscrição <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Pesquisar Estudante</label>
									<input type="text" id="search" class="form-control" placeholder="Pesquisar estudante...">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Estudante <span class="login-danger">*</span></label>
									<select id="estudantes" class="form-control select" name="student_id" required>
										<option value="">Selecione um estudante</option>
										@foreach ($estudantes as $estudante)
											<option value="{{ $estudante->id }}" {{ $estudante->id == $student->id ? 'selected' : '' }}>
												{{ $estudante->truncateName($estudante->first_name . ' ' . $estudante->last_name) }} </option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>

							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Faculdade <span class="login-danger">*</span></label>
									<select class="form-control select" required name="faculty_id">
										<option value="">Selecione o Faculdade</option>

										@foreach ($faculdades as $faculdade)
											<option value="{{ $faculdade->id }}" {{ $enrollment->faculty_id == $faculdade->id ? 'selected' : '' }}>
												{{ $faculdade->label }}</option>
										@endforeach

									</select>
									<div class="invalid-feedback">
										Campo obrigatório..
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Curso <span class="login-danger">*</span></label>
									<select class="form-control select" required name="course_id">
										<option value="">Selecione o Curso</option>
										@foreach ($cursos as $curso)
											<option {{ $enrollment->course_id == $curso->id ? 'selected' : '' }} value="{{ $curso->id }}">
												{{ $curso->label }}</option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										Campo obrigatório..
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Linha de Pesquisa <span class="login-danger">*</span></label>
									<select class="form-control select" required name="sewing_line_id">
										<option value="">Selecione a Linha de Pesquisa</option>
										@foreach ($linhasPesquisa as $dado)
											<option {{ $enrollment->sewing_line_id == $dado->id ? 'selected' : '' }} value="{{ $dado->id }}">
												{{ $dado->label }}</option>
										@endforeach

									</select>
									<div class="invalid-feedback">
										Campo obrigatório..
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Semestre <span class="login-danger">*</span></label>
									<select class="form-control select" required name="semestre">
										<option value="">Selecione o Semestre</option>
										<option value="1" {{ $enrollment->semestre == '1' ? 'selected' : '' }}>1º</option>
										<option value="2" {{ $enrollment->semestre == '2' ? 'selected' : '' }}>2º</option>
										<option value="3" {{ $enrollment->semestre == '3' ? 'selected' : '' }}>3º</option>
										<option value="4" {{ $enrollment->semestre == '4' ? 'selected' : '' }}>4º</option>
									</select>
									<div class="invalid-feedback">
										Campo obrigatório..
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Serviço <span class="login-danger">*</span></label>
									<select class="form-control select" required name="taxa">
										<option value="">Selecione o Serviço</option>
										<option value="1000" {{ $enrollment->taxa == '1000' ? 'selected' : '' }}>Inscrição para nacionais</option>
										<option value="1200" {{ $enrollment->taxa == '1200' ? 'selected' : '' }}>Inscrição para estrangeiros </option>
									</select>
									<div class="invalid-feedback">
										Campo obrigatório..
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Número de disciplinas<span class="login-danger">*</span></label>
									<input class="form-control" type="number" placeholder="Numero de disciplinas a frequentar" required
										value="{{ $enrollment->numero_disciplinas }}" name="numero_disciplinas">
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="student-submit">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var select = document.getElementById('estudantes');
			var options = select.getElementsByTagName('option');

			document.getElementById('search').addEventListener('keyup', function() {
				var searchText = this.value.toLowerCase();

				for (var i = 0; i < options.length; i++) {
					var optionText = options[i].text.toLowerCase();
					var visible = optionText.includes(searchText);
					options[i].style.display = visible ? '' : 'none';
				}
			});
		});
	</script>

@endsection
