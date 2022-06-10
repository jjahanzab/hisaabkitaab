<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Closure;
use App\SystemInfo;

class CheckSystemInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mac_ethernet = substr(shell_exec('getmac'), 159,20);
        $mac_wireless = substr(exec('getmac'), 0,17);

        $mac1 = $mac_ethernet;
        $mac2 = $mac_wireless;

        $systeminfo = SystemInfo::where('type', 'mac1')->where('value', $mac1)->first();
        if ($systeminfo) {

            if (file_exists(storage_path('app/system.txt'))) {
                $contents = File::get(storage_path('app/system.txt'));

                if ($systeminfo->value == $contents) {
                    
                } else {
                    return response()->json('Local Sytem is not valid for this app');
                }
                
            } else {
                return response()->json('This Sytem is not valid for this app');
            }
        } else {
            return response()->json('Sytem is not valid for this app');
        }

        return $next($request);
    }
}
