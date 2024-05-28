@extends('template.template')

@section('content')
    <div class="card-login">
        <img class="img-logo" src="{{ asset('img/logo.jpg') }}" alt="" srcset="">

        <form class="div-form-login" id="formVerifyEmail">
            <div class="form-group div-100">
                <p style="font-size: 10pt; margin-bottom: 10px; color: #474747;"><span style="color: red">Atenção: </span>insira o código de confirmação enviado para o seu email: {{$email}}.</p>
                <input type="hidden" id="emailVerify" value="{{$email}}">
                <label for="">Código de confirmação</label>
                <input class="input-begin" type="text" id="codeVerify" minlength="6" maxlength="6" required>
                <button class="btn-login" type="submit">
                    Confirmar
                </button>
            </div>
        </form>

        <p class="copyright">Desenvolvido por <strong>DTIC</strong>-2023</p>
    </div>

    <div class="success-register" id="successRegister">
        <div class="message-register">
            <i class="bi bi-check-circle"></i>
            <p>Cadastrado com Sucesso</p>
            <span id="count">5</span>
        </div>
    </div>
@endsection

<div id="preloader" style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}">
</div>


@section('javascript')
    <script type="text/javascript">
        //MANIPULACAO DE TEMPORIZADOR DE CONFIRMACAO DE EMAIL
        let count = document.getElementById('count');
        let init = 5

        function cronometer(){
            setInterval(() => {
                count.innerText = init
                if (init >= 1) {
                    init = init - 1
                }else{
                    window.location.href = '/';
                }
            }, 1000);
        }
        //Validando o email

        let form_verify_email = document.getElementById('formVerifyEmail');
        form_verify_email.addEventListener('submit', function(event){
            event.preventDefault()
            
            let email = document.getElementById('emailVerify');
            let code = document.getElementById('codeVerify');
            let confirm_data = {
                email: email.value,
                code: code.value
            }
            axios({
                method: 'POST',
                url: '/verify/email',
                data: confirm_data
            }).then(response => {
                if (response.data) {
                    document.getElementById('preloader').style.display = 'none';
                    div_form_success.style.display = 'flex';
                    cronometer();
                }else{
                    document.getElementById('preloader').style.display = 'none';
                    alert('O código digitado não é valido');
                }
            }).catch(error => {
                console.log(error)
            })
        })


        //Manipulando a div de mensagem de sucess
        let div_form_success = document.getElementById('successRegister');



        document.getElementById('formVerifyEmail').addEventListener('submit', function(){
            document.getElementById('preloader').style.display = 'flex';
        });
    </script>
@endsection