<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Article::class);
        return Article::with('user')->get();
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = $request->user()->articles()->create($validated);

        return response()->json($article, 201);
    }

    public function show(Article $article)
    {
        Gate::authorize('view', $article);
        return $article->load('user');
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $article->update($validated);

        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        return response()->json(null, 204);
    }
}
