<?php

namespace App\Supports\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendmailController extends Controller
{

    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$/|max:15|min:12',
            'message' => 'required',
        ]);

        $input = $request->all();
        $queryPage = $request->query('p');
        $referer = $request->headers->get('referer');
        $path = head(explode('/', ltrim(str_replace(config('app.url'), '', $referer), '/')));
        $email = collect(setting('pages'))->where('slug', $path)->first()['email'];

        if (is_null(env('MAIL_FROM_ADDRESS'))) {
            return redirect()->back()->with('error', 'Não foi possível enviar sua mensagem porque o "MAIL_FROM_ADDRESS" ainda não foi configurado.');
        }

        if (!is_null($queryPage)) {
            $email = setting('pages.' . $queryPage . '.email');
        }

        if (is_null($email)) {
            return redirect()->back()->with('info', 'Não foi possível enviar sua mensagem pois o administratdor do site não definiu uma e-mail para contato.');
        }

        Mail::send('supports.mails.contact', compact('input'), function ($message) use ($request, $email) {
            $subject = $request->get('subject') . ' - Contato via site ' . $request->url();

            $message->to($email)->subject($subject);
        });

        return redirect()->back()->with('success', 'Sua mensagem foi enviada com sucesso. Em breve lhe responderemos.');
    }
}
