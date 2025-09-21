<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    protected $table = 'receptions';

    protected $fillable = [
        'user_id',
        'patient_id',
        'observations',
        'status',
        'priority',
        'type_samples',
        'consecutive',
        'quantity_samples',
        'number_case',
        'type_study',
        'color',
        'quantity_plates',
        'departure_date',
        'delivered_to',
    ];

    // 🔗 Relación con la tabla CUPS many to many
    public function cups()
    {
        return $this->belongsToMany(Cup::class, 'reception_cups', 'reception_id', 'cups_id');
    }

    // relacion con el paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

