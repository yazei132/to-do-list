<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
    ];

    /**
     * Relacionamento: uma tarefa pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
