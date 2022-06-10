<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        $response = array();
        $setting = Setting::first();
        $response['setting'] = $setting;
        return view('backend.settings.edit', $response);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'shop_name' => 'required',
        ]);

        $setting = Setting::first();

        if ($setting) {
        } else {
            $setting = new Setting;
        }

        $setting->shop_name = $request->shop_name;
        $setting->shop_contact = $request->shop_contact ? $request->shop_contact : NULL;
        $setting->address = $request->address ? $request->address : NULL;

        if($setting->save()) {
            return redirect()->back()->with(['successMessage'=>'Setting saved successfully.']);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Error in setting saving.']);
        }

    }
}
