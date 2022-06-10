<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderTotal;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.dashboard.index');
    }

    public function loadChart()
    {
        $labels = array();
        $records = OrderTotal::orderBy('id', 'asc')->take(10)->get();
        if (!$records->isEmpty()) {
            $response['records'] = $records;
            $response['message'] = 'Request successful send';
            $response['statusCode'] = 200;
        } else {
            $response['message'] = 'Data not found';
            $response['statusCode'] = 404;
        }
        return response()->json($response);
    }
}
