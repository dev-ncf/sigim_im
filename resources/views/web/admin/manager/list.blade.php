@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Gestores</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Gestor</a></li>
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
					<input type="text" class="form-control" placeholder="Search by Nome ..." name="manager_name">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<select type="text" class="form-control" name="extension_id">
                        <option value="">Selecione a Extensão</option>
                        @foreach ($extensoes as $dado)
                        <option value="{{$dado->id}}">{{$dado->city}}</option>

                        @endforeach
                    </select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search by Email ..." name="manager_email">
				</div>
			</div>
			<div class="col-lg-2">
				<div class="search-student-btn">
					<button type="btn" class="btn btn-primary">Search</button>
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
							<div class="col">

							</div>
							<div class="float-end download-grp col-auto ms-auto text-end">

								<a href="{{ route('manager-add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table
							class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
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
												<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
													<i class="feather-eye"></i>
												</a>
												<a href="{{ route('manager-edit') }}" class="btn btn-sm bg-danger-light">
													<i class="feather-edit"></i>
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
@endsection
