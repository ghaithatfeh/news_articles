<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Block;
use App\Models\Gif;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')
            ->latest()
            ->paginate(10);

        return view('article.index', [
            'articles' => $articles
        ]);
    }
    public function myArticle()
    {
        $articles = Article::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('article.index', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return view('article.create');
    }

    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->with('blocks', 'blocks.gifs')->first();

        if (!$article) return abort(404);

        return view('article.edit', [
            'article' => $article
        ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->with('blocks', 'blocks.gifs')->first();

        if (!$article) return abort(404);

        return view('article.view', [
            'article' => $article
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:150',
            'blocks' => 'required'
        ]);

        $article = Article::create([
            'title' => $request->title,
            'user_id' => auth()->id()
        ]);

        foreach ($request->blocks as $block) {
            $block_data = [
                'type' => $block['type'],
                'article_id' => $article['id'],
            ];
            if (isset($block['data']['text']))
                $block_data['value'] = $block['data']['text'];

            $block_model = Block::create($block_data);

            if (isset($block['data']['urls'])) {
                foreach ($block['data']['urls'] as $gif_url)
                    $gifs_data[] = ['url' => $gif_url, 'block_id' => $block_model->id];

                Gif::insert($gifs_data);
            }
        }
        return true;
    }

    public function destroy(Article $article)
    {
        if ($article->user_id != auth()->id())
            return abort(403);

        $article->delete();

        return redirect()->route('article.index');
    }
}
