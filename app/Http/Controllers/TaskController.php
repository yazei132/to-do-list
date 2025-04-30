<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // ADICIONE ESTA LINHA

class TaskController extends Controller
{
    use AuthorizesRequests; // E ESTA LINHA

    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('home', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', // Validação da descrição
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description, // Salvando a descrição
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Tarefa criada com sucesso!');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', // Validação opcional na atualização
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_done' => $request->has('is_done'),
        ]);

        return redirect()->route('home')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('home')->with('success', 'Tarefa removida com sucesso!');
    }
}
