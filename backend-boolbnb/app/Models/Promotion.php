<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration'];

    /**
     * Apartments relation
     */
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('end_date');
    }
}
