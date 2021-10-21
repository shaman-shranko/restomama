<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
/**
 * App\Images
 *
 * @property int $id
 * @property string $filename
 * @property string $filepath
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images whereFilepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Images whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Images extends Model
{
    protected $fillable = [
        'filename','filepath'
    ];

    public function restaurant(){
        $this->hasOne(Restaurant::class);
    }
}
