<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ニュース要約-TOP</title>

    <!-- tailwindcss cdn -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4">ニュース要約</h1>
        <form action="{{ route('news.index') }}" method="get">
            <input type="text" name="keyword" class="border border-gray-300 rounded-md p-2"
            placeholder="キーワードを入力" value="">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">検索</button>
        </form>
    </div>
    @if($summerizeArticeles->isNotEmpty())
        @foreach($summerizeArticeles as $article)
            <div class="mb-4 border border-gray-300 rounded-md p-4">
                <h2 class="text-lg font-bold">{{ $article['title'] }}</h2>
                <p class="text-xs my-2">要約内容</p>
               <div class="border border-blue-100 p-2 rounded-sm">{{ $article['summary']}}</div>
               <a href="{{ $article['url'] }}" class="text-blue-500">詳細を見る</a>
            </div>
        @endforeach
        @else
        <p>記事が見つかりませんでした。</p>
    @endif


</body>
</html>