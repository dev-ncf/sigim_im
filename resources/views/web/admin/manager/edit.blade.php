@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Gestores</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('manager-list') }}">Gestor</a></li>
						<li class="breadcrumb-item active">Editar Gestor</li>
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

					<form method="post" action="{{ route('manager-update', $manager->id) }}" enctype="multipart/form-data"
						class="needs-validation" novalidate>
						@csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações do Gestor <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o nome" required name="first_name"
										value="{{ $manager->first_name }}" id="validationServer01">
									<div class="invalid-feedback">
										O nome é obrigatório.
									</div>
								</div>

							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Apelido <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o apelido" required name="last_name"
										value="{{ $manager->last_name }}">
									<div class="invalid-feedback">
										O apelido é obrigatório.
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Extensão <span class="login-danger">*</span></label>
									<select class="form-control select" required name="extension_id">
										<option value="">Selecione a extensão </option>
										@foreach ($extensions as $tipo)
											<option {{ $manager->extension_id == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">
												{{ $tipo->city }}
											</option>
										@endforeach

									</select>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Tipo de Documento <span class="login-danger">*</span></label>
									<select class="form-control select" required name="document_type_id">
										<option value="">Selecione o tipo de documento </option>
										@foreach ($documentTypes as $tipo)
											<option {{ $manager->document_type_id == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">
												{{ $tipo->label }} </option>
										@endforeach

									</select>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Numero de Documento <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o Numero de Documento" name="document_number"
										value="{{ $manager->document_number }}" required>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Local de Emissão <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o local de emissao" name="issue_place"
										value="{{ $manager->issue_place }}" required>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									{{-- <label>Contacto <span class="login-danger">*</span></label> --}}
									<input class="form-control" type="text" placeholder="Digite o numero de telefone" name="phone"
										value="{{ $manager->phone }}">
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Contacto alternativo</label>
									<input class="form-control" type="text" placeholder="Digite o contacto alternativo"
										value="{{ $manager->phone }}" name="phone_secondary">

								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>E-Mail <span class="login-danger">*</span></label>
									<input class="form-control" type="email" placeholder="Digite o email" name="email" required
										value="{{ $manager->email }}" id="validationCustom03">
									<div class="invalid-feedback">
										Insere um email válido, por favor!.
									</div>
								</div>

							</div>
							@if ($dadosUsuario->nivel == 'A')
								<div class="col-12 col-sm-4">
									<div class="form-group local-forms">
										<label>Nível <span class="login-danger">*</span></label>
										<select class="form-control select" required name="document_type_id">
											<option value="">Selecione o Nível </option>

											<option {{ $manager->nivel == 'B' ? 'selected' : '' }} value="B">B</option>
											<option {{ $manager->nivel == 'C' ? 'selected' : '' }} value="C">C</option>
											<option {{ $manager->nivel == 'D' ? 'selected' : '' }} value="D">D</option>
											<option {{ $manager->nivel == 'A' ? 'selected' : '' }} value="A">A</option>
										</select>
										<div class="invalid-feedback">
											Campo obrigatório.
										</div>
									</div>
								</div>
							@endif

							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>Foto de gestor (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
											Selecionar <input type="file" name="foto">
										</label>
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
