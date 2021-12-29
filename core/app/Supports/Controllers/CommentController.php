<?php

namespace App\Supports\Controllers;

use App\Comment;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class CommentController extends Controller
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    public function save(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'text' => 'required',
        ]);

        $commentableId = decrypt($request->input('id'));
        $commentableType = decrypt($request->input('type'));

        $inputMerge = [
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
            'ip' => $request->ip(),
            'device' => $request->userAgent(),
            'is_mobile' => MobileDetect::isMobile(),
        ];

        $input = $request->merge($inputMerge)->input();

        $create = $this->model->dontCache()->firstOrNew($inputMerge);

        if($create->exists === false) {
            $create->fill($input)->save();
        } else {
            // Debounce. Impede que seja inserido o mesmo conteudo varias vezes em um curto periodo de tempo
            if($create->updated_at->diffInSeconds(now()) > 30) {
                $create->fill($input)->save();
            } else {
                return response()->json([
                    'success' => false,
                    'text' => 'Por favor aguarde um momento para enviar um novo comentário. Estamos processando.',
                    'data' => $create->toArray()
                ]);
            }            
        }

        //$create->notify(new CommentNotification);

        return response()->json([
            'success' => true,
            'text' => 'Seu comentário foi enviado com sucesso. Agradecemos sua interação!',
            'data' => $create->toArray()
        ]);
    }

    /* public function sendMail(Model $data)
    {
        if (is_null(env('MAIL_FROM_ADDRESS')) || is_null($data->email)) {
            return false;
        }

        Mail::send('supports.mails.comment', compact('input'), function ($message) use ($data) {
            $subject = 'Você fez um comentário no em ' . preg_replace('/http:\/\/|https:\/\//', '', $data->commentable->present()->url);

            $message->to($data->commentable->email)->subject($subject);
        });

        return true;
    } */
}
