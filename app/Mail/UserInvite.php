<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

use App\User;

class UserInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User which should be invited.
     *
     * @var App\User
     */
    protected $user;

    /**
     * Password of the invited user.
     *
     * @var string
     */
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(sprintf('Herzlich Willkommen bei %s', Config::get('app.name')))
            ->view('mail.user.invite')
            ->text('mail.user.invite_text')
            ->with([
                'name' => $this->user->name,
                'url' => route('auth.login'),
                'password' => $this->password,
            ]);
    }
}
