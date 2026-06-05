<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('guest cannot access dashboard and is shown unauthorized page', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(403);
    $response->assertSee('403 Unauthorized');
    $response->assertSee('Login Kembali');
});

test('admin login page can be rendered', function () {
    $response = $this->get('/login/admin');

    $response->assertStatus(200);
    $response->assertSee('Portal Admin');
    $response->assertSee('Login sebagai Staff');
});

test('staff login page can be rendered', function () {
    $response = $this->get('/login/staff');

    $response->assertStatus(200);
    $response->assertSee('Portal Staff');
    $response->assertSee('Login sebagai Admin');
});

test('admin can log in via admin login page', function () {
    $admin = User::factory()->create([
        'username' => 'admin_test',
        'password' => bcrypt('password'),
        'role' => 'ADMIN',
    ]);

    $response = $this->post('/login/admin', [
        'username' => 'admin_test',
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($admin);
});

test('staff can log in via staff login page', function () {
    $staff = User::factory()->create([
        'username' => 'staff_test',
        'password' => bcrypt('password'),
        'role' => 'STAFF',
    ]);

    $response = $this->post('/login/staff', [
        'username' => 'staff_test',
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($staff);
});

test('admin cannot log in via staff login page', function () {
    User::factory()->create([
        'username' => 'admin_test',
        'password' => bcrypt('password'),
        'role' => 'ADMIN',
    ]);

    $response = $this->post('/login/staff', [
        'username' => 'admin_test',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

test('staff cannot log in via admin login page', function () {
    User::factory()->create([
        'username' => 'staff_test',
        'password' => bcrypt('password'),
        'role' => 'STAFF',
    ]);

    $response = $this->post('/login/admin', [
        'username' => 'staff_test',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

test('user can log out', function () {
    $admin = User::factory()->create([
        'username' => 'admin_test',
        'password' => bcrypt('password'),
        'role' => 'ADMIN',
    ]);

    $this->actingAs($admin);

    $response = $this->post('/logout');

    $response->assertRedirect('/login/admin');
    $this->assertGuest();
});
