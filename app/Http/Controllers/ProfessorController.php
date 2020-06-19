<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;

/**
 * @group Professor
 * APIs for Professor
 * @package App\Http\Controllers
 */
class ProfessorController extends Controller
{

    /**
     * Get orders
     * @authenticated
     * Get order list
     * @queryParam state The state of order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货) . Example: 0
     * @queryParam page The page number to return. Example: 1
     * @response {
     * "current_page": 1,
     * "data": [
     * {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "clinic_id": 1,
     * "professor_id": 1,
     * "doctor_id": 2,
     * "patient_case_id": 1,
     * "is_first": 1,
     * "state": 0,
     * "product_count": 0,
     * "product_amount_total": null,
     * "order_amount_total": null,
     * "logistics_fee": null,
     * "address_id": 1,
     * "logistics_no": null,
     * "pay_channel": null,
     * "pay_no": null,
     * "delivery_time": null,
     * "pay_time": null,
     * "order_settlement_status": null,
     * "order_settlement_time": null,
     * "fapiao_id": null,
     * "comments": "无备注"
     * }
     * ],
     * "first_page_url": "http://localhost:8000/api/professor/order?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/professor/order?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/professor/order",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrders(Request $request)
    {
        if ($request->has('state')) {
            return Order::whereState($request->get('state'))->paginate(15);
        }
        return Order::paginate(15);
    }


    // Doctor management

    /**
     * Get Doctors
     * @authenticated
     * Get doctor list
     * @queryParam state The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过) . Example: 0
     * @queryParam page The page number to return. Example: 1
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDoctors(Request $request)
    {
        if ($request->has('state')) {
            return User::whereType(0)->where('certificate_checked', $request->get('state'))->paginate(15);
        }
        return User::whereType(0)->paginate(15);
    }

    /**
     * Get doctor
     * @authenticated
     * Get doctor by id
     * @urlParam id required The id of the doctor. Example: 1
     * @param $id
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getDoctor($id)
    {
        return User::whereType(0)->whereId($id)->firstOrFail();
    }

    /**
     * Update doctor
     * @authenticated
     * Update a doctor info
     * @urlParam id required The id of the doctor. Example: 1
     * @bodyParam certificateChecked integer The certificate state of the doctor. Example: 0
     * @bodyParam clinicId integer The clinic id of the doctor. Example: 0
     * @param Request $request
     * @param $id
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function setDoctor(Request $request, $id)
    {
        $doctor = User::whereType(0)->whereId($id)->firstOrFail();
        if ($request->has('certificateChecked')) {
            $request->validate(['certificateChecked' => 'required|numeric|between:0,3']);
            $doctor->certificate_checked = $request->get('certificateChecked');
        }

        if ($request->has('clinicId')) {
            $request->validate(['clinicId' => 'required|numeric']);
            $doctor->clinic_id = $request->get('clinicId');
        }

        $doctor->saveOrFail();
        return $doctor;
    }
}
