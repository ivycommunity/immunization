<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sendsms()
    {
        $sid = env("TWILIO_SID");
        $token = env("TWILIO_TOKEN");
        $sendernumber = env("TWILIO_PHONE");
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("+18777804236", // to
                [
                    "body" => "Hello, This is a test message from Twilio",
                    "from" => $sendernumber
                ]
            );

            dd("message sent successful");

    }
}
