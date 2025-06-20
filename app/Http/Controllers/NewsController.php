<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index() {

        $articles = [];
        $keyword = request()->input('keyword');

        $articles = News::getNews($keyword);
        dd($articles);
        return view('news.index');
    }

}
