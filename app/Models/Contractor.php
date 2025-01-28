<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'tin',
        'license_num',
        'insurance_num',
        'address',
        'postal_code',
        'city',
        'country',
        'state',
        'representative_name',
        'last_name',
        'identity_document',
        'company_telephone',
        'mobile_num',
        'position',
        'company_type',
        'geographic_area',
        'email',
        'password',
        'countries',
        'states'
    ];


    protected $casts = [
        'states' => 'array',
        'countries' => 'array',
        'company_type' => 'array'
    ];
    public function country()
    {
        return $this->belongsTo(Paise::class,'country','id');
    }

    public function state()
    {
        return $this->belongsTo(Provincia::class,'state','id');
    }
    public function countryContractor()
    {
        return $this->belongsTo(Paise::class,'country','id');
    }

    public function stateContractor()
    {
        return $this->belongsTo(Provincia::class,'state','id');
    }


}
