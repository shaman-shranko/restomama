<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GalleryItemsLangs
 *
 * @property int $id
 * @property int $gallery_item_id
 * @property string $lang
 * @property string|null $title
 * @property string|null $subtitle
 * @property string $alt
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereGalleryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItemsLangs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GalleryItemsLangs extends Model
{
    protected $fillable = [
        'lang','title','subtitle','link','alt'
    ];
}
