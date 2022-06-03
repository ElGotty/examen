<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'fechainicio',
        'fechavencimiento',
        'status'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'tareas_user');
    }
    public function delete() {

        $this->users()->detach();;
        return parent::delete();
    }
}
