<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class BooleanInputs extends Middleware
{
    /**
     * The names of the inputs.
     *
     * @var array
     */
    protected $inputs = [
        'publish',
        'uses_writer',
        'mobile',
        'commentable',
        'cover_inside',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Se um campo boolean não existir significa que ele foi desmarcado então
        // é preciso atualizar com o valor "0" no banco de dados e no caso de inputs do tipo
        // checkbox quando desmarcados o campo não é incluido na request assim não sendo possivel 
        // atualizar o valor com "0" esse middleware adiciona esse campo novamante com o valor "0"
        if ($request->method() === 'POST' || $request->method() === 'PUT' || $request->method() === 'PATCH') {
            collect($this->inputs)->map(function ($item) use ($request) {
                if (!$request->has($item)) {
                    $request->merge([$item => 0]);
                }
            });
        }

        return $next($request);
    }
}
