<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    public $timestamps = true;

    protected $fillable = [
        
    ];

    // Relación con Recepciones
    public function receptions()
    {
        // Importante: especificar la clave foránea porque tu PK no es "id"
        return $this->hasMany(Reception::class, 'patient_id', 'Idpatient');
    }
}
