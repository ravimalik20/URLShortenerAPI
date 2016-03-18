<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Url;
use App\Models\UrlRequest;

use \Redirect;

class ApiController extends Controller
{
    public function shorten(Request $request)
    {
        $response = [
            "status" => "unprocessed",
            "errors" => [],
            "shortened_url" => "",
            "original_url" => ""
        ];

        $validation = Url::validate($request->all());
        if ($validation->fails()) {
            $errors = $validation->messages()->all();

            $response = [
                "status" => "error",
                "errors" => $errors
            ];

            return json_encode($response);
        }

        $shortened = Url::shortenAndSave($request->input("url"));

        $response = [
            "status" => "success",
            "shortened_url" => url($shortened->shortened_url),
            "original_url" => $request->input('url')
        ];

        return json_encode($response);
    }

    public function redirectExternal(Request $request, $token)
    {
        $url = Url::where("shortened_url", $token)
            ->first();

        $ip_address = $request->ip();

        UrlRequest::record($url, $ip_address);

        if (!$url) {
            $response = [
                "status" => "error",
                "errors" => [
                    "No such URL exists."
                ]
            ];

            return json_encode($response);
        }

        return Redirect::away($url->url);
    }
}
