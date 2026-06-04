<?php

/**
 * Control de acceso por roles.
 *
 * Rutas y middleware (ver routes/web.php):
 *  - /my-schedule    -> auth + role:client   (invitado: redirige a login)
 *  - /staff-scheduler-> auth + role:staff    (invitado: redirige a login; rol incorrecto: 403)
 *  - /users          -> auth + role:admin    (invitado: redirige a login; rol incorrecto: 403)
 */

// --- Invitados (sin autenticar) -> redirigidos al login ---

it('redirige al login a los invitados que entran al área de cliente', function () {
    $this->get('/my-schedule')->assertRedirect('/login');
});

it('redirige al login a los invitados que entran al área de personal', function () {
    $this->get('/staff-scheduler')->assertRedirect('/login');
});

it('redirige al login a los invitados que entran al área de administración', function () {
    $this->get('/users')->assertRedirect('/login');
});

// --- Cliente ---

it('prohíbe a un cliente el área de personal', function () {
    $this->actingAs(userWithRole('client'))
        ->get('/staff-scheduler')
        ->assertForbidden();
});

it('prohíbe a un cliente el área de administración', function () {
    $this->actingAs(userWithRole('client'))
        ->get('/users')
        ->assertForbidden();
});

// --- Personal (staff) ---

it('prohíbe al personal el área de cliente', function () {
    $this->actingAs(userWithRole('staff'))
        ->get('/my-schedule')
        ->assertForbidden();
});

it('prohíbe al personal el área de administración', function () {
    $this->actingAs(userWithRole('staff'))
        ->get('/users')
        ->assertForbidden();
});

// --- Administrador ---

it('permite al administrador acceder al listado de usuarios', function () {
    $this->actingAs(userWithRole('admin'))
        ->get('/users')
        ->assertOk();
});
