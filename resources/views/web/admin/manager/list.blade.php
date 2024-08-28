@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Gestores</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('manager-list') }}">Gestor</a></li>
						<li class="breadcrumb-item active">Todos Gestores</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" action="">
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar por Nome ..." name="manager_name">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="extension_id">
						<option value="">Selecione a Extensão</option>
						@foreach ($extensoes as $dado)
							<option value="{{ $dado->id }}">{{ $dado->city }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar por Email ..." name="manager_email">
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="btn" class="btn btn-primary">Pesquisar</button>
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
							<div class="col">

							</div>
							<div class="float-end download-grp col-auto ms-auto text-end">

								<a href="{{ route('manager-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
							<thead class="student-thread">
								<tr>

									<th>Id</th>
									<th>Name</th>
									<th>Issue place</th>
									<th>Mobile Number</th>
									<th>E-mail</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($managers as $manager)
									<tr>

										<td>
											# {{ $manager->id }}
										</td>
										<td>
											<h2 class="table-avatar">

												<a href="student-details.html">{{ $manager->first_name . ' ' . $manager->last_name }}</a>
											</h2>
										</td>
										<td>{{ $manager->issue_place }}</td>
										<td>{{ $manager->phone }}</td>
										<td>{{ $manager->email }}</td>
										<td class="text-end">
											<div class="actions">
												<a href="{{ route('manager-show', $manager->id) }}" class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('manager-edit', $manager->id) }}" class="btn btn-sm bg-danger-light">
													<i class="feather-edit"></i>
												</a>
												<a href="{{ route('manager-active-deactive', $manager->id) }}" class="btn btn-sm bg-success-light me-2">
													<i class="{{ $manager->estado == 'Activo' ? 'feather-slash' : 'feather-check' }}"></i>
												</a>
												<a href="javascript:;" id="delete-{{ $manager->id }}" onclick="return confirmDeletion(event)"
													class="btn btn-sm bg-danger" manager-code='{{ $manager->id }}'>
													<i class="feather-delete"></i>
												</a>
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
			{{-- <input type="text" id="student-code"> --}}
			<h3>Queres mesmo apagar este estudante?</h3>
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
			var manager = event.currentTarget.getAttribute('manager-code');
			var confirmLink = document.getElementById('confirm-delete');
			confirmLink.href = "{{ route('manager-delete', '') }}/" + manager;

			// Define o código no campo do modal
			document.getElementById('student-code').value = manager;

		}

		function closeModal() {
			document.getElementById('modal').style.display = 'none';
		}
	</script>
@endsection
