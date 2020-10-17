<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('admin.admin_name')) {
            User::firstOrCreate(
                ['email' => config('admin.admin_email')], [
                    'name' => config('admin.admin_name'),
                    'password' => bcrypt(config('admin.admin_password')),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'api_token' => Str::random(32),
                    'bank_account' =>'100000123456789',
                ]
            );
        }
        factory(User::class, 10)->create();
    }
}
