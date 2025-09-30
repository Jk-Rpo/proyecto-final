<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    public $timestamps = true;

    protected $fillable = [
           'identity_type',
           'identity', 
           'first_name', 
           'second_name', 
           'first_surname', 
           'second_surname',
           'birthdate',
           'gender', 
           'address', 
           'email',
           'phone', 

    ];

    // Relación con Recepciones
    public function receptions()
    {
        // Importante: especificar la clave foránea porque tu PK no es "id"
        return $this->hasMany(Reception::class, 'patient_id', 'Idpatient');
    }
}
