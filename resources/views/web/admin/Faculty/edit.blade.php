@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Faculdades</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Faculdade</a></li>
						<li class="breadcrumb-item active">Editar Faculdade</li>
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

					<form method="post" action="{{ route('faculty-update') }}" enctype="multipart/form-data" class="needs-validation"
						novalidate>
						@csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações da Faculdade <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome<span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Nome da faculdade ..." required name="label"
										value="{{ $faculty->label }}">
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Extensão<span class="login-danger">*</span></label>
									<select class="form-control" type="text" required name="extension_id">
										<option value="">Selecione a Extensão ...</option>
										@foreach ($extensaos as $extensao)
											<option {{ $faculty->extension_id == $extensao->id ? 'selected' : '' }} value="{{ $extensao->id }}">
												{{ $extensao->city }}</option>
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
