<?php

namespace App\Http\Controllers\Admin;

use App\GalleryItems;
use App\Http\Controllers\Controller;
use App\Images;
use App\Restaurant;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{

    public function index(){
        $data['images_count'] = Images::count();
        $data['images_resized'] = Images::where('resized', '=', true)->count();

        $items = GalleryItems::with('image')->get();
        $countGalleryWrong = 0;
        foreach($items as $item){
            if(!isset($item->image)){
                $countGalleryWrong++;
            }
        }
        $data['wrong_gallery_images'] = $countGalleryWrong;

        $items = Restaurant::with('image')->get();
        $countWrongThumb = 0;
        foreach ($items as $item){
            if(!isset($item->image)){
                $countWrongThumb++;
            }
        }

        $data['wrong_thumb_images'] = $countWrongThumb;

        return view('admin.resize', $data);
    }

    public static function imageUpload($u_image, $path, $exist = false, $exist_id = 0){
        if($exist){
            $image = Images::find($exist_id);
            app(Filesystem::class)->delete(public_path($image->filepath));
        }else{
            $image = new Images();
        }
        $imageName = time().'_'.str_replace(' ', '_', $u_image->getClientOriginalName());
        $u_image->move(public_path($path),$imageName);

        $image->filename    = $imageName;
        $image->filepath    = $path.$imageName;
        $image->save();

        return $image;
    }

    public static function imageResize($image, $sizes){
        foreach($sizes as $key => $size){
            $img = Image::make(public_path($image->filepath));

            $save_folder = 'resizes/'.$size[1].'x'.$size[2].'/';
            $save_path_jpg = $save_folder.$image->filename;
            $save_path = $save_path_jpg.'.webp';

            if(file_exists(public_path($image->filepath)) && isset($image->filename)){
                if(!file_exists(public_path($save_path_jpg))){

                    if(!file_exists(public_path($save_folder))){
                        mkdir(public_path($save_folder));
                    }

                    $img->fit($size[1], $size[2], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $img->save(public_path($save_path_jpg));

                    if(!file_exists(public_path($save_path))){
                        $webp = $img->encode('webp');
                        $webp->save($save_path);
                    }
                }
            }
        }
        $image->resized = true;
        $image->save();
    }

    /**
     * @param $image
     * @param $sizes
     * @return array
     */
    public static function imageResponsive($image, $sizes)
    {
        $data = [];
        $srcset = '';
        $src = '';
        $need_resizing = false;
        $support_webp = strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false;
        foreach($sizes as $key => $size){
            $save_folder = 'resizes/'.$size[1].'x'.$size[2].'/';
            $save_path_jpg = $save_folder.$image->filename;
            $save_path = $save_path_jpg.'.webp';
            if(!file_exists(public_path($save_path_jpg)) || !file_exists($save_path)){
                $need_resizing = true;
                break;
            }
        }
        if($need_resizing){
            $img = Image::make(public_path($image->filepath));
        }

        foreach($sizes as $key => $size){
            $save_folder = 'resizes/'.$size[1].'x'.$size[2].'/';
            $save_path_jpg = $save_folder.$image->filename;
            $save_path = $save_path_jpg.'.webp';

            if(!file_exists(public_path($save_path_jpg))){
                if(!file_exists(public_path($save_folder))){
                    mkdir(public_path($save_folder));
                }
                if($key == 0){
                    $img->fit($size[1], $size[2], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }else{
                    $img->fit($size[1], $size[2], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $img->save(public_path($save_path_jpg));
                $save_path = $save_path_jpg;
            }else if($support_webp && !file_exists(public_path($save_path))){
                $webp = Image::make($save_path_jpg);
                $webp->encode($webp);
                $webp->save($save_path);
            }else if(!$support_webp){
                $save_path = $save_path_jpg;
            }


            if($key == 0){
                $src = '/'.$save_path;
            }
            $srcset .= '/'.$save_path.' '.$size[0].'w,';
        }

        $data['src'] = $src;
        $data['srcset'] = $srcset;
        return $data;
    }

    public function isRestaurantsThumbs($image){
        $restaurants = Restaurants::with('image')->get();
        $images = [];
        foreach ($restaurants as $restaurant){
            if(isset($restaurant->image)){
                $images[] = $restaurant->image;
            }
        }
        $collection = collect($images);
        return $collection->contains($image);
    }

    /**
     * Now get all images. After 3 month need for chunked query
     */
    public function resizeOne(){
        $image = Images::where('resized', '=', false)->first();
        try{
            if($this->isRestaurantsThumbs($image)){
                $this->imageResize($image, config('image.sizes.card'));
            }
            $this->imageResize($image, config('image.sizes.fullwidth'));
            $image->resized = true;
            $image->save();

            return response()->json("success");
        }catch(NotReadableException $e){
            if(!file_exists(public_path($image->filepath))){
                $image->delete();
            }else{
                unlink(public_path($image->filepath));
                $image->delete();
            }
            return response()->json($image);
        }

    }

    public function removeResizes(){
        $images = Images::get();
        foreach($images as $image){
            foreach (config('image.sizes') as $variant){
                foreach($variant as $size){
                    $path = 'resizes/'.$size[1].'x'.$size[2].'/'.$image->filename;
                    $path_webp = $path.'.webp';
                    if(file_exists(public_path($path))){
                        unlink(public_path($path));
                    }
                    if(file_exists(public_path($path_webp))){
                        unlink(public_path($path_webp));
                    }
                }
            }
            $image->resized = false;
            $image->save();
        }

        return response()->json("success");
    }

    public function removeWrong(){
        $items = GalleryItems::with('image', 'langs')->get();
        foreach($items as $item){
            if(!isset($item->image)){
                $item->langs()->delete();
                $item->image()->delete();
                $item->delete();
            }
        }
        $items = Restaurants::with('image')->get();
        foreach ($items as $item){
            if(!isset($item->image)){
                $item->image_id = null;
                $item->save();
            }
        }

        return response()->json("success");
    }


}
