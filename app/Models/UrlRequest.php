<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;
use \Hash;

class UrlRequest extends Model
{
    protected $table = "url_requests";

    protected $fillable = ["url_id", "ip_address"];

    public static function record($url, $ip_address)
    {
        $url_record = UrlRequest::create([
            "url_id" => $url->id,
            "ip_address" => $ip_address
        ]);

        return $url_record;
    }
}
