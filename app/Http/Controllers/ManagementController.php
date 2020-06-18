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

    /**
     * Get all users
     * @authenticated
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsers()
    {
        return User::paginate(15);
    }

    /**
     * Get user
     * @authenticated
     * Get user by id
     * @urlParam id required The ID of the user
     * @param $id
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getUser($id)
    {
        return User::whereId($id)->firstOrFail();
    }

    /**
     * Get all clinic
     * @authenticated
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getClinics()
    {
        return Clinic::paginate(15);
    }

    /**
     * Get clinic
     * @authenticated
     * Get clinic by id
     * @urlParam id required The ID of the clinic
     * @param $id
     * @return Clinic|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getClinic($id)
    {
        return Clinic::whereId($id)->firstOrFail();
    }

    /**
     * Get all order
     * @authenticated
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrders()
    {
        return Order::paginate(15);
    }

    /**
     * Get order
     * @authenticated
     * Get order by id
     * @urlParam id required The ID of the order
     * @param $id
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getOrder($id)
    {
        return Order::whereId($id)->firstOrFail();
    }
}
