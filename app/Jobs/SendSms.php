<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Twilio\Rest\Client;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


	protected $sid = 'ACc39c5f363356dbad72e211a12aba1171';
	protected $token = '94a3c31c03984c213793129bd9c0c389';
	protected $from = '+15879059090';
	protected $body,$phone;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone,$body)
    {
        $this->body = $body;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$client = new Client($this->sid, $this->token);

		$client->messages->create(
			$this->phone,
			array(
				'from' => $this->from,
				'body' => $this->body
			)
		);
    }
}
