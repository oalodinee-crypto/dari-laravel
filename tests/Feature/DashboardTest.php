<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_buildings()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/buildings');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_units()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/units');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_contracts()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/contracts');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_invoices()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/invoices');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_notifications()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/notifications');
        $response->assertStatus(200);
    }

    public function test_admin_can_export_buildings()
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->first();
        
        $response = $this->actingAs($admin)->get('/export/buildings');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
