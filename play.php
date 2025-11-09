<?php
// play.php - wrapper page to display a target game URL inside an iframe on your domain.
// Query params:
//  - url: the target game URL (must be URL-encoded)
//  - id : optional game id
// Security: validate / whitelist hosts if possible before embedding.

$target = isset($_GET['url']) ? urldecode($_GET['url']) : '';
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

if (empty($target)) {
  http_response_code(400);
  echo "Missing target URL.";
  exit;
}

// Optional: basic whitelist example (uncomment and edit if desired)
// $allowedHosts = ['gamemonetize.com', 'example-game-host.com'];
// $parts = parse_url($target);
// if (!$parts || !in_array($parts['host'], $allowedHosts)) {
//   echo "This game host is not allowed.";
//   exit;
// }

// Serve minimal wrapper with ad slots on your domain (replace ad placeholders with your ad code)
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo htmlspecialchars($id ?: 'Game'); ?> - Play</title>
  <style>
    html,body {height:100%; margin:0; background:#7b4f35; color:#fff; font-family: Arial, Helvetica, sans-serif;}
    .container {height:100%; display:flex; flex-direction:column;}
    .topbar {padding:12px 16px; background: rgba(0,0,0,0.06); display:flex; align-items:center; justify-content:space-between;}
    .iframe-wrap {flex:1; background:#000; display:flex; align-items:center; justify-content:center;}
    iframe {width:100%; height:100%; border:0;}
    .ad-slot {width:100%; max-width:728px; margin:8px auto;}
    .footer {padding:8px;text-align:center;color:#eee;font-size:13px}
  </style>
</head>
<body>
  <div class="container">
    <div class="topbar">
      <div><strong>Lock Screen Rewards</strong></div>
      <div><?php echo htmlspecialchars($id ?: ''); ?></div>
    </div>

    <!-- Ad slot: replace with your real ad tag (AdSense/Ad Manager/other). -->
    <div class="ad-slot" aria-hidden="true">
      <div style="background:#f1e7df;color:#7b4f35;padding:12px;border-radius:8px;text-align:center;">
        Ad space — replace with your ad tag. ads.txt is at https://lockscreenrewards.site/ads.txt
      </div>
    </div>

    <div class="iframe-wrap">
      <iframe src="<?php echo htmlspecialchars($target); ?>" allow="autoplay; fullscreen" sandbox="allow-scripts allow-forms allow-pointer-lock allow-same-origin"></iframe>
    </div>

    <div class="footer">Powered by LockScreenRewards</div>
  </div>
</body>
</html>