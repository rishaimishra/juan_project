<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biduser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'postal_code',
        'city',
        'country',
        'state',
        'last_name',
        'identity_document',
        'home_telephone',
        'mobile_num',
        'association',
        'email',
        'password',
    ];
}
