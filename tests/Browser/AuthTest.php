<?php

uses(Tests\DuskTestCase::class);
use Laravel\Dusk\Browser;

beforeEach(function (): void {
    if (! static::$migrationRun) {
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
        static::$migrationRun = true;
    }
});

test('login logout', function (): void {
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
            ->clickLink('Log in')
            ->waitFor('#email')
            ->type('#email', env('ADMIN_EMAIL'))
            ->type('#password', env('ADMIN_PASSWORD'))
            ->press('INICIAR SESIÓN')
            ->waitForLocation(route('dashboard'))
            ->waitForText('Jose Vicente')
            ->assertSee('Jose Vicente')
            ->press('#profile-dropdown-btn')
            ->waitForText('Finalizar sesión')
            ->assertSee('Finalizar sesión')
            ->press('Finalizar sesión')
            ->waitForLocation('/')
            ->assertSee('Log in');
    });
});

test('register', function (): void {
    $this->browse(function (Browser $browser): void {
        $browser->visit('/')
            ->clickLink('Register')
            ->waitFor('#name')
            ->type('#name', 'Test')
            ->type('#email', 'test@example.test')
            ->type('#password', 'password')
            ->type('#password_confirmation', 'password')
            ->press('REGISTRARSE')
            ->waitForLocation(route('dashboard'))
            ->assertSee('Test')
            ->press('#profile-dropdown-btn')
            ->waitForText('Perfil')
            ->assertSee('Perfil')
            ->clickLink('Perfil')
            ->waitForText('BORRAR CUENTA')
            ->assertSee('BORRAR CUENTA')
            ->press('BORRAR CUENTA')
            ->waitFor('#delete-user-password')
            ->type('#delete-user-password', 'password')
            ->press('#delete-user-btn')
            ->waitForLocation('/')
            ->assertSee('Log in');

        $this->assertDatabaseCount('users', 1);
    });
});

//    public function testMagic(): void
//    {
//        $this->browse(function (Browser $browser): void {
//            $browser->visit('/')
//                ->clickLink('Log in')
//                ->waitFor('#email')
//                ->type('#email', env('ADMIN_EMAIL'))
//                ->type('#password', env('ADMIN_PASSWORD'))
//                ->press('INICIAR SESIÓN')
//                ->waitForLocation(route('dashboard'))
//                ->magic();
//        });
//    }
