<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\ImageController as ImageController;
use App\City;
use App\Kitchen;
use App\Orders;
use App\Restaurant;
use App\Language;
use App\RestaurantType;
use App\Role;
use App\Staff;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Class RestaurantsController
 * @package App\Http\Controllers\Adminpanel
 */
class RestaurantsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurants');
    }

    /**
     * Show list of restaurants
     * @return Factory|View
     */
    public function index(){
        $data['restaurants'] = Restaurant::with(['languages','image','city','types'])->get();
        return view('admin.restaurants.index', $data);
    }

    /**
     * Show form for creating resource
     */
    public function create(){
        $data['cities'] = City::with('languages')->get();
        $data['types'] = RestaurantType::with('languages')->get();
        $data['kitchens'] = Kitchen::with('languages')->get();
        return view('admin.restaurants.form', $data);
    }

    /**
     * Save new resource
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request){
        $request->validate(array(
            'uri'                 => 'required|unique:restaurants|regex:/^[a-z_0-9\.-]+$/i',
            'langs.*.name'        => 'required',
            'langs.*.seo_title'   => 'required',
            'price'               => 'required|integer',
            'opt_price'           => 'required|integer',
            'capacity'            => 'required|integer',
            'city'                => 'required|integer',
            'types.*'             => 'required|integer',
            'image'               => 'nullable|image|dimensions:max_width=2400,max_height=1350'
        ));

        $restaurant = new Restaurant();

        $restaurant->uri                 = $request->uri;
        $restaurant->sorting             = $request->sorting ?: 0;
        $restaurant->active              = $request->is_active == "on";
        $restaurant->price               = $request->price;
        $restaurant->opt_price           = $request->opt_price;
        $restaurant->capacity            = $request->capacity;
        $restaurant->cities_id           = $request->city;
        $restaurant->video               = $request->video;
        $restaurant->gift                = isset($request->gift) && $request->gift === "on";

        $u_image = $request->file('image');
        if(isset($u_image)){
            if(isset($restaurant->images_id)){
                $image = ImageController::imageUpload($u_image, 'uploads/'.$restaurant->id.'/thumb/', true, $restaurant->images_id);
            }else{
                $image = ImageController::imageUpload($u_image, 'uploads/'.$restaurant->id.'/thumb/');
            }
            ImageController::imageResize($image, config('image.sizes.card'));
            $restaurant->images_id = $image->id;
        }

        $restaurant->save();

        if(isset($request->types)){
            $types = RestaurantType::whereIn('id', $request->types)->get();
            foreach($types as $type){
                $restaurant->types()->save($type);
            }
        }

        if(isset($request->kitchens)){
            $kitchens = Kitchen::whereIn('id', $request->kitchens)->get();
            foreach($kitchens as $kitchen){
                $restaurant->kitchens()->save($kitchen);
            }
        }

        $langs = [];
        foreach($request->langs as $key => $lang) {
            $langs[$key] = new Language();
            $langs[$key]->fill(array(
                'language'          => $key,
                'name'              => $lang['name'],
                'seo_title'         => $lang['seo_title'],
                'seo_description'   => $lang['seo_description'],
                'address'           => isset($lang['address']) ? $lang['address']: '',
                'seo_text'          => $lang['seo_text'],
                'gift_text'         => isset($lang['gift_text']) ? $lang['gift_text']: '',
                'schedule'          => isset($lang['schedule']) ? $lang['schedule']: '',
                'discount'          => isset($lang['discount']) ? $lang['discount']: '',
            ));
            $restaurant->languages()->save($langs[$key]);
        }

        return redirect()->route('restaurants.index');
    }

    /**
     * Show single resource information
     */
    public function show($id){
        $data['restaurant'] = Restaurant::with(['languages','image','city','types','gallery','menu','halls','kitchens', 'staff'])->findOrFail($id);
        return view('admin.restaurants.info', $data);
    }

    /**
     * Show form for edit resource
     */
    public function edit($id){
        $restaurant = Restaurant::with(['languages','image','city','types','kitchens'])->findOrFail($id);
        $data['restaurant'] = $restaurant;
        $data['restaurant_lang'] = [];
        foreach($restaurant->languages as $lang){
            $data['restaurant_lang'][$lang->language]['name'] = $lang->name;
            $data['restaurant_lang'][$lang->language]['seo_title'] = $lang->seo_title;
            $data['restaurant_lang'][$lang->language]['seo_description'] = $lang->seo_description;
            $data['restaurant_lang'][$lang->language]['seo_text'] = $lang->seo_text;
            $data['restaurant_lang'][$lang->language]['address'] = $lang->address;
            $data['restaurant_lang'][$lang->language]['gift_text'] = $lang->gift_text;
            $data['restaurant_lang'][$lang->language]['schedule'] = $lang->schedule;
            $data['restaurant_lang'][$lang->language]['discount'] = $lang->discount;
        }
        $data['cities'] = City::with('languages')->get();
        $data['types'] = RestaurantType::with('languages')->get();
        $data['kitchens'] = Kitchen::with('languages')->get();
        return view('admin.restaurants.form', $data);
    }

    /**
     * Update resource information
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request){

        $request->validate(array(
            'uri'                 => [
                'required',
                'regex:/^[a-z_0-9\.-]+$/i',
                Rule::unique('restaurants')->ignore($id),
            ],
            'langs.*.name'        => 'required',
            'langs.*.seo_title'   => 'required',
            'price'               => 'required|integer',
            'opt_price'           => 'required|integer',
            'capacity'            => 'required|integer',
            'city'                => 'required|integer',
            'types.*'             => 'required|integer',
            'image'               => 'nullable|image|dimensions:max_width=2400,max_height=1350'
        ));

        $restaurant = Restaurant::findOrFail($id);

        $restaurant->uri                 = $request->uri;
        $restaurant->sorting             = $request->sorting ?: 0;
        $restaurant->active              = $request->is_active == "on";
        $restaurant->price               = $request->price;
        $restaurant->opt_price           = $request->opt_price;
        $restaurant->capacity            = $request->capacity;
        $restaurant->cities_id           = $request->city;
        $restaurant->video               = $request->video;
        $restaurant->gift                = isset($request->gift) && $request->gift === "on";

        // Save image
        $u_image = $request->file('image');
        if(isset($u_image)){
            if(isset($restaurant->images_id)){
                $image = ImageController::imageUpload($u_image, 'uploads/'.$restaurant->id.'/thumb/', true, $restaurant->images_id);
            }else{
                $image = ImageController::imageUpload($u_image, 'uploads/'.$restaurant->id.'/thumb/');
            }
            ImageController::imageResize($image, config('image.sizes.card'));
            $restaurant->images_id = $image->id;
        }

        $restaurant->save();

        $restaurant->types()->detach();
        $types = RestaurantType::whereIn('id', $request->types)->get();
        foreach($types as $type){
            $restaurant->types()->save($type);
        }

        $restaurant->kitchens()->detach();
        if(isset($request->kitchens)){
            $kitchens = Kitchen::whereIn('id', $request->kitchens)->get();
            foreach($kitchens as $kitchen){
                $restaurant->kitchens()->save($kitchen);
            }
        }

        foreach($request->langs as $key => $lang) {
            foreach($restaurant->languages as $item_lang){
                if($item_lang->language == $key){
                    $item_lang->name = $lang['name'];
                    $item_lang->seo_title = $lang['seo_title'];
                    $item_lang->seo_description = $lang['seo_description'];
                    $item_lang->seo_text = $lang['seo_text'];
                    $item_lang->address = isset($lang['address'])?$lang['address']:'';
                    $item_lang->gift_text = isset($lang['gift_text'])?$lang['gift_text']:'';
                    $item_lang->schedule = isset($lang['schedule'])?$lang['schedule']:'';
                    $item_lang->discount = isset($lang['discount'])?$lang['discount']:'';
                }
                $item_lang->save();
            }
        }

        return redirect()->route('restaurants.index');
    }

    /**
     * Destroy resource
     */
    public function destroy($id){
        $restaurant = Restaurant::with(['gallery','halls','menu'])->findOrFail($id);
        if(isset($restaurant->gallery)){
            foreach($restaurant->gallery->items as $item){
                $item->langs()->delete();
                $item->image()->delete();
                $item->delete();
            }
            $restaurant->gallery->langs()->delete();
            $restaurant->gallery()->delete();
        }
        if(isset($restaurant->halls)){
            foreach($restaurant->halls as $hall){
                $hall->languages()->delete();
                if(isset($hall->gallery)){
                    foreach($hall->gallery->items as $item){
                        $item->langs()->delete();
                        $item->image()->delete();
                        $item->delete();
                    }
                    $hall->gallery->langs()->delete();
                    $hall->gallery()->delete();
                }
            }
        }
        if(isset($restaurant->menu)){
            foreach($restaurant->menu->items as $item){
                $item->languages()->delete();
                $item->image()->delete();
                $item->delete();
            }
            $restaurant->menu->languages()->delete();
            $restaurant->menu()->delete();
        }
        $restaurant->languages()->delete();
        $restaurant->image()->delete();

        $image_folder = 'uploads/'.$restaurant->id;
        if(file_exists(public_path($image_folder))){
            File::deleteDirectory(public_path($image_folder));
        }

        $restaurant->delete();

        return redirect()->back();
    }


    public function createStaff($id, Request $request){
        $data['roles'] = Role::where('restaurant_role', '=', true)->with('languages')->get();
        $data['restaurant_id'] = $id;
        $whereArray = array();
        if(isset($request->name)){
            $whereArray[] = ['name', 'like', '%'.$request->name.'%'];
        }
        if(isset($request->surname)){
            $whereArray[] = ['surname', 'like', '%'.$request->surname.'%'];
        }
        if(isset($request->email)){
            $whereArray[] = ['email', 'like', '%'.$request->email.'%'];
        }
        if(isset($request->phone)){
            $whereArray[] = ['phone', 'like', '%'.$request->phone.'%'];
        }
        if(isset($request)){
            $data['users'] = User::where($whereArray)->limit(10)->get();
        }else{
            $data['users'] = User::limit(10)->get();
        }

        return view('admin.staff.form', $data);
    }

    public function storeStaff(Request $request){
        $request->validate(array(
            'restaurant'    => 'integer|required',
            'user'          => 'integer|required',
            'role'          => 'integer|required'
        ));

        $existRow = Staff::where([['restaurant_id', '=', $request->restaurant], ['user_id', '=', $request->user], ['role_id', '=', $request->role]])->count();

        if(!$existRow){
            $user = User::findOrFail($request->user);
            $role = Role::findOrFail($request->role);

            $user->roles()->save($role);

            $staff = new Staff();
            $staff->restaurant_id   = $request->restaurant;
            $staff->role_id         = $request->role;
            $staff->user_id         = $request->user;
            $staff->save();



            return redirect()->route('restaurants.show', ['id' => $request->restaurant]);
        }else{
            return redirect()->back()->withErrors(['doublecating' => 'Already exist']);
        }


    }

    public function destroyStaff($id){
        $staff = Staff::findOrFail($id);
        $user = User::findOrFail($staff->user_id);
        $role = Role::findOrFail($staff->role_id);
        $user->roles()->detach($role);
        $staff->delete();


        return redirect()->back();
    }




}
