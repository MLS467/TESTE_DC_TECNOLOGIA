<?php

namespace Database\Seeders;

use App\Models\client\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Client::factory()->count(10)->create();

        DB::table('clients')->insert([
            [
                'name' => 'Ichigo Kurosaki',
                'cpf' => '11111111111',
            ],
            [
                'name' => 'Rukia Kuchiki',
                'cpf' => '22222222222',
            ],
            [
                'name' => 'Renji Abarai',
                'cpf' => '33333333333',
            ],
            [
                'name' => 'Byakuya Kuchiki',
                'cpf' => '44444444444',
            ],
            [
                'name' => 'Toshiro Hitsugaya',
                'cpf' => '55555555555',
            ],
            [
                'name' => 'Soi Fon',
                'cpf' => '66666666666',
            ],
            [
                'name' => 'Kenpachi Zaraki',
                'cpf' => '77777777777',
            ],
            [
                'name' => 'Yachiru Kusajishi',
                'cpf' => '88888888888',
            ],
            [
                'name' => 'Uryu Ishida',
                'cpf' => '99999999999',
            ],
            [
                'name' => 'Orihime Inoue',
                'cpf' => '00000000000',
            ],
        ]);
    }
}