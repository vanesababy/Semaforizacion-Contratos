<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Permission::create(['name' => 'listar usuarios']);
        // Permission::create(['name' => 'actualizar usuarios']);
        // Permission::create(['name' => 'eliminar usuarios']);

        // // Crear roles y asignar permisos
        // $admin = Role::create(['name' => 'admin']);
        // $admin->givePermissionTo(['listar usuarios', 'actualizar usuarios', 'eliminar usuarios']);

        // $user = Role::create(['name' => 'user']);
        // $user->givePermissionTo('listar usuarios');
        
    
        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('123'),
        // ])->assignRole('admin');

        // User::factory()->create([
        //     'name' => 'Basic User',
        //     'email' => 'user@gmail.com',
        //     'password' => bcrypt('123'),
        // ])->assignRole('user');


        $permissions = ['listar usuarios', 'actualizar usuarios', 'eliminar usuarios','listar roles'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(['listar usuarios', 'actualizar usuarios', 'eliminar usuarios','listar roles']);

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo('listar usuarios');
        
        // Crear o actualizar el usuario de administración
        $this->createOrUpdateUser('admin@gmail.com', '123456789', 'Admin User', 'admin');

        // Crear o actualizar el usuario básico
        $this->createOrUpdateUser('user@gmail.com', '987654321', 'Basic User', 'user');
    }

    /**
     * Método para crear o actualizar un usuario
     */
    private function createOrUpdateUser($email, $identificacion, $name, $role)
    {
        // Buscar si el usuario con el correo existe
        $user = User::where('email', $email)->first();

        // Si el usuario existe, comprobar si la identificación es la misma
        if ($user) {
            // Si la identificación no coincide, creamos un nuevo correo con un número añadido
            if ($user->identificacion !== $identificacion) {
                $newEmail = $this->getUniqueEmail($email);
                $user = User::create([
                    'name' => $name,
                    'email' => $newEmail,
                    'identificacion' => $identificacion,
                    'password' => bcrypt('123'),
                ]);
            } else {
                // Si la identificación coincide, solo actualizamos el rol
                $user->assignRole($role);
            }
        } else {
            // Si el usuario no existe, creamos uno nuevo
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'identificacion' => $identificacion,
                'password' => bcrypt('123'),
            ]);
            $user->assignRole($role);
        }
    }

    /**
     * Generar un correo único agregando un número al final del correo
     */
    private function getUniqueEmail($email)
    {
        $originalEmail = $email;
        $counter = 1;

        // Obtener solo la parte antes del '@' para añadir el número
        $emailParts = explode('@', $email);
        $baseEmail = $emailParts[0];
        $domain = $emailParts[1];

        // Comprobar si el correo ya existe y agregar el número
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@' . $domain;
            $counter++;
        }

        return $email;
    }
}
