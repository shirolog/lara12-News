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
               
                $summerizeArticeles = News::summarizeNews($article['description']);
                $content = json_decode($summerizeArticeles->getContent(), true);
            }
        }
        dd($articles);
        return view('news.index');
    }

}
