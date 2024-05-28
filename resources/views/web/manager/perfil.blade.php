@extends('template.template3')


@section('active-perfil') class="active" @endsection

@section('content')

    <section class="section-profile">
        <h1>Personaliza&ccedil;&atilde;o</h1>
        <div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
        
        <div class="div-personal-info">
            <div style="position: absolute; background-color: green; color: #fff; padding: 3px 50px; top: 85px; font-size: 10pt;"><i class="bi bi-person"></i> Informacão Pessoal</div>
            <div class="div-50 div-mobile">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="input-form" value="{{ $manager->first_name }}" disabled />
                </div>
            </div>
            <div class="div-50 div-mobile">
                <div class="form-group">
                    <label>Apelido</label>
                    <input type="text" class="input-form" value="{{ $manager->last_name}}" disabled />
                </div>
            </div>
            <div class="div-30 div-mobile">
                <div class="form-group">
                    <label>Numero do BI</label>
                    <input type="text" class="input-form" value="{{ $manager->document_number}}" disabled="" />
                </div>
            </div>
            <div class="div-25 div-mobile">
                <div class="form-group">
                    <label>Local de emissão</label>
                    <input type="text" class="input-form" value="{{ $manager->issue_place}}" disabled="" />
                </div>
            </div>
            <div class="div-25 div-mobile">
                <div class="form-group">
                    <label>Data de emissão</label>
                    <input type="date" class="input-form" value="{{ $manager->issue_date}}" disabled="" />
                </div>
            </div>
            <div class="div-20 div-mobile">
                <div class="form-group">
                    <label>Data de Validade</label>
                    <input type="date" class="input-form" value="{{ $manager->expiration_date}}" disabled="" />
                </div>
            </div>
        </div>

        <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between;">
            <form style="width: 100%; display: flex; margin-top: 30px; flex-wrap: wrap; justify-content: space-between; border: 1px solid green; border-radius: 5px; padding: 15px;" class="div-contact" id="form-contact-update">
                <div class="div-contact-label" style="top: 250px !important"><i class="bi bi-person-lines-fill"></i> Contactos</div>
                <div class="div-100">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="input-form" value="{{ $manager->email}}" disabled />
                    </div>
                </div>
                <div class="div-50">
                    <div class="form-group">
                        <label>Telefone Principal</label>
                        <input type="text" class="input-form" value="{{ $manager->phone }}" minlength="9" maxlength="9" id="primaryphone" disabled required />
                    </div>
                </div>
                {{--<div class="div-50">
                    <div class="form-group">
                        <label>Telefone Secundario</label>
                        <input type="text" id="secondaryphone" class="input-form" value="{{ $manager->phone_secondary }}" minlength="9" maxlength="9" required />
                    </div>
                </div>
                <div class="div-100">
                    <button type="submit" class="btn-update">
                        <i class="bi bi-pencil-square"></i> Atualizar
                    </button>
                </div> --}}
            </form>
        </div>

        <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between;">

            <form style="width: 100%; display: flex; margin-top: 30px; flex-wrap: wrap; justify-content: space-between; border: 1px solid green; border-radius: 5px; padding: 15px;" id="form-password-update">
                <div class="div-password-label" style="top: 417px !important"><i class="bi bi-key"></i> Senha</div>
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
                passwordUpdate(new_password.value, conf_password.value);
            }else{
                return alert('As senhas não correspondem!');
            }
        });


        //Funcao para atualizacao de password
        function passwordUpdate(new_password, conf_password){
            //alert('Atualiando...')
            document.getElementById('preloader').style.display = 'flex';
            axios({
                method: 'POST',
                url: '/manager/password/update',
                data: {
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