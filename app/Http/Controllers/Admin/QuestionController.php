<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-articles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questions'] = Article::where('type', '=', 'question')->with('languages')->get();
        return view('admin.faq.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'langs.*.title'       => 'required',
            'langs.*.content'     => 'required',
        ]);

        $article = new Article();

        $stub_string = time();

        $article->uri        = $stub_string;
        $article->sorting    = $request->sorting ?: 0;
        $article->type       = 'question';
        $article->status     = $request->status == "on";
        $article->isTopMenu  = false;
        $article->isFooter_1 = false;
        $article->isFooter_2 = false;
        $article->isBlog     = false;
        $article->save();

        $langs = [];
        foreach($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language'         => $key,
                'title'            => $lang['title'],
                'seo_title'        => $stub_string,
                'seo_description'  => $stub_string,
                'description'      => $lang['content'],
            ));
            $article->languages()->save($langs[$key]);
        }

        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['article'] = Article::where([['id', '=', $id], ['type', '=', 'question']])->with('languages')->first();
        foreach($data['article']->languages as $lang){
            $data['article_lang'][$lang->language]['title']             = $lang->title;
            $data['article_lang'][$lang->language]['seo_title']         = $lang->seo_title;
            $data['article_lang'][$lang->language]['seo_description']   = $lang->seo_description;
            $data['article_lang'][$lang->language]['content']           = $lang->description;
        }

        return view('admin.faq.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'langs.*.title'       => 'required',
            'langs.*.content'      => 'required',
        ]);

        $article = Article::where([['id', '=', $id], ['type', '=', 'question']])->with('languages')->first();

        $stub_string = time();

        $article->uri        = $stub_string;
        $article->sorting    = $request->sorting ?: 0;
        $article->type       = 'question';
        $article->status     = $request->status == "on";
        $article->isTopMenu  = false;
        $article->isFooter_1 = false;
        $article->isFooter_2 = false;
        $article->isBlog     = false;
        $article->save();

        foreach($request->langs as $key => $lang) {
            foreach($article->languages as $article_lang){
                if($article_lang->language == $key){
                    $article_lang->title            = $lang['title'];
                    $article_lang->seo_title        = $stub_string;
                    $article_lang->seo_description  = $stub_string;
                    $article_lang->description      = $lang['content'];
                }
                $article_lang->save();
            }
        }

        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $item = Article::findOrFail($id);
        $item->languages()->delete();
        $item->delete();

        return redirect()->route('questions.index');
    }
}
