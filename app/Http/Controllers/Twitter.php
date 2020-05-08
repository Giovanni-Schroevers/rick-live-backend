<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Twitter extends BaseController
{
    public static function tweet($content) {

        $settings = [
            'oauth_access_token' => env("TWITTER_ACCESS_TOKEN"),
            'oauth_access_token_secret' => env("TWITTER_ACCESS_TOKEN_SECRET"),
            'consumer_key' => env("TWITTER_CONSUMER_KEY"),
            'consumer_secret' => env("TWITTER_CONSUMER_SECRET")
        ];
        $twitter = new TwitterAPIExchange($settings);
        try {
            $twitter->setPostfields(["status" => $content]);
            $twitter->buildOauth("https://api.twitter.com/1.1/statuses/update.json", "POST");
            $response = $twitter->performRequest(true, [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ]);
            echo $response;
        } catch (\Exception $e) {
            echo $e;
        }
    }
}
