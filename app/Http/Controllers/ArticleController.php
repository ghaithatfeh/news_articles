<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(10);
        return view('article.index', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:150',
            'blocks' => 'required'
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'user_id' => auth()->id()
        ]);

        foreach ($request->blocks as $block) {
            $blocks_data[] = [
                'type' => $block['type'],
                'value' => $block['data']['text'],
                'article_id' => $article['id'],
            ];
        }
        Block::insert($blocks_data);

        return true;
    }

    public function destroy(Article $article)
    {
        if ($article->user_id != auth()->id())
            return abort(403);

        $article->delete();

        return redirect(route('article.index'));
    }
}
