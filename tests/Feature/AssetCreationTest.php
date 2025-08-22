<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssetCreationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guest_cannot_access_admin_asset_create_page(): void
    {
        $response = $this->get('/admin/assets/create');

        $response->assertStatus(302);
    }

    public function test_admin_can_view_create_asset_form(): void
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.assets.create'));

        $response->assertOk();
        $response->assertViewIs('admin.assets.create-assets');
    }

    public function test_store_validates_required_fields(): void
    {
        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.assets.store'), [
            // intentionally empty to trigger required validation rules
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name',
            'category_id',
            'purchase_date',
            'purchase_price',
        ]);
    }

    public function test_admin_can_create_asset_persists_and_generates_qr(): void
    {
        // Prepare minimal supporting tables for validation and foreign key
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function ($table) {
                $table->id();
                $table->string('name');
            });
        }

        if (!Schema::hasTable('asset_categories')) {
            Schema::create('asset_categories', function ($table) {
                $table->id();
                $table->string('name');
            });
        }

        // Insert a category with the same id in both tables to satisfy validation and FK
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Laptops',
        ]);
        DB::table('asset_categories')->insert([
            'id' => $categoryId,
            'name' => 'Laptops',
        ]);

        Storage::fake('public');

        $admin = new Admin([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $this->actingAs($admin, 'admin');

        $payload = [
            'name' => 'Dell XPS 13',
            'description' => 'Developer laptop',
            'category_id' => $categoryId,
            'purchase_date' => now()->toDateString(),
            'purchase_price' => 1299.99,
        ];

        $response = $this->postJson(route('admin.assets.store'), $payload);

        $response->assertCreated();
        $response->assertJsonStructure([
            'message',
            'asset' => [
                'id', 'name', 'category_id', 'purchase_date', 'purchase_price', 'qr_code_data', 'qr_code_path', 'asset_image_path', 'qr_code_generated_at', 'created_at', 'updated_at'
            ],
        ]);

        $asset = $response->json('asset');

        // Assert DB persistence
        $this->assertDatabaseHas('assets', [
            'id' => $asset['id'],
            'name' => 'Dell XPS 13',
            'category_id' => $categoryId,
        ]);

        // Assert QR code file written to public disk
        Storage::disk('public')->assertExists($asset['qr_code_path']);
    }
}


