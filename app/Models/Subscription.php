<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public const SUBSCRIPTION = 'sub';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
