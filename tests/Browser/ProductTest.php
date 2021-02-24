<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends DuskTestCase
{
    
    public function test_create_and_delete_product()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'testman@pl')
                    ->type('password', 'password')
                    ->press('LOG IN');
            $browser->type('name', 'TestItem')
                    ->type('count', 50)
                    ->type('location', 'Boston')
                    ->press('Submit')
                    ->waitForLocation('/dashboard');
            $browser->with('table>tbody>tr:nth-child(1)', function ($row) {
                $row->assertSee('DELETE')
                    ->press('DELETE');
            });
            $browser->assertDontSee('DELETE');
        });
        
    }
}
