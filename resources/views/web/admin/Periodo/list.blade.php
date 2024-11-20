@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Periodos de Inscrições</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('periodo-list') }}">Periodos de Inscrição</a></li>

					</ul>
				</div>
			</div>
		</div>
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

								<a href="{{ route('periodo-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>#</th>
									<th>Inicio</th>
									<th>Fim</th>

									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>
								@php
									$count = 1;
								@endphp
								@foreach ($periodos as $periodo)
									<tr>

										<td>
											<h2 class="table-avatar">

												<a href="">{{ $count }}º</a>
											</h2>

										</td>
										<td>

											{{ $periodo->start }}

										</td>
										<td>

											{{ $periodo->end }}

										</td>

										<td class="text-end">
											<div class="actions">

												<a href="{{ route('periodo-edit', $periodo->id) }}" class="btn btn-sm bg-danger-light">

													<i class="feather-edit"></i>
												</a>
												@if ($dadosUsuario->nivel == 'A')
													<a href="javascript:;" id="delete-{{ $periodo->id }}" onclick="return confirmDeletion(event)"
														class="btn btn-sm bg-danger" periodo-id='{{ $periodo->id }}'>
														<i class="feather-delete"></i>
													</a>
												@endif
											</div>
										</td>
									</tr>
									@php
										$count++;
									@endphp
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
			var enrollmentId = event.currentTarget.getAttribute('periodo-id');
			var confirmLink = document.getElementById('confirm-delete');
			confirmLink.href = "{{ route('periodo-delete', '') }}/" + enrollmentId;

			// Define o código no campo do modal
			document.getElementById('periodo-id').value = enrollmentId;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
