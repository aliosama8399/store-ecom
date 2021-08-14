<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin ::create([
            'name'=>'ali osama',
            'email'=>'alo@gmail',
            'password'=>'$2a$10$BIP.tG.DmeiCqnQ9bYZWSeencfcWiraQQbolQ6HHLTyhPSP4ECZ12',
            'role_id'=>1





        ]);

    }
}
