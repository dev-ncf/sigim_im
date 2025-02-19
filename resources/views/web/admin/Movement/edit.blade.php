@extends('template.template4')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Serviços</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="students.html">Editar </a></li>
                        <li class="breadcrumb-item active">Editar Serviço</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card comman-shadow">
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

                    <form method="post" action="{{ route('admin-propina-update', $movementStudent->id) }}"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h5 class="form-title student-info">Dados da Serviço<span><a href="javascript:;"><i
                                                class="feather-more-vertical"></i></a></span></h5>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $movementStudent->student_id }}">
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Estudante</label>
                                    <input type="text" class="form-control" placeholder="Pesquisar estudante..."
                                        value="{{ $movementStudent->student->first_name . ' ' . $movementStudent->student->last_name }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Número de Recibo<span class="login-danger">*</span></label>
                                    <input class="form-control" type="number" placeholder="Numero de Recibo" required
                                        name="receipt_number" value="{{ $movementStudent->receipt_number }}">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Data de Depósito<span class="login-danger">*</span></label>
                                    <input class="form-control" type="date" required name="date_receipt"
                                        value="{{ $movementStudent->date_receipt }}">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Valor em MT<span class="login-danger">*</span></label>
                                    <input id="valor" class="form-control" type="number" min="1000" required
                                        placeholder="Valor total" name="total_amount"
                                        value="{{ $movementStudent->total_amount }}">
                                    <div class="invalid-feedback">
                                        Fornece um valor válido e maior ou igual a 1000.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Mês <span class="login-danger">*</span></label>
                                    <select class="form-control select" required name="month">
                                        <option value="">Selecione o Mês</option>
                                        <option {{ $movementStudent->month == 1 ? 'selected' : '' }} value="1">1º
                                        </option>
                                        <option {{ $movementStudent->month == 2 ? 'selected' : '' }} value="2">2º
                                        </option>
                                        <option {{ $movementStudent->month == 3 ? 'selected' : '' }} value="3">3º
                                        </option>
                                        <option {{ $movementStudent->month == 4 ? 'selected' : '' }} value="4">4º
                                        </option>
                                        <option {{ $movementStudent->month == 5 ? 'selected' : '' }} value="5">5º
                                        </option>
                                        <option {{ $movementStudent->month == 6 ? 'selected' : '' }} value="6">6º
                                        </option>
                                        <option {{ $movementStudent->month == 7 ? 'selected' : '' }} value="7">7º
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Ano <span class="login-danger">*</span></label>
                                    <input class="form-control" required name="year" type="number" min="2023"
                                        placeholder="Ano da Propina" value="{{ $movementStudent->year }}">
                                    <div class="invalid-feedback">
                                        Fornece um válido e maior ou igual 2023
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Semestre <span class="login-danger">*</span></label>
                                    <select class="form-control select" required name="semestre">
                                        <option value="">Selecione o Semestre</option>
                                        <option {{ $movementStudent->semestre == 1 ? 'selected' : '' }} value="1">1º
                                        </option>
                                        <option {{ $movementStudent->semestre == 2 ? 'selected' : '' }} value="2">2º
                                        </option>
                                        <option {{ $movementStudent->semestre == 3 ? 'selected' : '' }} value="3">3º
                                        </option>
                                        <option {{ $movementStudent->semestre == 4 ? 'selected' : '' }} value="4">4º
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
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
            var selectTaxa = document.getElementById('taxa');
            var inputNumeroDisciplinas = document.getElementById('nd');
            var valor = document.getElementById('valor');
            var numerd = document.getElementById('numero_disciplinas')

            selectTaxa.addEventListener('change', function() {
                var selectedValue = this.value;
                if (selectedValue === 'Taxa de inscrição por disciplina (Nacional)' || selectedValue ===
                    'Taxa de inscrição por disciplina (Estrangeiro)') {
                    inputNumeroDisciplinas.style.display = 'block';
                    inputNumeroDisciplinas.required = true;
                    inputNumeroDisciplinas.setAttribute('autofocus', true);
                    inputNumeroDisciplinas.setAttribute('selected', true);
                    valor.setAttribute('readonly', true);
                    numerd.setAttribute('required', true);

                    if (selectedValue === 'Taxa de inscrição por disciplina (Nacional)') {

                        valor.value = 1000 * numerd.value
                    } else {
                        valor.value = numerd.value * 1200
                    }

                    inputNumeroDisciplinas.addEventListener('input', function(event) {
                        let num = event.target.value

                        if (selectedValue === 'Taxa de inscrição por disciplina (Nacional)') {

                            valor.value = 1000 * num
                        } else {
                            let num = event.target.value
                            valor.value = num * 1200
                        }
                    })

                } else {
                    inputNumeroDisciplinas.style.display = 'none';
                    inputNumeroDisciplinas.removeAttribute('required');
                    valor.removeAttribute('readonly', false);
                    numerd.removeAttribute('required', false);
                }
            });
        });
    </script>

@endsection
