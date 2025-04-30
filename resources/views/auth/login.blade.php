<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Estilos para o formulário de login */
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Estilos para os inputs */
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Estilo para o botão */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Estilos para links */
        .link a {
            color: #007bff;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Estilo para mensagens de erro */
        .error-message, .success-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        /* Estilo para campos com erro de validação */
        .is-invalid {
            border: 1px solid #e3342f;
        }

        .invalid-feedback {
            color: #e3342f;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <!-- Exibir mensagens de erro -->
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Exibir mensagem de sucesso após registro -->
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulário de login -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Campo de Email -->
            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="{{ old('email') }}"
                    required
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                >
                <!-- Mensagem de erro para o campo de email -->
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- Campo de Senha -->
            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Senha"
                    required
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                >
                <!-- Mensagem de erro para o campo de senha -->
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <button type="submit">Entrar</button>
        </form>

        <div class="link">
            <a href="{{ route('register') }}">Não tem conta? Registre-se</a>
        </div>
    </div>
</body>
</html>
