<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\MailingTravel;
use Mail;
use App\MailingList;

class SendMailingTravel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails_count = MailingList::count();
        $offset = 0;
        $limit = 200;
        $all_emails = [];
        for ($i = 0; $i < ceil($emails_count / $limit); $i++) {
            $part_mails = MailingList::select('email')->offset($offset)->limit($limit)->get()->pluck('email');
            foreach ($part_mails->all() as $email) {
                $all_emails[] = $email;
            }
            $offset = $offset + $limit;
        }
        if (count($all_emails) > 0) {
            Mail::to($all_emails)->send(new MailingTravel($this->data));
        }
    }
}
