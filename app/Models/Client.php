<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, CrudTrait;

    protected $guarded = ['id'];
    public $timestamps = true;

    public const CLIENT = 'client';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function userGym()
    {
        $gym = Address::where('id', $this->gym_id)->first();
        return $gym->city . ', ' . $gym->address;
    }

    public function userTrainer()
    {
        return User::where('id', $this->trainer_id)->first()->name;
    }
}
