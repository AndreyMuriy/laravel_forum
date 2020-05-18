<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar11',
            'password_confirmation' => 'foobar11',
        ]);

        $notificationUrl = new VerifyEmail();
        $user = User::whereName('John')->first();
        $uri = $notificationUrl->

        $this->assertNull($user->email_verified_at);

    }
}
