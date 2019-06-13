<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Response;
use DB;
use App\User;
use Log;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Collection;


class ModalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_delete(request $request): \Illuminate\Http\Response
    {
        $id = $request->input('id');
        $delete_url = $request->input('delete_url');
        $model = $request->input('model');
        $field_name = $request->input('field_name');

        $Model = $model::findOrFail($id);

        return response()->view('modals.confirm_delete', compact('Model', 'delete_url', 'field_name'));
    }
}
