<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    public function view(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('view articles');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create articles');
    }

    public function update(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('edit articles') 
            && $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('delete articles') 
            && $user->id === $article->user_id;
    }
}
