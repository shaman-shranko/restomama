<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-articles');
    }

    /**
     * Show list of articles
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data['articles'] = Article::where('type', '=', 'article')->with('languages')->get();
        return view('admin.articles.index', $data);
    }

    /**
     * Show form for create article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin.articles.form');
    }

    /**
     * Save article
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){

        $validatedData = $request->validate([
            'uri'                 => 'required|unique:cities|regex:/^[a-z_0-9\.-]+$/i',
            'langs.*.title'        => 'required',
            'langs.*.seo_title'   => 'required',
        ]);
        $article = new Article();

        $article->uri        = $request->uri;
        $article->sorting    = $request->sorting ?: 0;
        $article->type       = 'article';
        $article->status     = $request->status == "on";
        $article->isTopMenu  = $request->isTopMenu == "on";
        $article->isFooter_1 = $request->isFooter_1 == "on";
        $article->isFooter_2 = $request->isFooter_2 == "on";
        $article->isBlog     = $request->isBlog == "on";
        $article->save();


        $langs = [];
        foreach($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language'         => $key,
                'title'            => $lang['title'],
                'seo_title'        => $lang['seo_title'],
                'seo_description'  => $lang['seo_description'],
                'description'      => $lang['content'],
            ));
            $article->languages()->save($langs[$key]);
        }
        return redirect()->route('articles.index');
    }

    /**
     * Show form for edit article
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data['article'] = Article::where([['id', '=', $id], ['type', '=', 'article']])->with('languages')->first();
        foreach($data['article']->languages as $lang){
            $data['article_lang'][$lang->language]['title'] = $lang->title;
            $data['article_lang'][$lang->language]['seo_title'] = $lang->seo_title;
            $data['article_lang'][$lang->language]['seo_description'] = $lang->seo_description;
            $data['article_lang'][$lang->language]['content'] = $lang->description;
        }
        return view('admin.articles.form', $data);
    }


    /**
     * Update article
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'uri'                 => [
                'required',
                'regex:/^[a-z_0-9\.-]+$/i',
                Rule::unique('articles')->ignore($id),
            ],
            'langs.*.title'       => 'required',
            'langs.*.seo_title'   => 'required',
        ]);
        $article = Article::where([['id', '=', $id], ['type', '=', 'article']])->with('languages')->first();

        $article->uri        = $request->uri;
        $article->sorting    = $request->sorting ?: 0;
        $article->type       = 'article';
        $article->status     = $request->status == "on";
        $article->isTopMenu  = $request->isTopMenu == "on";
        $article->isFooter_1 = $request->isFooter_1 == "on";
        $article->isFooter_2 = $request->isFooter_2 == "on";
        $article->isBlog     = $request->isBlog == "on";
        $article->save();

        foreach($request->langs as $key => $lang) {
            foreach($article->languages as $article_lang){
                if($article_lang->language == $key){
                    $article_lang->title           = $lang['title'];
                    $article_lang->seo_title       = $lang['seo_title'];
                    $article_lang->seo_description = $lang['seo_description'];
                    $article_lang->description     = $lang['content'];
                }
                $article_lang->save();
            }
        }

        return redirect()->route('articles.index');
    }


    /**
     * Delete article
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id){
        $item = Article::findOrFail($id);
        $item->languages()->delete();
        $item->delete();

        return redirect()->route('articles.index');
    }
}
