<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Nota: se usa User::create() (no factory) para no depender de Faker,
     * que es una dependencia de desarrollo y no está en producción.
     */
    public function run(): void
    {
        // Roles del sistema (idempotente: no falla si ya existen).
        foreach (['admin', 'staff', 'client'] as $role) {
            Role::findOrCreate($role, 'web');
        }

        // Administrador: contraseña PRIVADA (no se publica en el repo).
        // Definí DEMO_ADMIN_PASSWORD en tu .env para conocerla; si no, será aleatoria.
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@demo.com',
            'password' => env('DEMO_ADMIN_PASSWORD', Str::random(40)),
        ]);
        $admin->assignRole('admin');

        // Personal de demostración (credenciales públicas, documentadas en el README).
        $staff = User::create([
            'name' => 'Personal Demo',
            'email' => 'personal@demo.com',
            'password' => 'demo12345',
        ]);
        $staff->assignRole('staff');

        // Cliente de demostración (credenciales públicas, documentadas en el README).
        $client = User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => 'demo12345',
        ]);
        $client->assignRole('client');

        // Servicios y horarios de atención.
        $this->call(OpeningHoursSeeder::class);
        $this->call(ServicesSeeder::class);

        // El personal de demo presta todos los servicios (para poder reservar con él).
        $staff->services()->sync(Service::pluck('id'));
    }
}
