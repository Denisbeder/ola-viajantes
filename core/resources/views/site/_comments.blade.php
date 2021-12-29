@if($data->commentable)
<section id="comments" class="mt-5 comments-wrapper">
    @if(($commentsTotal = $data->comments->count()) > 0)
    <section class="mb-3">
        <div class="mb-3 section-title border-color-dark section-title-small">
            <span>{{ $commentsTotal }} comentários</span>
        </div>

        <ul class="list-group list-group-flush">
            @foreach ($data->comments as $item)
            <li class="px-0 list-group-item">
                <div class="media">
                    <img src="{{ $item->present()->gravatar }}" class="mr-3 rounded-pill img-fluid" alt="">
                    <div class="media-body">
                        <h6 class="mb-2 text-dark"><strong>{{ $item->name }}</strong></h6>
                        <p class="mb-2 text-dark text-break">{!! nl2br($item->text) !!}</p>
                        <p class="mb-0 text-muted">
                            <small>
                                <i class="far fa-clock"></i>
                                <time datetime="{{ $item->created_at->toDateTimeLocalString() }}">{{ $item->created_at->format('d/m/Y') }} às {{ $item->created_at->format('H:i') }}</time>
                            </small>
                        </p>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    <form id="comments-form" action="/support/comment/save" method="POST" class="p-4 border rounded bg-light">
        <div id="comment-alert" class="alert" style="display: none;"></div>
        <input type="hidden" name="id" value="{{ encrypt($data->id) }}">
        <input type="hidden" name="type" value="{{ encrypt(get_class($data)) }}">
        <strong style="font-size: 20px;">
            @if($commentsTotal > 0)            
                DEIXE SEU COMENTÁRIO
            @else
                SEJA O PRIMEIRO A COMENTAR
            @endif
        </strong>
        <small class="mt-2 mb-5 text-muted w-100 d-flex">Os comentários ofensivos, obscenos, que vão contra a lei ou que não contenha identificação não serão publicados.</small>
        <div class="form-group">
            <label for="text">Seu comentário *</label>
            <textarea name="text" id="text" rows="5" class="form-control"></textarea>
        </div>
        <div class="form-row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="rounded-pill btn btn-sm btn-dark">Enviar</button>
            <div class="text-right text-muted"><small>Campos obrigatório estão marcados com *</small></div>
        </div>
    </form>
</section>
@endif