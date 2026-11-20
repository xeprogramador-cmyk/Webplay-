<?php
// Devolve a lista de imagens da pasta (a mais recente primeiro), para o telefone da página usar qualquer imagem.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$pastas = ['', 'assets/', 'img/', 'imagens/', 'images/'];
$ext = ['png','jpg','jpeg','webp','gif','avif','bmp','svg'];
$achadas = [];
foreach ($pastas as $p) {
  $dir = __DIR__ . '/' . $p;
  if (!is_dir($dir)) continue;
  foreach (scandir($dir) as $f) {
    if ($f[0] === '.') continue;
    if (!is_file($dir . $f)) continue;
    if (!in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $ext)) continue;
    if (preg_match('/^webplay-(web|azul)\./i', $f)) continue; // ignora o logotipo
    $achadas[] = ['p' => $p . $f, 't' => filemtime($dir . $f)];
  }
}
usort($achadas, function($a, $b){ return $b['t'] - $a['t']; });
echo json_encode(array_map(function($x){ return $x['p']; }, $achadas));
