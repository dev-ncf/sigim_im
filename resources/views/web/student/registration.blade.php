@extends('template.template')

@section('content')

    <form class="card" action="{{ route('student-registration') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <img class="img-logo" src="{{ asset('img/logo.jpg') }}" alt="" srcset="">
        <h1 class="title">UNIVERSIDADE ROVUMA</h1>
        <h1 class="sub-title">DIRECÇÃO DO REGISTO ACADÉMICO</h1>
        <p>Atenção! Preenche todos campos obrigatorios indicados pelo caratere < <span style="color: #ff0000">*</span> >. </p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: #ff0000">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="div-form-begin registration-begin" id="div-form1">
            <div class="form-group div-100">
                <label for="">Nome Completo <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="name" id="name" value="" required>
            </div>
            <div class="form-group div-30">
                <label for="">Local de estudo <span style="color: #ff0000">*</span></label>
                <select id="extensions" class="input-begin" name="extension_id" required>
                    <option value="">escolha...</option>
                    @foreach ($extensions as $extension)
                        <option value="{{ $extension->id }}">{{ $extension->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Faculdade <span style="color: #ff0000">*</span></label>
                <select name="faculty_id" id="faculty" class="input-begin" required>
                    <option value="" selected disabled>escolha...</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-30">
                <label for="">Curso <span style="color: #ff0000">*</span></label>
                <select name="course_id" id="courses" class="input-begin" required>
                    <option value="" selected disabled>escolha...</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-100">
                <label for="">Linha de Pesguisa <span style="color: #ff0000">*</span></label>
                <select name="sewing_line_id" id="sewing-lines" class="input-begin" required>
                    <option value="" selected disabled>escolha...</option>
                    @foreach ($sewinglines as $sewingline)
                        <option value="{{ $sewingline->id }}">{{ $sewingline->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-next" id="btn-hide-form1" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form1', 'div-form2')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form2">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil</legend>
            </div>
            <div class="form-group div-40">
                <label for="">Apelido <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="last_name" id="student-last-name" required>
            </div>
            <div class="form-group div-60">
                <label for="">Nome <span style="color: #ff0000">*</span> (<span style="color: red;">Atenção:</span> <span
                        style="font-size: 8pt; font-weight: 400;">não preencha o seu apelido</span>)</label>
                <input class="input-begin" type="text" name="first_name" id="student-first-name" required>
            </div>
            <div class="form-group div-50">
                <label for="">Nome completo do Pai <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="father_name" id="student-father" required>
            </div>
            <div class="form-group div-50">
                <label for="">Nome completo da Mãe <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="mother_name" id="student-mother" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de Nascimento <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="date" name="birth_date" max="2000-01-01" id="student-birth-date"
                    required>
            </div>
            <div class="form-group div-30">
                <label for="">Província de Nasc <span style="color: #ff0000">*</span></label>
                <select name="province_birth_id" id="student-birth-province" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Local de Nascimento <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="birth_local" id="student-birth-local" required>
            </div>
            <div class="form-group div-100">
                <label for="">Nacionalidade <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="nationality" id="student-nationality" required>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form1" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form2', 'div-form1')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form2" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form2', 'div-form3')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form3">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil</legend>
            </div>
            <div class="form-group div-40">
                <label for="">Tipo de documento <span style="color: #ff0000">*</span></label>
                <select name="document_type_id" id="student-document-type" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($document_types as $document_type)
                        <option value="{{ $document_type->id }}">{{ $document_type->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60">
                <label for="">Número do documento <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="document_number" id="student-document-number" required>
            </div>
            <div class="form-group div-40">
                <label for="">Local de emissão <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="place_issue" id="student-place-issue" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de emissão <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="date" name="issue_date" id="student-issue-date" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de Validade <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="date" name="expiration_date" id="student-expiration-date" required>
            </div>
            <div class="form-group div-50">
                <label for="">Gênero <span style="color: #ff0000">*</span></label>
                <select name="gender_id" id="student-gender" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-50">
                <label for="">Estado Civil <span style="color: #ff0000">*</span></label>
                <select name="marital_status_id" id="student-marital-status" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($civil_statuses as $civil_status)
                        <option value="{{ $civil_status->id }}">{{ $civil_status->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-100">
                <label for="">Possui alguma necessidade educativa especial?
                    <span style="margin-left: 25px;">
                        <input type="radio" class="special-needs" name="special_need" id="special-need-yes"
                            value="1" required> Sim
                    </span>
                    <span style="margin-left: 15px;">
                        <input type="radio" class="special-needs" name="special_need" id="special-need-no"
                            value="0" required> Não
                    </span>
                </label>
            </div>
            <div class="form-group div-100" id="div-special-need" style="display: none;">
                <div class="special-need">
                    <span>
                        <input type="checkbox" name="special" id="" value="Altas habilidades"> Altas
                        habilidades
                    </span>
                    <span>
                        <input type="checkbox" name="special" id="" value="Auditivas"> Auditivas
                    </span>
                    <span>
                        <input type="checkbox" name="special" id="" value="Físicas"> Físicas
                    </span>
                    <span>
                        <input type="checkbox" name="special" id="" value="Mental"> Mental
                    </span>
                    <span>
                        <input type="checkbox" name="special" id="" value="Visual"> Visual
                    </span>
                    {{-- <span>
                        <input type="checkbox" name="special" id="" value="Outras"> Outras
                    </span> --}}
                </div>
                {{-- <input class="input-begin" type="text" name="" id=""> --}}
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form2" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form3', 'div-form2')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form3" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form3', 'div-form4')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form4">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Endereço</legend>
            </div>
            <div class="form-group div-50">
                <label for="">Província <span style="color: #ff0000">*</span></label>
                <select name="province_id" id="province" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-50">
                <label for="">Distrito/Cidade <span style="color: #ff0000">*</span></label>
                <select name="district_id" id="districts" class="input-begin" required>
                    <option value="" selected disabled>escolha...</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Bairro</label>
                <input class="input-begin" type="text" name="neighborhood" id="student-neighborhood" required>
            </div>
            <div class="form-group div-30">
                <label for="">Quarteirão</label>
                <input class="input-begin" type="number" min="1" name="block" id="student-block">
            </div>
            <div class="form-group div-30">
                <label for="">Numero de casa</label>
                <input class="input-begin" type="number" min="1" name="house_number" id="student-house-number">
            </div>
            <div class="form-group div-50">
                <label for="">Telefone <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1" minlength="9" maxlength="9" name="phone"
                    id="student-main-phone" required>
            </div>
            <div class="form-group div-50">
                <label for="">Telefone alternativo</label>
                <input class="input-begin" type="number" min="1" minlength="9" maxlength="9"
                    name="phone_secondary" id="student-secondary-phone">
            </div>
            <div class="form-group div-100">
                <label for="">Email <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="email" id="student-email" name="email" value="" required>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form3" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form4', 'div-form3')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form4" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form4', 'div-form5')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form5">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil Acadêmico
                </legend>
            </div>
            <div class="form-group div-40">
                <label for="">Habilitação anterior <span style="color: #ff0000">*</span></label>
                <select name="academic_level_id" id="student-previous-license" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($academic_levels as $level)
                        @if ($level->code == 00001)
                            <option value="{{ $level->id }}">{{ $level->label }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60">
                <label for="">Local onde frequentou (Cidade/Distrito) <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="local" id="student-previous-license-local" required>
            </div>
            <div class="form-group div-100">
                <label for="">Nome da instituição <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="institution" id="student-previous-license-institution"
                    required>
            </div>
            <div class="form-group div-50">
                <label for="">Periodo de frequência (Ano de inicio) <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') - 4 }}"
                    id="student-previous-license-start-year" name="start_year" required>
            </div>
            <div class="form-group div-50">
                <label for="">Ano de termino <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}"
                    id="student-previous-license-end-year" name="end_year" required>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form4" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form5', 'div-form4')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form5" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form5', 'div-form6')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form6">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Carreira profissional
                </legend>
            </div>
            <div class="form-group div-100">
                <label for="">Instituição <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="career_institution"
                    id="student-professional-career-institution">
            </div>
            <div class="form-group div-50">
                <label for="">Período (Ano de inicio) <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}"
                    name="career_start_year" id="student-professional-career-start-year">
            </div>
            <div class="form-group div-50">
                <label for="">Ano de termino <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}"
                    name="completion_year" id="student-professional-career-end-year">
            </div>
            <div class="form-group div-100">
                <label for="">Actividades/funções desenvolvidas <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="text" name="role" id="student-professional-career-role">
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form5" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form6', 'div-form5')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form6" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form6', 'div-form7')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form7">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Situação Económica
                </legend>
            </div>
            <div class="form-group div-50">
                <label for="">Profissão do Pai </label>
                <input class="input-begin" type="text" name="father_profession" id="student-father-profession">
            </div>
            <div class="form-group div-50">
                <label for="">Profissão da Mãe</label>
                <input class="input-begin" type="text" name="mother_profession" id="student-mother-profession">
            </div>
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Composição do Agregado
                    Familiar</legend>
            </div>
            <div class="form-group div-60">
                <label for="">Tipo de Familia <span style="color: #ff0000">*</span></label>
                <select name="family_type" id="student-family-type" class="input-begin" required>
                    <option value="">escolha...</option>
                    <option value="Família Alargada">Família Alargada</option>
                    <option value="Família Conjugal">Família Conjugal</option>
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Número de Agregado <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="number" min="1" name="household" id="student-household"
                    required>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form6" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form7', 'div-form6')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form7" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form7', 'div-form8')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form8">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Bolsas de Estudos
                </legend>
            </div>
            <div class="form-group div-100">
                <label for="">Possui uma bolsa?

                    <input type="radio" name="scholarship" id="scholarship-yes" value="1"
                        style="margin-left: 15px;" required> <span style="margin-right: 15px;">Sim</span>
                    <input type="radio" name="scholarship" id="scholarship-no" value="0" required>
                    <span>Nao</span>
                </label>
            </div>
            <div class="form-group div-40" id="scholarship-modality" style="margin-top: 10px; display: none;">
                <label for="">Modalidade</label>
                <select name="modality" id="student-scholarship-modality" class="input-begin">
                    <option value="">escolha...</option>
                    @foreach ($scholarship_modality as $modality)
                        <option value="{{ $modality->label }}">{{ $modality->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60" id="scholarship-other-type" style="margin-top: 10px; display: none;">
                <label for="">Indique o tipo</label>
                <input class="input-begin" type="text" name="modality_type" id="student-modality-type">
            </div>
            <div class="form-group div-100" id="scholarship-institution" style="margin-top: 10px; display: none;">
                <label for="">Instituição/Entidade</label>
                <input class="input-begin" type="text" name="scholarship_institution"
                    id="student-scholarship-institution">
            </div>
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Como tomou conhecimento
                    do Curso</legend>
            </div>
            <div class="form-group div-100" style="margin-top: 10px;">
                <label for="">Meio <span style="color: #ff0000">*</span></label>
                <select name="means_knowledge" id="student-means-knowledge" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach ($course_annoucement_sources as $course_annoucement_source)
                        <option value="{{ $course_annoucement_source->id }}">{{ $course_annoucement_source->label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form7" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form8', 'div-form7')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form8" type="button" style="border: solid 1px blue; color:blue"
                    onclick="hideDivForm('div-form8', 'div-form9')">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>

        <div class="div-form-begin registration-begin" id="div-form9">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Submissão de Documentos
                </legend>
            </div>
            <div class="form-group div-100">
                <p style="font-size: 10pt; margin: 10px 0; color:#3d3c3c;"><span
                        style="color: #ff0000; font-weight: 700;">Atenção:</span> Anexar os seguintes documentos
                    autenticados(Certificado e Bilhete de Identidade), Declaração Militar e NUIT</p>
            </div>
            <div class="form-group div-50">
                <label for="">Anexar BI/DIRE <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="file" id="student-file-bi" accept=".pdf,.PDF" name="bi"
                    required />
            </div>
            <div class="form-group div-50">
                <label for="">Anexar Nuit <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="file" id="student-file-nuit" accept=".pdf,.PDF" name="nuit"
                    required />
            </div>
            <div class="form-group div-50">
                <label for="">Anexar Certificado <span style="color: #ff0000">*</span></label>
                <input class="input-begin" type="file" id="student-file-certificate" accept=".pdf,.PDF"
                    name="certificate" required />
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form8" type="button" style="background-color: gray;"
                    onclick="hideDivForm('div-form9', 'div-form8')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-begin" type="submit" onclick="subscribe()"
                    style="border: solid 1px blue; color:blue">
                    Submeter-inscrição
                </button>
            </div>
        </div>
    </form>
    <div id="preloader"
        style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}">
    </div>
@endsection


@section('javascript')
    <script type="text/javascript">
        //TRrabalhando com o select de registo
        let extensions_begin = document.getElementById('extensions');
        let faculties = document.getElementById('faculty');








        //Recuperando os distritos no endereco




        //Funcao para ocultar div
        function hideDivForm(hide, show) {
            let form_hide = document.getElementById(hide);
            let form_show = document.getElementById(show);

            form_hide.style.display = 'none';
            form_show.style.display = 'flex';
        }


        //Validando o prencimento do formulario
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dados das faculdades, cursos e linhas de pesquisa carregados no Blade
            var faculties = @json($faculties);
            var courses = @json($courses);
            var sewingLines = @json($sewinglines);
            var districts = @json($districts);

            // Estrutura para mapear relações
            var facultyMap = {};
            var courseMap = {};
            var districtMap = {};

            // Organizando as faculdades por extensão (Local de Estudo)
            faculties.forEach(function(faculty) {
                if (!facultyMap[faculty.extension_id]) {
                    facultyMap[faculty.extension_id] = [];
                }
                facultyMap[faculty.extension_id].push(faculty);
            });

            // Organizando os cursos por faculdade
            courses.forEach(function(course) {
                if (!courseMap[course.faculty_id]) {
                    courseMap[course.faculty_id] = [];
                }
                courseMap[course.faculty_id].push(course);
            });
            // Organizando os distritos por provincia
            districts.forEach(function(district) {
                if (!districtMap[district.province_id]) {
                    districtMap[district.province_id] = [];
                }
                districtMap[district.province_id].push(district);
            });

            // Filtrar Faculdades ao escolher Local de Estudo
            document.getElementById("extensions").addEventListener("change", function() {
                var extensionId = this.value;
                var facultySelect = document.getElementById("faculty");
                facultySelect.innerHTML = '<option value="" selected disabled>escolha...</option>';

                if (facultyMap[extensionId]) {
                    facultyMap[extensionId].forEach(function(faculty) {
                        facultySelect.innerHTML +=
                            `<option value="${faculty.id}">${faculty.label}</option>`;
                    });
                }

                // Resetar selects dependentes
                document.getElementById("courses").innerHTML =
                    '<option value="" selected disabled>escolha...</option>';
                document.getElementById("sewing-lines").innerHTML =
                    '<option value="" selected disabled>escolha...</option>';
            });

            // Filtrar Cursos ao escolher Faculdade
            document.getElementById("faculty").addEventListener("change", function() {
                var facultyId = this.value;
                var courseSelect = document.getElementById("courses");
                courseSelect.innerHTML = '<option value="" selected disabled>escolha...</option>';

                if (courseMap[facultyId]) {
                    courseMap[facultyId].forEach(function(course) {
                        courseSelect.innerHTML +=
                            `<option value="${course.id}">${course.label}</option>`;
                    });
                }

                // Resetar select de Linha de Pesquisa
                document.getElementById("sewing-lines").innerHTML =
                    '<option value="" selected disabled>escolha...</option>';
            });
            // Filtrar distrito ao escolher provincia
            document.getElementById("province").addEventListener("change", function() {
                var provinceId = this.value;

                var districtSelect = document.getElementById("districts");
                districtSelect.innerHTML = '<option value="" selected disabled>escolha...</option>';

                if (districtMap[provinceId]) {
                    districtMap[provinceId].forEach(function(district) {

                        districtSelect.innerHTML +=
                            `<option value="${district.id}">${district.label}</option>`;
                    });
                }


            });

            // Filtrar Linhas de Pesquisa ao escolher Curso
            document.getElementById("courses").addEventListener("change", function() {
                var courseId = this.value;
                var sewingLineSelect = document.getElementById("sewing-lines");
                sewingLineSelect.innerHTML = '<option value="" selected disabled>escolha...</option>';

                sewingLines.forEach(function(line) {
                    if (line.course_id == courseId) {
                        sewingLineSelect.innerHTML +=
                            `<option value="${line.id}">${line.label}</option>`;
                    }
                });
            });
            document.getElementById('div-form1').addEventListener('submit', function(event) {

                event.preventDefault();
                console.log(true)
            });
            document.getElementById('div-form2').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form3').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form4').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form5').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form6').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form7').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form8').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });

            document.getElementById('div-form9').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log(true)
            });
            //Capturando os vdados de inscricao
            document.getElementById('div-form9').addEventListener('submit', function(e) {
                e.preventDefault();
                subscribe();
            });
            //criando a variavel para armazenamento de Bolsa de estudo
            document.getElementById('special-need-yes').addEventListener('click', function() {
                document.getElementById('div-special-need').style.display = 'block';

            })
            //controlando a exibicao das necessidades  especias
            document.getElementById('special-need-yes').addEventListener('click', function() {
                document.getElementById('div-special-need').style.display = 'block';

            })

            document.getElementById('special-need-no').addEventListener('click', function() {
                document.getElementById('div-special-need').style.display = 'none';
            })


            //Controlando a exibicao das bolsas de estudo
            document.getElementById('scholarship-yes').addEventListener('click', function() {
                document.getElementById('scholarship-modality').style.display = 'block'
            });


            document.getElementById('scholarship-modality').addEventListener('change', function(element) {
                //console.log(element.srcElement.value);
                if (element.srcElement.value != '') {
                    document.getElementById('scholarship-institution').style.display = 'block'
                } else {
                    document.getElementById('scholarship-institution').style.display = 'none'
                }

                if (element.srcElement.value == 'Outra') {
                    document.getElementById('scholarship-other-type').style.display = 'block';
                } else {
                    document.getElementById('scholarship-other-type').style.display = 'none';
                }

            });

            document.getElementById('scholarship-no').addEventListener('click', function() {
                document.getElementById('scholarship-modality').style.display = 'none'
            });


            //Capturando os checkboxs das necessidades especias
            let special_needs = document.getElementsByName('special');

            //vetor para armazenar as necessidades escolhidas
            let all_special_needs = [];

            //Percorrendo o vertor para capturar os checkboxs individualmente
            for (let i = 0; i < special_needs.length; i++) {

                //Escutando os clicks de cada checkbox
                special_needs[i].addEventListener('click', function(element) {

                    //verificando se esta incluso o valor do elemento dentro do array das necessidades especias escolhidas
                    if (!all_special_needs.includes(element.srcElement.value)) {
                        //adcionando o elemento dentro do vetor
                        all_special_needs.push(element.srcElement.value);
                    } else {
                        //console.log('remover')

                        let special_needs = all_special_needs;

                        all_special_needs = [];

                        for (var j = 0; j < special_needs.length; j++) {
                            if (special_needs[j] != element.srcElement.value) {
                                all_special_needs.push(special_needs[j])
                            }
                        }
                    }

                });
            }

            function subscribe() {

                //Preloader
                document.getElementById('preloader').style.display = 'flex';


            }
        });
    </script>
@endsection
