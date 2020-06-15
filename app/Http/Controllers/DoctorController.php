<?php

namespace App\Http\Controllers;

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


}
