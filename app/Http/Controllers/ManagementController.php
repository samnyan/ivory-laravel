<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Order;
use App\User;

class ManagementController extends Controller
{
    //

    public function getUsers()
    {
        return User::paginate(15);
    }

    public function getClinics()
    {
        return Clinic::paginate(15);
    }

    public function getOrders()
    {
        return Order::paginate(15);
    }
}
