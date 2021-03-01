<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    use HasFactory;

    public const MONEY = 'money';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
