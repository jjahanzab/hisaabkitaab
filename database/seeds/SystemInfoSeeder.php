<?php

use Illuminate\Database\Seeder;
use App\SystemInfo;

class SystemInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $mac_ethernet = substr(shell_exec('getmac'), 159,20);

        // call getMac helper function //
        $mac_ethernet = getMac();

        if ($mac_ethernet) {
            SystemInfo::create([
                'type' => 'mac1',
                'value' => $mac_ethernet,
            ]);
        } else {
            echo 'mac1 not found';
        }

        // $mac_wireless = substr(exec('getmac'), 0,17);
        // if ($mac_wireless) {
        //     SystemInfo::create([
        //         'type' => 'mac_wireless',
        //         'value' => $mac_wireless,
        //     ]);
        // } else {
        //     echo 'mac2 not found';
        // }
    }
}
