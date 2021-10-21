<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GalleryLangs
 *
 * @property int $id
 * @property string $lang
 * @property int $gallery_id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GalleryLangs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GalleryLangs extends Model
{
    protected $fillable = [
        'lang', 'name'
    ];

    public function gallery(){
        $this->belongsTo(Galleries::class);
    }
}
