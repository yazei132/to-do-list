<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home - Tarefas</title>
    <style>
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

        .task-form input[type="text"] {
            padding: 10px;
            width: 38%;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .task-form button {
            padding: 10px 15px;
        }

        .logout-form {
            text-align: right;
            margin-bottom: 15px;
        }

        .logout-form button {
            background-color: #dc3545;
        }

        .logout-form button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="logout-form">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </div>

        <h2>Bem-vindo, {{ Auth::user()->name }}!</h2>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Formulário de criação de tarefa -->
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
            @forelse ($tasks as $task)
                <li class="{{ $task->completed ? 'completed' : '' }}">
                    <div>
                        <strong>{{ $task->title }}</strong><br>
                        <small>{{ $task->description }}</small>
                    </div>
                    <div class="task-actions">
                        <!-- Concluir tarefa -->
                        @if (!$task->completed)
                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <input type="hidden" name="description" value="{{ $task->description }}">
                                <input type="hidden" name="completed" value="1">
                                <button type="submit">Concluir</button>
                            </form>
                        @endif

                        <!-- Excluir tarefa -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </div>
                </li>
            @empty
                <li>Nenhuma tarefa cadastrada ainda.</li>
            @endforelse
        </ul>
    </div>

</body>
</html>
