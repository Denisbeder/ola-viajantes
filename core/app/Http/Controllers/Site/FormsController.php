<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Supports\Services\FormService;
use App\Supports\Traits\SeoGenerateTrait;

class FormsController extends PageQueryViewController
{
    use SeoGenerateTrait;

    protected function queryBuilder()
    {
        return $this->page
            ->forms()
            ->latest()
            ->limit(1);
    }

    private function getData()
    {
        return $this->query()->first();
    }

    public function index()
    {
        if (strtolower(request()->method()) === 'post') {
            $this->send(request());
        }

        $page = $this->page;
        $data = $this->getData();
        if (!is_null($data)) {
            $data->load('page');
        }
        $seo = $this->seoSetType('ContactPage')->seoForIndexPage($page);

        return view('site.forms.index', compact('data', 'page', 'seo'));
    }

    private function send(Request $request)
    {
        if (strtolower($request->method()) !== 'post') {
            return;
        }
        
        $page = $this->page;
        $data = $this->getData();

        $sendTo = $data->email;
        $subject = 'Mensagem enviada de ' . preg_replace('/http:\/\/|https:\/\//', '', config('app.url'));
        $formService = new FormService($data->fields);
        $rules = $formService->rules();
        $input = $request->only($formService->getNameFields());

        $request->validate($rules);

        if (is_null(env('MAIL_FROM_ADDRESS'))) {
            return back()->withInput()->with('error', 'Não foi possível enviar seu contato. Entre em contato com o administrador. Error: MAIL_FROM_ADDRESS Undefined.');
        } elseif (is_null($sendTo)) {
            return back()->withInput()->with('error', 'Não foi possível enviar seu contato por causa de uma erro no sistema de envio.');
        } else {
            Mail::send('supports.mails.default', compact('input', 'page'), function ($message) use ($sendTo, $subject) {
                $message->to($sendTo)->subject($subject);
                session()->flush();
            });
            
            return redirect($page->present()->url)->with('success', 'Sua mensagem foi enviada com sucesso, em breve retornaremos o contato.');
        }
    }
}
