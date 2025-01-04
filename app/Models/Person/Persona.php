<?php

namespace App\Models\Person;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Persona extends Model
{
    // Especificar la tabla y el esquema
    protected $table = 'persona';
    protected $schema = 'salomon';

    // Clave primaria
    protected $primaryKey = 'id_persona';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'id_user',
        'nombre',
        'paterno',
        'materno',
        'fecha_nacimiento',
        'estado',
        'usuario_crea',
        'usuario_actualiza'
    ];

    // Cambiar nombres de timestamps por defecto
    const CREATED_AT = 'fecha_crea';
    const UPDATED_AT = 'fecha_actualiza';

    // Casteos de tipos de datos
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_crea' => 'datetime',
        'fecha_actualiza' => 'datetime',
        'estado' => 'integer'
    ];

    // Relación con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
