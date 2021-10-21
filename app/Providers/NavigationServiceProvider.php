<?php

namespace App\Providers;

use App\Article;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->headerNav();
        $this->footerNav_1();
        $this->footerNav_2();
        $this->cabinet_nav();
    }

    private function headerNav(){
        view()->composer('public.components.header_nav', function($view){
            $view->with('nav_articles', Article::where([['isTopMenu', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
        view()->composer('account.components.header_nav', function($view){
            $view->with('nav_articles', Article::where([['isTopMenu', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
    }

    private function footerNav_1(){
        view()->composer('public.components.footer_nav1', function($view){
            $view->with('nav_articles', Article::where([['isFooter_1', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
        view()->composer('account.components.footer_nav1', function($view){
            $view->with('nav_articles', Article::where([['isFooter_1', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
    }

    private function footerNav_2(){
        view()->composer('public.components.footer_nav2', function($view){
            $view->with('nav_articles', Article::where([['isFooter_2', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
        view()->composer('account.components.footer_nav2', function($view){
            $view->with('nav_articles', Article::where([['isFooter_2', '=', true], ['status', '=', true]])->with('languages')->orderBy('sorting')->get());
        });
    }

    private function cabinet_nav(){
        view()->composer('account.components.sidebar', function($view){
            $view->with('worked_at', auth()->user()->workedAt()->get()->unique());
        });
        view()->composer('account.components.account_nav', function($view){
            $view->with('worked_at', auth()->user()->workedAt()->get()->unique());
        });
    }
}
