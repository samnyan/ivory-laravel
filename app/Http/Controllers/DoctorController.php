<?php

namespace App\Http\Controllers;

use App\Order;
use App\Patient;
use App\PatientCase;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Get My account info
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get certificate
     * @authenticated
     * Get the uploaded certificate file
     * @response binary
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCertificate()
    {
        return Storage::download(auth()->user()->certificate);
    }

    /**
     * Upload certificate
     * @authenticated
     * Form request for upload a certificate image
     * @bodyParam certificate binary required The file of certificate image.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadCertificate(Request $request)
    {
        $path = $request->file('certificate')->store('certificate');
        $user = auth()->user();
        $user->certificate = $path;
        $user->save();
        return response()->json(['message' => '上传成功', 'path' => $path]);
    }

    /**
     * Get clinic
     * @authenticated
     * Get clinic info of the user
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

    public function updateClinic()
    {

    }

    /**
     * Get Patients
     * @authenticated
     * Get all patients created by this user.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPatients()
    {
        return Patient::whereUserId(auth()->id())->paginate(15);
    }

    /**
     * Get Patient
     * @authenticated
     * Get patient by id.
     * @pathParam id required The id of the patient.
     * @param Request $request
     * @return Patient|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPatient(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        return Patient::whereId($request->get('id'))->whereUserId(auth()->id())->firstOrFail();
    }

    /**
     * Create patient
     * @authenticated
     * Create a patient
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
     * @authenticated
     * Get all cases created by this user.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCases()
    {
        return PatientCase::whereUserId(auth()->user())->paginate(15);
    }

    /**
     * Get case
     * @authenticated
     * Get case by id
     * @urlParam id required The ID of the case
     * @param Request $request
     * @return PatientCase|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getCase(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        return PatientCase::whereId($request->get('id'))->whereUserId(auth()->id())->firstOrFail();
    }

    /**
     * Get orders
     * @authenticated
     * Get all order related to this user
     * @queryParam page Page of the request.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrders()
    {
        return Order::whereUserId(auth()->id())->paginate(15);
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
