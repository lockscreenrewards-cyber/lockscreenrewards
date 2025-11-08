<?php
// feed.php - simple proxy that fetches the original GameMonetize feed and rewrites game URLs
// to point to your wrapper (play.php). Use this if you want the app to read feed from your domain.

// upstream feed (GameMonetize)
$source = 'https://gamemonetize.com/feed.php?format=0&platform=1&num=50&page=1';

// fetch upstream
$opts = [
  "http" => [
    "timeout" => 15
  ]
];
$context = stream_context_create($opts);
$resp = @file_get_contents($source, false, $context);
if ($resp === false) {
  http_response_code(502);
  echo json_encode(['error' => 'Failed to fetch upstream feed']);
  exit;
}

$decoded = json_decode($resp, true);
if (!is_array($decoded)) {
  // not JSON, return original
  header('Content-Type: application/json');
  echo $resp;
  exit;
}

// rewrite each item url to point to your wrapper
foreach ($decoded as $i => $item) {
  if (is_array($item) && !empty($item['url'])) {
    $encoded = urlencode($item['url']);
    $id = urlencode($item['id'] ?? '');
    $decoded[$i]['url'] = "https://lockscreenrewards.site/play.php?url={$encoded}&id={$id}";
  }
}

header('Content-Type: application/json');
echo json_encode($decoded);