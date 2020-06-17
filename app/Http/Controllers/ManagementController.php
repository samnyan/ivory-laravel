<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Order;
use App\User;
use Request;

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

    public function getUser(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        return User::whereId($request->get('id'))->firstOrFail();
    }

    public function getClinics()
    {
        return Clinic::paginate(15);
    }

    public function getClinic(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        return Clinic::whereId($request->get('id'))->firstOrFail();
    }

    public function getOrders()
    {
        return Order::paginate(15);
    }

    public function getOrder(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        return Order::whereId($request->get('id'))->firstOrFail();
    }
}
