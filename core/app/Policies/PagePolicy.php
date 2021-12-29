<?php

namespace App\Policies;

use App\Page;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Verifica se o post que o usuário logado está tentado editar pertence uma coluna que ele tem permissão
    public function edit(User $user, Page $model)
    {
        $permissionsPagesId = collect($user->permissions['pages'])->map(function ($item) {
            return preg_replace('/[a-z]+|[A-Z]+|_/', '', $item);
        });

        return $permissionsPagesId->contains($model->id);
    }
}
