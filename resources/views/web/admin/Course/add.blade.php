@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Cursos</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('course-list') }}">Curso</a></li>
						<li class="breadcrumb-item active">Adicionar Curso</li>
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
					@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif

					<form method="post" action="{{ route('course-store') }}" enctype="multipart/form-data" class="needs-validation"
						novalidate>
						@csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações do Curso <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome<span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Nome do curso ..." required name="label">
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Faculdade<span class="login-danger">*</span></label>
									<select class="form-control" type="text" required name="faculty_id">
										<option value="">Selecione a Faculdade ...</option>
										@foreach ($faculties as $faculty)
											<option value="{{ $faculty->id }}">{{ $faculty->label }}</option>
										@endforeach
									</select>
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
