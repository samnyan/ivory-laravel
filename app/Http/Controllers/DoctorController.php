<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Order;
use App\OrderDetail;
use App\Patient;
use App\PatientCase;
use Illuminate\Http\Request;

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
            $user->saveOrFail();

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
     * @response {
     * "id": "0",
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "0",
     * "updated_at": "2020-06-26T13:43:15.000000Z",
     * "created_at": "2020-06-26T13:43:15.000000Z"
     * }
     * @param Request $request
     * @return Patient
     * @throws \Throwable
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
        $patient->saveOrFail();

        return $patient;
    }

    /**
     * Get patient cases
     * Get all patient cases created by this user.
     * @authenticated
     * @queryParam page Page of the request. Example: 1
     * @queryParam state The state of case (-1已取消 0创建 1资料已提交(医生) 2资料需修改 3方案已制定(专家) 4方案待修改 5方案已同意 6已确认 7已下单 8订单已确认 10已存档) . Example: 0
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
     * "therapy_program": "无需治疗",
     * "patient": {
     * "id": "DLE200617083554",
     * "created_at": null,
     * "updated_at": null,
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "无"
     * }
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
    public function getCases(Request $request)
    {
        $query = PatientCase::whereUserId(auth()->id())->with('patient');
        if ($request->has('state')) {
            $query->whereState($request->get('state'));
        }
        return $query->paginate(15);
    }

    /**
     * Get patient case
     * Get patient case by id
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
     * "patient": {
     * "id": "DLE200617083554",
     * "created_at": null,
     * "updated_at": null,
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "无"
     * },
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
     * "comments": "无备注"
     * },
     * {
     * "id": 2,
     * "created_at": "2020-06-20T02:55:40.000000Z",
     * "updated_at": "2020-06-20T02:58:48.000000Z",
     * "clinic_id": 1,
     * "professor_id": 3,
     * "doctor_id": 2,
     * "patient_case_id": 1,
     * "is_first": 0,
     * "state": 0,
     * "product_count": null,
     * "total_price": 1.2,
     * "payment_price": null,
     * "shipping_fee": null,
     * "pay_method": null,
     * "pay_number": null,
     * "pay_time": null,
     * "tracking_number": null,
     * "address_id": null,
     * "shipping_time": null,
     * "fapiao_id": null,
     * "comments": "还行"
     * }
     * ]
     * }
     * @param Request $request
     * @param $id integer of case
     * @return PatientCase|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCase(Request $request, $id)
    {
        return PatientCase::whereId($id)->whereUserId(auth()->id())->with(['patient', 'orders'])->firstOrFail();
    }

    /**
     * Create patient case
     * Create a patient case base on a patient
     * @authencated
     * @bodyParam patient_id string required The patient id. Example: PAT0315091509
     * @bodyParam features string required The patient case detail. Example: Some content.
     * @response {
     * "patient_id": "DLE200617083554",
     * "user_id": 2,
     * "state": 0,
     * "features": "Something",
     * "updated_at": "2020-06-26T13:35:35.000000Z",
     * "created_at": "2020-06-26T13:35:35.000000Z",
     * "id": 3
     * }
     * @param Request $request
     * @return PatientCase
     * @throws \Throwable
     */
    public function createCase(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id', // Create a case base on patient
            'features' => 'required'
        ]);

        $doctor = auth()->user();

        $patient = Patient::whereId($request->get('patient_id'))->firstOrFail();

        $case = new PatientCase();
        $case->patient_id = $patient->id;
        $case->user_id = $doctor->id;
        $case->state = 0;
        $case->features = $request->get('features');
        $case->saveOrFail();
        return $case;
    }

    /**
     * Update patient case
     * Update the patient case detail
     * @authenticated
     * @urlParam id required The ID of the case. Example: 1
     * @bodyParam state integer The state of this patient case. Example: 1.
     * @bodyParam features string The patient case detail. Example: Some content.
     * @bodyParam files json The required files (path) related to this patient case, in json format. Example: {photo1: '/case/1234.jpg'}.
     * @response {
     * "id": 3,
     * "created_at": "2020-06-26T13:35:35.000000Z",
     * "updated_at": "2020-06-26T13:35:35.000000Z",
     * "patient_id": "DLE200617083554",
     * "user_id": 2,
     * "state": 0,
     * "features": "Something",
     * "files": null,
     * "therapy_program": null
     * }
     * @param Request $request
     * @param $id
     * @return PatientCase|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function updateCase(Request $request, $id)
    {
        $rule = [
            'state' => 'numeric',
            'features' => 'string',
            'files' => 'json'
        ];

        $request->validate($rule);
        $case = PatientCase::whereUserId(auth()->id())->whereId($id)->firstOrFail();

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $case->$k = $request->get($k);
            }
        }

        $case->saveOrFail();
        return $case;
    }

    /**
     * Upload case files
     * Form request for upload a any files relate to a patient case (Such as images)
     * @authenticated
     * @bodyParam file binary required The file of certificate image.
     * @response {
     * "message": "上传成功",
     * "path": "patientCase/DRUCjs92FfgYEXY0DFTa5OUSrivUADxqB4sxPopS.jpeg"
     * }
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadCaseFile(Request $request)
    {
        $path = $request->file('file')->store('patientCase');
        return response()->json(['message' => '上传成功', 'path' => $path]);
    }

    /**
     * Get orders
     * Get all order related to this user
     * @authenticated
     * @queryParam page Page of the request. Example: 1
     * @queryParam state The state of order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货) . Example: 0
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
     * Get order
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

        $doctor = auth()->user();

        $order = new Order();
        $order->clinic_id = $doctor->clinic_id;
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
     * @urlParam id required The id of the order. Example: 1
     * @bodyParam state integer The state of the order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货). Example: 1
     * @bodyParam product_count integer The total product count of the order. Example: 1
     * @bodyParam total_price double The total price of the order. Example: 1
     * @bodyParam address_id integer The address id of the order. Example: 1
     * @bodyParam comments string The comments id of the order. Example: 1
     * @response {
     * "id": 2,
     * "created_at": "2020-06-20T08:42:49.000000Z",
     * "updated_at": "2020-06-20T08:43:32.000000Z",
     * "order_id": 2,
     * "product_no": "SFX221",
     * "product_name": "Some Product",
     * "product_params": "{\"size\": \"100cm\"}",
     * "product_count": 3,
     * "product_price": 155.2,
     * "customer_comments": "Comments content"
     * }
     * @param Request $request
     * @param $id
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::whereId($id)->firstOrFail();
        $rule = [
            'state' => 'numeric|between:0,7',
            'product_count' => 'numeric',
            'total_price' => 'numeric',
            'address_id' => 'numeric',
            'comments' => 'string'
        ];
        $request->validate($rule);

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $order->$k = $request->get($k);
            }
        }

        $order->saveOrFail();
        return $order;
    }

    /**
     * Create order detail
     * Create an order detail
     * @authenticated
     * @urlParam id required The id of the order. Example: 1
     * @bodyParam product_no required integer The product number of the order detail. Example: 1
     * @bodyParam product_name string The product number of the order detail. Example: ""
     * @bodyParam product_params json_string The product parameters of the order detail. Example: { some: data }
     * @bodyParam product_count required integer The product count of the product. Example: 15
     * @bodyParam product_price required double The product price of the product. Example: 115.5
     * @bodyParam customer_comments string The comments of the detail. Example: ""
     * @response {
     * "order_id": 2,
     * "product_no": "SFX220",
     * "product_name": "Some Product",
     * "product_params": "{\"size\": \"100cm\"}",
     * "product_count": 3,
     * "product_price": 155.2,
     * "customer_comments": "Comments content",
     * "updated_at": "2020-06-20T08:42:49.000000Z",
     * "created_at": "2020-06-20T08:42:49.000000Z",
     * "id": 2
     * }
     * @param Request $request
     * @param $id
     * @return OrderDetail
     * @throws \Throwable
     */
    public function createOrderDetail(Request $request, $id)
    {
        $order = Order::whereDoctorId(auth()->id())->whereId($id)->firstOrFail();

        $rule = [
            'product_no' => 'required|max:30',
            'product_name' => 'string|max:30',
            'product_params' => 'json',
            'product_count' => 'required|numeric',
            'product_price' => 'required|numeric',
            'customer_comments' => 'string|max:255'
        ];
        $request->validate($rule);

        $detail = new OrderDetail();
        $detail->order_id = $order->id;

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $detail->$k = $request->get($k);
            }
        }

        $detail->saveOrFail();

        return $detail;
    }

    /**
     * Update order detail
     * Update order detail by order and order detail id.
     * @authenticated
     * @urlParam id required The id of the order. Example: 1
     * @urlParam detailId required The id of the order detail. Example: 1
     * @bodyParam product_no integer The product number of the order detail. Example: 1
     * @bodyParam product_name string The product number of the order detail. Example: ""
     * @bodyParam product_params json_string The product parameters of the order detail. Example: { some: data }
     * @bodyParam product_count integer The product count of the product. Example: 15
     * @bodyParam product_price double The product price of the product. Example: 115.5
     * @bodyParam customer_comments string The comments of the detail. Example: ""
     * @response {
     * "id": 2,
     * "created_at": "2020-06-20T08:42:49.000000Z",
     * "updated_at": "2020-06-20T08:43:32.000000Z",
     * "order_id": 2,
     * "product_no": "SFX221",
     * "product_name": "Some Product",
     * "product_params": "{\"size\": \"100cm\"}",
     * "product_count": 3,
     * "product_price": 155.2,
     * "customer_comments": "Comments content"
     * }
     * @param Request $request
     * @param $id
     * @param $detailId
     * @return OrderDetail|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function updateOrderDetail(Request $request, $id, $detailId)
    {
        $detail = OrderDetail::whereOrderId($id)->whereId($detailId)->firstOrFail();
        $rule = [
            'product_no' => 'max:30',
            'product_name' => 'string|max:30',
            'product_params' => 'json',
            'product_count' => 'numeric',
            'product_price' => 'numeric',
            'customer_comments' => 'string|max:255'
        ];
        $request->validate($rule);

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $detail->$k = $request->get($k);
            }
        }

        $detail->saveOrFail();

        return $detail;
    }

    /**
     * Delete order detail
     * @authenticated
     * @urlParam id required The id of the order. Example: 1
     * @urlParam detailId required The id of the order detail. Example: 1
     * @param $id
     * @param $detailId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteOrderDetail($id, $detailId)
    {
        $detail = OrderDetail::whereOrderId($id)->whereId($detailId)->firstOrFail();
        $detail->delete();
        return response()->json(['message' => '删除成功']);
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
