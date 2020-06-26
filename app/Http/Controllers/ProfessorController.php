<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
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
     * Get patient cases
     * Get patient case list
     * @authenticated
     * @queryParam state The state of patient case (-1已取消 0创建 1资料已提交(医生) 2资料需修改 3方案已制定(专家) 4方案待修改 5方案已同意 6已确认 7已下单 8订单已确认 10已存档) . Example: 0
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
     * "first_page_url": "http://localhost:8000/api/professor/patientCase?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/professor/patientCase?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/professor/patientCase",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPatientCases(Request $request)
    {
        $query = PatientCase::query();
        if ($request->has('state')) {
            $query->whereState($request->get('state'));
        }
        return $query->with('patient')->paginate(15);
    }

    /**
     * Get patient case
     * Get patient case by id
     * @authenticated
     * @urlParam id required The id of the patient case. Example: 1
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
     * ],
     * "patient": {
     * "id": "DLE200617083554",
     * "created_at": null,
     * "updated_at": null,
     * "name": "某人",
     * "age": 10,
     * "sex": 0,
     * "comments": "无",
     * "doctor": null
     * }
     * }
     * @param Request $request
     * @param $id
     * @return PatientCase|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPatientCase(Request $request, $id)
    {
        return PatientCase::whereId($id)->with(['orders', 'patient', 'patient.doctor'])->firstOrFail();
    }

    /**
     * Update patient case
     * Update the patient case detail
     * @authenticated
     * @urlParam id required The ID of the case. Example: 1
     * @bodyParam state integer The state of this patient case. Example: 1.
     * @bodyParam therapy_program string The therapy program for this case. Example: Some detailed information.
     * @param Request $request
     * @param $id
     * @return bool
     * @throws \Throwable
     */
    public function updatePatientCase(Request $request, $id) {
        $rule = [
            'state' => 'numeric',
            'therapy_program' => 'string',
        ];

        $request->validate($rule);
        $case = PatientCase::whereId($id)->firstOrFail();

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $case->$k = $request->get($k);
            }
        }

        return $case->saveOrFail();
    }

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
     * Get order
     * Get order by id
     * @authenticated
     * @urlParam id required The id of the order. Example: 1
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
     * "clinic": {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "name": "达明口腔门诊部",
     * "city": "广州",
     * "image": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "position": "23.544983,113.595114",
     * "address": "广州市从化区河东北路5号",
     * "intro": "暂无介绍"
     * },
     * "doctor": {
     * "id": 2,
     * "created_at": null,
     * "updated_at": null,
     * "username": "测试医生",
     * "email": "me@example.com",
     * "type": 0,
     * "sex": 0,
     * "age": 24,
     * "head_portrait": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "clinic_id": 1,
     * "mobile": "+8613800000000",
     * "fix_phone_number": "",
     * "certificate": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "certificate_checked": 2,
     * "wechat": "00000",
     * "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
     * "school": "没读大学",
     * "major": "忽悠专业"
     * },
     * "fapiao": null,
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
     * ],
     * "address": {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "user_id": 2,
     * "real_name": "某医生",
     * "telephone": "13800000000",
     * "country": 86,
     * "province": 44,
     * "city": 1,
     * "area": 84,
     * "street": "某街道",
     * "zip": 500000,
     * "is_default": 1
     * }
     * }
     * @param $id
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getOrder($id)
    {
        return Order::whereId($id)->with(['clinic', 'doctor', 'fapiao', 'orderDetail', 'address'])->firstOrFail();
    }

    /**
     * Update order
     * Update order information
     * @authenticated
     * @urlParam id required The id of the order. Example: 1
     * @bodyParam clinic_id integer The clinic id of the order. Example: 1
     * @bodyParam professor_id integer The professor user id of who create this order. Example: 1
     * @bodyParam doctor_id integer The doctor id of the patient case belong to. Example: 1
     * @bodyParam is_first boolean Is this first order for the doctor. Example: 1
     * @bodyParam state integer The state of the order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货). Example: 1
     * @bodyParam product_count integer The total product count of the order. Example: 1
     * @bodyParam total_price double The total price of the order. Example: 1
     * @bodyParam payment_price double The actual payment amount of the order, usually total price - discount + shipping fee. Example: 1
     * @bodyParam shipping_fee double The shipping fee of the order. Example: 1
     * @bodyParam pay_method integer The pay method of the order (0=cash, 1=Alipay, 2=WechatPay). Example: 1
     * @bodyParam pay_number string The the payment id of the external payment platform, like alipay. Example: 1
     * @bodyParam pay_time datetime The payment time of the order. Example: 1
     * @bodyParam tracking_number string The tracking number of the package. Example: 1
     * @bodyParam address_id integer The address id of the order. Example: 1
     * @bodyParam shipping_time datetime The shipping time of the order. Example: 1
     * @bodyParam fapiao_id integer The fapiao id of the order. Example: 1
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
     */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::whereId($id)->firstOrFail();
        $rule = [
            'clinic_id' => 'numeric',
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
        $order = Order::whereId($id)->firstOrFail();

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

    // Doctor management

    /**
     * Get doctors
     * Get doctor list
     * @authenticated
     * @queryParam state The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过) . Example: 0
     * @queryParam page The page number to return. Example: 1
     * @response {
     * "current_page": 1,
     * "data": [
     * {
     * "id": 2,
     * "created_at": null,
     * "updated_at": null,
     * "username": "测试医生",
     * "email": "me@example.com",
     * "type": 0,
     * "sex": 0,
     * "age": 24,
     * "head_portrait": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "clinic_id": 1,
     * "mobile": "+8613800000000",
     * "fix_phone_number": "",
     * "certificate": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "certificate_checked": 2,
     * "wechat": "00000",
     * "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
     * "school": "没读大学",
     * "major": "忽悠专业"
     * }
     * ],
     * "first_page_url": "http://localhost:8000/api/professor/doctor?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/professor/doctor?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/professor/doctor",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
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
     * @response {
     * "id": 2,
     * "created_at": null,
     * "updated_at": null,
     * "username": "测试医生",
     * "email": "me@example.com",
     * "type": 0,
     * "sex": 0,
     * "age": 24,
     * "head_portrait": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "clinic_id": 1,
     * "mobile": "+8613800000000",
     * "fix_phone_number": "",
     * "certificate": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "certificate_checked": 2,
     * "wechat": "00000",
     * "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
     * "school": "没读大学",
     * "major": "忽悠专业",
     * "clinic": {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "name": "达明口腔门诊部",
     * "city": "广州",
     * "image": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "position": "23.544983,113.595114",
     * "address": "广州市从化区河东北路5号",
     * "intro": "暂无介绍"
     * }
     * }
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getDoctor($id)
    {
        return User::whereType(0)->whereId($id)->with('clinic')->firstOrFail();
    }

    /**
     * Update doctor
     * Update a doctor info, mainly use to set the certificate status of a doctor.
     * @authenticated
     * @urlParam id required The id of the doctor. Example: 1
     * @bodyParam certificate_checked integer The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过). Example: 0
     * @bodyParam clinic_id integer The clinic id of the doctor. Example: 0
     * @param Request $request
     * @param $id
     * @response {
     * "id": 2,
     * "created_at": null,
     * "updated_at": null,
     * "username": "测试医生",
     * "email": "me@example.com",
     * "type": 0,
     * "sex": 0,
     * "age": 24,
     * "head_portrait": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "clinic_id": 1,
     * "mobile": "+8613800000000",
     * "fix_phone_number": "",
     * "certificate": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "certificate_checked": 2,
     * "wechat": "00000",
     * "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
     * "school": "没读大学",
     * "major": "忽悠专业"
     * }
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function setDoctor(Request $request, $id)
    {
        $doctor = User::whereType(0)->whereId($id)->firstOrFail();
        $rule = [
            'certificate_checked' => 'numeric|between:0,3',
            'clinic_id' => 'numeric|exist:clinic,id'
        ];
        $request->validate($rule);

        foreach ($rule as $k => $v) {
            if ($request->has($k)) {
                $doctor->$k = $request->get($k);
            }
        }

        $doctor->saveOrFail();
        return $doctor;
    }
}
