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

    /**
     * Get clinics
     * Get clinic list
     * @queryParam name Search clinic by name. Example: 牙科医院
     * @queryParam city Filter clinic by city. Example: 广州
     * @queryParam page The page number to return. Example: 1
     * @response {
     * "current_page": 1,
     * "data": [
     * {
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
     * ],
     * "first_page_url": "http://localhost:8000/api/open/clinic?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://localhost:8000/api/open/clinic?page=1",
     * "next_page_url": null,
     * "path": "http://localhost:8000/api/open/clinic",
     * "per_page": 15,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
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

    /**
     * Get clinic
     * Get clinic by id
     * @urlParam id required The ID of the clinic
     * @response {
     * "id": 1,
     * "created_at": null,
     * "updated_at": null,
     * "name": "达明口腔门诊部",
     * "city": "广州",
     * "image": "http://pic136.huitu.com/res/20200110/2350458_20200110022605051080_1.jpg",
     * "position": "23.544983,113.595114",
     * "address": "广州市从化区河东北路5号",
     * "intro": "暂无介绍",
     * "users": [
     * {
     * "clinic_id": 1,
     * "username": "测试医生",
     * "school": "没读大学",
     * "major": "忽悠专业"
     * }
     * ]
     * }
     * @param $id
     * @return Clinic|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getClinic($id)
    {
        return Clinic::whereId($id)->with('users:clinic_id,username,school,major')->firstOrFail();
    }
}
