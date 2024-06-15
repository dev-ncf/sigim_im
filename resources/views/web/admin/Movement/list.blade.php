@extends('template.template4')


@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Propinas</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Propina</a></li>
						<li class="breadcrumb-item active">Todas Propinas</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="student-group-form">
		<form class="row" action="{{route('propina-search')}}" method="POST">
            @csrf
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar pelo numero de Recibo ..." name="receipt_number">
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Pesquisar pelo Código ..." name="student_code" value="{{ old('student_code')}}">
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

					<div class="page-header">
						<div class="row align-items-center">

						</div>
					</div>


                    <div class="table-responsive">
						<table
							class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
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
                                                        href="">{{
                                                        $propina->student->truncateName($propina->student->first_name . ' ' . $propina->student->last_name) }}</a>
                                                </h2>

                                            </td>
                                            <td>

                                                {{ $propina->receipt_number }}

                                        </td>
                                        <td>{{$propina->total_amount}}</td>
                                        <td>{{$propina->semestre}}</td>
                                            <td>
                                                {{ $propina->month }}
                                            </td>
                                            <td>
                                                {{ $propina->year }}
                                            </td>


                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="{{ route('student-edit', ['studente_code' => $propina->id]) }}"
                                                        class="btn btn-sm bg-danger-light">

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
