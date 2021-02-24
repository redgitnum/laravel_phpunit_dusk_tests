<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_list_of_products_when_logged()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();
        $this->followRedirects($response)->assertViewHas('products');
    }

    public function test_add_product_to_database_successfully_when_logged()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        $this->post('/dashboard/add', [
            'name' => 'Testitem',
            'count' => 45,
            'location' => 'Boston'
        ])->assertSessionHas('success');
        $this->assertDatabaseHas('products', [
            'name' => 'Testitem'
        ]);

    }

    public function test_fail_to_add_product_with_wrong_input_to_database_when_logged()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $this->post('/dashboard/add', [
            'name' => 'Testitem',
            'count' => 5000,
            'location' => 'London'
        ])->assertSessionHasErrors();
    }

    public function test_fail_to_create_product_with_existing_name_in_database_when_logged()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $this->post('/dashboard/add', [
            'name' => 'TestItem',
            'count' => 50,
            'location' => 'London'
        ])->assertSessionHasNoErrors();

        $this->post('/dashboard/add', [
            'name' => 'TestItem',
            'count' => 30,
            'location' => 'Berlin'
        ])->assertSessionHas('duplicate');
    }

    public function test_fail_to_create_product_as_guest()
    {
        $this->post('/dashboard/add', [
            'name' => 'TestItem',
            'count' => 30,
            'location' => 'Berlin'
        ])->assertRedirect('/login');
    }
}
