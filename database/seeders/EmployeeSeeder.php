<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // pakai locale Indonesia jika perlu
        $password = Hash::make('12345');

        $phone = $faker->unique()->numerify('08##########');
        $nik = '2025' . str_pad(1, 3, '0', STR_PAD_LEFT);
        Employee::create([
            'nik' => $nik,
            'name' => $faker->firstName('male') . ' ' . $faker->lastName('male'),
            'phone' => $phone,
            'address' => $faker->address,
            'active' => $faker->boolean(90),

            'password' => $password,
            'remember_token' => Str::random(10),
            'last_login_datetime' => null,
            'last_activity_description' => '',
            'last_activity_datetime' => null,

            'created_datetime' => now(),
            'updated_datetime' => now(),
            'created_by_uid' => 1,
            'updated_by_uid' => 1,
        ]);

        for ($i = 2; $i <= 10; $i++) {
            $phone = $faker->unique()->numerify('08##########');
            $nik = $faker->randomElement(['2023', '2024', '2025']) . str_pad($i, 3, '0', STR_PAD_LEFT);

            Employee::create([
                'nik' => $nik,
                'name' => $faker->firstName('male') . ' ' . $faker->lastName('male'),
                'phone' => $phone,
                'address' => $faker->address,
                'active' => $faker->boolean(90),

                'password' => $password,
                'remember_token' => Str::random(10),
                'last_login_datetime' => null,
                'last_activity_description' => '',
                'last_activity_datetime' => null,

                'created_datetime' => now(),
                'updated_datetime' => now(),
                'created_by_uid' => 1,
                'updated_by_uid' => 1,
            ]);
        }
    }
}
