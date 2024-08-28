@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col">
				<h3 class="page-title">Perfil</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Gestor</a></li>
					<li class="breadcrumb-item active">Perfil</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="profile-header">
				<div class="row align-items-center">
					<div class="profile-image col-auto">
						<a href="#">
							<img class="rounded-circle" alt="User Image" src="{{ asset('img/logo.jpg') }}">
						</a>
					</div>

					<div class="col ms-md-n2 profile-user-info">
						<h4 class="user-name mb-0">{{ $manager->first_name . ' ' . $manager->last_name }}</h4>
						<h6 class="text-muted">{{ $manager->funcao }}</h6>
						<div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $manager->issue_place }}</div>
						<div class="about-text">{{ $manager->email }}</div>
					</div>

					<div class="profile-btn col-auto">
						<a href="{{ route('manager-edit', $manager->id) }}" class="btn btn-primary">
							Edit
						</a>
					</div>
				</div>
			</div>

			<div class="profile-menu">
				<ul class="nav nav-tabs nav-tabs-solid">
					<li class="nav-item active">
						<a class="nav-link" data-bs-toggle="tab" href="#per_details_tab">Sobre</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
					</li>
				</ul>
			</div>
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
			<div class="tab-content profile-tab-cont">

				<div class="tab-pane fade show active" id="per_details_tab">

					<div class="row">
						<div class="col-lg-9">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
										<span>Dados Pessoais</span>

									</h5>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Nome</p>
										<p class="col-sm-9">{{ $manager->first_name }}</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Apelido</p>
										<p class="col-sm-9">{{ $manager->last_name }}</p>
									</div>
									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Email</p>
										<p class="col-sm-9">{{ $manager->email }}</p>
									</div>

									<div class="row">
										<p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Contacto</p>
										<p class="col-sm-9">{{ $manager->phone . ($manager->phone_secondary ? '/' : '') . $manager->phone_secondary }}
										</p>
									</div>

								</div>
							</div>
						</div>
						<div class="col-lg-3">

							<div class="card">
								<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
										<span>Estado da Conta</span>

									</h5>
									<button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i>
										{{ $manager->estado }}</button>
								</div>
							</div>

						</div>
					</div>

				</div>

				<div id="password_tab" class="tab-pane fade">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Mudar Senha</h5>
							<div class="row">
								<div class="col-md-10 col-lg-6">
									<form action="{{ route('manager-update-password', $manager->id) }}" method="POST">
										@csrf

										<div class="form-group">
											<label>Nova Senha</label>
											<input type="password" class="form-control" name="password" required>
										</div>
										<div class="form-group">
											<label>Confirmar Senha</label>
											<input type="password" class="form-control" name="confir_password" required>
										</div>
										<button class="btn btn-primary" type="submit">Salvar</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
