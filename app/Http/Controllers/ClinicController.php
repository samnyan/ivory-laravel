<?php

namespace App\Http\Controllers;

use App\Clinic;
use Illuminate\Http\Request;

/**
 * @group Clinic
 * Public APIs for getting clinic info.
 * @package App\Http\Controllers
 */
class ClinicController extends Controller
{

    public function getClinics(Request $request)
    {
        $size = $request->get('size', 15);
        if ($request->has('name')) {
            return Clinic::where('name', 'LIKE', '%' . $request->get('name') . '%')
                ->paginate($size)->appends($request->query());
        }
        if ($request->has('city')) {
            return Clinic::where('city', 'LIKE', '%' . $request->get('city') . '%')
                ->paginate($size)->appends($request->query());
        }
        return Clinic::paginate($size);
    }

    public function getClinic($id)
    {
        return Clinic::whereId($id);
    }
}
