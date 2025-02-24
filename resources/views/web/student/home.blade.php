@extends('template.template2')



@section('content')
    <section class="section-home">
        <div
            style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; flex-wrap: true">
            <h1>Minhas Inscrições</h1>
            @php
                $level = null;
                $enrollmentId = null;
                foreach ($student->studentPreviousSkills as $lev) {
                    $level = $lev;
                    # code...
                }

            @endphp

            @if ($lastEnrollmentPeriod->end > date('Y-m-d'))
                {{-- @if ($movements->count() >= 1) --}}
                @if ($lastEnrollment->enrollment_status != '0')
                    @if (
                        $lastEnrollment->created_at >= $lastEnrollmentPeriod->start &&
                            $lastEnrollment->created_at <= $lastEnrollmentPeriod->end)
                        <p
                            style="width: 50%; background-color: #1900ff2c; color: #1900ff; border-radius:5px; padding:4px 8px; font-size:12px;margin:0">
                            Clique no botão a seguir para baixar a ficha de Pré-inscrição.
                        </p>
                        <a class="hover:border-1 ml-2 rounded-sm border-blue-900 bg-blue-700 px-1 py-0.5 text-white hover:bg-opacity-60 hover:text-blue-950"
                            href=" {{ url('/printer/recipient-inscription/' . $student->code . '/' . $lastEnrollment->id) }}">Baixar</a>
                        <img class="blinking" style="position: absolute;top:55px; right: 165px;"
                            src="{{ asset('img/seta-para-baixo.png') }}" alt="seta">
                    @else
                        <button id="novaInscricaoLink" class="novaInscricaoLink" style="">Nova
                            Inscrição</button>
                    @endif
                @else
                    <button id="novaMatricula" class="novaInscricaoLink" style="">Matricular-se
                    </button>
                    <img class="blinking" style="position: absolute;top:55px; right: 165px;"
                        src="{{ asset('img/seta-para-baixo.png') }}" alt="seta">
                @endif
                {{-- @else
					<p
						style="width: 50%; background-color: #ff88002c; color: #ff8800; border-radius:5px; padding:4px 8px; font-size:12px;margin:0">
						Olá <span style="color: #000; font-weight: bold"> Sr(a)
							{{ $student->last_name }}</span>, dirige-se a Direcção do Registo Académico para
						regularizar sua situação financeira!</p>
				@endif --}}
            @endif
            <form id="enrollmentform" style="display: none" action="{{ route('enrollment-store') }}" method="post"
                class="absolute left-0 top-0 flex h-full w-full flex-col items-center justify-center rounded-md bg-blue-900 bg-opacity-40 p-2">
                @csrf
                <div class="flex w-[40rem] flex-col gap-2 rounded-md bg-white" id="inscricao">
                    <div class="flex h-12 items-center rounded-md bg-sky-200 px-4 text-sky-900">
                        <span class="text-2xl">Nova inscrição</span>
                    </div>
                    <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                        <span>Serviços</span>
                        <select name="taxa" id="taxa"
                            class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                            title="Selecione um serviço. Por favor!" required>
                            <option value="">Selecione um serviço...</option>

                            <option value="{{ $lastEnrollment->taxa }}">Taxa de inscrição por disciplina (Nacional)</option>
                            <option value="{{ $lastEnrollment->taxa }}">Taxa de inscrição por disciplina (Estrangeiro)
                            </option>
                        </select>
                    </div>
                    <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                        <span>Número de displinas</span>
                        <input type="number" name="number"
                            class="h-8 w-full rounded-md border-2 border-blue-400 px-2 outline-none" min="1"
                            placeholder="Digite um número..." max="9" required>
                    </div>
                    <div class="mb-2 flex w-full flex-row justify-between gap-2 border-2 p-2 px-4">
                        <button id="enrollmentCancel" type="button"
                            class="rounded-md bg-red-700 px-4 text-xl text-white hover:bg-opacity-50">Cancel</button>
                        <button type="submit"
                            class="rounded-md bg-green-700 px-4 text-xl text-white hover:bg-opacity-50">Confirmar</button>
                    </div>

                </div>
            </form>
            <form id="matriculaform" style="display: none"
                action="{{ route('enrollment-matricular', $lastEnrollment->id) }}" method="post"
                class="absolute left-0 top-0 flex h-full w-full flex-col items-center justify-center rounded-md bg-blue-900 bg-opacity-40 p-2">
                @csrf
                @method('PUT')
                <div class="flex w-[40rem] flex-col gap-2 rounded-md bg-white" id="matricula">

                    @if ($level->academic_level_id === '1')
                        <div class="flex h-12 items-center rounded-md bg-sky-200 px-4 text-sky-900">
                            <span class="text-2xl">Matrícula para Mestrados</span>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Matrícula</span>
                            <select name="taxa_matricula" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="4850">Estudantes Nacionais</option>
                                <option value="7700">Estudantes Estrangeiros</option>
                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Inscrição semestral por módulo/disciplina</span>
                            <select name="taxa_inscricao_disciplina" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="1000">Inscrição semestral por módulo/disciplina para estudantes nacionais
                                </option>
                                <option value="1200">Inscrição semestral por módulo/disciplina para estudantes
                                    estrangeiros</option>

                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Numero de disciplinas</span>
                            <input name="numero_disciplinas" id="taxa" type="number"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                placeholder="Digite o numero de dis. Por favor!" min="5" max="9" required>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Propina Mensal</span>
                            <select name="primeira_propina_mensal" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="8000">Propina mensal para estudantes nacionais
                                </option>
                                <option value="10000">Propina Mensal para estudantes
                                    estrangeiros</option>

                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Serviços Semestrais</span>
                            <select name="taxa_servico_semestrais" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="1750">Taxa de Serviços Semestrais
                                </option>

                            </select>
                        </div>
                    @else
                        <div class="flex h-12 items-center rounded-md bg-sky-200 px-4 text-sky-900">
                            <span class="text-2xl">Matrícula para Doutoramento</span>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Matrícula</span>
                            <select name="taxa_matricula" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="10000">Estudantes Nacionais</option>
                                <option value="15000">Estudantes Estrangeiros</option>
                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Inscrição semestral por módulo/disciplina</span>
                            <select name="taxa_inscricao_disciplina" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="2150">Inscrição semestral por módulo/disciplina para estudantes nacionais
                                </option>
                                <option value="2650">Inscrição semestral por módulo/disciplina para estudantes
                                    estrangeiros</option>

                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Numero de disciplinas</span>
                            <input name="numero_disciplinas" id="taxa" type="number"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none p-2"
                                placeholder="Digite o numero de dis. Por favor!" min="5" max="9" required>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Incluir Primeira Propina Mensal (opcional)</span>
                            <select name="primeira_propina_mensal" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="">Selecione um taxa...</option>
                                <option value="15000">Propina mensal para estudantes nacionais
                                </option>
                                <option value="19000">Propina Mensal para estudantes
                                    estrangeiros</option>

                            </select>
                        </div>
                        <div class="mb-2 flex w-full flex-col gap-2 border-2 p-2 px-4">
                            <span>Taxa de Serviços Semestrais</span>
                            <select name="taxa_servico_semestrais" id="taxa"
                                class="h-8 w-full rounded-md border-2 border-blue-400 outline-none"
                                title="Selecione um serviço. Por favor!" required>
                                <option value="4000">Taxa de Serviços Semestrais
                                </option>

                            </select>
                        </div>
                    @endif
                    <div class="mb-2 flex w-full flex-row justify-between gap-2 border-2 p-2 px-4">
                        <button id="matriculaCancel" type="button"
                            class="rounded-md bg-red-700 px-4 text-xl text-white hover:bg-opacity-50">Cancel</button>
                        <button type="submit"
                            class="rounded-md bg-green-700 px-4 text-xl text-white hover:bg-opacity-50">Confirmar</button>
                    </div>

                </div>
            </form>
        </div>

        @if ($enrollments->count() >= 1)
            <div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
            <table class="table-registration">
                <tr>
                    <th>Código do estudante</th>
                    <th>Local de Estudo</th>
                    <th>Faculdade</th>
                    <th>Curso</th>
                    <th>Semestre</th>
                    <th>Estado de Inscrição</th>

                    <th>Acção</th>

                </tr>
                @foreach ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $student->code }}</td>
                        <td>{{ $enrollment->extension->city }}</td>
                        <td>{{ $enrollment->faculty->label }}</td>
                        <td>{{ $enrollment->course->label }}</td>
                        <td>{{ $enrollment->semestre }}º</td>
                        <td>
                            @if ($enrollment->enrollment_status == '2')
                                <span
                                    style="padding: 5px; background-color: #00800021; border-radius: 3px; font-size: 10pt; color: #008000;">Aprovada</span>
                            @elseif($enrollment->enrollment_status == '1')
                                <span
                                    style="padding: 5px; background-color: #00008821; border-radius: 3px; font-size: 10pt; color: #000088;">Pendente</span>
                            @else
                                <span
                                    style="padding: 5px; background-color: #ffa50021; border-radius: 3px; font-size: 10pt; color: #ffa500;">Inicial</span>
                            @endif
                        </td>
                        <td>
                            @if ($enrollment->enrollment_status > '0')
                                <a
                                    href="{{ url('/printer/recipient-inscription/' . $enrollment->student->code . '/' . $enrollment->id) }}">
                                    <i class="bi bi-printer"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <div>
                @if (session('success'))
                    <div id="success-alert" class="alert alert-success"
                        style="background-color: #00ff0021 ; padding: 2px;">
                        <span style="font-size: 8pt;color: #008800"> {{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div id="error-alert" class="alert alert-danger "
                        style="background-color: #ff000021 ; padding: 2px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><span style="font-size: 8pt;color: #880000">{{ $error }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="div-100" style="margin-top: 50px; border-top: 1px solid #cccccc; padding:14px 0">
                {{-- {{-- <h3 style="font-weight: bold;font-size: 17px; margin: 4px 0">Linha de Pesquisa</h3> --}}
                <div style="display: flex;justify-content: space-between">
                    <div></div>
                    <div
                        style="display: flex;justify-content: center;align-items: center;width: 44%; border: solid 1px #00000021 ">
                        Semestres e Número de disciplinas</div>
                </div>
                <table class="table-registration">
                    <tr>
                        <th>Curso</th>
                        <th>1º</th>
                        <th>2º</th>
                        <th>3º</th>
                        <th>4º</th>

                    </tr>
                    @if ($lastEnrollment->academic_level_id == '1')
                        @foreach ($courseSubjects as $subject)
                            @if ($subject->nivel == '1')
                                <tr>

                                    <td>{{ $subject->course->label }}</td>
                                    <td>{{ $subject->sem_1 }}</td>
                                    <td>{{ $subject->sem_2 }}</td>
                                    <td>{{ $subject->sem3_ }}</td>
                                    <td>{{ $subject->sem_4 }}</td>

                                </tr>
                            @endif
                        @endforeach
                    @else
                        @foreach ($courseSubjects as $subject)
                            @if ($subject->nivel == '2')
                                <tr>

                                    <td>{{ $subject->course->label }}</td>
                                    <td>{{ $subject->sem_1 }}</td>
                                    <td>{{ $subject->sem_2 }}</td>
                                    <td>{{ $subject->sem3_ }}</td>
                                    <td>{{ $subject->sem_4 }}</td>

                                </tr>
                            @endif
                        @endforeach
                    @endif


                </table>
            </div>
        @else
            <div class="div-100" style="margin-top: 50px; border-top: 1px solid #cccccc; padding:14px 0">
                <p style="font-weight: bold;font-size: 17px; margin: 4px 0">Ola Sr(a) {{ $student->last_name }}, seja bem
                    vindo! Por favor, clique no botão indicado pela seta a cima direito para proseguir como a matricula.</p>

                {{-- <p style="font-size: 14px; font-weight: normal">
                    {{ $enrollment->sewingLine->label }}.</p> --}}
            </div>
        @endif
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            if (document.getElementById('novaInscricaoLink')) {
                // Adicionar o listener de clique apenas se o botão existir
                document.getElementById('novaInscricaoLink').addEventListener('click', function(event) {
                    event.preventDefault(); // Evita a execução do link diretamente

                    if (confirm('Deseja realmente criar uma nova inscrição?')) {
                        document.getElementById('enrollmentform').style.display = 'flex';
                    }
                });
            }
            if (document.getElementById('novaMatricula')) {
                document.getElementById('novaMatricula').addEventListener('click', function(event) {
                    // alert('ola')
                    event.preventDefault(); // Evita a execução do link diretamente


                    document.getElementById('matriculaform').style.display = 'flex';

                });
            }


            document.getElementById('enrollmentCancel').addEventListener('click', function(event) {

                event.preventDefault(); // Evita a execução do link diretamente

                document.getElementById('enrollmentform').style.display = 'none';

            });

            document.getElementById('matriculaCancel').addEventListener('click', function(event) {
                event.preventDefault(); // Evita a execução do link diretamente

                document.getElementById('matriculaform').style.display = 'none';

            });

        });

        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            var errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.style.display = 'none';
            }
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection
