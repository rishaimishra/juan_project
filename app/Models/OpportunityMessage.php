<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityMessage extends Model
{
    use HasFactory;

    protected $table = 'opportunity_messages';
  
  protected $fillable = [
                'sender_id',
                'invoice_id',
                'opportunity_id',
                'reciever_id',
                'message',
                'image',
                'created_at',
                'updated_at'
            ];
}
