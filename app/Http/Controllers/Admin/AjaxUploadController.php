<?php

namespace App\Http\Controllers\Admin;

use App\Galleries;
use App\GalleryLangs;
use App\GalleryItems;
use App\GalleryItemsLangs;
use App\Hall;
use App\Http\Controllers\Admin\ImageController as ImageController;
use App\Restaurant;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-restaurants');
    }

    /**
     * Upload hall images
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */

    public function ajaxHallUpload($id, Request $request){
        $request->validate([
            'file' => 'required|image|dimensions:max_width=2400,max_height=1350'
        ]);
        $hall = Hall::where('id','=',$id)->with(['languages','restaurant'])->first();

        if(isset($hall->gallery_id)){
            $gallery = Galleries::where('id', '=', $hall->gallery_id)->first();
        }else{
            $gallery = new Galleries();
            $gallery->type = 'hall';
            $gallery->save();
            $hall->gallery_id = $gallery->id;
            $hall->save();
            foreach(config('app.locales') as $locale){
                $gallery_lang = new GalleryLangs();
                $gallery_lang->lang = $locale;
                foreach($hall->languages as $lang){
                    if($locale == $lang->language){
                        $gallery_lang->name = 'Gallery:'.$lang->name;
                    }
                }
                $gallery->langs()->save($gallery_lang);
            }
        }
        $image = ImageController::imageUpload($request->file, 'uploads/'.$id.'/gallery/');
        ImageController::imageResize($image, config('image.sizes.fullwidth'));

        return response()->json($this->createGalleryItem($image, $gallery, $hall));
    }

    public function ajaxEventUpload($id, Request $request){
        $request->validate([
            'file' => 'required|image|dimensions:max_width=2400,max_height=1350'
        ]);
        $gallery = Galleries::findOrFail($id);
        $gallery_event = '';
        foreach($gallery->event() as $event){
            $gallery_event = $event;
        }

        $image = ImageController::imageUpload($request->file, 'uploads/event_gallery/'.$id.'/');
        ImageController::imageResize($image, config('image.sizes.fullwidth'));

        return response()->json($this->createGalleryItem($image, $gallery, $gallery_event));
    }

    /**
     * Upload restaurant gallery images
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRestaurantUploadImage($id, Request $request){
        $request->validate([
            'file' => 'required|image|dimensions:max_width=2400,max_height=1350'
        ]);

        $restaurant = Restaurant::where('id','=',$id)->with('languages')->first();

        if(isset($restaurant->gallery_id)){
            $gallery = Galleries::where('id', '=', $restaurant->gallery_id)->first();
        }else{
            $gallery = new Galleries();
            $gallery->type = 'restaurant';
            $gallery->save();
            $restaurant->gallery_id = $gallery->id;
            $restaurant->save();
            foreach(config('app.locales') as $locale){
                $gallery_lang = new GalleryLangs();
                $gallery_lang->lang = $locale;
                foreach($restaurant->languages as $lang){
                    if($locale == $lang->language){
                        $gallery_lang->name = 'Gallery:'.$lang->name;
                    }
                }
                $gallery->langs()->save($gallery_lang);
            }
        }

        $image = ImageController::imageUpload($request->file, 'uploads/'.$id.'/gallery/');
        ImageController::imageResize($image, config('image.sizes.fullwidth'));

        return response()->json($this->createGalleryItem($image, $gallery, $restaurant));
    }

    /**
     * Menu image upload
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */

    public function ajaxMenuUploadImage($id, Request $request){
        $request->validate([
            'file' => 'required|image|dimensions:max_width=2400,max_height=1350'
        ]);
        $restaurant = Restaurant::where('id','=',$id)->with('languages')->first();

        if(isset($restaurant->menu_id)){
            $gallery = Galleries::where('id', '=', $restaurant->menu_id)->first();
        }else{
            $gallery = new Galleries();
            $gallery->type = 'menu';
            $gallery->save();
            $restaurant->menu_id = $gallery->id;
            $restaurant->save();
            foreach(config('app.locales') as $locale){
                $gallery_lang = new GalleryLangs();
                $gallery_lang->lang = $locale;
                foreach($restaurant->languages as $lang){
                    if($locale == $lang->language){
                        $gallery_lang->name = 'Menu:'.$lang->name;
                    }
                }
                $gallery->langs()->save($gallery_lang);
            }
        }

        $image = ImageController::imageUpload($request->file, 'uploads/'.$id.'/gallery/');
        ImageController::imageResize($image, config('image.sizes.fullwidth'));

        return response()->json($this->createGalleryItem($image, $gallery, $restaurant));
    }

    /**
     * Save gallery item
     * @param $image
     * @param $gallery
     * @param $restaurant
     * @return mixed
     */
    private function createGalleryItem($image, $gallery, $restaurant){
        $gallery_item = new GalleryItems();
        $gallery_item->image_id = $image->id;
        $gallery_item->gallery_id = $gallery->id;
        $gallery_item->sorting = 10;
        $gallery_item->save();
        $image_langs = [];
        foreach(config('app.locales') as $locale){
            $gallery_item_lang = new GalleryItemsLangs();
            $gallery_item_lang->lang = $locale;
            foreach($restaurant->languages as $lang){
                if($lang->language == $locale){
                    if(isset($lang->name)){
                        $gallery_item_lang->alt = $lang->name;
                    }elseif(isset($lang->name)){
                        $gallery_item_lang->alt = $lang->name;
                    }
                }
            }
            $gallery_item->langs()->save($gallery_item_lang);
            $image_langs[$locale] = $gallery_item_lang;
        }
        $data['image'] = $image;
        $data['image_langs'] = $image_langs;

        return $data;
    }

    /**
     * remove item from gallery (hall, restaurant, menu)
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function removeGalleryItem($id){
        /** @var GalleryItems $item */
        $item = GalleryItems::where('id','=',$id)->with('langs', 'image')->first();
        if(file_exists(public_path($item->image->filepath))) {
            unlink(public_path($item->image->filepath));
        }
        $item->langs()->delete();
        $item->image()->delete();
        $item->delete();
        return redirect()->back();
    }
}
