{!! Form::open(['id' => 'social-form-popup']) !!}
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Configurar integração Facebook</h5>
            <button type="button" class="close popup-modal-dismiss" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="status"></div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header">
                                Selecione uma página que você gerencia
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($pages as $page)
                                <li class="py-2 list-group-item">
                                    <label class="mb-0 d-flex align-items-center">
                                        <input class="mr-2" type="radio" name="fb_page" value="{{ $page['id'] . ',' . $page['instagram_business_account']['id'] }}" <?= $page['id'] == @$data['fb_page'] ? 'checked' : '' ?>>
                                        <img src="{{ $page['picture']['url'] }}" alt="{{ $page['name'] }}" class="mr-3 rounded" style="object-fit: cover; width: 40px; height: 40px;">
                                        @if($page['instagram'] !== null)
                                        <div>
                                            {{ $page['name'] }} <br>
                                            <small>Instagram {{ '@'.$page['instagram']['username'] }}</small>
                                        </div>
                                        @endif
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header">
                                Compartilhar automaticamente da página do Facebook com o site
                            </div>
                            <ul class="list-group list-group-flush">
                                <!-- <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="fb_fields" id="feed" value="feed?fields=permalink_url,full_picture,message,created_time" <?= Str::startsWith(@$data['fb_fields'], 'feed') ? 'checked' : '' ?>>
                                    <label class="mb-0" for="feed">
                                        Feed
                                    </label>
                                </li>
                                <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="fb_fields" id="posts" value="posts?fields=full_picture,message,permalink_url,created_time" <?= Str::startsWith(@$data['fb_fields'], 'posts') ? 'checked' : '' ?>>
                                    <label class="mb-0" for="posts">
                                        Posts
                                    </label>
                                </li> 
                                <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="fb_fields" id="live_videos" value="live_videos?fields=permalink_url,embed_html,description,created_time" <?= Str::startsWith(@$data['fb_fields'], 'live_videos') ? 'checked' : '' ?>>
                                    <label class="mb-0" for="live_videos">
                                        Lives
                                    </label>
                                </li>-->
                                <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="fb_fields" id="none_" value="" <?= @$data['fb_fields'] == '' ? 'checked' : '' ?>>
                                    <label class="mb-0" for="none_">
                                        Nenhuma
                                    </label>
                                </li>
                                <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="fb_fields" id="videos" value="videos?fields=embed_html,embeddable,permalink_url,description,created_time" <?= Str::startsWith(@$data['fb_fields'], 'videos') ? 'checked' : '' ?>>
                                    <label class="mb-0" for="videos">
                                        Vídeos
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header">
                                Em que página do site você quer compartilhar
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="py-2 list-group-item d-flex align-items-center">
                                    <input class="mr-2" type="radio" name="page_id_model" id="none__" value="" <?= @$data['page_id_model'] == '' ? 'checked' : '' ?>>
                                    <label class="mb-0" for="none__">
                                        Nenhuma
                                    </label>
                                </li>
                                @foreach (App\Page::where('manager->type', '<>', 'App\Page')->whereNotNull('manager')->get() as $page)
                                    <li class="py-2 list-group-item d-flex align-items-center">
                                        <input class="mr-2" type="radio" name="page_id_model" id="{{ $page->id }}" value="{{ $page->id }},{{ @$page->manager['type'] }}" <?= $page->id.','.@$page->manager['type'] == @$data['page_id_model'] ? 'checked' : '' ?>>
                                        <label class="mb-0" for="{{ $page->id }}">
                                            {{ $page->title }}
                                        </label>
                                    </li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-0 form-group">
                <a href="/support/facebook/disconect" class="btn btn-danger btn-sm">
                    <i class="ti-facebook"></i> Desconectar Facebook
                </a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="bg-white border btn popup-modal-dismiss">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>
</div>
{!! Form::close() !!}