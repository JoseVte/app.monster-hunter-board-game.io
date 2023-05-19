<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
