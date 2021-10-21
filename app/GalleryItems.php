<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class GalleryItems
 *
 * @package App
 * @mixin Eloquent;
 * @property int $id
 * @property int $gallery_id
 * @property int $image_id
 * @property int $sorting
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Galleries $gallery
 * @property-read \App\Images $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GalleryItemsLangs[] $langs
 * @property-read int|null $langs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereSorting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryItems whereUpdatedAt($value)
 */
class GalleryItems extends Model
{
    protected $fillable = [
        'sorting'
    ];

    public function gallery(){
        return $this->belongsTo(Galleries::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function langs(){
        return $this->hasMany(GalleryItemsLangs::class, 'gallery_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image(){
        return $this->belongsTo(Images::class);
    }
}
