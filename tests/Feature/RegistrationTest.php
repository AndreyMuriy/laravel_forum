<?php

namespace Tests\Feature;

use App\User;
use Config;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use URL;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar11',
            'password_confirmation' => 'foobar11',
        ]);

        /** @var Notifiable $user */
        $user = User::where('email', '=', 'john@example.com')->first();
        $this->assertFalse($user->hasVerifiedEmail());

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        $this->get($verificationUrl);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
