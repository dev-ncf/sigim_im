@extends('template.template2')


@section('active-perfil') class="active" @endsection

@section('content')

    <section class="section-profile">
        <h1>Personaliza&ccedil;&atilde;o</h1>
        <div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
        
        <div class="div-personal-info">
            <div style="position: absolute; background-color: green; color: #fff; padding: 3px 50px; top: 85px; font-size: 10pt;"><i class="bi bi-person"></i> Informacão Pessoal</div>
            <div class="div-40 div-mobile">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="input-form" value="{{ $student->first_name. ' '.$student->last_name}}" disabled />
                </div>
            </div>
            <div class="div-40 div-mobile">
                <div class="form-group">
                    <label>Apelido</label>
                    <input type="text" class="input-form" value="{{ $student->first_name. ' '.$student->last_name}}" disabled />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input type="date" class="input-form" value="{{ $student->birth_date}}" disabled />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Local de Nascimento</label>
                    <input type="text" class="input-form" value="{{ $student->birth_local}}" disabled />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Nacionalidade</label>
                    <input type="text" class="input-form" value="{{ $student->nationality}}" disabled="" />
                </div>
            </div>
            <div class="div-25 div-mobile">
                <div class="form-group">
                    <label>Tipo de Documento</label>
                    <input type="text" class="input-form" value="{{ $student->document->documentType->label}}" disabled="" />
                </div>
            </div>
            <div class="div-30 div-mobile">
                <div class="form-group">
                    <label>Numero do Documento</label>
                    <input type="text" class="input-form" value="{{ $student->document->document_number}}" disabled="" />
                </div>
            </div>
            <div class="div-25 div-mobile">
                <div class="form-group">
                    <label>Local de emissão</label>
                    <input type="text" class="input-form" value="{{ $student->document->issue_place}}" disabled="" />
                </div>
            </div>
            <div class="div-25 div-mobile">
                <div class="form-group">
                    <label>Data de emissão</label>
                    <input type="date" class="input-form" value="{{ $student->document->issue_date}}" disabled="" />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Data de Validade</label>
                    <input type="date" class="input-form" value="{{ $student->document->expiration_date}}" disabled="" />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Gênero</label>
                    <input type="text" class="input-form" value="{{ $student->gender->label}}" disabled="" />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Estado Civil</label>
                    <input type="text" class="input-form" value="{{ $student->maritalStatus->label}}" disabled="" />
                </div>
            </div>
            <div class="div-40 div-mobile">
                <div class="form-group">
                    <label>Necessidade educativa especial</label>
                    <p style="color: #000; margin-top: 10px; font-size: 10;">{{ $student->special_educational_need != '' ? $student->special_educational_need : 'Nenhuma Necessidade'}}</p>
                </div>
            </div>
        </div>

        <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div class="div-address">
                <div class="div-address-legend"><i class="bi bi-geo-alt"></i> Endereço Residencial</div>
                <div class="div-60 div-mobile">
                    <div class="form-group">
                        <label>Provincia</label>
                        <input type="text" class="input-form" value="{{ $student->address->province->label}}" disabled />
                    </div>
                </div>
                <div class="div-40 div-mobile">
                    <div class="form-group">
                        <label>Distrito/Cidade</label>
                        <input type="text" class="input-form" value="{{ $student->address->district->label}}" disabled />
                    </div>
                </div>
                <div class="div-50 div-mobile">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" class="input-form" value="{{ $student->address->neighborhood}}" disabled="" />
                    </div>
                </div>
                <div class="div-25 div-mobile">
                    <div class="form-group">
                        <label>Quarteirão</label>
                        <input type="text" class="input-form" value="{{ $student->address->block}}" disabled="" />
                    </div>
                </div>
                <div class="div-25 div-mobile">
                    <div class="form-group">
                        <label>Nr. Casa</label>
                        <input type="text" class="input-form" value="{{ $student->address->house_number}}" disabled="" />
                    </div>
                </div>
            </div>

            <form class="div-contact" id="form-contact-update">
                <div class="div-contact-label"><i class="bi bi-person-lines-fill"></i> Contactos</div>
                <div class="div-100">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="input-form" value="{{ $student->email}}" disabled />
                    </div>
                </div>
                <div class="div-50">
                    <div class="form-group">
                        <label>Telefone Principal</label>
                        <input type="text" class="input-form" value="{{ $student->phone}}" minlength="9" maxlength="9" id="primaryphone" required />
                    </div>
                </div>
                <div class="div-50">
                    <div class="form-group">
                        <label>Telefone Secundario</label>
                        <input type="text" id="secondaryphone" class="input-form" value="{{ $student->phone_secondary}}" minlength="9" maxlength="9" required />
                    </div>
                </div>
                <div class="div-100">
                    <button type="submit" class="btn-update">
                        <i class="bi bi-pencil-square"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>

        <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between;">

            <form style="width: 100%; display: flex; margin-top: 30px; flex-wrap: wrap; justify-content: space-between; border: 1px solid green; border-radius: 5px; padding: 15px;" id="form-password-update">
                <div class="div-password-label"><i class="bi bi-key"></i> Senha</div>
                <div class="div-50">
                    <div class="form-group">
                        <label>Nova Senha</label>
                        <input type="password" class="input-form" placeholder="digita..." id="newpassword" minlength="8" required/>
                    </div>
                </div>
                <div class="div-50">
                    <div class="form-group">
                        <label>Confirmar Senha</label>
                        <input type="password" class="input-form" placeholder="digita..." id="confpassword" minlength="8" required/>
                    </div>
                </div>
                <div class="div-100">
                    <button type="submit" class="btn-update-password">
                        <i class="bi bi-pencil-square"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </section>

    <div id="preloader" style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}">
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
        
        //Escutando a submicao do formulario de edicao da password
        document.getElementById('form-password-update').addEventListener('submit', function(element){
            element.preventDefault();
            let new_password = document.getElementById('newpassword');
            let conf_password = document.getElementById('confpassword');

            if (new_password.value == conf_password.value) {
                var password = prompt('Digita a sua senha: ');
                passwordUpdate(password, new_password.value, conf_password.value);
            }else{
                return alert('As senhas não correspondem!');
            }
        });


        //Funcao para atualizacao de password
        function passwordUpdate(password, new_password, conf_password){
            document.getElementById('preloader').style.display = 'flex';
            axios({
                method: 'POST',
                url: '/user/password/update',
                data: {
                    password: password,
                    new_password: new_password,
                    conf_password: conf_password
                }
            }).then(response => {
                alert(response.data.message)
                document.getElementById('preloader').style.display = 'none';
            }).catch(error => {
                console.log(error)
            });
        }

        //Escutando a submicao do formulario de edicao de contactos
        document.getElementById('form-contact-update').addEventListener('submit', function(element){
            element.preventDefault();
            let secondary_phone = document.getElementById('secondaryphone');
            let primary_phone = document.getElementById('primaryphone');

            contactUpdate(primary_phone.value, secondary_phone.value);
        });


        //Funcao para atualizacao de contactos
        function contactUpdate(primary_phone, secondary_phone){
            document.getElementById('preloader').style.display = 'flex';
            axios({
                method: 'POST',
                url: '/user/contact/update',
                data: {
                    primary_phone: primary_phone,
                    secondary_phone: secondary_phone
                }
            }).then(response => {
                alert(response.data.message)
                document.getElementById('preloader').style.display = 'none';
            }).catch(error => {
                console.log(error)
            });
        }
    </script>
@endsection