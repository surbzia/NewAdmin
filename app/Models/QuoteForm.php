<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'description',
        'condition',
        'quantity',
        'quote_id',
        'phone',
    ];
}
