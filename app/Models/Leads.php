<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = [
        'name', 'email', 'phone', 'country', 'state', 'city',
    ];
}
