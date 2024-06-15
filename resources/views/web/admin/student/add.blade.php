@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Estudantes</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Estudante</a></li>
						<li class="breadcrumb-item active">Adicionar estudante</li>
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

					<form method="post" action="{{route('admin-student-store')}}"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Informações do estudante <span><a href="javascript:;"><i
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
									<label>Genero <span class="login-danger">*</span></label>
									<select class="form-control select" required name="gender_id">
										<option value="">Selecione o genero</option>
										<option value="1">Feminino</option>
										<option value="2">Masculino</option>
									</select>
                                    <div class="invalid-feedback">
                                        O Genero é obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms ">
									<label>Data de Nascimento<span class="login-danger">*</span></label>
									<input class="form-control datetimepicker" type="date" placeholder="DD-MM-YYYY" required name="birth_date">
                                    <div class="invalid-feedback">
                                        A data de nascimento é obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Provincia de Nascimento <span class="login-danger">*</span></label>
									<select id="provincias" class="form-control select" required name="province_birth_id">
										<option value="">Selecione a provincia </option>
                                        @foreach ($provincias as $provincia)
										<option value="{{$provincia->id}}">{{$provincia->label}}</option>
                                        @endforeach

									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Distrito de Nascimento <span class="login-danger">*</span></label>
									<select id="distritos" class="form-control select" required name="birth_local">
                                        <option value="">Selecione o distrito </option>
                                        @foreach ($distritos as $distrito)
										<option value="{{$distrito->label}}" data-provincia-id="{{$distrito->province_id}}">{{$distrito->label}} </option>

                                        @endforeach

									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Estado Civil <span class="login-danger">*</span></label>
									<select class="form-control select" required name="marital_status_id">
										<option value="">Selecione o estado civil </option>
										@foreach ($estadosCivil as $estado)
										<option value="{{$estado->id}}">{{$estado->label}} </option>

                                        @endforeach

									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nacionalidade  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite a nacionalidade" name="nationality" required>
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
									<label>Tipo de agregado familiar  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o tipo de agregado Familiar" name="family_type" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Numero de agregado  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o numero de agregado" name="household" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Necessidade de educação especial</label>
									<input class="form-control" type="text" placeholder="Digite a educação que necessita" name="special_educational_need">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Gestor Responsavel  <span class="login-danger">*</span></label>
									<select class="form-control select" name="manager_response_id" required>
										<option value="">Selecione o Gestor </option>
										@foreach ($gestores as $gestor)
										<option value="{{$gestor->id}}">{{$gestor->first_name.' '.$gestor->last_name." (".$gestor->issue_place.")"}}</option>

                                        @endforeach

									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Extensão <span class="login-danger">*</span></label>
									<select class="form-control select" name="extension_id" required>
										<option value="">Selecione a extensão </option>
                                        @foreach ($extensoes as $extensao)

										<option value="{{$extensao->id}}">{{$extensao->city}}</option>
                                        @endforeach
									</select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
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
                            <div class="col-12">
								<h5 class="form-title student-info">Filiação <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome do pai  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o nome do pai" name="father_name" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Profissão do pai </label>
									<input class="form-control" type="text" placeholder="Digite a profissão do pai" name="father_profession">
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nome da mãe  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o nome da mãe" name="mother_name" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
                            <div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Profissão da mãe </label>
									<input class="form-control" type="text" placeholder="Digite a profissão da mãe" name="mother_profession">
								</div>
							</div>

                            <div class="col-12">
								<h5 class="form-title student-info">Identificação <span><a href="javascript:;"><i
												class="feather-more-vertical"></i></a></span></h5>
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
                            <div class="col-12">
								<h5 class="form-title student-info">Endereço <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Provincia <span class="login-danger">*</span></label>
									<select id="provinciasE" class="form-control select" required name="province_id">
										<option value="">Selecione a provincia </option>
										@foreach ($provincias as $tipo)
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
									<label>Distrito <span class="login-danger">*</span></label>
									<select id="distritosE" class="form-control select" required name="district_id">
										<option value="">Selecione o distrito </option>
										@foreach ($distritos as $distrito)
										<option value="{{$distrito->id}}" data-provincia-id="{{$distrito->province_id}}">{{$distrito->label}} </option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										Campo obrigatório.
									</div>
								</div>
							</div>
							<!-- Restante do código -->

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Bairro  <span class="login-danger">*</span></label>
									<input class="form-control" type="text" placeholder="Digite o nome do bairro" name="neighborhood" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Quarteirão  <span class="login-danger">*</span></label>
									<input class="form-control" type="number" placeholder="Digite o Numero do quarteirão" name="block" required>
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Nº de Casa  <span class="login-danger">*</span></label>
									<input class="form-control" type="number"  name="house_number" required placeholder="Numero de casa">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>Foto de Estudante (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
											Selecionar <input type="file" name="foto">
										</label>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>Certificado (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
                                            Selecionar <input type="file" name="certificado">
										</label>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>BI (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
											Selecionar <input type="file" name="bi">
										</label>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>NUIT (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
											Selecionar <input type="file" name="nuit">
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

    <script>
		document.addEventListener('DOMContentLoaded', function() {
			var selectProvinciasL = document.getElementById('provincias');
			var selectDistritosL = document.getElementById('distritos');
			var selectProvincias = document.getElementById('provinciasE');
			var selectDistritos = document.getElementById('distritosE');
			var optionsDistritos = selectDistritos.querySelectorAll('option');
			var optionsDistritosL = selectDistritosL.querySelectorAll('option');

			// Filtrar distritos com base na provincia selecionada
			selectProvincias.addEventListener('change', function() {
				var selectedProvinciaId = this.value;

				optionsDistritos.forEach(function(option) {
					var provinciaId = option.getAttribute('data-provincia-id');
					option.style.display = (provinciaId === selectedProvinciaId || option.value === '') ? '' : 'none';
				});

				selectDistritos.value = ''; // Resetar o valor do select de distritos
			});
			selectProvinciasL.addEventListener('change', function() {
				var selectedProvinciaId = this.value;

				optionsDistritosL.forEach(function(option) {
					var provinciaId = option.getAttribute('data-provincia-id');
					option.style.display = (provinciaId === selectedProvinciaId || option.value === '') ? '' : 'none';
				});

				selectDistritosL.value = ''; // Resetar o valor do select de distritos
			});
		});
	</script>


@endsection
