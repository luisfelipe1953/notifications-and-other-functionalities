<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\MailWelcomeJob;
use Illuminate\Http\Request;
use App\Events\MailsSubmittedEvent;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function sendMails()
    {
        event(new MailsSubmittedEvent(auth()->user()));

        return redirect()->route('welcome')/* ->with('create', 'Los emails se han sido añadidos a la cola') */;
    }
}
