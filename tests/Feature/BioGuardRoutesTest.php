<?php

namespace Tests\Feature;

use App\Models\IncidentLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BioGuardRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database with demo data
        $this->seed();
        $this->adminUser = User::where('email', 'admin@bioguard.id')->first();
    }

    /**
     * Test root redirect.
     */
    public function test_root_redirects_to_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test dashboard page.
     */
    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Pusat Kendali Logistik Medis');
        $response->assertSee('TERHUBUNG');
        $response->assertSee('Kurir Aktif');
        $response->assertSee('Sinkronisasi Tertunda');
    }

    /**
     * Test guest redirected to login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test login view.
     */
    public function test_login_view_loads_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk Portal Admin');
    }

    /**
     * Test login process.
     */
    public function test_login_process_authenticates_user(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@bioguard.id',
            'password' => 'password'
        ]);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test logout process.
     */
    public function test_logout_process_clears_auth(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test profile view.
     */
    public function test_profile_view_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/profil');
        $response->assertStatus(200);
        $response->assertSee('Profil Dispatcher Admin');
        $response->assertSee($this->adminUser->name);
    }

    /**
     * Test profile update.
     */
    public function test_profile_update_saves_data(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/profil', [
            'name' => 'Operator Bio-Guard Palembang',
            'dispatcher_id' => 'DSP-PLB-NEW',
        ]);
        $response->assertStatus(302);
        $this->assertEquals('Operator Bio-Guard Palembang', $this->adminUser->fresh()->name);
        $this->assertEquals('DSP-PLB-NEW', $this->adminUser->fresh()->dispatcher_id);
    }

    /**
     * Test API Key regeneration.
     */
    public function test_regenerate_api_key(): void
    {
        $oldKey = $this->adminUser->iot_api_key;
        $response = $this->actingAs($this->adminUser)->postJson('/profil/regenerate-key');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        
        $newKey = $this->adminUser->fresh()->iot_api_key;
        $this->assertNotEquals($oldKey, $newKey);
        $this->assertStringStartsWith('bg_api_', $newKey);
    }

    /**
     * Test shipments page.
     */
    public function test_shipments_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/pengiriman');
        $response->assertStatus(200);
        $response->assertSee('Pengiriman');
        $response->assertSee('Vaksin Sinovac');
    }

    /**
     * Test sensors/analytics page.
     */
    public function test_sensors_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/sensor');
        $response->assertStatus(200);
        $response->assertSee('Laporan');
        $response->assertSee('Indeks Efisiensi Rute');
    }

    /**
     * Test alerts page.
     */
    public function test_alerts_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/peringatan');
        $response->assertStatus(200);
        $response->assertSee('Peringatan Sistem Global');
        $response->assertSee('Aliran Insiden Aktif');
    }

    /**
     * Test fleet page.
     */
    public function test_fleet_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/armada');
        $response->assertStatus(200);
        $response->assertSee('Pelacakan Armada Aktif');
        $response->assertSee('Ahmad Fadillah');
    }

    /**
     * Test inventory/inventaris page.
     */
    public function test_inventory_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/inventaris');
        $response->assertStatus(200);
        $response->assertSee('Inventaris');
        $response->assertSee('Total Hub Faskes');
    }

    /**
     * Test inventory search functionality.
     */
    public function test_inventory_page_search_works(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/inventaris?search=Mohammad+Hoesin');
        $response->assertStatus(200);
        $response->assertSee('RSUP Dr. Mohammad Hoesin');
        $response->assertSee('HOSP-');
    }

    /**
     * Test old routes redirects to Indonesian paths.
     */
    public function test_old_english_routes_redirect_properly(): void
    {
        $this->actingAs($this->adminUser)->get('/shipments')->assertRedirect('/pengiriman');
        $this->actingAs($this->adminUser)->get('/sensors')->assertRedirect('/sensor');
        $this->actingAs($this->adminUser)->get('/alerts')->assertRedirect('/peringatan');
        $this->actingAs($this->adminUser)->get('/fleet')->assertRedirect('/armada');
    }

    /**
     * Test live data API endpoints.
     */
    public function test_live_data_api_endpoints(): void
    {
        $response1 = $this->actingAs($this->adminUser)->getJson('/api/dashboard/live-data');
        $response1->assertStatus(200);
        $response1->assertJsonStructure([
            'success',
            'stats' => [
                'total_kurir_aktif',
                'total_pending_sync',
                'alert_count'
            ],
            'data'
        ]);

        $response2 = $this->actingAs($this->adminUser)->getJson('/api/dashboard/map-data');
        $response2->assertStatus(200);
        $response2->assertJson(['success' => true]);

        $response3 = $this->actingAs($this->adminUser)->getJson('/api/fleet/live');
        $response3->assertStatus(200);
        $response3->assertJson(['success' => true]);

        $response4 = $this->actingAs($this->adminUser)->getJson('/api/fleet/live-location');
        $response4->assertStatus(200);
        $response4->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id_rute',
                    'nama_kurir',
                    'nomor_kendaraan',
                    'lokasi_tujuan',
                    'id_box',
                    'latitude',
                    'longitude',
                    'suhu_aktual',
                    'excursion_status',
                    'status_label',
                    'text_class'
                ]
            ]
        ]);
    }

    /**
     * Test resolve incident AJAX POST.
     */
    public function test_resolve_incident_endpoint(): void
    {
        $incident = IncidentLog::where('status', 'aktif')->first();
        $this->assertNotNull($incident);

        $response = $this->actingAs($this->adminUser)->postJson("/peringatan/{$incident->id}/resolve");
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Insiden berhasil dikonfirmasi dan ditandai selesai.'
        ]);

        $this->assertEquals('resolved', $incident->fresh()->status);
    }
}
