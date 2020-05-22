<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralLink extends Mailable
{
    use Queueable, SerializesModels;

	protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->subject('Joining invitation from '.$this->user->first_name)
            ->view('emails.referral',['user'=>$this->user]);
        //return $this->view('emails.referral');
    }
}
