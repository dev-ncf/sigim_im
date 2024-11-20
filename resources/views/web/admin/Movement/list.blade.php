@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Propinas</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('propina-list')}}">Propinas</a></li>
						<li class="breadcrumb-item active">Todas Propinas</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" action="{{ route('propina-search') }}" method="POST">
			@csrf
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar pelo numero de Recibo ..." name="receipt_number">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar pelo Código ..." name="student_code"
						value="{{ old('student_code') }}">
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="month">
						<option value="">Selecione o Mês</option>
						<Option value="1">1º</Option>
						<Option value="2">2º</Option>
						<Option value="3">3º</Option>
						<Option value="4">4º</Option>
						<Option value="5">5º</Option>
						<Option value="6">6º</Option>
						<Option value="7">7º</Option>
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="semestre">
						<option value="">Selecione o Semestre</option>
						<Option value="1">1º</Option>
						<Option value="2">2º</Option>
						<Option value="3">3º</Option>
						<Option value="4">4º</Option>
					</select>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="submit" class="btn btn-primary">Filtrar</button>
				</div>
			</div>
			</fom>
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

						</div>
					</div>

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

								@foreach ($propinas as $propina)
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
												<a href="{{ route('propina-print', ['number' => $propina->code]) }}"
													class="btn btn-sm bg-success-light me-2">
													<i class="feather-printer"></i>
												</a>
												<a href="{{ route('propina-edit', $propina->id) }}" class="btn btn-sm bg-danger-light">

													<i class="feather-edit"></i>
												</a>
												@if ($dadosUsuario->nivel == 'A')
													<a href="#" id="delete-{{ $propina->id }}" onclick="return confirmDeletion(event)"
														class="btn btn-sm bg-danger" enrollment-id='{{ $propina->id }}'>
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
			confirmLink.href = "{{ route('propina-delete', '') }}/" + enrollmentId;

			// Define o código no campo do modal
			document.getElementById('enrollment-id').value = enrollmentId;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
