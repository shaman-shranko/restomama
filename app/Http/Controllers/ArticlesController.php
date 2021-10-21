<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index($article_uri){
        $data['article'] = Article::where([['uri', '=', $article_uri], ['type', '=', 'article']])->with('languages')->first();
        return view('public.article', $data);
    }

    public function view_faq(){
        $data['questions'] = Article::where([['type', '=', 'question'], ['status', '=', true]])->with('languages')->get();
        return view('public.faq', $data);
    }

}
