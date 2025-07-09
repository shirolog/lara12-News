<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class News extends Model
{
    use HasFactory;

    //ニュースの取得
    public static function getNews($keyword=null) {

        $baseUrl = 'https://newsapi.org/v2/top-headlines';
        $apiKey = config('services.newsapi.key'); 
        
        $params = [
            'sources' => 'bild',
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

    public static function summarizeNews($content) {
        $client = new Client();
        $apiKey = config('services.mistral.key');
        $systemRole = 'あなたは優秀なWebライターです';
        $prompt = <<<EOT
        以下の英文ニュースを日本語に翻訳したあと、100文字以内で要約してください。
        
        #記事
        $content
        EOT;  
        
        try{
            $response = $client->post('https://api.mistral.ai/v1/chat/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $apiKey,
                ],
                'json' => [
                    'model' => 'mistral-small',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemRole],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 300,
                ]
            ]);
            $response = json_decode($response->getBody(), true);
            $summarizedContent = $response['choices'][0]['message']['content'];
            return response()->json($summarizedContent);        

            }catch(\Exception $e){
                
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
