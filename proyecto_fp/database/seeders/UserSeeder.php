<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarioejemplo=[
            [
                "nombre"=>'admin',
                "email"=>'admin@admin.com',
                "password"=>'admin@admin'
            ],
            [
                "nombre"=>'bejexi4412',
                "email"=>'bejexi4412@kuandika.com',
                "password"=>'bejexi4412'
            ],
            [
                "nombre"=>'neyeri3080',
                "email"=>'neyeri3080@gufutu.com',
                "password"=>'neyeri3080'
            ],
            [
                "nombre"=>'fatraces',
                "email"=>'fatraces@yevme.com',
                "password"=>'fatraces@yevme.com'
            ],
            [
                "nombre"=>'zinewwu5yu',
                "email"=>'zinewwu5yu@qacmjeq.com',
                "password"=>'zinewwu5yu'
            ],
            [
                "nombre"=>'kfp11817',
                "email"=>'kfp11817@bcooq.com',
                "password"=>'kfp11817'
            ],
            [
                "nombre"=>'pclusemfxqsxffokgd',
                "email"=>'pclusemfxqsxffokgd@hthlm.com',
                "password"=>'pclusemfxqsxffokgd'
            ],
            [
                "nombre"=>'kendarius.wyman',
                "email"=>'kendarius.wyman@megasend.org',
                "password"=>'kendarius.wyman'
            ],
        ];
        
        
        foreach($usuarioejemplo as $u){        
            DB::table('usuario')->insert([
                'nombre' => $u['nombre'],
                'email' => $u['email'],
                'password' => Hash::make($u['password']),
            ]);
        }
        
    }
}
