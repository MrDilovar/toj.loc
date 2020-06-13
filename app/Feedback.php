<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [
        'appeal',
        'categoryAppeal',
        'contactName',
        'contactPhone',
        'contactEmail',
        'contactReview'
    ];
}
