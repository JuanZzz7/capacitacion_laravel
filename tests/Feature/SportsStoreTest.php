<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\SportsStoreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportsStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SportsStoreSeeder::class);
    }

    public function test_catalog_displays_products_and_categories(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SUPERÁ TUS');
        $response->assertSee('LÍMITES');
        $response->assertSee('Kinetic Velocity Nitro Pro');
        $response->assertSee('Running');
    }

    public function test_catalog_filters_by_category(): void
    {
        $response = $this->get('/catalogo?category=running');

        $response->assertStatus(200);
        $response->assertSee('Kinetic Velocity Nitro Pro');
    }

    public function test_product_detail_page_displays_telemetry_and_variants(): void
    {
        $product = Product::where('slug', 'kinetic-velocity-nitro-pro')->first();

        $response = $this->get("/producto/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('198 g');
        $response->assertSee('Full Carbon K-Wave 3K');
        $response->assertSee('Añadir a la Bolsa');
    }

    public function test_cart_operations(): void
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $product = Product::first();

        // 1. Add to cart
        $addResponse = $this->post('/carrito/agregar', [
            'product_id' => $product->id,
            'quantity' => 1,
            'size' => '42 EU',
            'color' => 'Negro / Naranja Lava',
        ]);

        $addResponse->assertRedirect('/carrito');

        // 2. View cart
        $cartResponse = $this->get('/carrito');
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($product->name);
        $cartResponse->assertSee('42 EU');

        // 3. Apply coupon
        $couponResponse = $this->post('/carrito/cupon', [
            'coupon_code' => 'KINETIC15',
        ]);
        $couponResponse->assertRedirect('/carrito');
        $couponResponse->assertSessionHas('applied_coupon', 'KINETIC15');
    }

    public function test_auth_page_renders_login_and_register_tabs(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Bienvenido de vuelta');
        $response->assertSee('Crea tu Cuenta Pro');
        $response->assertSee('15% OFF');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/registro', [
            '_form' => 'register',
            'name' => 'Maratonista Pro',
            'email' => 'maratonista@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'maratonista@example.com',
        ]);
    }
}
