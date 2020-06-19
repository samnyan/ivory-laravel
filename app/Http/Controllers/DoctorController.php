<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Order;
use App\Patient;
use App\PatientCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @group Doctor
 * APIs for Doctor
 * @package App\Http\Controllers
 */
class DoctorController extends Controller
{
    /**
     * Create a new DoctorController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('certificate', ['except' => ['me', 'getCertificate', 'uploadCertificate']]);
    }

    /**
     * Upload certificate
     * Form request for upload a certificate image
     * @authenticated
     * @bodyParam certificate binary required The file of certificate image.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadCertificate(Request $request)
    {
        $path = $request->file('certificate')->store('certificate');
        $user = auth()->user();
        $user->certificate = $path;
        $user->certificate_checked = 1;
        $user->save();
        return response()->json(['message' => '上传成功', 'path' => $path]);
    }

    /**
     * Get clinic
     * Get clinic info of the user
     * @authenticated
     * @response {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "name": "达明口腔门诊部",
     * "city": "广州",
     * "position": "113.595114,23.544983",
     * "intro": "暂无介绍"
     * }
     * @return \App\Clinic|mixed|null
     */
    public function getClinic()
    {
        return auth()->user()->clinic;
    }

    /**
     * Create clinic
     * Create clinic for this doctor if this doctor doesn't belong to any clinic
     * @authenticated
     * @bodyParam name string required The name of the clinic. Example: 诊所
     * @bodyParam city string required The city of the clinic. Example: 广州
     * @bodyParam position string required The position of the clinic. Example: 23.544983,113.595114
     * @bodyParam address string required The address of the clinic. Example: 广州市从化区河东北路5号
     * @bodyParam intro string required The description of the clinic.
     * @param Request $request
     * @return Clinic|\Illuminate\Http\JsonResponse|mixed|null
     * @throws \Throwable
     */
    public function createClinic(Request $request)
    {
        $user = auth()->user();
        if ($user->clinic_id == null) {
            // Create clinic
            $request->validate([
                'name' => 'required',
                'city' => 'required',
                'position' => 'required',
                'address' => 'required',
                'intro' => 'required',
            ]);

            $clinic = new Clinic();
            $clinic->name = $request->get('name');
            $clinic->city = $request->get('city');
            $clinic->position = $request->get('position');
            $clinic->address = $request->get('address');
            $clinic->intro = $request->get('intro');

            $clinic->saveOrFail();

            $user->clinic_id = $clinic->id;
            $user->save();

            return $user->clinic;
        } else {
            return response()->json(['message' => '你已经添加过诊所了'], 409);
        }
    }

    /**
     * Upload clinic image
     * Upload clinic image with Form data, return the uploaded url.
     * @authenticated
     * @bodyParam image binary The image of the clinic.
     * @response {
     * "message": "上传成功",
     * "path": "clinic/xxx.jpg"
     * }
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadClinicImage(Request $request)
    {
        $path = $request->file('image')->store('clinic');
        $clinic = Clinic::whereId(auth()->user()->clinic_id)->firstOrFail();
        $clinic->image = $path;
        return response()->json(['message' => '上传成功', 'path' => $path]);
    }

    /**
     * Get patients
     * Get all patients created by this user.
     * @authenticated
     * @queryParam  page The page number to return. Example: 1
     * @response {
     * "current_page": 1,
     * "data": [
     * {
     * "id": "DLE200617083554",
     * "created_at": null,
     * "updated_at": null,
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "无"
     * }
     * ],
     * "first_page_url": "http://localhost:8000/api/doctor/patient?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/doctor/patient?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/doctor/patient",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPatients()
    {
        return Patient::whereUserId(auth()->id())->paginate(15);
    }

    /**
     * Get patient
     * Get patient by id.
     * @authenticated
     * @urlParam id required The ID of the case. Example: DLE200617083554
     * @response {
     * "id": "DLE200617083554",
     * "created_at": null,
     * "updated_at": null,
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "无",
     * "patient_cases": [
     * {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "patient_id": "DLE200617083554",
     * "user_id": 2,
     * "state": 2,
     * "features": "无症状",
     * "files": "{}",
     * "therapy_program": "无需治疗"
     * }
     * ]
     * }
     * @param $id integer
     * @return Patient|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPatient($id)
    {
        return Patient::whereId($id)->whereUserId(auth()->id())->with('patientCases')->firstOrFail();
    }

    /**
     * Create patient
     * Create a patient
     * @authenticated
     * @bodyParam name string required The name of the patient. Example: someone
     * @bodyParam age integer required The age of the patient. Example: 24
     * @bodyParam sex integer required The sex of the patient. Example: [0, 1, 2]
     * @bodyParam comments string required The comments of the patient. Example: Some content.
     * @param Request $request
     * @return Patient
     */
    public function createPatient(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required|between:0,2',
            'comments' => 'required'
        ]);

        $patient = new Patient();
        // Generate patient ID
        $patient->id = $this->generateRandomChar(3) . strval(date("ymdHis"));
        $patient->user_id = auth()->user()->id;
        $patient->name = request()->get('name');
        $patient->age = request()->get('age');
        $patient->sex = request()->get('sex');
        $patient->comments = request()->get('comments');
        $patient->save();

        return $patient;
    }

    /**
     * Get cases
     * Get all cases created by this user.
     * @authenticated
     * @response {
     * "current_page": 1,
     * "data": [
     * {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "patient_id": "DLE200617083554",
     * "user_id": 2,
     * "state": 2,
     * "features": "无症状",
     * "files": "{}",
     * "therapy_program": "无需治疗"
     * }
     * ],
     * "first_page_url": "http://localhost:8000/api/doctor/patientCase?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/doctor/patientCase?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/doctor/patientCase",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCases()
    {
        return PatientCase::whereUserId(auth()->id())->paginate(15);
    }

    /**
     * Get case
     * Get case by id
     * @authenticated
     * @urlParam id required The ID of the case. Example: 1
     * @response {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "patient_id": "DLE200617083554",
     * "user_id": 2,
     * "state": 2,
     * "features": "无症状",
     * "files": "{}",
     * "therapy_program": "无需治疗",
     * "orders": [
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
     * ]
     * }
     * @param Request $request
     * @param $id integer of case
     * @return PatientCase|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCase(Request $request, $id)
    {
        return PatientCase::whereId($id)->whereUserId(auth()->id())->with('orders')->firstOrFail();
    }

    /**
     * Get orders
     * Get all order related to this user
     * @authenticated
     * @queryParam page Page of the request. Example: 1
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
     * "first_page_url": "http://localhost:8000/api/doctor/order?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/doctor/order?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/doctor/order",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrders(Request $request)
    {
        $query = Order::whereDoctorId(auth()->id());
        if ($request->has('state')) {
            $query->whereState($request->get('state'));
        }
        return $query->paginate(15);
    }

    /**
     * Get order by id
     * @authenticated
     * @response {
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
     * "comments": "无备注",
     * "order_detail": [
     * {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "order_id": 1,
     * "product_no": "XXSD02",
     * "product_name": "器具",
     * "product_params": "{\"size\": 0}",
     * "product_count": 2,
     * "product_price": 20,
     * "customer_comments": "无备注"
     * }
     * ]
     * }
     * @param $id
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getOrder($id)
    {
        return Order::whereDoctorId(auth()->id())->whereKey($id)->with('orderDetail')->firstOrFail();
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'patient_case_id' => 'required',
            'product_count' => 'required',
            'address_id' => 'required|exists:addresses,id',
        ]);

        $user = auth()->user();

        $order = new Order();
        $order->clinic_id = $user->clinic->id;
        $order->user_id = $user->id;
        $order->patient_case_id = $request->get('patient_case_id');
        $order->is_fist = !Order::whereUserId($user->id)->exists();
        $order->state = 0;
        $order->product_count = $request->get('product_count');

    }

    function generateRandomChar($length = 2)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
