<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    use HasFactory;
    
    protected $table = 'cups';
    protected $fillable = ['code', 'description'];

    public function receptions()
    {
        return $this->belongsToMany(Reception::class, 'reception_cups', 'cups_id', 'reception_id');
    }
}
