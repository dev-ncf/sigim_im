@extends('template.template')

@section('content')
    <div class="card-login">
        <img class="img-logo" src="{{ asset('img/logo.jpg') }}" alt="" srcset="">

        <form class="div-form-login" id="formCreateUser" action="/register" method="POST">
            @csrf
            <div class="form-group div-100">
                <label for="">Nome completo</label>
                <input class="input-begin" type="text" name="name" id="name" required>
            </div>
            <div class="form-group div-100">
                <label for="">Email</label>
                <input class="input-begin" type="email" name="email" id="email" required>
            </div>
            <div class="form-group div-100">
                <label for="">Senha</label>
                <input class="input-begin" type="password" name="password" id="password" id="" required>
            </div>
            <div class="form-group div-100">
                <label for="">Confirmar senha</label>
                <input class="input-begin" type="password" name="confPassword" id="confPassword" required>
                <div class="div-100 div-btn-login">
                    <a href="{{ route('login') }}" style="font-size: 10pt; margin-top: 10px;">Iniciar-sessão</a>
                    <button class="btn-login" type="submit">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>

        <p class="copyright">Desenvolvido por <strong>DTIC</strong>-2023</p>
    </div>
    <div id="preloader" style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}">
    </div>
@endsection


@section('javascript')
    <script type="text/javascript">
        document.getElementById('formCreateUser').addEventListener('submit', function(){
            document.getElementById('preloader').style.display = 'flex';
        });
    </script>
@endsection