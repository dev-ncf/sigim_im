@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Gestores</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Gestor</a></li>
						<li class="breadcrumb-item active">Adicionar Gestor</li>
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

					<form method="post" action="{{route('admin-manager-store')}}"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações do Gestor <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o nome" required name="first_name"  id="validationServer01">
                                    <div class="invalid-feedback">
                                        O nome é obrigatório.
                                        </div>
								</div>


							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Apelido <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o apelido" required name="last_name">
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
										<option value="{{$tipo->id}}">{{$tipo->city}} </option>

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
										<option value="{{$tipo->id}}">{{$tipo->label}} </option>

                                        @endforeach

									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Numero de Documento  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o Numero de Documento" name="document_number" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Local de Emissão  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o Numero de Documento" name="issue_place" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Data de Emissão  <span class="login-danger">*</span></label>
									<input class="form-control" type="date"  name="issue_date" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Data de Validade  <span class="login-danger">*</span></label>
									<input class="form-control" type="date"  name="expiration_date" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>



                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Contacto  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o numero de telefone" name="phone" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Contacto alternativo</label>
									<input class="form-control" type="text" placeholder="Digite o contacto alternativo" name="phone_secondary">
								</div>
							</div>



							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>E-Mail <span class="login-danger">*</span></label>
									<input class="form-control" type="email" placeholder="Digite o email" name="email" required id="validationCustom03">
                                    <div class="invalid-feedback">
                                        Insere um email válido, por favor!.
                                    </div>
								</div>


							</div>

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
