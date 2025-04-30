<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tarefas</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Estilos para a lista de tarefas */
        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fafafa;
            border-radius: 5px;
        }

        li.completed {
            text-decoration: line-through;
            background-color: #e0ffe0;
        }

        .task-actions form {
            display: inline-block;
            margin-left: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message, .success-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .task-form input[type="text"], .task-form input[type="description"] {
            padding: 10px;
            width: 80%;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .task-form button {
            padding: 10px 15px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>Tarefas - {{ Auth::user()->name }}</h2>

        <!-- Exibir mensagens de erro ou sucesso -->
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Formulário para adicionar tarefa -->
        <div class="task-form">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Título da tarefa" required>
                <input type="text" name="description" placeholder="Descrição (opcional)">
                <button type="submit">Criar Tarefa</button>
            </form>
        </div>

        <!-- Lista de tarefas -->
        <ul>
            @foreach ($tasks as $task)
                <li class="{{ $task->completed ? 'completed' : '' }}">
                    <div>
                        <strong>{{ $task->title }}</strong>
                        <p>{{ $task->description }}</p>
                    </div>
                    <div class="task-actions">
                        <!-- Atualizar tarefa -->
                        <form action="{{ route('tasks.update', $task) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="completed" value="1" {{ $task->completed ? 'disabled' : '' }}>Concluir</button>
                        </form>
                        <!-- Excluir tarefa -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>
