<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'Invoices';

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

}
