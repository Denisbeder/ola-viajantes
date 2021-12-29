<div class="modal-dialog modal-@yield('size', 'lg')" role="document">
    <div class="modal-content">
        @hasSection('title')      
            <div class="modal-header">
                <h5 class="modal-title">@yield('title')</h5>
                <button type="button" class="close popup-modal-dismiss" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <button type="button" class="close popup-modal-dismiss position-absolute mr-2 mt-1" style="right: 0; z-index: 1;" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif
        <div class="modal-body">
            @yield('body')
        </div>
        @hasSection('footer')            
        <div class="modal-footer">
            @yield('footer')
        </div>
        @endif
    </div>
</div>