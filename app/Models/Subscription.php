<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, CrudTrait;

    protected $guarded = ['id'];
    public $timestamps = true;

    public const SUBSCRIPTION = 'sub';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
