<?php

namespace App\Http\Controllers;

use App\Order;
use App\Patient;
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

    public function getClinic()
    {
        return auth()->user()->clinic;
    }

    public function getPatients()
    {
        return Patient::whereUserId(auth()->id())->paginate(15);
    }

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

    public function updateClinic()
    {

    }

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
