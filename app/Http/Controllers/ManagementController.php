<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Order;
use App\User;

/**
 * @group Management
 * APIs for Management
 * @package App\Http\Controllers
 */
class ManagementController extends Controller
{
    //

    public function getUsers()
    {
        return User::paginate(15);
    }

    public function getUser($id)
    {
        return User::whereId($id)->firstOrFail();
    }

    public function getClinics()
    {
        return Clinic::paginate(15);
    }

    public function getClinic($id)
    {
        return Clinic::whereId($id)->firstOrFail();
    }

    public function getOrders()
    {
        return Order::paginate(15);
    }

    public function getOrder($id)
    {
        return Order::whereId($id)->firstOrFail();
    }
}
