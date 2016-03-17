<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;
use \Hash;

class Url extends Model
{
    protected $table = "url";

    protected $fillable = ["url", "shortened_url"];

    public static function validate($data)
    {
        $rules = [
            "url" => "required|url"
        ];

        return Validator::make($data, $rules);
    }

    public static function shortenAndSave($url)
    {
        $shortened_url = self::shorten($url);

        $urlObj = Url::create([
            "url" => $url,
            "shortened_url" => $shortened_url
        ]);

        return $urlObj;
    }

    public static function shortenedUrlExists($url)
    {
        $url = Url::where("shortened_url", $url)
            ->first();

        if ($url)
            return true;
        else
            return false;
    }

    public static function shorten($url)
    {
        $url_hash = Hash::make($url);
        $url_hash = substr($url_hash, 7);

        $shortened_url = "";
        $shortened_unique = false;
        $shortened_length = 4;

        while ($shortened_unique != true) {
            $shortened_url = substr($url_hash, 0, $shortened_length);

            if (self::shortenedUrlExists($shortened_url) == true) {
                $shortened_unique = false;

                $shortened_length ++;
            }
            else {
                $shortened_unique = true;
            }
        }

        return $shortened_url;
    }
}
