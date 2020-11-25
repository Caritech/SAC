<?php

namespace Modules\ContactInformation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactInformation\Entities\PersonalDetail;

class AxiosGetController extends Controller
{
    public function get_contact(Request $request)
    {
        $sort = $request->input('sort') ?? null;
        $page = $request->input('page') ?? null;
        $per_page = $request->input('per_page') ?? null;

        $data = PersonalDetail::select(
            'FirstName',
            'Surname',
            'ChineseName',
            'PreferName',
            'Active'
        );

        $data = $data->paginate($per_page);

        return \Response::json($data);
    }
}
