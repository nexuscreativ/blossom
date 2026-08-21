<?php

namespace App\Http\Controllers;

use App\Models\AggregatedArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AggregatedNewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = AggregatedArticle::published()
            ->with('newsSource');

        if ($request->filled('category')) {
            $query->byCategory($request->input('category'));
        }

        if ($request->filled('source')) {
            $query->whereHas('newsSource', function ($q) use ($request) {
                $q->where('name', $request->input('source'));
            });
        }

        $articles = $query->latest('published_at_local')
            ->paginate(12)
            ->withQueryString();

        $categories = AggregatedArticle::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('pages.news.index', compact('articles', 'categories'));
    }

    public function show(string $slug): View
    {
        $article = AggregatedArticle::published()
            ->where('slug', $slug)
            ->with('newsSource')
            ->firstOrFail();

        $article->increment('views_count');

        $related = AggregatedArticle::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->latest('published_at_local')
            ->take(4)
            ->get();

        return view('pages.news.show', compact('article', 'related'));
    }
}
