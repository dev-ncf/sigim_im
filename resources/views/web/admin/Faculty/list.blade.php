@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Faculdades</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('faculty-list')}}">Faculdades</a></li>
						<li class="breadcrumb-item active">Todas Faculdades</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" action="{{ route('faculty-search') }}" method="POST">
			@csrf
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar por Nome ..." name="nome">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="extension_id">
						<option value="">Selecione o Extensão ...</option>
						@foreach ($extensaos as $extensao)
							<option value="{{ $extensao->id }}">{{ $extensao->city }}</option>
						@endforeach
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

								<a href="{{ route('faculty-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>Nome</th>
									<th>Extensao</th>

									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>

								@foreach ($faculties as $faculty)
									<tr>

										<td>
											<h2 class="table-avatar">

												<a href="">{{ $faculty->label }}</a>
											</h2>

										</td>
										<td>

											{{ $faculty->extensao->city }}

										</td>

										<td class="text-end">
											<div class="actions">

												<a href="{{ route('faculty-show', $faculty->id) }}" class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('faculty-edit', $faculty->id) }}" class="btn btn-sm bg-danger-light">

													<i class="feather-edit"></i>
												</a>
												@if ($dadosUsuario->nivel == 'A')
													<a href="javascript:;" id="delete-{{ $faculty->id }}" onclick="return confirmDeletion(event)"
														class="btn btn-sm bg-danger" faculty-id='{{ $faculty->id }}'>
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

			<h3>Queres mesmo apagar esta Faculdade?</h3>
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
			var enrollmentId = event.currentTarget.getAttribute('faculty-id');
			var confirmLink = document.getElementById('confirm-delete');
			confirmLink.href = "{{ route('faculty-delete', '') }}/" + enrollmentId;

			// Define o código no campo do modal
			document.getElementById('faculty-id').value = enrollmentId;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
