<?php 

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Contracts\iUserService;
use App\Traits\Crud;


class UserService implements iUserService
{
    use Crud;


    public function index ($request)
    {
        $users = User::all();

        return $users;

    }
}