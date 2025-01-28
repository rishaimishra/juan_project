<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $table = 'opportunities';

    protected $fillable = [
        'contractor_id',
        'bidUser_id',
        'opportunity_name',
        'state',
        'window_with_name',
        'city',
        'project_type',
        'est_amount',
        'est_time',
        'best_time',
        'purchase_finalize',
        'detail_description',
        'opp_keep_time',
        'save_bit',
        'admin_bit',
        'language'
    ];

    public function state()
    {
        return $this->belongsTo(Provincia::class, 'state','id');
    }

}
