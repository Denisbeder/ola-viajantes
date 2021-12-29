<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

     /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        try {
            return array_filter([
                'url' => request()->fullUrlWithQuery(request()->query()),
                'userId' => Auth::id(),
                // 'email' => optional(Auth::user())->email,
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Se o token do formulários expirar retorna ao formulário com uma mensagem
        if ($exception instanceof \Illuminate\Session\TokenMismatchException && !$request->ajax()){            
            return back()->withInput($request->input())->with('new_token', csrf_token())->withWarning(config('app.admin.messages.token_mismatch'));
        }
        return parent::render($request, $exception);
    }
}
