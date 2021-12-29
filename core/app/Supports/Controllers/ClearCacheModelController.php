<?php

namespace App\Supports\Controllers;

use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;

class ClearCacheModelController extends Controller
{
    public function clear($str = null)
    {
        if (is_null($str)) {
            return back()->withWarning('O cache não foi limpo porque nenhum Model foi informado. Entre em contato com o administrador.');
        }

        $items = explode(',', $str);

        foreach ($items as $item) {
            $modelClass = '\App\\' . ucfirst(trim($item));
            if (class_exists($modelClass)) {
                $instance = new $modelClass;
                $instance->flushQueryCache();
            } elseif ($item == 'all') {
                Artisan::call("page-cache:clear"); 
            } else {                
                Artisan::call("page-cache:clear pc__index__pc"); 
                Artisan::call("page-cache:clear mobile/pc__index__pc"); 
                Artisan::call("page-cache:clear {$item} --recursive");     
                Artisan::call("page-cache:clear mobile/{$item} --recursive");           
            }            
 
            (new PurgeNginxCacheService)->purgeAll();
        }        

        return back()->withSuccess('Cache limpo com sucesso');
    }
}
