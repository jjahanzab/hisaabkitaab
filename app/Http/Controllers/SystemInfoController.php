<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\SystemInfo;

class SystemInfoController extends Controller
{
    public function setup()
    {
        $mac_ethernet = substr(shell_exec('getmac'), 159,17);
        $mac_wireless = substr(exec('getmac'), 0,17);

        $mac1 = $mac_ethernet;
        $mac2 = $mac_wireless;

        if ($mac1) {
            $system_info = new SystemInfo;
            $system_info->type = 'mac1';
            $system_info->value = $mac1;
            if ($system_info->save()) {
                
                if (Storage::disk('local')->put('system.txt', $mac1)) {
                    echo 'system configure successfully';
                } else {
                    dd('system file not created');
                }
            } else {
                dd('mac not saved');
            }
        } else {
            dd('mac not found for this system');
        }
    }

    // public function createFile()
    // {
        // if (file_exists(storage_path('app/system.txt'))) {
        //     $contents = File::get(storage_path('app/system.txt'));
        //     dd($contents);
        // } else {
        //     return false;
        // }
        // $mac_wireless = substr(exec('getmac'), 0,17);
        // Storage::disk('local')->put('system.txt', $mac_wireless);
        // return true;
    // }
}
