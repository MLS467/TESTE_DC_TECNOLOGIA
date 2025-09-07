<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Smartphone XYZ',
                'description' => 'Smartphone com 128GB de armazenamento e 6GB de RAM',
                'price' => 1999.99,
            ],
            [
                'name' => 'Notebook ABC',
                'description' => 'Notebook 15” com processador Intel i7 e 16GB de RAM',
                'price' => 4999.99,
            ],
            [
                'name' => 'Fone de Ouvido Bluetooth',
                'description' => 'Fone sem fio com cancelamento de ruído',
                'price' => 299.99,
            ],
            [
                'name' => 'Smartwatch Tech',
                'description' => 'Relógio inteligente com monitor de batimentos cardíacos',
                'price' => 899.99,
            ],
            [
                'name' => 'Teclado Mecânico Gamer',
                'description' => 'Teclado RGB com switches mecânicos',
                'price' => 499.99,
            ],
            [
                'name' => 'Mouse Gamer RGB',
                'description' => 'Mouse ergonômico com alta precisão e iluminação RGB',
                'price' => 259.99,
            ],
            [
                'name' => 'Monitor 27” 4K',
                'description' => 'Monitor ultrafino 4K com painel IPS',
                'price' => 2199.99,
            ],
            [
                'name' => 'SSD 1TB NVMe',
                'description' => 'SSD de alta velocidade para jogos e produtividade',
                'price' => 749.99,
            ],
        ]);
    }
}