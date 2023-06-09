<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    public function setUp() :void {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }


    public function test_products_page_is_empty(): void
    {
        $response = $this->get('/products');
        
        $response->assertStatus(200);

        $response->assertSee("No Produts Found");
    }


    public function test_products_page_has_products(): void
    {
        $product = Product::create([
            'name' => 'Product 1',
            'price' => 12.6
        ]);
        
        $response = $this->get('/products');

        $response->assertStatus(200);

        $response->assertSee("Product 1");
        $response->assertDontSee("No Produts Found");

        // Below is better approch 
        // products here is variable passed in view from our controller 
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });

    }

    public function test_only_admin_can_see_create_product_button(): void 
    {
        $response = $this->actingAs($this->admin)
                        ->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Create Product');
    }

    public function test_only_admin_can_create_products(): void 
    {
        $admin = $this->createUser(isAdmin: true);

        $response = $this->actingAs($admin)
                        ->get('/product/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_create_products(): void
    {
        $response = $this->actingAs($this->user)
                        ->get('/product/create');

        $response->assertStatus(302);
    }

    public function test_product_stored_successfuly(): void 
    {
        $product = [
            'name' => 'Mobile Phone 2',
            'price' => 12
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/product/create',$product);

        $response->assertStatus(302);
        $response->assertRedirect('products');
        
        $this->assertDatabaseHas('products',$product);

        // Also check if product was already stored or just created now

        $lastProduct = Product::latest()->first();
        $product = (object) $product;

        $this->assertEquals($product->name, $lastProduct->name);
        $this->assertEquals($product->price, $lastProduct->price);
    }

    public function test_product_edit_from_has_correct_values(): void 
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)
                        ->get('product/'.$product->id.'/edit');

        $response->assertStatus(200);
        $response->assertSee('value="'.$product->name.'"',false);
        $response->assertSee('value="'.$product->price.'"',false);
        
        $response->assertViewHas('product',$product);

    }

    public function test_product_update_validation_redirect_back_with_errors(): void 
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)
                        ->post('product/'.$product->id.'/update',[
                            'name' => '',
                            'price' => 52.3,
                        ]);
                       
        $response->assertStatus(302);
        // $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name', 'price']);


    }

    private function createUser(bool $isAdmin = false) {
        
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
