<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'username'  => 'rifa',
                'password'  => password_hash('admin', PASSWORD_BCRYPT),
                'name'      => 'Admin',
                'roles'     => 'admin'
            ],
            [
                'username' => 'hana',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'name' => 'Admin',
                'roles' => 'admin'
            ]
        ];
        $this->db->table('admin')->insertBatch($data);
    }
}
