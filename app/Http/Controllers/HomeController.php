<?php

namespace App\Http\Controllers;

use Hamcrest\TypeSafeDiagnosingMatcher;
use Illuminate\Http\Request;
use App;
use Config;
use Redirect;
use App\Restaurant;
use App\City;

class HomeController extends Controller
{
    /**
     * Show the main page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $data['city'] = City::where('active', '=', true)->first();
        $data['popular'] = Restaurant::where('active','=', true)->orderBy('sorting')->take(6)->with(['image','languages','gallery','menu','halls','kitchens','city'])->get();
        $data['cities'] = City::with('languages')->get();
        return view('public.home', $data);
    }

    public function filter($city_uri, Request $request){
        $city = City::where('uri', '=', $city_uri)->first();
        $restaurants = Restaurant::where('cities_id','=', $city->id)->with(['image','languages','gallery','menu','halls','kitchens','city', 'schedule']);

        $data['city_uri'] = $city->uri;
        if(isset($request->type) && $request->type !== "all"){
            $typeId = $request->type;
            $restaurants = $restaurants->whereHas('types', function($query) use($typeId){
                $query->whereRestaurantsTypesId($typeId);
            });
            $data['type'] = $typeId;
        }
        if(isset($request->kitchen) && $request->kitchen !== "all"){
            $kitchenId = $request->kitchen;
            $restaurants = $restaurants->whereHas('kitchens', function($query) use($kitchenId){
               $query->whereKitchenId($kitchenId);
            });
            $data['kitchen'] = $kitchenId;
        }
        if(isset($request->quantity) && $request->quantity > 0){
            $quantity = (int) $request->quantity;
            $restaurants = $restaurants->where('capacity', '>', $quantity);
            $data['quantity'] = $quantity;
        }
        if(isset($request->date)){
            $date = $request->date;
            $restaurants = $restaurants->whereDoesntHave('schedule', function($query) use($date){
                $query->where([['date', '=', $date], ['status', '=', '2']]);
            });
            $data['date'] = $request->date;
        }

        $restaurants = $restaurants->paginate(12);
        $data['restaurants'] = $restaurants;
        $data['seo_title'] = '';
        $data['seo_description'] = '';
        $data['types'] = App\RestaurantType::where('active','=', true)->get();
        $data['kitchens'] = App\Kitchen::get();

        return view('public.city', $data);
    }

    public function city($uri)
    {
        $city = City::where('uri', '=', $uri)->with('languages')->first();
        $restaurants = Restaurant::where([['cities_id', '=', $city->id], ['active', '=', true]])->orderBy('sorting')->with(['languages','image'])->paginate(12);
        $data['restaurants'] = $restaurants;
        $data['types'] = App\RestaurantType::where('active','=', true)->with('languages')->get();
        $data['kitchens'] = App\Kitchen::with('languages')->get();
        $data['city_uri'] = $city->uri;
        foreach ($city->languages as $lang){
            if($lang->language == app()->getLocale()){
                $data['seo_title'] = $lang->seo_title;
                $data['seo_description'] = $lang->seo_description;
            }
        }
        return view('public.city', $data);
    }

    public function cities_form(Request $request){
        $validated_data = $request->validate([
            'city' => 'string|required'
        ]);

        return redirect()->route('city-page', ['uri' => $request->city]);
    }

    public function lang($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        $referer = redirect()->back()->getTargetUrl();; //URL предыдущей страницы
        $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

        //разбиваем на массив по разделителю
        $segments = explode('/', $parse_url);

        //Если URL (где нажали на переключение языка) содержал корректную метку языка
        if (in_array($segments[1], config()->get('app.locales'))) {

            unset($segments[1]); //удаляем метку
        }

        //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
        array_splice($segments, 1, 0, $locale);

        //формируем полный URL
        $url = request()->root().implode("/", $segments);

        //если были еще GET-параметры - добавляем их
        if(parse_url($referer, PHP_URL_QUERY)){
            $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
        }

        return redirect($url);
    }
}
