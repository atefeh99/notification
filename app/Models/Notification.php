<?php


namespace App\Models;


use App\Helpers\Date;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $hidden = [
        'updated_at'
    ];
    protected $fillable = [
        "date",
        "job_id",
        "metadata",
        "type",
        "topic"
    ];
    protected $casts = [
        'metadata' => 'array'
    ];
    public static function createItem($data)
    {
        return self::create($data);
    }
    public static function show($id)
    {
        return self::findOrFail($id);
    }
    public static function index($take,$skip)
    {
        return self::take($take)->skip($skip)->get()->toArray();

    }
    public static function updateItem($data,$id)
    {
        $item =  self::where('id', $id)->firstOrFail();
        foreach ($data as $key => $value) {
            $item->update([$key => $value]);
        }
        return $item;

    }
    public static function removeItem($id)
    {
        $item = self::where('id', $id)->firstOrFail();
        $item->delete();
        return $item;


    }
    public function getCreatedAtAttribute($value)
    {
        return Date::convertCarbonToJalali($value);
    }

}
