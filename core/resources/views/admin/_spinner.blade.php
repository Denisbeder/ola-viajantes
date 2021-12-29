<div id='loader'>
    <div class="spinner"></div>
</div>

<script>
    const loader = document.getElementById('loader');
    window.addEventListener('load', () => {
        setTimeout(function () {
            loader.classList.add('fadeOut');
        }, 100);
    });
    
    // Se a página demorar mais que 4 segundos para carregar totalmente remove o loader permitindo clicar no que já foi carregado
    setTimeout(function () {
        loader.classList.add('fadeOut');
    }, 4000);
</script>