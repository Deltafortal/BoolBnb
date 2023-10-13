<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'date', 'apartment_id'];

    //*** RELATIONS ***//
    /**
     * Apartments relation
     */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }


    //*** UTILITIES ***//
    /**
     * Format a date field
     */
    public function getDate($date_field, $format = 'd/m/y H:i')
    {
        return Carbon::create($this->$date_field)
            ->format($format);
    }
}
