<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Request;

class Localization
{

    public static function getLocale()
    {
        $locale = Config::get('app.locale');
        if(session()->has('locale')){
            $locale = session()->get('locale');
        }else{
            $uri = Request::path();
            $segmentsURI = explode('/', $uri);

            if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], Config::get('app.locales'))){
                $locale = $segmentsURI[0];
            }
        }

        return $locale;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('locale')){
            App::setLocale(session()->get('locale'));
        }else{
            App::setLocale(self::getLocale());
        }
        return $next($request);
    }
}
