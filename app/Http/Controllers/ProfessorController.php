<?php

namespace App\Http\Controllers;

use App\Order;
use App\PatientCase;
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
     * Get order list
     * @authenticated
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
     * "product_count": 3,
     * "total_price": 1000,
     * "payment_price": 998,
     * "shipping_fee": 14,
     * "pay_method": 1,
     * "pay_number": "15233958572390",
     * "pay_time": "2020-06-19 13:26:43",
     * "tracking_number": "SF000002231231",
     * "address_id": 1,
     * "shipping_time": "2020-06-19 13:26:43",
     * "fapiao_id": 1,
     * "comments": "无备注",
     * "doctor": {
     * "id": 2,
     * "username": "测试医生"
     * },
     * "clinic": {
     * "id": 1,
     * "name": "达明口腔门诊部"
     * }
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
        $query = Order::query();
        if ($request->has('state')) {
            $query->whereState($request->get('state'));
        }
        return $query->with('doctor:id,username')->with('clinic:id,name')->paginate(15);
    }

    /**
     * Create order
     * Create a order from patient case. This request only require a case id, other information should fill in with update request.
     * @authenticated
     * @bodyParam patient_case_id integer required The patient case id. Example: 1
     * @response {
     * "clinic_id": 1,
     * "professor_id": 3,
     * "doctor_id": 2,
     * "patient_case_id": 1,
     * "is_first": false,
     * "state": 0,
     * "updated_at": "2020-06-20T02:55:40.000000Z",
     * "created_at": "2020-06-20T02:55:40.000000Z",
     * "id": 2
     * }
     * @param Request $request
     * @return Order
     * @throws \Throwable
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'patient_case_id' => 'required|exists:patient_cases,id', // This is the most important id.
        ]);

        $patientCase = PatientCase::whereId($request->get('patient_case_id'))->firstOrFail();

        $professor = auth()->user();
        $doctor = User::whereId($patientCase->user_id)->firstOrFail();

        $order = new Order();
        $order->clinic_id = $doctor->clinic_id;
        $order->professor_id = $professor->id;
        $order->doctor_id = $doctor->id;
        $order->patient_case_id = $patientCase->id;
        $order->is_first = !Order::whereDoctorId($doctor->id)->exists();
        $order->state = 0;
        $order->saveOrFail();

        return $order;
    }

    /**
     * Update order
     * Update order information
     * @authenticated
     * @param Request $request
     * @param $id
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::whereId($id)->firstOrFail();
        $rule = [
            'clinicId' => 'numeric',
            'professor_id' => 'numeric',
            'doctor_id' => 'numeric',
            'is_first' => 'boolean',
            'state' => 'numeric|between:0,7',
            'product_count' => 'numeric',
            'total_price' => 'numeric',
            'payment_price' => 'numeric',
            'shipping_fee' => 'numeric',
            'pay_method' => 'numeric',
            'pay_number' => 'numeric',
            'pay_time' => 'date',
            'tracking_number' => 'string|max:30',
            'address_id' => 'numeric',
            'shipping_time' => 'date',
            'fapiao_id' => 'numeric',
            'comments' => 'string'
        ];
        $request->validate($rule);

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $order->$k = $request->get($k);
            }
        }

        $order->save();
        return $order;
    }

    // Doctor management

    /**
     * Get doctors
     * Get doctor list
     * @authenticated
     * @queryParam state The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过) . Example: 0
     * @queryParam page The page number to return. Example: 1
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDoctors(Request $request)
    {
        $query = User::query()->whereType(0);
        if ($request->has('state')) {
            $query->where('certificate_checked', $request->get('state'));
        }
        if ($request->has('clinicId')) {
            $query->where('clinic_id', $request->get('clinicId'));
        }
        return $query->paginate(15);
    }

    /**
     * Get doctor
     * Get doctor by id
     * @authenticated
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
     * Update a doctor info, mainly use to set the certificate status of a doctor.
     * @authenticated
     * @urlParam id required The id of the doctor. Example: 1
     * @bodyParam certificateChecked integer The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过). Example: 0
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
