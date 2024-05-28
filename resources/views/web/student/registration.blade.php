@extends('template.template')

@section('content')
    <div class="card">
        <img class="img-logo" src="{{ asset('img/logo.jpg') }}" alt="" srcset="">
        <h1 class="title">UNIVERSIDADE ROVUMA</h1>
        <h1 class="sub-title">DIRECÇÃO DO REGISTO ACADÉMICO</h1>
        <form class="div-form-begin registration-begin" id="div-form1" onsubmit="hideDivForm('div-form1', 'div-form2')">
            <div class="form-group div-100">
                <label for="">Nome Completo</label>
                <input class="input-begin" type="text" name="" id="name" value="{{ $name }}">
            </div>
            <div class="form-group div-30">
                <label for="">Local de estudo</label>
                <select id="extensions" class="input-begin" name="extension" required>
                    <option value="">escolha...</option>
                    @foreach($extensions as $extension)
                        <option value="{{ $extension->id }}">{{ $extension->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Faculdade</label>
                <select name="" id="faculty" class="input-begin" required>
                    <option value="">escolha...</option>
                </select>
            </div>
            <div class="form-group div-30">
                <label for="">Curso</label>
                <select name="" id="courses" class="input-begin" required>
                    <option value="">escolha...</option>
                </select>
            </div>
            <div class="form-group div-100">
                <label for="">Linha de Pesguisa</label>
                <select name="" id="sewing-lines" class="input-begin" required>
                    <option value="">escolha...</option>
                </select>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-next" id="btn-hide-form1" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form2" onsubmit="hideDivForm('div-form2', 'div-form3')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil</legend>
            </div>
            <div class="form-group div-40">
                <label for="">Apelido</label>
                <input class="input-begin" type="text" name="" id="student-last-name" required>
            </div>
            <div class="form-group div-60">
                <label for="">Nome (<span style="color: red;">Atenção:</span> <span style="font-size: 8pt; font-weight: 400;">não preencha o seu apelido</span>)</label>
                <input class="input-begin" type="text" name="" id="student-first-name" required>
            </div>
            <div class="form-group div-50">
                <label for="">Nome completo do Pai</label>
                <input class="input-begin" type="text" name="" id="student-father" required>
            </div>
            <div class="form-group div-50">
                <label for="">Nome completo da Mãe</label>
                <input class="input-begin" type="text" name="" id="student-mother" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de Nascimento</label>
                <input class="input-begin" type="date" name="student-birth-date" max="2000-01-01" id="student-birth-date" required>
            </div>
            <div class="form-group div-30">
                <label for="">Província de Nasc</label>
                <select name="" id="student-birth-province" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Local de Nascimento</label>
                <input class="input-begin" type="text" name="" id="student-birth-local" required>
            </div>
            <div class="form-group div-100">
                <label for="">Nacionalidade</label>
                <input class="input-begin" type="text" name="" id="student-nationality" required>
            </div>
            <div class="div-100" style="text-align: center;">
                <button class="btn-prev" id="btn-show-form1" onclick="hideDivForm('div-form2', 'div-form1')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button>
                <button class="btn-next" id="btn-hide-form2" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form3" onsubmit="hideDivForm('div-form3', 'div-form4')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil</legend>
            </div>
            <div class="form-group div-40">
                <label for="">Tipo de documento</label>
                <select name="" id="student-document-type" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($document_types as $document_type)
                        <option value="{{ $document_type->id }}">{{ $document_type->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60">
                <label for="">Número do documento</label>
                <input class="input-begin" type="text" name="" id="student-document-number" required>
            </div>
            <div class="form-group div-40">
                <label for="">Local de emissão</label>
                <input class="input-begin" type="text" name="" id="student-place-issue" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de emissão</label>
                <input class="input-begin" type="date" name="" id="student-issue-date" required>
            </div>
            <div class="form-group div-30">
                <label for="">Data de Validade</label>
                <input class="input-begin" type="date" name="" id="student-expiration-date" required>
            </div>
            <div class="form-group div-50">
                <label for="">Gênero</label>
                <select name="" id="student-gender" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-50">
                <label for="">Estado Civil</label>
                <select name="" id="student-marital-status" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($civil_statuses as $civil_status)
                        <option value="{{ $civil_status->id }}">{{ $civil_status->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-100">
                <label for="">Possui alguma necessidade educativa especial?
                    <span style="margin-left: 25px;">
                        <input type="radio" class="special-needs" name="special-need" id="special-need-yes" value="1" required> Sim
                    </span>
                    <span style="margin-left: 15px;">
                        <input type="radio" class="special-needs" name="special-need" id="special-need-no" value="0" required> Não
                    </span>
                </label>
            </div>
            <div class="form-group div-100" id="div-special-need" style="display: none;">
                <div class="special-need">
                    <span>
                        <input type="checkbox" name="special" id="" value="Altas habilidades"> Altas habilidades
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
                {{-- <button class="btn-prev" id="btn-show-form2" onclick="hideDivForm('div-form3', 'div-form2')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form3" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form4" onsubmit="hideDivForm('div-form4', 'div-form5')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Endereço</legend>
            </div>
            <div class="form-group div-50">
                <label for="">Província</label>
                <select name="" id="province-address" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-50">
                <label for="">Distrito/Cidade</label>
                <select name="" id="district-address" class="input-begin" required>
                    <option value="">escolha...</option>
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Bairro</label>
                <input class="input-begin" type="text" name="" id="student-neighborhood" required>
            </div>
            <div class="form-group div-30">
                <label for="">Quarteirão</label>
                <input class="input-begin" type="number" min="1" name="" id="student-block">
            </div>
            <div class="form-group div-30">
                <label for="">Numero de casa</label>
                <input class="input-begin" type="number" min="1" name="" id="student-house-number">
            </div>
            <div class="form-group div-50">
                <label for="">Telefone</label>
                <input class="input-begin" type="number" min="1" minlength="9" maxlength="9" name="" id="student-main-phone" required>
            </div>
            <div class="form-group div-50">
                <label for="">Telefone alternativo</label>
                <input class="input-begin" type="number" min="1" minlength="9" maxlength="9" name="" id="student-secondary-phone">
            </div>
            <div class="form-group div-100">
                <label for="">Email</label>
                <input class="input-begin" type="email" id="student-email" name="student-email" value="{{$email}}" disabled required>
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form3" onclick="hideDivForm('div-form4', 'div-form3')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form4" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form5" onsubmit="hideDivForm('div-form5', 'div-form6')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Perfil Acadêmico</legend>
            </div>
            <div class="form-group div-40">
                <label for="">Habilitação anterior</label>
                <select name="" id="student-previous-license" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($academic_levels as $level)
                        @if($level->code == 00001)
                            <option value="{{$level->id}}">{{ $level->label }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60">
                <label for="">Local onde frequentou (Cidade/Distrito)</label>
                <input class="input-begin" type="text" name="" id="student-previous-license-local" required>
            </div>
            <div class="form-group div-100">
                <label for="">Nome da instituição</label>
                <input class="input-begin" type="text" name="" id="student-previous-license-institution" required>
            </div>
            <div class="form-group div-50">
                <label for="">Periodo de frequência (Ano de inicio)</label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') - 4 }}" id="student-previous-license-start-year" required>
            </div>
            <div class="form-group div-50">
                <label for="">Ano de termino</label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}" id="student-previous-license-end-year" required>
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form4" onclick="hideDivForm('div-form5', 'div-form4')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form5" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form6" onsubmit="hideDivForm('div-form6', 'div-form7')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Carreira profissional</legend>
            </div>
            <div class="form-group div-100">
                <label for="">Instituição</label>
                <input class="input-begin" type="text" name="" id="student-professional-career-institution">
            </div>
            <div class="form-group div-50">
                <label for="">Período (Ano de inicio)</label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}" name="" id="student-professional-career-start-year">
            </div>
            <div class="form-group div-50">
                <label for="">Ano de termino</label>
                <input class="input-begin" type="number" min="1970" max="{{ date('Y') }}" name="" id="student-professional-career-end-year">
            </div>
            <div class="form-group div-100">
                <label for="">Actividades/funções desenvolvidas</label>
                <input class="input-begin" type="text" name="" id="student-professional-career-role">
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form5" onclick="hideDivForm('div-form6', 'div-form5')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form6" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form7" onsubmit="hideDivForm('div-form7', 'div-form8')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Situação Económica</legend>
            </div>
            <div class="form-group div-50">
                <label for="">Profissão do Pai</label>
                <input class="input-begin" type="text" name="" id="student-father-profession">
            </div>
            <div class="form-group div-50">
                <label for="">Profissão da Mãe</label>
                <input class="input-begin" type="text" name="" id="student-mother-profession">
            </div>
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Composição do Agregado Familiar</legend>
            </div>
            <div class="form-group div-60">
                <label for="">Tipo de Familia</label>
                <select name="" id="student-family-type" class="input-begin" required>
                    <option value="">escolha...</option>
                    <option value="Família Alargada">Família Alargada</option>
                    <option value="Família Conjugal">Família Conjugal</option>
                </select>
            </div>
            <div class="form-group div-40">
                <label for="">Número de Agregado</label>
                <input class="input-begin" type="number" min="1" name="" id="student-household" required>
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form6" onclick="hideDivForm('div-form7', 'div-form6')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form7" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form8" onsubmit="hideDivForm('div-form8', 'div-form9')">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Bolsas de Estudos</legend>
            </div>
            <div class="form-group div-100">
                <label for="">Possui uma bolsa?

                    <input type="radio" name="student-scholarship" id="scholarship-yes" value="1" style="margin-left: 15px;" required> <span style="margin-right: 15px;">Sim</span>
                    <input type="radio" name="student-scholarship" id="scholarship-no" value="0" required> <span>Nao</span>
                </label>
            </div>
            <div class="form-group div-40" id="scholarship-modality" style="margin-top: 10px; display: none;">
                <label for="">Modalidade</label>
                <select name="" id="student-scholarship-modality" class="input-begin">
                    <option value="">escolha...</option>
                    @foreach( $scholarship_modality as $modality)
                        <option value="{{$modality->label}}">{{$modality->label}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group div-60" id="scholarship-other-type" style="margin-top: 10px; display: none;">
                <label for="">Indique o tipo</label>
                <input class="input-begin" type="text" name="" id="student-modality-type">
            </div>
            <div class="form-group div-100" id="scholarship-institution" style="margin-top: 10px; display: none;">
                <label for="">Instituição/Entidade</label>
                <input class="input-begin" type="text" name="" id="student-scholarship-institution">
            </div>
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Como tomou conhecimento do Curso</legend>
            </div>
            <div class="form-group div-100" style="margin-top: 10px;">
                <label for="">Meio</label>
                <select name="" id="student-means-knowledge" class="input-begin" required>
                    <option value="">escolha...</option>
                    @foreach($course_annoucement_sources as $course_annoucement_source)
                        <option value="{{$course_annoucement_source->id}}">{{$course_annoucement_source->label}}</option>
                    @endforeach
                </select>
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form7" onclick="hideDivForm('div-form8', 'div-form7')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-next" id="btn-hide-form8" type="submit">
                    Próximo <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </form>

        <form class="div-form-begin registration-begin" id="div-form9">
            <div class="div-100" style="margin: 10px 0; padding: 5px;  background-color:#3997bc;">
                <legend style="font-size: 12pt; text-align: center; font-weight: 600; color: #fff;">Submissão de Documentos</legend>
            </div>
            <div class="form-group div-100">
                <p style="font-size: 10pt; margin: 10px 0; color:#3d3c3c;" ><span style="color: #ff0000; font-weight: 700;">Atenção:</span> Anexar os seguintes documentos autenticados(Certificado e Bilhete de Identidade), Declaração Militar e NUIT</p>
            </div>
            <div class="form-group div-50">
                <label for="">Anexar BI/DIRE</label>
                <input class="input-begin" type="file" id="student-file-bi" accept=".pdf,.PDF" required />
            </div>
            <div class="form-group div-50">
                <label for="">Anexar Nuit</label>
                <input class="input-begin" type="file" id="student-file-nuit" accept=".pdf,.PDF" required />
            </div>
            <div class="form-group div-50">
                <label for="">Anexar Certificado</label>
                <input class="input-begin" type="file" id="student-file-certificate" accept=".pdf,.PDF" required />
            </div>
            <div class="div-100" style="text-align: center;">
                {{-- <button class="btn-prev" id="btn-show-form8" onclick="hideDivForm('div-form9', 'div-form8')">
                    <i class="bi bi-chevron-double-left"></i> Anterior
                </button> --}}
                <button class="btn-begin" type="submit">
                    Submeter-inscrição
                </button>
            </div>
        </form>
    </div>
    <div id="preloader" style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}">
    </div>
@endsection


@section('javascript')
    <script type="text/javascript">
        //TRrabalhando com o select de registo
        let extensions_begin = document.getElementById('extensions');
        let faculties = document.getElementById('faculty');

        extensions_begin.addEventListener('change', function(){
            let extension = extensions_begin.value

            axios({
                method: 'post',
                url: '/user/registration/faculties',
                data: {
                    extension: extension
                }
            }).then(response => {
                
                faculties.innerHTML = ''
                let option = document.createElement('option');
                option.textContent = 'escolha...';
                option.value = '';
                faculties.appendChild(option);
                for(let i = 0; i < response.data.length; i++){
                    let option2 = document.createElement('option')

                    option2.textContent = response.data[i].label;
                    option2.value = response.data[i].id;

                    faculties.appendChild(option2);
                }

            }).catch(error => {
                console.log(error)
            })
        });



        //Trabalhando para recuperar cursos da faculdade
        let courses = document.getElementById('courses');

        faculties.addEventListener('change', function(){
            let faculty = faculties.value

            axios({
                method: 'post',
                    url: '/user/registration/courses',
                data: {
                    faculty: faculty
                }
            }).then(response => {
                //console.log(response.data)
                courses.innerHTML = '';
                let option = document.createElement('option');
                option.textContent = 'escolha...';
                option.value = '';
                courses.appendChild(option);

                for(let j = 0; j < response.data.length; j++){
                    let option2 = document.createElement('option')
                    option2.textContent = response.data[j].label;
                    option2.value = response.data[j].id;

                    courses.appendChild(option2);
                }
            }).catch(error => {
                console.log(error)
            })
        });

        //Carregando a linha de pesguisa
        var sewing_lines = document.getElementById('sewing-lines')
        courses.addEventListener('change', function(){
            let course = courses.value
            axios({
                method: 'post',
                url: '/user/registration/sewing-lines',
                data: {
                    course: course
                }
            }).then(response => {
                sewing_lines.innerHTML = '';
                let option = document.createElement('option');
                option.textContent = 'escolha...';
                option.value = '';
                sewing_lines.appendChild(option);

                for(let j = 0; j < response.data.length; j++){
                    let option2 = document.createElement('option')
                    option2.textContent = response.data[j].label;
                    option2.value = response.data[j].id;

                    sewing_lines.appendChild(option2);
                }
            }).catch(error => {
                console.log(error)
            })
        });

        //Recuperando os distritos no endereco
        document.getElementById('province-address').addEventListener('change', function(element){
            let districts = document.getElementById('district-address');
            axios({
                method: 'post',
                url: '/address/districts',
                data: {
                    province: element.srcElement.value
                }
            }).then(response => {
                //console.log(response.data)
                districts.innerHTML = '';
                let option = document.createElement('option');
                option.textContent = 'escolha...';
                option.value = '';
                districts.appendChild(option);

                for(let i = 0; i < response.data.length; i++){
                    let option2 = document.createElement('option');
                    option2.textContent = response.data[i].label;
                    option2.value = response.data[i].id;

                    districts.appendChild(option2);
                }
            }).catch(error => {
                console.log(error)
            })
        });

        //controlando a exibicao das necessidades  especias
        document.getElementById('special-need-yes').addEventListener('click', function(){
            document.getElementById('div-special-need').style.display = 'block';

        })

        document.getElementById('special-need-no').addEventListener('click', function(){
            document.getElementById('div-special-need').style.display = 'none';
        })


        //Controlando a exibicao das bolsas de estudo
        document.getElementById('scholarship-yes').addEventListener('click', function(){
            document.getElementById('scholarship-modality').style.display = 'block'
        });


        document.getElementById('scholarship-modality').addEventListener('change', function(element){
            //console.log(element.srcElement.value);
            if (element.srcElement.value != '') {
                document.getElementById('scholarship-institution').style.display = 'block'
            }else{
                document.getElementById('scholarship-institution').style.display = 'none'
            }

            if (element.srcElement.value == 'Outra') {
                document.getElementById('scholarship-other-type').style.display = 'block';
            }else{
                document.getElementById('scholarship-other-type').style.display = 'none';
            }

        });

        document.getElementById('scholarship-no').addEventListener('click', function(){
            document.getElementById('scholarship-modality').style.display = 'none'
        });


        //Capturando os checkboxs das necessidades especias
        let special_needs = document.getElementsByName('special');

        //vetor para armazenar as necessidades escolhidas
        let all_special_needs = [];

        //Percorrendo o vertor para capturar os checkboxs individualmente
        for(let i = 0; i < special_needs.length; i++){

            //Escutando os clicks de cada checkbox
            special_needs[i].addEventListener('click', function(element){
                
                //verificando se esta incluso o valor do elemento dentro do array das necessidades especias escolhidas
               if (!all_special_needs.includes(element.srcElement.value)) {
                    //adcionando o elemento dentro do vetor
                    all_special_needs.push(element.srcElement.value);
               }else{
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

        //Funcao para ocultar div
        function hideDivForm(hide, show)
        {
            let form_hide = document.getElementById(hide);
            let form_show = document.getElementById(show);

            form_hide.style.display = 'none';
            form_show.style.display = 'flex';
        }


        //Validando o prencimento do formulario
        document.getElementById('div-form1').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form2').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form3').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form4').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form5').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form6').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form7').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form8').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });

        document.getElementById('div-form9').addEventListener('submit', function(event){
            event.preventDefault();
            console.log(true)
        });


        //criando a variavel para armazenamento de Bolsa de estudo
        let special_need;
        let all_special_need = document.querySelectorAll('.special-needs');
        for(i = 0; i < all_special_need.length; i++){
            all_special_need[i].addEventListener('click', function(element){
                special_need = element.srcElement.value
            });
        }

        //Capturando os vdados de inscricao
        document.getElementById('div-form9').addEventListener('submit', function(e){
            e.preventDefault();
            subscribe();
        });

        function subscribe(){

            //Preloader
            document.getElementById('preloader').style.display = 'flex';

            let full_name = document.getElementById('name');
            let student_extension = document.getElementById('extensions')
            let student_faculty = document.getElementById('faculty')
            let student_course = document.getElementById('courses')
            let student_last_name = document.getElementById('student-last-name')
            let student_first_name = document.getElementById('student-first-name')
            let student_father = document.getElementById('student-father')
            let student_mother = document.getElementById('student-mother')
            let student_birth_date = document.getElementById('student-birth-date')
            let student_birth_province = document.getElementById('student-birth-province')
            let student_birth_local = document.getElementById('student-birth-local')
            let student_nationality = document.getElementById('student-nationality')
            let student_document_type = document.getElementById('student-document-type')
            let student_document_number = document.getElementById('student-document-number')
            let student_place_issue = document.getElementById('student-place-issue')
            let student_issue_date = document.getElementById('student-issue-date')
            let student_expiration_date = document.getElementById('student-expiration-date')
            let student_gender = document.getElementById('student-gender')
            let student_marital_status = document.getElementById('student-marital-status')
            let student_special_needs = all_special_needs
            let student_province_address = document.getElementById('province-address')
            let student_district_address = document.getElementById('district-address')
            let student_neighborhood_address = document.getElementById('student-neighborhood')
            let student_block_address = document.getElementById('student-block')
            let student_road_address = document.getElementById('student-road')
            let student_house_number_address = document.getElementById('student-house-number')
            let student_main_phone = document.getElementById('student-main-phone')
            let student_secondary_phone = document.getElementById('student-secondary-phone')
            let student_email = document.getElementById('student-email');
            let student_previous_license = document.getElementById('student-previous-license')
            let student_previous_license_local = document.getElementById('student-previous-license-local')
            let student_previous_license_institution = document.getElementById('student-previous-license-institution')
            let student_previous_license_start_year = document.getElementById('student-previous-license-start-year')
            let student_previous_license_end_year = document.getElementById('student-previous-license-end-year')
            let student_professional_career_institution = document.getElementById('student-professional-career-institution')
            let student_professional_career_start_year = document.getElementById('student-professional-career-start-year')
            let student_professional_career_end_year = document.getElementById('student-professional-career-end-year')
            let student_professional_career_role = document.getElementById('student-professional-career-role')
            let student_father_profession = document.getElementById('student-father-profession')
            let student_mother_profession = document.getElementById('student-mother-profession')
            let student_family_type = document.getElementById('student-family-type')
            let student_household = document.getElementById('student-household')

            /*let scholarship_yes = document.getElementById('scholarship-yes')
            let scholarship_no = document.getElementById('scholarship-no')*/

            //Variavel que controla de bolsas de estudo
            let scholarship_modality;

            let student_scholarship_modality = document.getElementById('student-scholarship-modality')
            let student_modality_type = document.getElementById('student-modality-type')
            let student_scholarship_institution = document.getElementById('student-scholarship-institution')


            if (student_scholarship_modality.value != 'Outra') {
                scholarship_modality = student_scholarship_modality.value;
            }else{
                scholarship_modality = student_modality_type.value;
            }

            //Variavel que controla anuncio dos cursos
            let student_means_knowledge = document.getElementById('student-means-knowledge');

            let data = {
                student: {
                    first_name: student_first_name.value,
                    last_name: student_last_name.value,
                    province_birth_id: student_birth_province.value,
                    birth_local: student_birth_local.value,
                    gender_id: student_gender.value,
                    marital_status_id: student_marital_status.value,
                    special_education_need: student_special_needs,
                    birth_date: student_birth_date.value,

                    father_name: student_father.value,
                    father_profession: student_father_profession.value,
                    mother_name: student_mother.value,
                    mother_profession: student_mother_profession.value,
                    nationality: student_nationality.value,
                    email: student_email.value,
                    phone: student_main_phone.value,
                    phone_secondary: student_secondary_phone.value,
                    family_type: student_family_type.value,
                    household: student_household.value
                },
                student_course_knowledge: {
                    ad_source: student_means_knowledge.value
                },
                student_documents: {
                    document_type_id: student_document_type.value,
                    document_number: student_document_number.value,
                    issue_date: student_issue_date.value,
                    expiration_date: student_expiration_date.value,
                    issue_place: student_place_issue.value
                },
                student_professional_careers:{
                    institution: student_professional_career_institution.value,
                    start_year: student_professional_career_start_year.value,
                    completion_year: student_professional_career_end_year.value,
                    role: student_professional_career_role.value
                },
                student_scholarship: {
                    scholarship: special_need,
                    institution: student_scholarship_institution.value,
                    modality: scholarship_modality
                },
                student_enrollments: {
                    faculty_id: student_faculty.value,
                    course_id: student_course.value,
                    extension_id: student_extension.value,
                    sewing_line_id: sewing_lines.value
                },
                student_addresses: {
                    province_id: student_province_address.value,
                    district_id: student_district_address.value,
                    neighborhood: student_neighborhood_address.value,
                    block: student_block_address.value,
                    house_number: student_house_number_address.value
                },

                previous_skills: {
                    academic_level_id: student_previous_license.value,
                    local: student_previous_license_local.value,
                    institution: student_previous_license_institution.value,
                    start_year: student_previous_license_start_year.value,
                    completion_year: student_previous_license_end_year.value,
                }
            }

            //console.log(data)

            //Criando a class para enviar arquivos
            let formData = new FormData();

            let bi = document.getElementById('student-file-bi');
            let nuit = document.getElementById('student-file-nuit');
            let certificate = document.getElementById('student-file-certificate');

            //return console.log(files)
            formData.append('bi', bi.files[0]);
            formData.append('nuit', nuit.files[0]);
            formData.append('certificate', certificate.files[0]);
            //Enviando para o cadastro

            axios.post('/user/student/registration', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                params: data
            }).then(response => {
                if (response.data) {
                    window.window.location.href = '/';
                }
            }).catch(error => {
                console.log(error)
            })
        }

    </script>
@endsection