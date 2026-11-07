<?php
/**
 * cine4k.com.br — API de Atualização Automática de Capas e Lançamentos
 * Fonte 100% Oficial e Independente: TMDb (The Movie Database)
 * Zero dependência de sites de terceiros.
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$category = $_GET['cat'] ?? 'lancamentos';
$apiKey = '2dca580c2a14b55200e784d157207b4d'; // TMDb API Key Oficial

// Cache local simples em JSON (atualiza a cada 6 horas)
$cacheDir = __DIR__ . '/cache';
if (!is_dir($cacheDir)) {
    @mkdir($cacheDir, 0755, true);
}
$safeCategory = preg_replace('/[^a-z0-9_-]/i', '', $category);
$cacheFile = $cacheDir . '/' . $safeCategory . '.json';

// Se o cache tiver menos de 6 horas, serve do cache
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 21600)) {
    echo file_get_contents($cacheFile);
    exit;
}

$url = '';
switch ($category) {
    case 'lancamentos':
        $url = "https://api.themoviedb.org/3/movie/now_playing?api_key={$apiKey}&language=pt-BR&page=1";
        break;
    case 'acao':
        $url = "https://api.themoviedb.org/3/discover/movie?api_key={$apiKey}&with_genres=28&language=pt-BR&sort_by=popularity.desc&page=1";
        break;
    case 'animacao':
        $url = "https://api.themoviedb.org/3/discover/movie?api_key={$apiKey}&with_genres=16&language=pt-BR&sort_by=popularity.desc&page=1";
        break;
    case 'anime':
        $url = "https://api.themoviedb.org/3/discover/movie?api_key={$apiKey}&with_genres=16&with_keywords=210024|287501&language=pt-BR&sort_by=popularity.desc&page=1";
        break;
    case 'series':
        $url = "https://api.themoviedb.org/3/tv/popular?api_key={$apiKey}&language=pt-BR&page=1";
        break;
    default:
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=pt-BR&page=1";
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Cine4K/1.0 (https://cine4k.com.br)');
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    $items = [];
    if (isset($data['results']) && is_array($data['results'])) {
        foreach (array_slice($data['results'], 0, 15) as $item) {
            $isTv = isset($item['name']);
            $title = $isTv ? ($item['name'] ?? '') : ($item['title'] ?? '');
            $posterPath = $item['poster_path'] ?? '';
            $backdropPath = $item['backdrop_path'] ?? '';
            $date = $isTv ? ($item['first_air_date'] ?? '') : ($item['release_date'] ?? '');
            $year = !empty($date) ? substr($date, 0, 4) : '2026';
            
            if (!empty($title) && !empty($posterPath)) {
                $items[] = [
                    'id' => 'tmdb-' . ($item['id'] ?? uniqid()),
                    'title' => $title,
                    'poster' => 'https://image.tmdb.org/t/p/w400' . $posterPath,
                    'backdrop' => 'https://image.tmdb.org/t/p/w1280' . ($backdropPath ?: $posterPath),
                    'rating' => isset($item['vote_average']) ? number_format($item['vote_average'], 1) : '8.5',
                    'year' => $year,
                    'duration' => $isTv ? 'Série' : '4K Ultra HD',
                    'category' => $isTv ? 'Séries | Populares em 4K' : 'Filmes | 4K',
                    'overview' => !empty($item['overview']) ? $item['overview'] : 'Assista a este título completo em alta definição 4K Ultra HD no aplicativo Cine 4K.',
                    'type' => $isTv ? 'series' : 'movie'
                ];
            }
        }
    }
    $output = json_encode(['success' => true, 'count' => count($items), 'items' => $items], JSON_UNESCAPED_UNICODE);
    @file_put_contents($cacheFile, $output);
    echo $output;
} else {
    echo json_encode(['success' => false, 'items' => []]);
}

