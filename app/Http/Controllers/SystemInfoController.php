<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\SystemInfo;

class SystemInfoController extends Controller
{
    public function install()
    {

        $install = DB::table('installs')->first();

        if ($install && $install->status == 'F') {
            
            // $mac_ethernet = substr(shell_exec('getmac'), 159,17);
            // $mac_wireless = substr(exec('getmac'), 0,17);

            // $mac1 = $mac_ethernet;
            // $mac2 = $mac_wireless;

            // call getMac helper function //
            $mac1 = getMac();

            if ($mac1) {
                $system_info = new SystemInfo;
                $system_info->type = 'mac1';
                $system_info->value = $mac1;
                if ($system_info->save()) {
                    
                    if (Storage::disk('local')->put('system.txt', $mac1)) {
                        echo 'system configure successfully';
                        echo '<br>';

                        $insert_status = DB::table('installs')->where('id', $install->id)->update(['status'=>'T']);
                        if ($insert_status) {
                            echo 'installed successfully';
                        }

                    } else {
                        dd('system file not created for this app');
                    }
                } else {
                    dd('system data not saved for this app');
                }
            } else {
                dd('system data not found for this system');
            }

        } else {
            return redirect('/');
        }

    }
}
