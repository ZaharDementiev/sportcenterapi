<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function login(Request $request)
    {
        $client = Client::where('phone', $request->input('name'))->first();
        if (Hash::check($request->input('password'), $client->password)) {
            setcookie(Client::CLIENT, $client->id, time() + 7200, '/');
        }
        return redirect()->back();
    }

    public function register(Request $request)
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->phone = $request->input('phone');
        $client->password = Hash::make($request->input('password'));
        $client->save();
        setcookie(Client::CLIENT, $client->id, time() + 7200, '/');
        return redirect()->back();
    }

    public function logout()
    {
        setcookie(Client::CLIENT, 0, time() + 0, '/');
        return redirect()->back();
    }
}
