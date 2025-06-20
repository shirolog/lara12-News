<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class News extends Model
{
    use HasFactory;

    //ニュースの取得
    public static function getNews($keyword=null) {

        $baseUrl = 'https://newsapi.org/v2/top-headlines';
        $apiKey = config('services.newsapi.key'); 
        
        $params = [
            'country' => 'JP',
            'apiKey' => $apiKey,
        ];

        //キーワードを含むニュースを取得
        if($keyword) {
            $params['q'] = urlencode($keyword);
        }

        // ?country=jp&q=keyword&apiKey=... の形式に変換
        $response = Http::get($baseUrl, $params);

        if($response->failed()) {
            throw new \Exception('Failed to fetch news');
        }

        return $response->json();
    }
}
