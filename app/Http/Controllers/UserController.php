<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withoutBanned()->paginate($request->get('per_page'));
    }
}
