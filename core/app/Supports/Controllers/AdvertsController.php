<?php

namespace App\Supports\Controllers;

use App\Advert;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Notifications\AdvertNotification;
use App\Supports\Traits\MediaLibraryTrait;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class AdvertsController extends Controller
{
    use MediaLibraryTrait;

    public $model;

    public function __construct(Advert $model)
    {
        $this->model = $model;
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'city_id' => 'required',
            'phones.0' => 'required',
            'images.*' => 'required|mimes:jpg,jpeg,jfif,bmp,png,gif',
            'body' => 'required',
        ]);

        $token = md5(bcrypt(uniqid(rand(), true)));
        $pageId = decrypt($request->get('page_id'));
        $id = $request->has('id') ? decrypt($request->get('id')) : null;

        $input = $request->merge([
            'page_id' => $pageId,
            'ip' => $request->ip(),
            'device' => $request->userAgent(),
            'is_mobile' => MobileDetect::isMobile(),
            'publish' => 0,
            'phones' => array_filter($request->get('phones')),
            'token' => $token,
        ])->input();
        
        // Adiciona 1 minuto para impedir inserção quando houver de varios cliques
        $sentence = (bool) strlen($id) ? ['id' => $id] : ['page_id' => $pageId, 'ip' => $request->ip(), ['updated_at', '>', now()->sub(1, 'minutes')]];

        $create = $this->model->firstOrNew($sentence);

        if ($create->exists) {
            $create->update(Arr::except($input, ['publish', 'token', 'page_id', 'city_id', 'email', 'title']));
        } else {
            $create = $create->create($input);
        }

        // Salva as imagens na pasta e no banco de dados
        $this->addMedia('images', $create, $create->title, 'images');

        //$create->notify(new AdvertNotification);

        return response()->json([
            'success' => true,
            'text' => 'Seu anúncio foi enviado com sucesso. Seu anúncio vai passar por uma análise antes de ser aprovado.',
            'data' => $create->toArray()
        ]);
    }

    public function destroy(int $id)
    {
        $continue = request()->get('continue') ?? '/';
        $token = filter_var(request()->get('token'));
        $id = filter_var($id);

        if ((bool) strlen($token) === false) {
            return redirect()->to($continue)->with('info', 'O token não foi informado.');
        }

        $data = $this->model->where('token', $token)->where('id', $id)->first();

        if (is_null($data)) {
            return redirect()->to($continue)->with('info', 'Anúncio anúncio não encontrado ou o token informado é inválido.');
        }

        $data->delete();

        return redirect()->to($continue)->with('success', 'Anúncio excluído com sucesso.');
    }
}
