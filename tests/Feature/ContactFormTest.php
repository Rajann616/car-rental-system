<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submits_and_notifies_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry About Luxury Sedan',
            'message' => 'Hello, I would like to book a luxury sedan for 3 days.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Notification::assertSentTo(
            $admin,
            AdminNotification::class,
            function ($notification, $channels) {
                return in_array('database', $channels);
            }
        );
    }
}
