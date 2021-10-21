<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
/**
 * Class Galleries
 *
 * @package App
 * @mixin Eloquent;
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Restaurant $gallery_restaurant
 * @property-read \App\Images $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GalleryItems[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GalleryLangs[] $langs
 * @property-read int|null $langs_count
 * @property-read \App\Restaurant $menu_restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Galleries whereUpdatedAt($value)
 */
class Galleries extends Model
{
    protected $fillable = [
        'type'
    ];

    public function gallery_restaurant(){
        return $this->hasOne(Restaurant::class, 'gallery_id','id')->with('languages');
    }

    public function menu_restaurant(){
        return $this->hasOne(Restaurant::class, 'menu_id', 'id')->with('languages');
    }

    public function image(){
        return $this->hasOne(Images::class);
    }

    public function langs(){
        return $this->hasMany(GalleryLangs::class, 'gallery_id');
    }

    public function items(){
        return $this->hasMany(GalleryItems::class, 'gallery_id')->with(['langs','image']);
    }
}
