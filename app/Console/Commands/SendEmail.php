<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto send email in project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $max = env('NUM_SUBMISSIONS_MAX', 5);

        $emails = Email::where('status', '<>', 0)->where('num_submissions', '<', $max)->get();

        if (!empty($emails)) {
            foreach ($emails as $email) {
                $subject = $email->subject;
                $to = $email->to;
                $parameter = json_decode($email->parameter, true);
                $view = $email->view;

                // check empty mail
                if (!empty($to)) {

                    Mail::send($view, ['parameter' => $parameter] , function($messages) use ($subject, $to){
                        $messages->to($to)->subject($subject);
                        $messages->from('no-reply@natec.gov.vn','NATEC');
                    });

                    $email->num_submissions += 1;

                    if (!empty(Mail::failures())) {
                        $email->status = 1;
                    }
                    else {
                        $email->status = 0;
                    }

                    $email->save();

                    sleep(20);
                }


            }
        }
    }
}
