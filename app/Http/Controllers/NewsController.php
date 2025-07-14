<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index() {

        $articles = [];
        $keyword = request()->input('keyword');

        $articles = News::getNews();
    
        $summerizeArticeles = [];
    
        if(($articles) && isset($articles['articles'])) {
            foreach ($articles['articles'] as $article) {
               
                $jsonSummerizeArticeles = News::summarizeNews($article['description']);
                $content = json_decode($jsonSummerizeArticeles->getContent(), true);
                $summerizeArticeles[] = [
                    'title' => $article['title'],
                    'summary' => $content,
                    'url' => $article['url'],
                ];
            }
        }

        $summerizeArticeles = collect($summerizeArticeles);

        // dd($summerizeArticeles);
        return view('news.index', compact('summerizeArticeles'));
    }

}
