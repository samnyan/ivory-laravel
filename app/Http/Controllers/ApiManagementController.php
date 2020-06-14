<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ApiManagementController extends Controller
{
    public function getAllUsers()
    {
        $users = User::get();
        return response($users, 200);
    }

    public function getUser(Request $request)
    {
        $user = new User();
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'pwd' => 'required',
            'type' => 'required',
            'username' => 'required',
            'email' => 'required',
            'sex' => 'required',
        ]);

        $user = new User;
        $user->pwd = $request->get('pwd');
        $user->type = $request->get('type');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->sex = $request->get('sex');
        $user->age = $request->get('age');
        $user->save();

        return response($user, 200);
    }

    public function updateUser(Request $request)
    {

    }

    public function deleteUser(Request $request)
    {

    }
}
