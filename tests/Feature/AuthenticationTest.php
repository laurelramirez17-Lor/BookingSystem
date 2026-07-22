<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_pages(): void
    {
        $this->get(route('bookings.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('bookings.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_is_redirected_to_login_from_customer_booking_page(): void
    {
        $this->get(route('customer.book.create'))
            ->assertRedirect(route('login'));
    }

    public function test_customer_can_access_booking_form(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        $this->get(route('customer.book.create'))
            ->assertOk();
    }

    public function test_customer_is_redirected_to_booking_page_after_login(): void
    {
        $customer = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => 'password',
            'role' => 'customer',
        ]);

        $this->post(route('login.store'), [
            'email' => 'customer@example.com',
            'password' => 'password',
        ])->assertRedirect(route('customer.book.create'));

        $this->assertAuthenticatedAs($customer);
    }

    public function test_customer_cannot_access_admin_pages(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->actingAs($customer)
            ->get(route('bookings.index'))
            ->assertForbidden();
    }
}
