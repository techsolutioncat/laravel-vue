<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    // ユーザー情報を削除する
    public function delete($id)
    {
        User::where('id', '=', $id)
            ->delete();
    }

    // ユーザー情報を更新する
    public function update($user)
    {
        User::where('id', '=', $user->id)
            ->update($user);
    }
}
