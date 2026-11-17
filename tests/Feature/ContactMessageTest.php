<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_accepts_thirty_submissions_per_hour_then_throttles(): void
    {
        $response = $this->postJson('/contact', [
            'name' => 'Pengunjung Situs',
            'email' => 'pengunjung@example.com',
            'topic' => 'Lainnya',
            'message' => 'Saya ingin menanyakan informasi lebih lanjut.',
            'consent' => 'yes',
        ]);

        $response->assertCreated()
            ->assertJsonPath('email_sent', true);
        $this->assertDatabaseCount('contact_messages', 1);

        for ($attempt = 2; $attempt <= 30; $attempt++) {
            $this->postJson('/contact', ['website' => 'bot-field'])
                ->assertAccepted();
        }

        $this->postJson('/contact', ['website' => 'bot-field'])
            ->assertTooManyRequests();
    }
}
