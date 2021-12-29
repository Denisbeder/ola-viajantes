<footer class="mt-5 footer">
    <div class="container text-center d-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('/assets/site/img/logo-black.png') }}" alt="{{ config('app.site.name') }}" class="footer-logo" height="50">

        {!! app('menuRenderService')->setClassNav('nav footer-social mt-5')->setClassItem('nav-item')->render('social_footer') !!}
        {!! app('menuRenderService')->setClassNav('nav mt-4 d-flex justify-content-center')->setClassItem('nav-item')->render('footer') !!}

        <p class="border-top footer-copyright">
            © {{ config('app.site.name') }}, 2021-{{ date('Y') }}. Todos os direitos reservados. As notícias veiculadas nos blogs, colunas e artigos são de inteira responsabilidade dos autores.
            <br>
            <small>Desenvolvido por <a href="http://facebook.com/duekdigital" target="_blank" title="Duek Digital"><strong>Duek Digital</strong></a> 😃</small>
        </p>
    </div>
</footer>