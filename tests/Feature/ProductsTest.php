<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

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
}
