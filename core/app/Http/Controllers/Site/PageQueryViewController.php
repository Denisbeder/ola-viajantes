<?php

namespace App\Http\Controllers\Site;

use App\Advert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

abstract class PageQueryViewController extends Controller
{
    protected $page;
    protected $category;
    protected $slug;

    abstract protected function queryBuilder();

    protected function query()
    {
        // Inicia a query com os relacionamentos
        $query = $this->queryBuilder();

        // Se não existir uma slug entende-se que deverar mostrar resultados paginado então limita para não buscar todo o bando de uma vez
        if (!$this->hasSlug()) {
            $query->limit(500);
        }

        // Faz a query para a categoria quando for passado uma categoria garante que ela seja a mesma salva no registro
        if ($this->hasCategory()) {
            $query->whereHas('category', function ($query) {
                $query->where('slug', $this->category->slug);
            });
        }

        if ($this->hasSlug()) {
            // Se NÃO for passado uma categoria entende-se que o registro não possua uma sendo assim o campo category_id deve ser obrigatoriamente NULL
            // caso exista o método category no model
            if (!$this->hasCategory() && $this->hasMethodCategory($query) && $this->exceptModelsForceNullCategory($query)) {
                $query->whereNull('category_id');
            }

            // Faz a query para a slug
            $query->where('slug', $this->slug);
        }

        return $query;
    }

    public function makePage()
    {
        $action = Str::camel($this->getView());

        return $this->{$action}();
    }

    protected function hasPage()
    {
        return $this->page->exists;
    }

    protected function hasCategory()
    {
        return $this->category->exists ?? !is_null($this->category);
    }

    protected function hasMethodCategory($query)
    {
        return method_exists($query->getModel(), 'category');
    }

    protected function exceptModelsForceNullCategory($query)
    {
        if ($query->getModel() instanceof Advert) {
            return false;
        }
        return true;
    }

    protected function hasSlug()
    {
        return !is_null($this->slug) && !empty($this->slug) && (bool) strlen($this->slug);
    }

    protected function getView()
    {
        // Se EXISTIR slug prioriza mostrar o conteudo
        if ($this->hasSlug()) {
            return 'show';
        }

        // Se EXISTIR categoria mas NÃO EXISTE uma Slug listas os registros dessa categoria
        if ($this->hasCategory()) {
            return 'index-category';
        }

        // Se EXISTIR somente a pagina listas todos os registros
        return 'index';
    }

    public function __invoke()
    {
        $this->page = Route::current()->parameter('page');
        $this->category = Route::current()->parameter('category');
        $this->slug = Route::current()->parameter('slug');

        return $this->makePage();
    }
}
