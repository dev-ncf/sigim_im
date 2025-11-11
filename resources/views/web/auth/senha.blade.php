<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha - UniRovuma</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container-recuperacao {
    text-align: center;
}

.caixa-recuperacao {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.logo-unirovuma img {
    max-width: 200px;
    margin-bottom: 20px;
}

h2 {
    color: #004a99; /* Azul principal da UniRovuma */
    margin-bottom: 10px;
}

p {
    color: #666;
    margin-bottom: 20px;
}

.campo-input {
    text-align: left;
    margin-bottom: 20px;
}

.campo-input label {
    display: block;
    margin-bottom: 5px;
    color: #333;
    font-weight: bold;
}

.campo-input input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.botao-recuperar {
    background-color: #004a99; /* Azul principal da UniRovuma */
    color: #ffffff;
    padding: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.botao-recuperar:hover {
    background-color: #003366; /* Tom de azul mais escuro para o hover */
}

.link-login {
    margin-top: 20px;
}

.link-login a {
    color: #004a99;
    text-decoration: none;
}

.link-login a:hover {
    text-decoration: underline;
}
    </style>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QF0fK+4zENyJrV3SvhNfrZ3tI5VvL8vIefR9f0tW1T7lYylIbfm8f1S4l2kTnZ1C" crossorigin="anonymous">

</head>
<body>
    <div class="container-recuperacao">
        <div class="caixa-recuperacao">
            <div class="logo-unirovuma">
                <img src="{{asset('img/logo.png')}}" alt="Logótipo da UniRovuma">
            </div>
            <h2>Recuperação de Senha</h2>
            <p>Insira o seu endereço de e-mail abaixo para receber as instruções de como redefinir a sua senha.</p>
            @if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif
            <form action="{{ route('recuperarSenha') }}" method="post">
                @csrf
                <div class="campo-input">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                </div>
                <button type="submit" class="botao-recuperar">Enviar Instruções</button>
            </form>
            <div class="link-login">
                <a href="{{ route('login') }}">Voltar para o Login</a>
            </div>
        </div>
    </div>
</body>
</html>