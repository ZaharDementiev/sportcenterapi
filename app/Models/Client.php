<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public const CLIENT = 'client';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
