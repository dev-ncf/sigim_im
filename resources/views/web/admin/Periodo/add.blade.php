@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Periodos de Inscrições</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('periodo-list') }}">Periodo de Inscrição</a></li>
						<li class="breadcrumb-item active">Adicionar Periodo de Inscrição</li>
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

					<form method="post" action="{{ route('periodo-store') }}" enctype="multipart/form-data" class="needs-validation"
						novalidate>
						@csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações do Periodo de Inscrição <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Inicio<span class="login-danger">*</span></label>
									<input class="form-control" type="date" placeholder="" required name="start">
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Fim<span class="login-danger">*</span></label>
									<input class="form-control" type="date" placeholder="" required name="end">
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
@endsection
