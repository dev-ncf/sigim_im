@extends('template.template4')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Serviços</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="students.html">Adicionar </a></li>
                        <li class="breadcrumb-item active">Adicionar Serviço</li>
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

                    <form method="post" action="{{ route('admin-propina-store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h5 class="form-title student-info">Dados do Serviço<span><a href="javascript:;"><i
                                                class="feather-more-vertical"></i></a></span></h5>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $estudante->id }}">
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Estudante</label>
                                    <input type="text" class="form-control" placeholder="Pesquisar estudante..."
                                        value="{{ $estudante->first_name . ' ' . $estudante->last_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Número de Recibo<span class="login-danger">*</span></label>
                                    <input class="form-control" type="number" placeholder="Numero de Recibo" required
                                        name="receipt_number">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Data de Depósito<span class="login-danger">*</span></label>
                                    <input class="form-control" type="date" required name="date_receipt">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Taxa de
                                        Matrícula <span class="login-danger"></span></label>
                                    <select id="taxa" class="form-control select" name="taxa_matricula">
                                        <option value="" selected>Selecione o Serviço</option>

                                        <option value="{{ $enrollment->academic_level_id == '2' ? '4850' : '10000' }}">Taxa
                                            de
                                            Matrícula (Nacional)</option>
                                        <option value="{{ $enrollment->academic_level_id == '2' ? '7700' : '15000' }}">Taxa
                                            de
                                            Matrícula (Estrangeiro)</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Taxa
                                        de
                                        inscrição por disciplina <span class="login-danger"></span></label>
                                    <select id="taxa" class="form-control select" name="taxa_inscricao_disciplina">
                                        <option value="" selected>Selecione o Serviço</option>


                                        <option value="{{ $enrollment->academic_level_id == '2' ? '1000' : '2150' }}">Taxa
                                            de
                                            inscrição por disciplina (Nacional)
                                        <option value="{{ $enrollment->academic_level_id == '2' ? '1200' : '2650' }}">Taxa
                                            de
                                            inscrição por disciplina (Estrangeiro)
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
                                    </div>
                                </div>
                            </div>
                            <div id="nd" class="col-12 col-sm-4" style="display: none">
                                <div class="form-group local-forms">
                                    <label>Número de disciplinas<span class="login-danger"></span></label>
                                    <input class="form-control" type="number"
                                        placeholder="Numero de disciplinas a frequentar" name="numero_disciplinas"
                                        id="numero_disciplinas">
                                    <div class="invalid-feedback">
                                        Campo obrigatório.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Taxa
                                        de
                                        Propinas (Mensalidade para nacional) <span class="login-danger"></span></label>
                                    <select id="taxa" class="form-control select" name="propina_mensal">
                                        <option value="" selected>Selecione o Serviço</option>

                                        <option value="{{ $enrollment->academic_level_id == '2' ? '8000' : '15000' }}">Taxa
                                            de
                                            Propinas (Mensalidade para nacional)</option>
                                        <option value="{{ $enrollment->academic_level_id == '2' ? '10000' : '19000' }}">
                                            Taxa de
                                            Propinas (Mensalidade para estrangeiro)</option>


                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Taxa
                                        de
                                        Serviços Semestrais <span class="login-danger"></span></label>
                                    <select id="taxa" class="form-control select" name="taxa_servicos_semestrais">
                                        <option value="" selected>Selecione o Serviço</option>

                                        <option value="{{ $enrollment->academic_level_id == '2' ? '1750' : '4000' }}">Taxa
                                            de
                                            Serviços Semestrais</option>

                                    </select>
                                    <div class="invalid-feedback">
                                        Campo obrigatório..
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                    <label>Valor<span class="login-danger">*</span></label>
                                    <input id="valor" class="form-control" type="number" min="1000" required
                                        placeholder="Valor total" name="total_amount" readonly>
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
                                        <option value="1">1º</option>
                                        <option value="2">2º</option>
                                        <option value="3">3º</option>
                                        <option value="4">4º</option>
                                        <option value="5">5º</option>
                                        <option value="6">6º</option>
                                        <option value="7">7º</option>
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
                                        placeholder="Ano da Propina">
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
                                        <option value="1">1º</option>
                                        <option value="2">2º</option>
                                        <option value="3">3º</option>
                                        <option value="4">4º</option>
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
        document.addEventListener("DOMContentLoaded", function() {
            const taxaMatricula = document.querySelector("[name='taxa_matricula']");
            const taxaInscricao = document.querySelector("[name='taxa_inscricao_disciplina']");
            const taxaPropina = document.querySelector("[name='propina_mensal']");
            const taxaServicos = document.querySelector("[name='taxa_servicos_semestrais']");
            const numeroDisciplinas = document.querySelector("#numero_disciplinas");
            const totalAmount = document.querySelector("#valor");
            const campoNumeroDisciplinas = document.querySelector("#nd");

            function calcularTotal() {
                let total = 0;

                // Pegando valores das taxas selecionadas
                total += taxaMatricula.value ? parseFloat(taxaMatricula.value) : 0;
                total += taxaPropina.value ? parseFloat(taxaPropina.value) : 0;
                total += taxaServicos.value ? parseFloat(taxaServicos.value) : 0;

                // Cálculo da taxa de inscrição por disciplina
                let taxaDisciplina = taxaInscricao.value ? parseFloat(taxaInscricao.value) : 0;
                let numeroDisciplinasValor = numeroDisciplinas.value ? parseInt(numeroDisciplinas.value) : 0;

                if (taxaDisciplina > 0 && numeroDisciplinasValor > 0) {
                    total += taxaDisciplina * numeroDisciplinasValor;
                }

                // Atualiza o campo total
                totalAmount.value = total;
            }

            // Ativar campo "Número de disciplinas" ao selecionar "Taxa de inscrição por disciplina"
            taxaInscricao.addEventListener("change", function() {
                if (this.value) {
                    campoNumeroDisciplinas.style.display = "block";
                    numeroDisciplinas.setAttribute("required", "true");
                } else {
                    campoNumeroDisciplinas.style.display = "none";
                    numeroDisciplinas.removeAttribute("required");
                    numeroDisciplinas.value = "";
                }
                calcularTotal();
            });

            // Eventos para recalcular o total ao mudar os valores das taxas
            [taxaMatricula, taxaInscricao, taxaPropina, taxaServicos, numeroDisciplinas].forEach(element => {
                element.addEventListener("change", calcularTotal);
            });
        });
    </script>

@endsection
