<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $fillable = [
        "valor",
        "user_id",
        "descricao",
        "datadespesa"
    ];
    use HasFactory;


    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
