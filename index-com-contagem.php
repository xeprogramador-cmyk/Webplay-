<?php
// ===== PORTA DE ENTRADA =====
// Link partilhado de dentro do app (tem &de=app) aberto num navegador Android SEM o app:
// o site NÃO é mostrado. A pessoa vê só "Abrindo o aplicativo…"; se o app estiver instalado ele abre
// no título, e se não estiver vai direto para o download (nunca vê o site nem o link dele).
// Robôs de pré-visualização (WhatsApp, Telegram...) passam normalmente, para a capa continuar a aparecer.
function webplayPortaDeEntrada(){
  $APP_PACOTE       = 'co.median.android.dykpbqj';              // igual ao APP_PACOTE mais abaixo
  $APP_URL_DOWNLOAD = '';    // COLOQUE AQUI o link do APK no seu servidor (igual ao APP_URL_DOWNLOAD mais abaixo)
  if (($_GET['de'] ?? '') !== 'app') return;
  $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
  if (!preg_match('/Android/i', $ua)) return;
  if (preg_match('/bot|crawler|spider|preview|WhatsApp|facebookexternalhit|Telegram|Twitter|Discord|Slack|Skype|LinkedIn|Pinterest|embedly|vkShare/i', $ua)) return;
  $xrw = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
  $ehPacote = preg_match('/^[a-z][a-z0-9_]*(\.[a-z0-9_]+)+$/i', $xrw)
    && !preg_match('/^(com\.android\.chrome|com\.chrome\.|org\.mozilla\.|com\.brave\.|com\.opera\.|com\.sec\.android\.app\.sbrowser|com\.microsoft\.emmx|com\.google\.android\.apps\.chrome|com\.kiwibrowser|com\.duckduckgo|idm\.internet)/i', $xrw);
  if ($ehPacote || preg_match('/; wv\)|WebPlayApp/i', $ua)) return;   // já está dentro do app: mostra o site
  $pk = $APP_PACOTE !== '' ? $APP_PACOTE : preg_replace('/[^a-z0-9_.]/i', '', $_GET['pk'] ?? '');
  if ($pk === '') return;

  $host  = $_SERVER['HTTP_HOST'] ?? '';
  $path  = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
  $query = $_SERVER['QUERY_STRING'] ?? '';
  $fb    = rawurlencode($APP_URL_DOWNLOAD);
  $abrirTitulo = 'intent://' . $host . $path . ($query !== '' ? '?' . $query : '') . '#Intent;scheme=https;package=' . $pk . ';S.browser_fallback_url=' . $fb . ';end';
  $abrirApp    = 'intent:#Intent;action=android.intent.action.MAIN;category=android.intent.category.LAUNCHER;package=' . $pk . ';S.browser_fallback_url=' . $fb . ';end';

  header('Cache-Control: no-store');
  header('X-Robots-Tag: noindex');
  echo '<!DOCTYPE html><html lang="pt"><head><meta charset="UTF-8">'
     . '<meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex">'
     . '<title>WebPlay</title><style>'
     . 'html,body{margin:0;height:100%;background:#0d0f14;color:#eae6dd;font-family:system-ui,sans-serif;}'
     . 'body{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:24px;}'
     . 'a{display:block;width:100%;max-width:320px;box-sizing:border-box;margin-top:12px;padding:14px;border-radius:24px;font-weight:bold;text-decoration:none;}'
     . '.p{background:#e0a33c;color:#1a1305;}.s{border:1px solid #555;color:#eae6dd;}'
     . '#bt{display:none;width:100%;max-width:320px;margin-top:18px;}'
     . '</style></head><body><b style="font-size:1.1rem">Abrindo o aplicativo…</b>'
     . '<div id="bt"><a class="p" href="' . htmlspecialchars($abrirTitulo, ENT_QUOTES) . '">Abrir o aplicativo</a>'
     . ($APP_URL_DOWNLOAD !== '' ? '<a class="s" href="' . htmlspecialchars($APP_URL_DOWNLOAD, ENT_QUOTES) . '">Baixar o aplicativo</a>' : '') . '</div>'
     . '<script>setTimeout(function(){document.getElementById("bt").style.display="block";},2500);'
     . 'location.replace(' . json_encode($abrirTitulo) . ');</script></body></html>';
  exit;
}
webplayPortaDeEntrada();
?>
<?php
// Procura as imagens do logótipo na pasta assets/ ou, se não existir, na mesma pasta do index.
$logoDir = 'assets/';
foreach (['assets/', '', 'img/', 'imagens/', 'images/'] as $d) {
  if (is_file(__DIR__ . '/' . $d . 'webplay-web.png') || is_file(__DIR__ . '/' . $d . 'webplay-azul.png')) { $logoDir = $d; break; }
}
$logoVer = (int) @filemtime(__DIR__ . '/' . $logoDir . 'webplay-web.png') ?: 1;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<link rel="preconnect" href="https://uplcm.com">
<link rel="dns-prefetch" href="https://uplcm.com">
<meta charset="UTF-8">
<link rel="preconnect" href="https://superflixapi.monster" crossorigin>
<link rel="dns-prefetch" href="https://superflixapi.monster">
<link rel="preconnect" href="https://challenges.cloudflare.com" crossorigin>
<script>
(function(){try{
  var h=document.documentElement, ls=localStorage;
  if(ls.getItem("webplay_sem_cab")==="1") h.setAttribute("data-sem-cab","1");
  if(ls.getItem("webplay_nome_cab")) h.setAttribute("data-nome-cab","1");
  var b=ls.getItem("webplay_borda"); if(b && b!=="auto") h.setAttribute("data-borda",b);
  var F={estilo:["'Chakra Petch'","Chakra+Petch:wght@400;600;700"],rajdhani:["'Rajdhani'","Rajdhani:wght@400;600;700"],poppins:["'Poppins'","Poppins:wght@400;600;700"],montserrat:["'Montserrat'","Montserrat:wght@400;600;700"],space:["'Space Grotesk'","Space+Grotesk:wght@400;600;700"],quicksand:["'Quicksand'","Quicksand:wght@400;600;700"],playfair:["'Playfair Display'","Playfair+Display:wght@400;600;700"],lora:["'Lora'","Lora:wght@400;600;700"]};
  var id=ls.getItem("webplay_fonte")||(document.cookie.match(/webplay_fonte=([^;]+)/)||[])[1]||"estilo";
  var f=F[id];
  if(f){
    h.style.setProperty("--fonte-app",f[0]); h.setAttribute("data-fonte",id);
    var l=document.createElement("link"); l.rel="stylesheet"; l.href="https://fonts.googleapis.com/css2?family="+f[1]+"&display=swap"; document.head.appendChild(l);
    var st=document.createElement("style"); st.textContent="html[data-fonte] #ligarServidor,html[data-fonte] #ligarServidor *{font-family:var(--fonte-app),system-ui,sans-serif !important;}"; document.head.appendChild(st);
  }
}catch(e){}})();
</script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
<?php include __DIR__ . '/og-meta.php'; ?>
<title><?= htmlspecialchars($og_title ?? 'Catálogo', ENT_QUOTES, 'UTF-8') ?></title>
<style>
  :root{
    --bg:#0d0f14; --panel:#161a22; --ink:#eae6dd; --muted:#8a8f9c;
    --accent:#e0a33c; --accent-dim:#7a5a20; --line:#232833;
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  body{background:var(--bg);color:var(--ink);font-family:'Segoe UI',system-ui,sans-serif;line-height:1.4;}
  h1,h2,h3{font-family:Georgia,'Times New Roman',serif;font-weight:600;}

  header{
    position:relative;
    padding:14px 4vw 12px;
    display:flex;flex-direction:column;align-items:center;gap:10px;
    border-bottom:1px solid var(--line);
    background:linear-gradient(180deg,var(--panel),var(--bg));
  }
  header h1{font-size:1.45rem;letter-spacing:0.5px;text-align:center;line-height:1.2;}
  header h1 span{color:var(--accent);}
  .search{flex:none;width:100%;max-width:460px;position:relative;display:flex;gap:8px;}
  .search input{width:100%;padding:10px 14px;border-radius:8px;border:1px solid var(--line);background:var(--panel);color:var(--ink);font-size:.9rem;}
  @media (min-width:640px){
    header{padding:28px 5vw 22px;gap:14px;}
    header h1{font-size:2rem;}
  }
  .search input:focus{outline:2px solid var(--accent);}
  .history-btn{background:var(--panel);border:1px solid var(--line);color:var(--accent);border-radius:8px;padding:0 14px;font-size:1rem;cursor:pointer;}
  .history-btn:hover{background:var(--accent-dim);color:var(--ink);}
  .search-suggestions{
    display:none;position:absolute;top:calc(100% + 6px);left:0;right:46px;
    max-width:340px;background:var(--panel);border:1px solid var(--line);border-radius:14px;
    max-height:240px;overflow-y:auto;z-index:20;box-shadow:0 8px 20px rgba(0,0,0,.5);
  }
  .sugestao-item{display:flex;align-items:center;gap:8px;padding:10px 14px;font-size:.85rem;cursor:pointer;border-bottom:1px solid var(--line);}
  .sugestao-item:last-child{border-bottom:none;}
  .sugestao-item:hover{background:var(--accent-dim);color:var(--ink);}
  .sugestao-item .icone-historico{opacity:.6;flex-shrink:0;}
  .sugestao-item .texto-sugestao{flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .sugestao-item .btn-remover-sugestao{margin-left:auto;color:var(--muted);font-size:1.05rem;padding:0 4px;flex-shrink:0;}
  .sugestao-item .btn-remover-sugestao:hover{color:#ff5252;}

  /* ===== Ecrã cheio de Histórico (abre ao clicar no ícone 🕒) — mostra em
     cards, como nos resultados de pesquisa, os títulos que já abriste neste
     aparelho. Só visualização nova; não mexe na pesquisa/sugestões acima. */
  .tela-historico{display:none;position:fixed;inset:0;z-index:800;background:var(--bg);overflow-y:auto;}
  .tela-historico.aberta{display:block;}
  .tela-historico-cabecalho{
    position:sticky;top:0;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:10px;
    padding:16px 5vw;background:var(--panel);border-bottom:1px solid var(--line);
  }
  .tela-historico-titulo{font-size:1.2rem;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:8px;font-family:inherit;}
  .tela-historico-acoes{display:flex;align-items:center;gap:10px;}
  .btn-limpar-historico{background:none;border:1px solid var(--line);color:var(--muted);border-radius:20px;padding:6px 12px;font-size:.72rem;cursor:pointer;font-family:inherit;}
  .btn-limpar-historico:hover{border-color:#ff5252;color:#ff5252;}
  .tela-historico-fechar{font-size:1.3rem;color:var(--ink);cursor:pointer;line-height:1;padding:4px 10px;border-radius:50%;background:var(--panel);border:1px solid var(--line);}
  .tela-historico-fechar:hover{border-color:var(--accent-dim);}
  .tela-historico-corpo{padding:18px 5vw 60px;}

  /* ===== Seletor de temporada no ecrã de detalhes (só aparece em
     série/anime/dorama — filme continua só com "Assistir Agora"). ===== */
  .detalhes-temporada-bloco{display:flex;gap:10px;align-items:center;margin-bottom:18px;}
  .detalhes-temporada-label{display:flex;flex-direction:column;gap:4px;font-size:.72rem;color:var(--muted);}
  .detalhes-temporada-label select{background:var(--panel);border:1px solid var(--line);color:var(--ink);border-radius:8px;padding:8px 10px;font-size:.9rem;font-family:inherit;}
  .detalhes-temporada-bloco .btn-play-principal{flex:1;margin:0;}

  /* ===== NOVO: menu customizado que substitui a lista branca nativa do
     Android quando se abre um <select> (temporada/episódio). Visualmente
     seguimos o mesmo esquema de cores do resto do site. ===== */
  .seletor-custom{position:relative;display:inline-block;}
  .seletor-custom-botao{display:flex;align-items:center;justify-content:space-between;gap:10px;background:var(--panel);border:1px solid var(--line);color:var(--ink);border-radius:8px;padding:8px 12px;font-size:.9rem;font-family:inherit;cursor:pointer;min-width:76px;}
  .seletor-custom-botao:after{content:"▾";color:var(--accent);font-size:.72rem;line-height:1;}
  .seletor-custom.aberto .seletor-custom-botao:after{content:"▴";}
  .seletor-custom-botao:hover{border-color:var(--accent-dim);}
  .seletor-custom-lista{display:none;position:absolute;top:calc(100% + 6px);left:0;min-width:100%;max-height:240px;overflow-y:auto;background:var(--panel);border:1px solid var(--line);border-radius:10px;box-shadow:0 12px 26px rgba(0,0,0,.6);z-index:120;}
  .seletor-custom.aberto .seletor-custom-lista{display:block;}
  .seletor-custom-opcao{padding:9px 16px;font-size:.88rem;color:var(--ink);cursor:pointer;border-bottom:1px solid var(--line);white-space:nowrap;}
  .seletor-custom-opcao:last-child{border-bottom:none;}
  .seletor-custom-opcao:hover{background:var(--accent-dim);}
  .seletor-custom-opcao.selecionada{color:var(--accent);font-weight:700;}

  /* ===== Lista tipo "temporada 1,2,3…" (como o picker do Android)
     mas com o tema escuro do site ===== */
  .modal-lista-escolha{
    display:none;position:fixed;inset:0;z-index:1200;
    background:rgba(0,0,0,.72);align-items:flex-end;justify-content:center;
  }
  .modal-lista-escolha.aberto{display:flex;}
  .modal-lista-escolha-caixa{
    width:100%;max-width:480px;max-height:70vh;
    background:var(--panel);border:1px solid var(--line);
    border-radius:18px 18px 0 0;overflow:hidden;
    display:flex;flex-direction:column;
    animation:subirListaEscolha .25s ease-out;
  }
  @keyframes subirListaEscolha{from{transform:translateY(40%);}to{transform:translateY(0);}}
  .modal-lista-escolha-cabecalho{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 16px;border-bottom:1px solid var(--line);flex-shrink:0;
  }
  .modal-lista-escolha-titulo{font-size:.95rem;font-weight:700;color:var(--ink);}
  .modal-lista-escolha-fechar{
    width:32px;height:32px;border-radius:50%;border:1px solid var(--line);
    background:var(--bg);color:var(--ink);font-size:1.1rem;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
  }
  .modal-lista-escolha-opcoes{overflow-y:auto;padding:4px 0 20px;}
  .modal-lista-opcao{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 18px;border-bottom:1px solid var(--line);cursor:pointer;
    font-size:1.05rem;color:var(--ink);font-family:inherit;background:none;width:100%;border-left:none;border-right:none;border-top:none;text-align:left;
  }
  .modal-lista-opcao:last-child{border-bottom:none;}
  .modal-lista-opcao:hover,.modal-lista-opcao:active{background:var(--accent-dim);}
  .modal-lista-opcao .radio-bola{
    width:22px;height:22px;border-radius:50%;border:2px solid var(--muted);
    flex-shrink:0;display:flex;align-items:center;justify-content:center;
  }
  .modal-lista-opcao.selecionada .radio-bola{
    border-color:var(--accent);background:var(--accent);
    box-shadow:inset 0 0 0 4px var(--panel);
  }
  .modal-lista-opcao.selecionada{color:var(--accent);font-weight:700;}


  /* ===== Lista de episódios — mesmo ecrã cheio do Histórico, mas cada
     linha é um episódio: miniatura + "EP SxE" + sinopse + baixar (visual,
     sem função por agora). ===== */
  .tela-episodios{display:none;position:fixed;inset:0;z-index:850;background:var(--bg);overflow-y:auto;}
  .tela-episodios.aberta{display:block;}
  .tela-episodios-cabecalho{
    position:sticky;top:0;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:10px;
    padding:16px 5vw;background:var(--panel);border-bottom:1px solid var(--line);
  }
  .tela-episodios-titulo{font-size:1.05rem;font-weight:700;color:var(--ink);font-family:inherit;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .tela-episodios-fechar{font-size:1.3rem;color:var(--ink);cursor:pointer;line-height:1;padding:4px 10px;border-radius:50%;background:var(--panel);border:1px solid var(--line);flex-shrink:0;}
  .tela-episodios-fechar:hover{border-color:var(--accent-dim);}
  .tela-episodios-corpo{padding:14px 5vw 60px;display:flex;flex-direction:column;gap:10px;}

  .episodio-linha{display:flex;gap:12px;align-items:center;background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:10px;cursor:pointer;transition:border-color .15s ease;}
  .episodio-linha:hover{border-color:var(--accent-dim);}
  .episodio-thumb{position:relative;flex:0 0 96px;width:96px;aspect-ratio:16/9;border-radius:8px;background-size:cover;background-position:center;background-color:#1d222c;}
  .episodio-play{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;background:rgba(0,0,0,.25);border-radius:8px;}
  .episodio-info{flex:1;min-width:0;}
  .episodio-num-nome{font-size:.85rem;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .episodio-data{font-size:.7rem;color:var(--muted);margin:2px 0 4px;}
  .episodio-sinopse{font-size:.78rem;color:var(--muted);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
  .episodio-baixar{flex:0 0 auto;background:none;border:1px solid var(--line);color:var(--muted);border-radius:50%;width:34px;height:34px;font-size:.95rem;cursor:pointer;font-family:inherit;}
  .episodio-baixar:hover{border-color:var(--accent-dim);color:var(--accent);}

  /* ===== Modal de servidor — pequena caixa central, aparece antes do
     leitor abrir (filme: ao clicar Assistir; série: ao clicar um episódio). */
  .modal-servidor{display:none;position:fixed;inset:0;z-index:900;background:rgba(0,0,0,.75);align-items:center;justify-content:center;padding:6vw;}
  .modal-servidor.aberto{display:flex;}
  .modal-servidor-caixa{background:var(--panel);border:1px solid var(--line);border-radius:14px;padding:18px;width:100%;max-width:380px;}
  .modal-servidor-cabecalho{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:16px;}
  .modal-servidor-cabecalho span:first-child{font-size:.95rem;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .modal-servidor-fechar{font-size:1.1rem;color:var(--ink);cursor:pointer;line-height:1;padding:2px 8px;border-radius:50%;background:var(--bg);border:1px solid var(--line);flex-shrink:0;}
  .modal-servidor-fechar:hover{border-color:var(--accent-dim);}
  .modal-servidor-lista{display:flex;flex-direction:column;gap:8px;}
  .btn-servidor{width:100%;background:var(--accent);color:#1a1305;border:none;border-radius:10px;padding:13px;font-size:.9rem;font-weight:700;cursor:pointer;font-family:inherit;}
  .btn-servidor:hover{opacity:.9;}

  /* ===== "Mais Acessados": abas Semanal/Mensal/Todos + lista numerada
     (visual pedido pelo utilizador, com base no smartanimes.net) ===== */
  .tabs-mais-acessados{display:flex;gap:8px;background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:5px;margin-bottom:16px;}
  .tab-periodo{flex:1;background:none;border:none;color:var(--muted);font-family:inherit;font-size:.85rem;font-weight:600;padding:9px 6px;border-radius:8px;cursor:pointer;}
  .tab-periodo.ativa{background:var(--accent);color:#fff;}
  .lista-mais-acessados{display:flex;flex-direction:column;}
  .item-mais-acessado{display:flex;align-items:flex-start;gap:12px;padding:14px 0;border-bottom:1px solid var(--line);cursor:pointer;}
  .item-mais-acessado:last-child{border-bottom:none;}
  .item-mais-acessado .posicao-numero{
    flex:none;width:34px;height:34px;border:1px solid var(--line);border-radius:6px;
    display:flex;align-items:center;justify-content:center;color:var(--muted);font-weight:700;font-size:.95rem;
  }
  .item-mais-acessado .poster-mini{flex:none;width:56px;aspect-ratio:2/3;object-fit:cover;border-radius:6px;background:#1d222c;}
  .item-mais-acessado .info-mais-acessado{min-width:0;}
  .item-mais-acessado .titulo-mais-acessado{font-weight:700;color:var(--ink);font-size:.95rem;line-height:1.3;}
  .item-mais-acessado .generos-mais-acessado{color:var(--muted);font-size:.78rem;margin-top:4px;line-height:1.4;}
  .item-mais-acessado .avaliacao-mais-acessado{display:flex;align-items:center;gap:8px;margin-top:6px;}
  .item-mais-acessado .estrelas{position:relative;display:inline-block;color:var(--line);font-size:.85rem;letter-spacing:1px;}
  .item-mais-acessado .estrelas::before{content:"★★★★★";position:absolute;top:0;left:0;white-space:nowrap;overflow:hidden;width:var(--pct);color:#f5c518;}
  .item-mais-acessado .nota-numero{color:var(--muted);font-size:.82rem;font-style:italic;}

  .profile-btn{
    position:absolute;top:10px;right:3.5vw;
    width:34px;height:34px;border-radius:50%;
    background:var(--panel);border:1px solid var(--line);color:var(--ink);
    font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;
  }
  .profile-btn:hover{border-color:var(--accent-dim);}
  .profile-box{width:min(360px,100%);max-height:100%;background:var(--bg);border-radius:10px;overflow:hidden;border:1px solid var(--line);display:flex;flex-direction:column;}
  .profile-box .player-head{flex:none;}
  .profile-body{padding:6px 16px 12px;display:flex;flex-direction:column;gap:8px;flex:1 1 auto;min-height:0;overflow:hidden;}
  .profile-body > *{flex-shrink:0;}
  /* parte de baixo (Temas): rola sozinha, sem mexer no catálogo por trás */
  .profile-body > .perfil-rolagem{flex:1 1 auto;min-height:120px;overflow-y:auto;overflow-x:hidden;overscroll-behavior:contain;-webkit-overflow-scrolling:touch;touch-action:pan-y;}
  #profileOverlay{overscroll-behavior:contain;}
  body:has(#profileOverlay.open){overflow:hidden;}
  .profile-body label{font-size:.8rem;color:var(--muted);}
  .profile-body input[type="text"]{padding:10px 12px;border-radius:8px;border:1px solid var(--line);background:var(--panel);color:var(--ink);font-size:.9rem;}

  .profile-btn{overflow:hidden;padding:0;}
  .profile-body input[type="email"],.profile-body input[type="password"],.profile-body input[type="url"]{width:100%;padding:10px 12px;border-radius:8px;border:1px solid var(--line);background:var(--panel);color:var(--ink);font-size:.9rem;}
  .profile-body input[type="text"]{width:100%;}
  .profile-body input:focus{outline:2px solid var(--accent);}
  .profile-box .player-head{position:relative;padding:16px 18px 4px;background:none;pointer-events:auto;}
  .profile-box .player-head h3{pointer-events:auto;}
  .profile-box .player-head button{pointer-events:auto;}
  .perfil-avatar-grande{width:72px;height:72px;border-radius:50%;overflow:hidden;align-self:center;border:2px solid var(--line);}
  .perfil-avatar-grande img,.profile-btn img{width:100%;height:100%;object-fit:cover;display:block;}
  .perfil-campo{display:flex;flex-direction:column;gap:6px;margin-bottom:10px;}
  .btn-google{width:100%;display:flex;align-items:center;justify-content:center;gap:10px;background:#fff;color:#1f1f1f;border:none;border-radius:8px;padding:11px 14px;font-size:.92rem;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn-email{background:var(--panel);color:var(--ink);border:1px solid var(--line);}
  .btn-email:hover{border-color:var(--accent-dim);}
  .perfil-voltar{background:none;border:none;color:var(--muted);font-size:.85rem;cursor:pointer;font-family:inherit;padding:0 0 10px;}
  .profile-body{position:relative;}
  .perfil-letra-linha{width:100%;display:flex;align-items:center;justify-content:space-between;margin-top:8px;padding:11px 12px;border-radius:10px;border:1px solid var(--line);background:var(--panel);color:var(--ink);font-family:inherit;font-size:.9rem;cursor:pointer;}
  .perfil-letra-linha em{font-style:normal;color:var(--accent);font-weight:700;}
  .perfil-topo{display:flex;justify-content:center;}
  .perfil-resumo{cursor:pointer;display:flex;flex-direction:column;gap:6px;}
  .perfil-editar{display:none;}
  #perfilLogado.editando .perfil-editar{display:block;}
  #perfilLogado.editando .perfil-resumo,#perfilLogado.editando .btn-sair{display:none;}
  .perfil-menu{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:2px;}
  .perfil-menu[hidden]{display:none;}
  .perfil-menu .perfil-ico{width:100%;min-width:0;}
  .profile-box .player-head #btnEngrenagemPerfil{margin-left:4px;background:transparent;border:none;box-shadow:none;color:var(--ink);width:36px;height:36px;padding:0;}
  #btnEngrenagemPerfil[aria-expanded="true"]{border-color:var(--accent);}
  .profile-box .player-head h3{flex:0 1 auto;}
  .profile-box .player-head #closeProfile{margin-left:auto;}
  .perfil-col{display:flex;flex-direction:column;gap:6px;align-items:flex-start;}
  .perfil-col-dir{align-items:flex-end;}
  .perfil-ico{position:static;top:8px;z-index:2;display:flex;flex-direction:column;align-items:center;gap:1px;background:var(--panel);color:var(--ink);border:1px solid var(--line);border-radius:12px;padding:4px 8px;min-width:62px;cursor:pointer;font-family:inherit;}
  .perfil-ico b{font-size:.95rem;line-height:1;} .perfil-ico small{font-size:.58rem;color:var(--muted);}
  .perfil-ico-esq{left:16px;}
  .perfil-ou{display:flex;align-items:center;gap:10px;color:var(--muted);font-size:.75rem;margin:14px 0;}
  .perfil-ou:before,.perfil-ou:after{content:"";flex:1;height:1px;background:var(--line);}
  .perfil-abas{display:flex;gap:6px;margin-bottom:12px;}
  .perfil-abas button{flex:1;padding:9px;border-radius:8px;border:1px solid var(--line);background:var(--panel);color:var(--muted);font-size:.85rem;cursor:pointer;font-family:inherit;}
  .perfil-abas button.ativa{border-color:var(--accent);color:var(--accent);font-weight:700;}
  .perfil-erro{color:#ff6b6b;font-size:.78rem;min-height:1em;margin-top:8px;}
  .perfil-nome-logado{text-align:center;font-size:1.1rem;font-weight:700;}
  .perfil-email-logado{text-align:center;font-size:.8rem;color:var(--muted);margin-top:-6px;}
  .btn-sair{background:none;border:1px solid var(--line);color:var(--muted);border-radius:8px;padding:10px;font-size:.85rem;cursor:pointer;font-family:inherit;}
  .btn-sair:hover{border-color:#ff5252;color:#ff5252;}
  .perfil-local summary{font-size:.78rem;color:var(--muted);cursor:pointer;margin-top:14px;}
  .perfil-local .perfil-local-corpo{display:flex;flex-direction:column;gap:12px;margin-top:10px;}
  .avatar-grid{display:flex;flex-wrap:wrap;gap:8px;}
  .avatar-opcao{width:38px;height:38px;border-radius:50%;background:var(--panel);border:2px solid var(--line);display:flex;align-items:center;justify-content:center;font-size:1.1rem;cursor:pointer;}
  .avatar-opcao.selecionado{border-color:var(--accent);}

  main{padding:8px 3.5vw calc(70px + env(safe-area-inset-bottom,0px));}
  .row{margin-top:34px;}
  .row h2{font-size:1.15rem;margin-bottom:14px;color:var(--ink);}
  .row h2 small{color:var(--muted);font-family:inherit;font-size:.8rem;font-weight:400;margin-left:8px;}
  .track{display:flex;gap:14px;overflow-x:auto;padding-bottom:10px;scroll-snap-type:x proximity;}
  .track::-webkit-scrollbar{height:6px;}
  .track::-webkit-scrollbar-thumb{background:var(--line);border-radius:3px;}

  .card{position:relative;flex:0 0 40vw;max-width:200px;min-width:130px;scroll-snap-align:start;cursor:pointer;border-radius:14px;overflow:hidden;background:var(--panel);border:1px solid var(--line);transition:transform .15s ease,border-color .15s ease;box-shadow:0 4px 14px rgba(0,0,0,.25);}
  .card:hover{transform:translateY(-4px);border-color:var(--accent-dim);}
  .card:active{transform:scale(.94);}

  /* NOVO: efeito de clique/toque nos botões principais — dá aquele
     "estalinho" visual ao tocar, em vez de não reagir a nada. */
  .btn-play-principal,.banner-btn,.nav-btn,.player-head button,.btn-proximo-episodio,
  .btn-toggle-sinopse,.btn-download-episodio,.btn-fechar-detalhes{
    transition:transform .12s ease,opacity .12s ease;
  }
  .btn-play-principal:active,.banner-btn:active,.nav-btn:active:not(:disabled),
  .player-head button:active,.btn-proximo-episodio:active,.btn-toggle-sinopse:active,
  .btn-fechar-detalhes:active{
    transform:scale(.92);opacity:.85;
  }
  .card .poster{width:100%;aspect-ratio:2/3;object-fit:cover;background:#1d222c;display:block;}
  .card .meta{padding:8px 10px;}
  .card .meta .t{font-size:.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .card .meta .y{font-size:.72rem;color:var(--muted);}
  /* NOVO: selo do tipo (FILME/SÉRIE/ANIME/DORAMA) no canto do poster + o
     tipo também entra na linha de baixo, ao lado do ano. Não inventamos
     classificação etária nem DUB/LEG aqui porque não temos essa informação
     confiável por título (nem a TMDB nem a SuperFlixAPI trazem isso pronto
     na listagem do catálogo) — só o que realmente sabemos. */
  .card-tipo-badge{position:absolute;top:8px;left:8px;z-index:2;background:rgba(0,0,0,.72);color:var(--ink);font-size:.6rem;font-weight:800;letter-spacing:.3px;padding:3px 8px;border-radius:8px;}
  .card-meta-tipo{color:var(--accent);font-weight:700;}
  /* NOVO: botão de remover (✕) no canto do card - só aparece nas faixas que
     passam a opção "remover" (por agora, só "Continuar Assistindo"). */
  .card-btn-remover{position:absolute;top:6px;right:6px;z-index:3;width:26px;height:26px;border-radius:50%;background:rgba(0,0,0,.72);color:var(--ink);border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-size:.78rem;cursor:pointer;line-height:1;}
  .card-btn-remover:hover{background:#ff5252;border-color:#ff5252;}

  /* ===== PARTILHAR: ícone no canto superior esquerdo da capa (ao lado do selo)
     e nos episódios (à direita do ícone de baixar) ===== */
  .card-topo-esq{position:absolute;top:8px;left:8px;z-index:3;display:flex;align-items:center;gap:6px;}
  .card-topo-esq .card-tipo-badge{position:static;}
  .grade-catalogo .card-topo-esq{top:6px;left:6px;gap:4px;}
  .card-btn-partilhar,.episodio-partilhar{display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--ink);font-family:inherit;}
  .card-btn-partilhar{width:24px;height:24px;border-radius:50%;background:rgba(0,0,0,.72);border:1px solid rgba(255,255,255,.25);padding:0;}
  .card-btn-partilhar:hover{background:var(--accent-dim);border-color:var(--accent);}
  .episodio-partilhar{flex:0 0 auto;background:none;border:1px solid var(--line);color:var(--muted);border-radius:50%;width:34px;height:34px;padding:0;}
  .episodio-partilhar:hover{border-color:var(--accent-dim);color:var(--accent);}
  .aviso-partilha{position:fixed;left:50%;bottom:28px;transform:translateX(-50%);z-index:3000;background:var(--panel);color:var(--ink);border:1px solid var(--accent-dim);border-radius:20px;padding:10px 18px;font-size:.85rem;box-shadow:0 8px 24px rgba(0,0,0,.6);}

  /* ===== Continuar Assistindo + Últimos Episódios
     CARDS GRANDES (retângulo largo 16:9) — não usar o tamanho pequeno do catálogo ===== */
  #continuar-assistindo-track,
  #ultimos-episodios-track{
    gap:12px;
    padding-bottom:6px;
  }
  #continuar-assistindo-track .card,
  #ultimos-episodios-track .card{
    flex:0 0 72vw;
    max-width:280px;
    min-width:200px;
    border-radius:16px;
  }
  #continuar-assistindo-track .card .poster,
  #ultimos-episodios-track .card .poster{
    aspect-ratio:16/9;
    object-fit:cover;
  }
  #continuar-assistindo-track .card .meta,
  #ultimos-episodios-track .card .meta{
    padding:10px 12px 12px;
  }
  #continuar-assistindo-track .card .meta .t,
  #ultimos-episodios-track .card .meta .t{
    font-size:.92rem;
    font-weight:700;
    white-space:normal;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    line-height:1.25;
  }
  #continuar-assistindo-track .card .meta .y,
  #ultimos-episodios-track .card .meta .y{
    font-size:.78rem;
    margin-top:4px;
  }
  #ultimos-episodios-track .card-tipo-badge{
    top:8px; right:8px; left:auto;
    background:rgba(0,0,0,.75);
    font-size:.65rem;
    padding:3px 8px;
    border-radius:8px;
  }
  #continuar-assistindo-track .card-btn-remover{
    top:8px; right:8px; width:28px; height:28px;
  }
  @media (min-width:640px){
    #continuar-assistindo-track .card,
    #ultimos-episodios-track .card{
      flex:0 0 240px;
      max-width:280px;
    }
  }

  /* Catálogo / lançamentos recentes / pesquisa: poster vertical arredondado
     (estilo do index de referência — ~3 cards no ecrã, 2:3) */
  #recente-filme .card,
  #recente-serie .card,
  #recente-anime .card,
  #recente-dorama .card{
    flex:0 0 32vw;
    max-width:150px;
    min-width:118px;
    border-radius:16px;
  }
  #recente-filme .card .meta .t,
  #recente-serie .card .meta .t,
  #recente-anime .card .meta .t,
  #recente-dorama .card .meta .t{
    font-size:.78rem;
    font-weight:700;
    white-space:normal;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    line-height:1.25;
  }

  /* ===== Últimas avaliações — cartão estilo app (avatar + poster + selo) ===== */
  #ultimas-avaliacoes-track{gap:12px;}
  .avaliacao-card{
    flex:0 0 min(86vw, 340px) !important;
    max-width:360px;
    padding:14px !important;
    border-radius:14px !important;
  }
  .avaliacao-card .avaliacao-cabecalho{
    display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;
  }
  .avaliacao-card .comentario-avatar{
    width:40px;height:40px;border-radius:50%;background:var(--accent-dim);color:var(--accent);
    display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1rem;flex-shrink:0;
  }
  .avaliacao-card .avaliacao-meta-user{flex:1;min-width:0;}
  .avaliacao-card .comentario-nome{font-weight:700;font-size:.9rem;color:var(--ink);}
  .avaliacao-card .comentario-estrelas-exibidas{color:var(--accent);letter-spacing:1px;font-size:.85rem;}
  .avaliacao-card .comentario-data{color:var(--muted);font-size:.72rem;margin-left:6px;}
  .avaliacao-card .avaliacao-titulo-bloco{
    display:flex;align-items:center;gap:10px;background:var(--bg);border:1px solid var(--line);
    border-radius:10px;padding:8px;margin:8px 0;
  }
  .avaliacao-card .avaliacao-poster-mini{
    width:42px;aspect-ratio:2/3;object-fit:cover;border-radius:6px;background:#1d222c;flex-shrink:0;
  }
  .avaliacao-card .avaliacao-titulo-info{min-width:0;flex:1;}
  .avaliacao-card .avaliacao-titulo-nome{
    font-weight:700;font-size:.88rem;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
  }
  .avaliacao-card .avaliacao-titulo-tags{
    font-size:.7rem;color:var(--muted);margin-top:3px;
  }
  .avaliacao-card .avaliacao-titulo-tags .selo-tipo{color:var(--accent);font-weight:700;}
  .avaliacao-card .comentario-texto{
    font-size:.84rem;color:var(--ink);opacity:.9;line-height:1.45;
    display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;
  }
  .row-head-sub{font-size:.78rem;color:var(--muted);font-weight:400;margin-top:2px;font-family:inherit;}


  /* Catálogo completo (abas Filmes/Séries/Animes/Doramas): grade que quebra
     linha, em vez da faixa de rolagem horizontal usada nas prévias da
     Início. 4 colunas no celular, 6 no tablet, 8 no PC. */
  /* Grelha do catálogo: 3 colunas no telemóvel (vê-se tudo sem zoom).
     min-width:0 anula o min-width:130px do .card que empurrava a página
     para o lado e obrigava a fazer zoom. */
  .track.grade-catalogo{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:10px 8px;
    overflow:visible;
    scroll-snap-type:none;
    width:100%;
  }
  .grade-catalogo .card{
    flex:none;
    width:100%;
    min-width:0;
    max-width:none;
    border-radius:14px;
  }
  .grade-catalogo .card .meta{padding:6px 6px 8px;}
  .grade-catalogo .card .meta .t{font-size:.72rem;}
  .grade-catalogo .card .meta .y{font-size:.65rem;}
  .grade-catalogo .card-tipo-badge{font-size:.55rem;padding:2px 6px;top:6px;left:6px;}
  @media (min-width:640px){
    .track.grade-catalogo{grid-template-columns:repeat(4, 1fr);gap:14px;}
    .grade-catalogo .card .meta .t{font-size:.8rem;}
  }
  @media (min-width:1024px){
    .track.grade-catalogo{grid-template-columns:repeat(6, 1fr);gap:16px;}
  }

  .empty,.loading{color:var(--muted);font-size:.9rem;padding:10px 0;}
  .more-btn{flex:0 0 110px;align-self:center;background:var(--panel);border:1px solid var(--accent-dim);color:var(--accent);border-radius:6px;padding:10px;font-size:.8rem;cursor:pointer;}
  .more-btn:hover{background:var(--accent-dim);color:var(--ink);}

  /* ===== Banner de destaque (Início) — 1 card grande em rotação, com o
     título mais recente de cada categoria (Filme/Série/Anime/Dorama).
     Sem caixa/borda própria: as bordas desvanecem para se misturar com o
     resto da página, em vez de parecer um bloco à parte. ===== */
  .banner-destaque-container{position:relative;width:100%;height:55vh;min-height:360px;overflow:hidden;margin-bottom:6px;}
  .banner-slide{position:absolute;top:0;left:0;width:100%;height:100%;background-size:cover;background-position:center;opacity:0;transition:opacity .8s ease;display:flex;align-items:flex-end;}
  .banner-slide.ativo{opacity:1;z-index:1;}
  .banner-gradiente{width:100%;padding:40px 20px 20px;background:linear-gradient(to top, var(--bg) 15%, transparent 100%);}
  .banner-titulo{font-size:1.6rem;font-weight:bold;margin-bottom:6px;font-family:Georgia,'Times New Roman',serif;color:var(--ink);}
  .banner-sub{font-size:.75rem;color:var(--muted);margin-bottom:12px;}
  .banner-sinopse{font-size:.82rem;color:var(--ink);opacity:.9;margin-bottom:15px;max-width:90%;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
  .banner-btn{background:var(--accent);color:#1a1305;padding:10px 22px;border-radius:25px;font-weight:bold;font-size:.8rem;border:none;cursor:pointer;}
  .banner-indicadores{position:absolute;bottom:10px;right:20px;z-index:2;display:flex;gap:6px;}
  .ponto{width:8px;height:8px;background:rgba(255,255,255,.4);border-radius:50%;transition:.3s;}
  .ponto.ativo{background:var(--accent);width:20px;border-radius:10px;}
  /* desvanecimentos nas 3 bordas que não já têm o gradiente escuro do
     banner-gradiente (topo, esquerda, direita) — para as bordas do banner
     "desaparecerem" no fundo da página em vez de mostrar um limite reto */
  .banner-fade{position:absolute;z-index:2;pointer-events:none;}
  .banner-fade-topo{top:0;left:0;right:0;height:70px;background:linear-gradient(to bottom, var(--bg), transparent);}
  .banner-fade-esq{top:0;bottom:0;left:0;width:9vw;background:linear-gradient(to right, var(--bg), transparent);}
  .banner-fade-dir{top:0;bottom:0;right:0;width:9vw;background:linear-gradient(to left, var(--bg), transparent);}

  /* ===== Modal de detalhes (abre ao clicar num card ou no banner, ANTES
     de ir para o leitor) — mesmo comportamento/estilo do WebPlay: mostra
     capa, título, sinopse, botão "Assistir Agora" e comentários. ===== */
  .modal-oculto{display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:1000;justify-content:center;align-items:flex-end;}
  .modal-oculto.aberto{display:flex;}
  .conteudo-modal{background:var(--bg);width:100%;max-width:480px;height:92vh;border-top-left-radius:22px;border-top-right-radius:22px;position:relative;overflow-y:auto;animation:subirPainelDetalhes .3s ease-out;}
  @keyframes subirPainelDetalhes{from{transform:translateY(100%);}to{transform:translateY(0);}}
  .modal-capa-fundo{position:relative;width:100%;height:230px;background-size:cover;background-position:center;background-color:var(--panel);}
  .modal-capa-gradiente{position:absolute;inset:0;background:linear-gradient(to bottom, rgba(13,15,20,.2) 0%, rgba(13,15,20,.8) 70%, var(--bg) 100%);display:flex;justify-content:flex-end;padding:14px;}
  .btn-fechar-detalhes{position:fixed;top:12px;right:12px;z-index:1200;background:rgba(0,0,0,.6);color:#fff;border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;font-size:18px;cursor:pointer;border:none;}
  .btn-partilhar-detalhes{position:fixed;top:12px;left:12px;z-index:1200;background:rgba(0,0,0,.6);color:#fff;border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;cursor:pointer;border:none;padding:0;transition:transform .12s ease,opacity .12s ease;}
  .btn-partilhar-detalhes:active{transform:scale(.92);opacity:.85;}
  .modal-info-corpo{padding:0 20px 30px;margin-top:-26px;position:relative;z-index:2;}
  .modal-titulo-principal{font-size:1.5rem;font-weight:700;color:var(--ink);font-family:Georgia,'Times New Roman',serif;}
  .modal-meta-linha{display:flex;flex-wrap:wrap;align-items:center;gap:6px;font-size:.75rem;color:var(--muted);margin:6px 0 14px;}
  .modal-meta-item{color:var(--accent);font-weight:600;}

  /* ===== Ficha do título: cartaz centrado, voltar à esquerda, lista à direita ===== */
  .modal-capa-fundo{height:270px;overflow:hidden;}
  .modal-capa-fundo::before{content:"";position:absolute;inset:0;background:inherit;background-size:cover;background-position:center;filter:blur(22px) brightness(.5);transform:scale(1.2);}
  .modal-capa-gradiente{align-items:flex-end;justify-content:center;padding:0 0 4px;background:linear-gradient(to bottom, rgba(13,15,20,.25) 0%, rgba(13,15,20,0) 35%, var(--bg) 100%);}
  .btn-fechar-detalhes{left:12px;right:auto;width:40px;height:40px;background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.18);color:var(--ink);box-shadow:0 2px 10px rgba(0,0,0,.35);}
  .btn-fechar-detalhes svg{display:block;}
  .btn-partilhar-detalhes{display:none;}
  .btn-lista-detalhes{position:fixed;top:12px;right:12px;z-index:1200;background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.18);color:var(--ink);border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;cursor:pointer;border:none;padding:0;}
  .btn-lista-detalhes{right:58px;}
  .btn-fav-detalhes{right:12px;}
  .btn-lista-detalhes.ativo{background:var(--accent);color:#1a1305;}
  .det-poster-card{position:relative;width:128px;aspect-ratio:2/3;border-radius:14px;overflow:hidden;border:2px solid rgba(255,255,255,.25);box-shadow:0 8px 22px rgba(0,0,0,.55);margin-bottom:6px;background:var(--panel);}
  .det-poster-card img{width:100%;height:100%;object-fit:cover;display:block;}
  .det-idade{position:absolute;top:5px;right:5px;font-size:.7rem !important;background:rgba(0,0,0,.75);color:#fff;border:1px solid var(--accent);border-radius:8px;padding:2px 8px;font-weight:800;font-size:.85rem;}
  .modal-info-corpo{text-align:center;margin-top:0;}
  .modal-titulo-principal{text-align:center;font-size:1.6rem;}
  .modal-meta-linha{justify-content:center;}
  .modal-info-corpo .btn-play-principal{border-radius:16px;padding:16px;font-size:1rem;}
  .detalhes-temporada-bloco .btn-play-principal{padding:14px;}
  .modal-info-corpo .painel-det#painelDetGeral{border:1px solid var(--line);border-radius:16px;padding:14px;text-align:left;margin-bottom:14px;}
  .modal-info-corpo .painel-det#painelDetGeral .modal-sinopse-texto{margin:0;}
  .modal-sinopse-texto{font-size:.82rem;color:var(--ink);opacity:.85;line-height:1.55;margin-bottom:18px;}
  .detalhes-acoes{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:10px 0 16px;}
  .detalhes-abas{display:flex;border:1px solid var(--line);border-radius:14px;margin-bottom:12px;overflow:hidden;}
  .aba-det{flex:1;padding:12px 6px;background:none;border:none;color:var(--muted);font-family:inherit;font-weight:600;font-size:.82rem;cursor:pointer;border-bottom:2px solid transparent;}
  .aba-det.ativa{color:var(--ink);border-bottom-color:var(--accent);}
  .painel-det{margin-bottom:6px;font-size:.88rem;}
  .det-linha{margin:6px 0;color:var(--muted);} .det-linha b{color:var(--ink);font-weight:600;}
  .det-chips{display:flex;flex-wrap:wrap;gap:6px;margin:8px 0;} .det-chips span{padding:3px 10px;border-radius:12px;background:var(--panel);border:1px solid var(--line);font-size:.74rem;}
  .det-elenco{display:flex;gap:12px;overflow-x:auto;padding:6px 0 10px;}
  .det-ator{flex:0 0 74px;text-align:center;font-size:.7rem;} .det-ator img,.det-ator .sem-foto{width:64px;height:64px;border-radius:50%;object-fit:cover;background:var(--panel);display:block;margin:0 auto 4px;}
  .det-ator small{display:block;color:var(--muted);}
  .det-video{position:relative;margin:10px 0;border-radius:20px;overflow:hidden;aspect-ratio:16/9;background:#000;cursor:pointer;border:1px solid var(--line);box-shadow:0 6px 18px rgba(0,0,0,.35);}
  .det-video img,.det-video iframe{width:100%;height:100%;border:0;object-fit:cover;display:block;}
  .det-video .tocar{position:absolute;left:50%;top:50%;width:58px;height:58px;margin:-29px 0 0 -29px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;padding-left:4px;box-sizing:border-box;color:#1a1305;background:var(--accent);box-shadow:0 4px 14px rgba(0,0,0,.5);}
  .det-video-yt{display:block;text-align:center;margin:4px 0 10px;padding:10px;border-radius:12px;border:1px solid var(--line);color:var(--accent);font-weight:700;font-size:.85rem;text-decoration:none;}
  .det-video-nome{font-size:.74rem;color:var(--muted);margin:-4px 0 8px;}
  .btn-acao-detalhes{flex:1;display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;border-radius:14px;border:1px solid var(--line);background:var(--panel);color:var(--ink);font-family:inherit;font-weight:600;font-size:.85rem;cursor:pointer;}
  .btn-acao-detalhes:active{opacity:.7;}
  .btn-play-principal{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--accent);color:#1a1305;text-decoration:none;padding:13px;border-radius:30px;font-weight:bold;font-size:.9rem;border:none;cursor:pointer;width:100%;}

  .secao-comentarios{margin-top:22px;padding-top:14px;border-top:1px solid var(--line);}
  .secao-comentarios-cabecalho{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
  .secao-comentarios-titulo{font-size:.9rem;color:var(--ink);font-weight:600;}
  .comentarios-media{font-size:.75rem;color:var(--accent);font-weight:700;white-space:nowrap;}
  .comentarios-aviso{font-size:.72rem;color:var(--muted);background:var(--panel);border:1px solid var(--line);border-radius:6px;padding:8px 10px;margin-bottom:10px;}

  /* ===== Avaliações da ficha (cartões grandes, estilo da captura) ===== */
  .secao-comentarios{border-top:none;margin-top:18px;}
  .secao-comentarios-cabecalho{align-items:flex-end;margin-bottom:12px;}
  .secao-comentarios-titulo{font-size:1.5rem;font-weight:800;}
  .secao-comentarios-sub{font-size:.8rem;color:var(--muted);margin-top:2px;}
  .btn-ver-todas-coment{background:none;border:none;color:var(--accent);font-weight:700;font-size:.85rem;cursor:pointer;font-family:inherit;padding:4px 0;}
  .selo-verif{display:inline-block;vertical-align:-3px;margin-left:5px;}
  .cmt{background:var(--panel);border:1px solid var(--line);border-radius:18px;padding:14px;margin-bottom:12px;text-align:left;}
  .cmt-oficial{border-color:var(--accent-dim);}
  .cmt-topo{display:flex;align-items:flex-start;gap:10px;}
  .cmt .comentario-avatar{width:44px;height:44px;font-size:1.1rem;font-weight:800;}
  .cmt-quem{flex:1;min-width:0;}
  .cmt-nome{font-weight:800;font-size:1rem;color:var(--ink);}
  .cmt-estr{color:#f5c542;font-size:.95rem;letter-spacing:1px;display:flex;align-items:center;gap:8px;}
  .cmt-estr b{font-size:.8rem;letter-spacing:0;color:var(--ink);}
  .cmt-vazias{opacity:.25;}
  .cmt-data{font-size:.75rem;color:var(--muted);white-space:nowrap;}
  .cmt-texto{margin-top:10px;font-size:.92rem;line-height:1.45;color:var(--ink);opacity:.92;word-break:break-word;}
  .cmt-texto.cmt-curto{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
  .cmt-mais{background:none;border:none;color:var(--accent);font-weight:700;font-size:.85rem;cursor:pointer;padding:2px 0;font-family:inherit;}
  .cmt-rodape{display:flex;justify-content:flex-end;margin-top:8px;}
  .cmt .btn-voto{background:none;border:none;color:var(--muted);font-size:.9rem;display:flex;align-items:center;gap:6px;cursor:pointer;font-family:inherit;}
  .cmt .btn-voto.marcado{color:var(--accent);}
  .comentario-form{background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:12px;margin-bottom:14px;}
  .comentario-estrelas-input{display:flex;gap:4px;margin-bottom:8px;}
  .comentario-estrelas-input .estrela-input{font-size:1.3rem;color:var(--line);cursor:pointer;user-select:none;transition:color .15s;}
  .comentario-estrelas-input .estrela-input.selecionada{color:var(--accent);}
  .comentario-textarea{width:100%;box-sizing:border-box;background:var(--bg);border:1px solid var(--line);border-radius:6px;color:var(--ink);font-size:.8rem;padding:8px 10px;resize:vertical;font-family:inherit;margin-bottom:8px;}
  .btn-enviar-comentario{background:var(--accent);color:#1a1305;border:none;border-radius:6px;font-weight:700;font-size:.75rem;padding:9px 14px;cursor:pointer;}
  .lista-comentarios{display:flex;flex-direction:column;gap:10px;}
  .comentario-vazio{font-size:.75rem;color:var(--muted);text-align:center;padding:10px 0;}
  .comentario-item{display:flex;gap:10px;background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:10px;}
  /* NOVO: cartão de avaliação na faixa "Últimas avaliações" da Início -
     reaproveita o visual do .comentario-item, só que numa faixa horizontal,
     com um selo clicável em cima indicando de que título é. */
  .avaliacao-card{flex:0 0 270px;scroll-snap-align:start;display:flex;flex-direction:column;background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:12px;cursor:pointer;}
  .avaliacao-card:hover{border-color:var(--accent-dim);}
  .avaliacao-titulo-chip{display:block;font-size:.68rem;font-weight:800;color:var(--accent);letter-spacing:.2px;margin-bottom:8px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .avaliacao-linha{display:flex;gap:10px;}
  .comentario-avatar{flex-shrink:0;width:30px;height:30px;border-radius:50%;background:var(--accent-dim);color:var(--ink);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;}
  .comentario-avatar{position:relative;overflow:hidden;}
  .comentario-avatar img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
  #profileOverlay{z-index:1300;}
  .comentario-login-bloco{background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:14px;margin-bottom:12px;text-align:center;}
  .comentario-login-bloco p{font-size:.85rem;color:var(--muted);margin-bottom:10px;}
  .comentario-login-bloco button{background:var(--accent);color:#1a1205;border:none;border-radius:20px;padding:9px 20px;font-weight:700;font-size:.85rem;cursor:pointer;font-family:inherit;}
  .comentario-corpo{flex:1;min-width:0;}
  .comentario-linha-topo{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
  .comentario-nome{font-size:.78rem;font-weight:700;color:var(--ink);}
  .comentario-estrelas-exibidas{font-size:.7rem;color:var(--accent);letter-spacing:1px;}
  .comentario-data{font-size:.65rem;color:var(--muted);}
  .comentario-texto{font-size:.78rem;color:var(--ink);opacity:.85;margin-top:4px;line-height:1.4;word-break:break-word;}

  /* botão de download do episódio, dentro do leitor */
  .btn-download-episodio:hover{color:var(--accent);}

  .pag-controls{display:flex;gap:10px;margin-top:10px;}
  .nav-btn{background:var(--panel);border:1px solid var(--accent-dim);color:var(--accent);border-radius:6px;padding:8px 16px;font-size:.8rem;cursor:pointer;}
  .nav-btn:hover:not(:disabled){background:var(--accent-dim);color:var(--ink);}
  .nav-btn:disabled{opacity:.35;cursor:default;}

  /* ===== Leitor (player) em modo cinema: ecrã inteiro, vídeo grande em
     primeiro plano e um painel fino por baixo com sinopse/episódios — em
     vez da caixa pequena e centrada de antes. ===== */
  .overlay{position:fixed;inset:0;background:#000;display:none;z-index:1000;}
  .overlay.open{display:flex;}
  .player-box{
    position:relative;width:100%;height:100%;
    display:flex;flex-direction:column;background:#000;
    animation:zoomEntradaPlayer .28s ease-out;
  }
  @keyframes zoomEntradaPlayer{from{opacity:0;transform:scale(.97);}to{opacity:1;transform:scale(1);}}

  /* Barra do topo flutua POR CIMA do vídeo (como nos apps grandes), em vez
     de empurrá-lo para baixo e roubar-lhe espaço. */
  .player-head{
    position:absolute;top:0;left:0;right:0;z-index:5;
    display:flex;align-items:center;gap:8px;
    padding:6px 14px 24px;
    background:linear-gradient(to bottom, rgba(0,0,0,.8), rgba(0,0,0,0));
    pointer-events:none;
  }
  .player-head h3{
    flex:1;color:#fff;font-size:.95rem;font-weight:600;margin:0;
    text-shadow:0 1px 6px rgba(0,0,0,.9);
    overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
    pointer-events:none;
  }
  .player-head button{
    pointer-events:auto;flex-shrink:0;
    background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.25);color:#fff;
    border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;
    font-size:1.05rem;
  }
  .player-head button.btn-sem-legenda{width:auto;padding:0 12px;gap:6px;font-size:.78rem;font-weight:600;white-space:nowrap;}
  .menu-sem-legenda{position:absolute;z-index:9;top:50px;right:14px;width:min(300px,82vw);background:#141417;border:1px solid #2a2a2e;border-radius:16px;padding:10px;box-shadow:0 10px 30px rgba(0,0,0,.6);max-height:60vh;overflow-y:auto;}
  .menu-sem-legenda .ps-cabecalho{margin:2px 0 10px;font-size:.85rem;}
  .player-head button:hover{background:rgba(0,0,0,.75);border-color:rgba(255,255,255,.5);}

  /* O vídeo ocupa TODO o espaço que sobrar (flex:1) — é isto que faz o
     iframe ficar grande de verdade, em vez de uma caixa 16:9 pequena
     encolhida no meio do ecrã. */
  .player-frame-wrap{position:relative;flex:1 1 auto;min-height:0;background:#000;}
  .player-frame-wrap iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}
  /* NOVO: tapa (visual e a clique) só o canto onde fica o BOTÃO DE VOLTAR
     que o próprio servidor de vídeo mostra dentro do iframe (que levava
     para o catálogo dele, fora do nosso site) — só esse cantinho, sem
     tapar o nome do episódio, que fica ao lado. Nunca conseguimos tirar
     isso de dentro do iframe deles, só cobrir por cima.
     pointer-events:auto de propósito, para bloquear esse clique. */
  .mascara-topo-iframe{
    position:absolute;top:0;left:0;width:56px;height:56px;
    background:#000;z-index:5;pointer-events:auto;
  }
  /* NOVO: garante que a caixa do leitor preenche mesmo TODO o ecrã quando
     está em ecrã cheio nativo (alguns navegadores, sobretudo com prefixo
     -webkit-, precisam do tamanho explícito em vez de confiar só no
     comportamento padrão). */
  /* PERMANENTE (sem timer, sem esconder ao rodar o ecrã): faixa INVISÍVEL por cima do iframe, na lateral esquerda, do meio do vídeo (26% do topo) até logo acima dos controlos (11% do fundo). Não mexer: deixa livres o topo (🌐/⬇/✕) e a barra de play/volume.
     A seta de voltar do servidor continua a ver-se, mas o clique fica apanhado aqui
     e não chega ao iframe. (Em horizontal/ecrã cheio fica desligada.) */
  .mascara-voltar-embed{position:absolute;left:0;top:26%;bottom:11%;width:16%;background:transparent;pointer-events:auto;z-index:5;}
  .mascara-voltar-embed i{display:none;}
  /* NOVO: o botão de download só aparece depois da verificação Cloudflare do embed */
  .btn-download-episodio.oculto-verificacao{display:none !important;}
  .modal-como-baixar{position:fixed;inset:0;z-index:3500;background:rgba(0,0,0,.75);display:none;align-items:center;justify-content:center;padding:18px;}
  .modal-como-baixar.aberto{display:flex;}
  .mcb-caixa{background:var(--panel);border:1px solid var(--line);border-radius:16px;max-width:360px;width:100%;max-height:90vh;overflow-y:auto;padding:16px;color:var(--ink);}
  .mcb-caixa h3{margin:0 0 8px;font-size:1rem;}
  .mcb-caixa img,.mcb-caixa video{width:100%;border-radius:10px;margin:8px 0;background:#000;}
  .mcb-txt{font-size:.82rem;line-height:1.5;color:var(--muted);margin:0 0 12px;}
  ol.mcb-txt{padding-left:20px;}
  .mcb-topo{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px;}
  .mcb-aviso{font-size:.68rem;color:var(--muted);border:1px solid var(--line);border-radius:20px;padding:2px 9px;}
  .mcb-x{width:30px;height:30px;border-radius:50%;border:1px solid var(--line);background:none;color:var(--ink);cursor:pointer;font-size:.9rem;}
  .mcb-vel{display:flex;justify-content:flex-end;margin:-2px 0 6px;}
  .mcb-vel button{background:none;border:1px solid var(--line);color:var(--ink);border-radius:20px;padding:4px 12px;font-size:.75rem;font-family:inherit;cursor:pointer;}
  .mcb-botoes{display:flex;gap:8px;}
  .mcb-botoes button{flex:1;border-radius:10px;padding:10px 8px;font-weight:700;font-size:.8rem;cursor:pointer;font-family:inherit;border:1px solid var(--line);background:none;color:var(--ink);}
  .mcb-botoes .mcb-principal{background:var(--accent);color:#1a1305;border-color:var(--accent);}
  /* balão de banda desenhada no perfil */
  .balao-como-baixar{position:relative;margin:12px 4px 2px;padding:12px;background:#fff;color:#1a1a1a;border:2px solid #1a1a1a;border-radius:16px;font-size:.8rem;line-height:1.4;box-shadow:3px 3px 0 rgba(0,0,0,.35);}
  .balao-como-baixar:before{content:"";position:absolute;top:-12px;left:50%;margin-left:-10px;border:10px solid transparent;border-top:0;border-bottom-color:#1a1a1a;}
  .balao-como-baixar:after{content:"";position:absolute;top:-8px;left:50%;margin-left:-8px;border:8px solid transparent;border-top:0;border-bottom-color:#fff;}
  .balao-como-baixar button{display:block;margin-top:8px;width:100%;padding:8px;border-radius:10px;border:2px solid #1a1a1a;background:var(--accent);color:#1a1305;font-weight:700;cursor:pointer;font-family:inherit;}
  .player-box:fullscreen,.player-box:-webkit-full-screen{width:100vw;height:100vh;}

  /* Painel fino por baixo do vídeo — sinopse e episódios ficam aqui, sem
     empurrar o vídeo para fora do ecrã; se o conteúdo for maior do que o
     espaço disponível (ex.: telemóvel deitado), ele rola por dentro em vez
     de espremer o vídeo. */
  /* NOVO: rodapé do leitor escondido a pedido - no leitor só deve aparecer
     o iframe do servidor + os botões de download e fechar no cabeçalho,
     nada de temporada/episódio nem sinopse ali embaixo. Os elementos
     continuam a existir no HTML (o JS que os preenche continua a correr
     sem erros), só ficam sempre escondidos. */
  .player-servidores{flex-shrink:0;background:#0f0f11;padding:6px 14px calc(14px + env(safe-area-inset-bottom,0px));max-height:55vh;overflow-y:auto;}
  .btn-voltar-servidor{position:absolute;z-index:8;top:6px;left:14px;width:36px;height:36px;align-items:center;justify-content:center;background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.25);color:#fff;border-radius:8px;font-size:1.1rem;cursor:pointer;}
  .ps-cabecalho{color:#fff;font-size:.95rem;font-weight:700;text-align:center;margin:4px 0 10px;}
  .ps-linha{width:100%;display:flex;align-items:center;gap:14px;background:#141417;color:#fff;border:1px solid #2a2a2e;border-radius:16px;padding:12px 14px;margin-bottom:8px;font-family:inherit;cursor:pointer;text-align:left;}
  .ps-linha .ps-icone{width:40px;height:40px;border-radius:50%;background:#1f1f23;color:#ff1a1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .ps-linha .ps-texto{flex:1;display:flex;flex-direction:column;min-width:0;}
  .ps-linha .ps-texto b{font-size:.95rem;font-weight:700;}
  .ps-linha .ps-texto small{color:#8a8a90;font-size:.72rem;margin-top:2px;}
  .ps-linha .ps-seta{color:#8a8a90;font-size:1.3rem;}
  .ps-linha.ativo{border-color:#ff0000;}
  .ps-linha.ativo .ps-icone{background:#ff0000;color:#fff;}
  .player-painel-inferior{display:none;flex-shrink:0;max-height:40vh;overflow-y:auto;background:var(--bg);border-top:1px solid var(--line);}
  .player-info{padding:14px 18px 14px;border-bottom:1px solid var(--line);}
  .player-info:empty{display:none;}
  .player-info-linha{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:8px;}
  .player-tipo{background:var(--accent-dim);color:var(--ink);border-radius:5px;padding:2px 9px;font-size:.72rem;font-weight:600;letter-spacing:.3px;}
  .player-genero{color:var(--muted);font-size:.8rem;}
  .btn-toggle-sinopse{margin-left:auto;background:none;border:1px solid var(--line);color:var(--muted);border-radius:20px;padding:4px 12px;font-size:.72rem;cursor:pointer;font-family:inherit;white-space:nowrap;}
  .btn-toggle-sinopse:hover{border-color:var(--accent-dim);color:var(--accent);}
  .btn-toggle-sinopse.ativo{border-color:var(--accent);color:var(--accent);}
  /* Sinopse escondida por padrão dentro do leitor — só aparece ao clicar no
     botão de olho acima, para não ocupar espaço logo ao entrar no vídeo. */
  .player-sinopse{color:var(--ink);font-size:.85rem;line-height:1.5;opacity:.9;display:none;}
  .player-sinopse.visivel{display:block;}
  .ep-controls{display:flex;gap:10px;padding:12px 18px;flex-wrap:wrap;align-items:center;font-size:.85rem;}
  .ep-controls select{background:var(--panel);color:var(--ink);border:1px solid var(--line);border-radius:6px;padding:6px 10px;}
  .btn-proximo-episodio{margin-left:auto;background:var(--accent);color:#1a1305;border:none;border-radius:20px;padding:7px 16px;font-size:.8rem;font-weight:700;cursor:pointer;font-family:inherit;}
  .btn-proximo-episodio:hover{opacity:.9;}

  footer .rodape-direitos{margin:0 auto 6px;max-width:460px;line-height:1.45;}
  footer{text-align:center;padding:12px 5vw calc(80px + env(safe-area-inset-bottom,0px));color:var(--muted);font-size:.72rem;border-top:1px solid var(--line);}

  /* ===== Páginas (abas) ===== */
  .page{display:none;}
  .page.ativa{display:block;}

  /* Início: linhas de "últimos lançamentos" (prévia, não é o catálogo todo) */
  .row-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:14px;}
  .row-head h2{font-size:1.15rem;margin-bottom:0;}
  .row-head h2 small{color:var(--muted);font-family:inherit;font-size:.8rem;font-weight:400;margin-left:8px;}
  .ver-tudo{color:var(--accent);font-size:.82rem;white-space:nowrap;background:none;border:none;cursor:pointer;font-family:inherit;}
  .ver-tudo:hover{text-decoration:underline;}

  /* ===== Navegação inferior (rodapé fixo, estilo app) ===== */
  .bottom-nav{
    position:fixed;left:0;right:0;bottom:0;z-index:40;
    display:flex;justify-content:space-around;align-items:center;
    background:var(--panel);border-top:1px solid var(--line);
    padding:8px 2vw calc(8px + env(safe-area-inset-bottom,0px));
  }
  .bottom-nav button{
    background:none;border:none;color:var(--muted);cursor:pointer;
    display:flex;flex-direction:column;align-items:center;gap:3px;
    font-family:inherit;font-size:.68rem;padding:4px 8px;flex:1;
  }
  .bottom-nav button svg{width:22px;height:22px;stroke:currentColor;fill:none;stroke-width:1.8;}
  .bottom-nav button.ativa{color:var(--accent);}
  .bottom-nav button.ativa svg{fill:var(--accent);stroke:var(--accent);}

  /* ===== Feed (avisos/perguntas/enquetes) — mesmo Firebase do site principal ===== */
  .btn-feed{
    position:fixed;top:10px;left:3.5vw;z-index:60;
    width:38px;height:38px;padding:0;border-radius:50%;
    background:var(--panel);border:1px solid var(--line);color:var(--ink);
    display:flex;align-items:center;justify-content:center;
    font-size:.55rem;font-weight:800;letter-spacing:.3px;line-height:1;font-family:inherit;cursor:pointer;
  }
  .btn-feed:hover{border-color:var(--accent-dim);}
  /* pontinho verde no topo da palavra FEED, a chamar a atenção */
  .btn-feed::before{
    content:"";position:absolute;top:-1px;right:-1px;width:9px;height:9px;border-radius:50%;
    background:#2ecc71;box-shadow:0 0 0 0 rgba(46,204,113,.7);animation:pontoFeed 1.8s infinite;
  }
  @keyframes pontoFeed{0%{box-shadow:0 0 0 0 rgba(46,204,113,.6);}70%{box-shadow:0 0 0 6px rgba(46,204,113,0);}100%{box-shadow:0 0 0 0 rgba(46,204,113,0);}}
  .feed-badge{
    position:absolute;bottom:-5px;right:-5px;min-width:16px;height:16px;padding:0 4px;
    border-radius:8px;background:#ff3b30;color:#fff;font-size:.62rem;font-weight:800;letter-spacing:0;
    display:flex;align-items:center;justify-content:center;
  }
  #painel-feed{
    display:none;position:fixed;inset:0;z-index:1100;background:rgba(0,0,0,.82);
    align-items:flex-start;justify-content:center;overflow-y:auto;padding:56px 12px 24px;
  }
  #painel-feed.aberto{display:flex;}
  .feed-card{
    background:var(--bg);border:1px solid var(--line);border-radius:14px;
    width:100%;max-width:360px;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.6);
  }
  .feed-titulo{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
  .feed-titulo h2{font-size:1.05rem;color:var(--ink);margin:0;}
  .feed-fechar{cursor:pointer;color:var(--muted);font-size:1.3rem;line-height:1;background:none;border:none;}
  .feed-abas{display:flex;gap:6px;margin-bottom:14px;overflow-x:auto;}
  .feed-aba-btn{
    flex-shrink:0;background:var(--panel);border:1px solid var(--line);color:var(--muted);
    font-size:.72rem;font-weight:700;padding:7px 12px;border-radius:20px;cursor:pointer;white-space:nowrap;
  }
  .feed-aba-btn.ativa{background:var(--accent);border-color:var(--accent);color:#1a1305;}
  .feed-item{background:var(--panel);border:1px solid var(--line);border-radius:10px;padding:12px;margin-bottom:10px;}
  .feed-item-cabecalho{display:flex;align-items:center;gap:8px;margin-bottom:6px;}
  .feed-item-selo{font-size:.6rem;font-weight:800;padding:2px 7px;border-radius:8px;}
  .feed-item-selo.aviso{background:#2596be;color:#fff;}
  .feed-item-selo.pergunta{background:#8e44ad;color:#fff;}
  .feed-item-selo.enquete{background:var(--accent);color:#1a1305;}
  .feed-item-data{color:var(--muted);font-size:.6rem;margin-left:auto;}
  .feed-item-titulo{color:var(--ink);font-size:.85rem;font-weight:700;margin-bottom:4px;}
  .feed-item-texto{color:var(--ink);opacity:.85;font-size:.76rem;line-height:1.5;margin-bottom:8px;}
  .feed-item-opcoes{display:flex;flex-direction:column;gap:6px;}
  .feed-opcao-btn{
    background:var(--bg);border:1px solid var(--line);color:var(--ink);border-radius:8px;
    padding:8px 10px;font-size:.76rem;text-align:left;cursor:pointer;position:relative;overflow:hidden;
  }
  .feed-opcao-btn.marcada{border-color:var(--accent);}
  .feed-opcao-btn:disabled{cursor:default;}
  .feed-opcao-barra{position:absolute;left:0;top:0;bottom:0;background:var(--accent-dim);opacity:.5;z-index:0;}
  .feed-opcao-conteudo{position:relative;z-index:1;display:flex;justify-content:space-between;}
  .feed-resposta-livre textarea{width:100%;margin-bottom:6px;background:var(--bg);border:1px solid var(--line);border-radius:6px;color:var(--ink);font-size:.76rem;padding:8px 10px;font-family:inherit;}
  .feed-resposta-livre button{background:var(--accent);color:#1a1305;border:none;border-radius:6px;font-size:.72rem;font-weight:700;padding:7px 12px;cursor:pointer;}
  .feed-vazio{color:var(--muted);font-size:.78rem;text-align:center;padding:24px 0;}
  .feed-enquete-rodape{display:flex;align-items:center;justify-content:space-between;margin-top:6px;}
  .feed-enquete-rodape span{color:var(--muted);font-size:.66rem;}
  .feed-enquete-rodape a{color:var(--accent);font-size:.66rem;text-decoration:underline;cursor:pointer;}
  .feed-respostas-publicas{margin-top:10px;border-top:1px dashed var(--line);padding-top:8px;}
  .feed-respostas-publicas-titulo{color:var(--muted);font-size:.66rem;font-weight:700;margin-bottom:6px;}
  .feed-resposta-publica-item{background:var(--bg);border-radius:8px;padding:6px 9px;color:var(--ink);opacity:.9;font-size:.72rem;margin-bottom:5px;line-height:1.4;word-break:break-word;}

  /* ===== Cartões de comentários: útil / não útil + tela "ver todos" ===== */
  .avaliacao-votos{display:flex;align-items:center;gap:8px;margin-top:10px;padding-top:10px;border-top:1px solid var(--line);}
  .avaliacao-votos .votos-pergunta{font-size:.7rem;color:var(--muted);margin-right:auto;}
  .btn-voto{display:inline-flex;align-items:center;gap:5px;background:var(--bg);border:1px solid var(--line);color:var(--muted);border-radius:16px;padding:5px 11px;font-size:.72rem;font-family:inherit;cursor:pointer;}
  .btn-voto b{font-weight:700;color:var(--ink);}
  .btn-voto svg{flex-shrink:0;}
  .btn-voto.marcado{border-color:var(--ink);color:var(--ink);}
  .btn-voto.marcado svg{fill:currentColor;}
  .lista-comentarios-cheia{display:flex;flex-direction:column;gap:12px;}
  .lista-comentarios-cheia .avaliacao-card{flex:none !important;width:100%;max-width:none !important;}

  /* ===== Faixa "Comentários recentes" compacta (mais estreita que os cards de lançamentos) ===== */
  #ultimas-avaliacoes-track{gap:10px;}
  #ultimas-avaliacoes-track .avaliacao-card{flex:0 0 min(68vw,240px) !important;max-width:240px !important;padding:10px !important;border-radius:12px !important;}
  #ultimas-avaliacoes-track .avaliacao-titulo-bloco{padding:6px;margin:0 0 8px;gap:8px;border-radius:8px;}
  #ultimas-avaliacoes-track .avaliacao-poster-mini{width:28px;border-radius:4px;}
  #ultimas-avaliacoes-track .avaliacao-titulo-nome{font-size:.76rem;}
  #ultimas-avaliacoes-track .avaliacao-titulo-tags{font-size:.62rem;margin-top:2px;}
  #ultimas-avaliacoes-track .avaliacao-cabecalho{gap:8px;margin-bottom:6px;}
  #ultimas-avaliacoes-track .comentario-avatar{width:26px;height:26px;font-size:.72rem;}
  #ultimas-avaliacoes-track .comentario-nome{font-size:.74rem;}
  #ultimas-avaliacoes-track .comentario-estrelas-exibidas{font-size:.66rem;letter-spacing:0;}
  #ultimas-avaliacoes-track .comentario-data{font-size:.6rem;margin-left:4px;}
  #ultimas-avaliacoes-track .comentario-texto{font-size:.74rem;line-height:1.35;-webkit-line-clamp:2;}
  #ultimas-avaliacoes-track .avaliacao-votos{margin-top:8px;padding-top:8px;gap:6px;}
  #ultimas-avaliacoes-track .votos-pergunta{display:none;}
  #ultimas-avaliacoes-track .btn-voto{flex:1;justify-content:center;padding:4px 6px;font-size:.64rem;}

  /* ===== Vidro aqua (estilo iPhone) — só nos cartões de comentários ===== */
  .avaliacao-card{
    background:linear-gradient(145deg,rgba(150,215,255,.16),rgba(255,255,255,.04)) !important;
    -webkit-backdrop-filter:blur(14px) saturate(180%);backdrop-filter:blur(14px) saturate(180%);
    border:1px solid rgba(255,255,255,.22) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.35),0 6px 18px rgba(0,0,0,.28);
  }
  .avaliacao-card .avaliacao-titulo-bloco{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.14);}
  .avaliacao-card .avaliacao-votos{border-top-color:rgba(255,255,255,.14);}
  .avaliacao-card .btn-voto{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.2);}
  .avaliacao-card .btn-voto.marcado{background:rgba(255,255,255,.16);border-color:var(--ink);}

  /* ===== Temas: 1) Escuro (principal, o de sempre)  2) Claro  3) Oceano ===== */
  :root[data-tema="claro"]{--bg:#f4f1ea;--panel:#ffffff;--ink:#1c1f26;--muted:#6b707c;--accent:#c78410;--accent-dim:#f0d9a8;--line:#e2ded3;}
  :root[data-tema="oceano"]{--bg:#06131f;--panel:#0d2233;--ink:#e6f3fb;--muted:#7f9bb0;--accent:#35c4e0;--accent-dim:#145a6b;--line:#16344a;}
  :root[data-tema="claro"] .avaliacao-card{border-color:rgba(0,0,0,.12) !important;box-shadow:0 4px 14px rgba(0,0,0,.08);}
  :root[data-tema="claro"] .avaliacao-card .btn-voto{background:rgba(0,0,0,.04);border-color:rgba(0,0,0,.14);}
  :root[data-tema="claro"] .avaliacao-card .avaliacao-titulo-bloco{background:rgba(0,0,0,.03);border-color:rgba(0,0,0,.1);}
  .perfil-temas{margin-top:8px;padding-top:8px;border-top:1px solid var(--line);}
  .perfil-temas > label{display:block;font-size:.8rem;color:var(--muted);margin-bottom:8px;}
  .perfil-temas-lista{display:flex;gap:8px;}
  .btn-tema{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;background:var(--panel);border:1px solid var(--line);color:var(--ink);border-radius:10px;padding:10px 4px;font-size:.72rem;font-family:inherit;cursor:pointer;}
  .btn-tema.ativo{border-color:var(--accent);color:var(--accent);font-weight:700;}
  .btn-tema .amostra{width:30px;height:30px;border-radius:50%;border:2px solid rgba(128,128,128,.4);display:flex;align-items:flex-end;justify-content:flex-end;overflow:hidden;}
  .btn-tema .amostra i{display:block;width:12px;height:12px;border-radius:50%;margin:0 2px 2px 0;}
  /* ===== Configuração de temas: discreta, com interruptores (clica → vai para a direita = ligado; clica de novo → volta para a esquerda = desligado) ===== */
  #perfilConfig{margin-top:12px;padding-top:10px;}
  #perfilConfig .cfg-titulo{display:flex;align-items:baseline;gap:8px;font-size:.72rem;color:var(--muted);margin-bottom:6px;}
  #perfilConfig .cfg-titulo small{font-size:.68rem;opacity:.85;}
  #perfilConfig .cfg-switches{display:flex;gap:14px;flex-wrap:wrap;}
  #perfilConfig .cfg-sw{display:inline-flex;align-items:center;gap:7px;cursor:pointer;font-size:.78rem;color:var(--ink);margin:0;user-select:none;}
  #perfilConfig .sw-input{position:absolute;opacity:0;width:0;height:0;}
  #perfilConfig .sw-trilho{position:relative;flex:none;width:34px;height:19px;border-radius:19px;background:var(--line);border:1px solid rgba(128,128,128,.35);transition:background .2s;}
  #perfilConfig .sw-trilho i{position:absolute;top:1px;left:1px;width:15px;height:15px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.35);transition:transform .2s;}
  #perfilConfig .sw-input:checked + .sw-trilho{background:var(--accent);border-color:var(--accent);}
  #perfilConfig .sw-input:checked + .sw-trilho i{transform:translateX(15px);}
  #perfilConfig .sw-input:focus-visible + .sw-trilho{outline:2px solid var(--accent);outline-offset:2px;}
  #perfilConfig .cfg-dica{display:block;margin-top:6px;font-size:.68rem;line-height:1.35;color:var(--muted);}
  #perfilComoBaixar .cfg-titulo{display:flex;align-items:baseline;gap:8px;font-size:.72rem;color:var(--muted);margin-bottom:6px;}
  #perfilComoBaixar .cfg-titulo small{font-size:.68rem;opacity:.85;}
  #perfilComoBaixar .cfg-switches{display:flex;gap:14px;flex-wrap:wrap;}
  #perfilComoBaixar .cfg-sw{display:inline-flex;align-items:center;gap:7px;cursor:pointer;font-size:.78rem;color:var(--ink);margin:0;user-select:none;}
  #perfilComoBaixar .sw-input{position:absolute;opacity:0;width:0;height:0;}
  #perfilComoBaixar .sw-trilho{position:relative;flex:none;width:34px;height:19px;border-radius:19px;background:var(--line);border:1px solid rgba(128,128,128,.35);transition:background .2s;}
  #perfilComoBaixar .sw-trilho i{position:absolute;top:1px;left:1px;width:15px;height:15px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.35);transition:transform .2s;}
  #perfilComoBaixar .sw-input:checked + .sw-trilho{background:var(--accent);border-color:var(--accent);}
  #perfilComoBaixar .sw-input:checked + .sw-trilho i{transform:translateX(15px);}
  #perfilComoBaixar .sw-input:focus-visible + .sw-trilho{outline:2px solid var(--accent);outline-offset:2px;}
  #perfilComoBaixar .cfg-dica{display:block;margin-top:6px;font-size:.68rem;line-height:1.35;color:var(--muted);}
  #perfilComoBaixar .cfg-switches{flex-direction:column;align-items:stretch;gap:8px;}
  .perfil-temas-lista.desligado .btn-tema{opacity:.5;}

  /* ===== Tema Aqua: botões/ícones de vidro transparente (estilo iPhone) ===== */
  :root[data-tema="aqua"] .btn-feed,:root[data-tema="aqua"] .profile-btn,:root[data-tema="aqua"] .card-btn-partilhar,
  :root[data-tema="aqua"] .card-tipo-badge,:root[data-tema="aqua"] .btn-fechar-detalhes,:root[data-tema="aqua"] .btn-partilhar-detalhes{
    background:linear-gradient(145deg,rgba(150,215,255,.26),rgba(255,255,255,.07)) !important;
    -webkit-backdrop-filter:blur(14px) saturate(180%);backdrop-filter:blur(14px) saturate(180%);
    border:1px solid rgba(255,255,255,.30) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.45),inset 0 -1px 0 rgba(255,255,255,.08),0 4px 14px rgba(0,0,0,.28);
  }
  :root[data-tema="aqua"] .btn-feed:hover,:root[data-tema="aqua"] .profile-btn:hover,:root[data-tema="aqua"] .card-btn-partilhar:hover{
    background:linear-gradient(145deg,rgba(150,215,255,.38),rgba(255,255,255,.12)) !important;
    border-color:rgba(255,255,255,.45) !important;
  }
  :root[data-tema="aqua"] .bottom-nav{
    background:linear-gradient(180deg,rgba(150,215,255,.12),rgba(22,26,34,.38)) !important;
    -webkit-backdrop-filter:blur(22px) saturate(180%);backdrop-filter:blur(22px) saturate(180%);
    border-top:1px solid rgba(255,255,255,.22);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.3);
  }
  :root[data-tema="aqua"] .bottom-nav button svg{filter:drop-shadow(0 1px 3px rgba(0,0,0,.35));}
  :root[data-tema="aqua"] .bottom-nav button.ativa svg{fill:rgba(224,163,60,.22);}

  /* Cabeçalhos das telas cheias ficam por cima dos selos/botões dos cards */
  .tela-historico-cabecalho,.tela-episodios-cabecalho{z-index:10;}

  /* ===== Logótipo Webplay (imagens lidas da pasta, cor segue o tema) ===== */
  :root{--logo-hue:186deg;}
  :root[data-tema="oceano"]{--logo-hue:-22deg;}
  .logo-webplay{position:relative;display:block;height:34px;aspect-ratio:900/205;margin:0 auto;cursor:pointer;-webkit-tap-highlight-color:transparent;font-size:0;}
  .logo-webplay i,.logo-webplay .logo-original{display:none;}
  .logo-webplay i{position:absolute;inset:0;
    -webkit-mask-repeat:no-repeat;mask-repeat:no-repeat;-webkit-mask-position:center;mask-position:center;-webkit-mask-size:contain;mask-size:contain;}
  .logo-webplay .logo-web{background:var(--ink);-webkit-mask-image:url(<?= $logoDir ?>webplay-web.png?v=<?= $logoVer ?>);mask-image:url(<?= $logoDir ?>webplay-web.png?v=<?= $logoVer ?>);}
  .logo-webplay .logo-play{background:var(--accent);background:linear-gradient(180deg,var(--accent),color-mix(in srgb,var(--accent) 62%,#000));
    -webkit-mask-image:url(<?= $logoDir ?>webplay-play.png?v=<?= $logoVer ?>);mask-image:url(<?= $logoDir ?>webplay-play.png?v=<?= $logoVer ?>);}
  .logo-webplay .logo-original{position:absolute;inset:0;width:100%;height:100%;object-fit:contain;mix-blend-mode:screen;filter:hue-rotate(var(--logo-hue));}
  :root[data-tema="claro"] .logo-webplay .logo-original{mix-blend-mode:multiply;filter:invert(1) hue-rotate(15deg);}
  .logo-webplay .logo-texto{display:flex;align-items:center;justify-content:center;height:100%;font-family:'Segoe UI',system-ui,sans-serif;font-size:1.55rem;font-weight:900;letter-spacing:-1px;line-height:1;white-space:nowrap;color:var(--ink);}
  .logo-webplay .logo-texto b{color:var(--accent);font-weight:900;}
  .logo-webplay.logo-ok i{display:block;}
  .logo-webplay.logo-img .logo-original{display:block;}
  .logo-webplay.logo-ok .logo-texto,.logo-webplay.logo-img .logo-texto{display:none;}
  @media (min-width:640px){ .logo-webplay{height:44px;} }
  @media (max-width:639px){ header{padding-top:10px;} }
  .btn-feed.oculto{display:none !important;}

  /* ===== Pílula do topo: [Feed] [Cronograma], cada um na sua bolinha dentro da mesma pílula ===== */
  .pilula-topo{position:fixed;top:10px;left:3.5vw;z-index:60;display:flex;align-items:center;gap:4px;padding:3px;border-radius:999px;background:var(--panel);border:1px solid var(--line);}
  .pilula-topo.oculto{display:none !important;}
  :root .pilula-topo .btn-feed,:root .pilula-topo .btn-cronograma{position:relative;top:auto;left:auto;width:32px;height:32px;padding:0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-family:inherit;-webkit-tap-highlight-color:transparent;}
  :root .pilula-topo .btn-feed{background:var(--accent);border:none;color:#1a1305;}
  :root .pilula-topo .btn-cronograma{background:none;border:none;color:var(--ink);}
  .pilula-topo svg{width:17px;height:17px;display:block;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
  .pilula-topo button:active{opacity:.7;}
  /* o pontinho verde só aparece quando há novidade no feed */
  .pilula-topo .btn-feed:not(.tem-novo)::before{display:none;}
  .pilula-topo .btn-feed::before{top:-3px;right:-3px;border:2px solid var(--panel);width:11px;height:11px;box-sizing:border-box;}
  .pilula-topo .btn-feed.tem-novo{animation:feedChama 1.8s infinite;}
  @keyframes feedChama{0%{box-shadow:0 0 0 0 rgba(46,204,113,.55);}70%{box-shadow:0 0 0 7px rgba(46,204,113,0);}100%{box-shadow:0 0 0 0 rgba(46,204,113,0);}}
  .pilula-topo .feed-badge{bottom:-6px;right:-6px;}

  /* ===== Cronograma de lançamentos ===== */
  #painel-cronograma{display:none;position:fixed;inset:0;z-index:1100;background:rgba(0,0,0,.82);align-items:flex-start;justify-content:center;overflow-y:auto;overscroll-behavior:contain;-webkit-overflow-scrolling:touch;padding:56px 12px 24px;}
  #painel-cronograma.aberto{display:flex;}
  body:has(#painel-cronograma.aberto){overflow:hidden;}
  .cron-card{background:var(--bg);border:1px solid var(--line);border-radius:14px;width:100%;max-width:480px;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.6);}
  .cron-topo{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;}
  .cron-topo h2{font-size:1.05rem;color:var(--ink);margin:0;}
  .cron-dica{color:var(--muted);font-size:.7rem;margin:0 0 12px;line-height:1.4;}
  .cron-dia{font-size:.95rem;font-weight:800;color:var(--ink);margin:18px 0 10px;padding-bottom:8px;border-bottom:1px solid var(--line);}
  .cron-dia small{color:var(--muted);font-weight:600;font-size:.72rem;margin-left:6px;}
  .cron-grade{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;}
  .cron-item{cursor:pointer;text-align:center;}
  .cron-poster{position:relative;aspect-ratio:2/3;border-radius:12px;overflow:hidden;background:var(--panel);border:1px solid var(--line);}
  .cron-poster img{width:100%;height:100%;object-fit:cover;display:block;}
  .cron-poster-base{position:absolute;left:0;right:0;bottom:0;display:flex;align-items:flex-end;justify-content:space-between;gap:6px;padding:22px 8px 8px;background:linear-gradient(transparent,rgba(0,0,0,.85));color:#fff;font-size:.78rem;font-weight:700;}
  .cron-ep{background:var(--accent);color:#1a1305;border-radius:6px;padding:2px 7px;font-size:.78rem;font-weight:800;}
  .cron-tit{margin-top:6px;font-size:.76rem;line-height:1.3;color:var(--ink);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
  .cron-hora{font-size:.66rem;color:var(--muted);margin-top:2px;}
  .cron-msg{color:var(--muted);font-size:.8rem;text-align:center;padding:28px 0;}
  .cron-msg button{margin-top:10px;background:var(--accent);color:#1a1305;border:none;border-radius:8px;font-weight:700;font-size:.78rem;padding:8px 14px;cursor:pointer;}

  /* ===== Botão "+" — na Início: aba discreta na lateral direita (onde fica o botão de
     ligar do telemóvel); nas outras abas: "+" no cabeçalho, no lugar do Feed (que só
     aparece na Início), sem tirar o logótipo do meio. Cores seguem o tema (fundo do
     tema, nunca uma cor viva). O ícone pode ser trocado em .btn-mais .icone-mais. ===== */
  .btn-mais{
    position:fixed;z-index:60;padding:0;cursor:pointer;font-family:inherit;
    background:var(--panel);border:1px solid var(--line);color:var(--ink);
    display:flex;align-items:center;justify-content:center;-webkit-tap-highlight-color:transparent;
  }
  .btn-mais .icone-mais{width:16px;height:16px;display:block;stroke:currentColor;fill:none;stroke-width:2.2;stroke-linecap:round;}
  .btn-mais:active{opacity:.65;}
  /* aba lateral: a borda do ecrã faz uma curva suave para dentro à volta do "+" */
  .btn-mais.mais-lateral{
    right:0;top:40%;width:30px;height:130px;background:none;border:none;border-radius:0;
    color:var(--ink);filter:drop-shadow(-2px 0 4px rgba(0,0,0,.22));
  }
  .btn-mais.mais-lateral .forma-aba{position:absolute;inset:0;width:100%;height:100%;display:block;}
  .btn-mais.mais-lateral .forma-aba .fundo{fill:var(--panel);}
  .btn-mais.mais-lateral .forma-aba .contorno{fill:none;stroke:var(--line);stroke-width:1.2;}
  .btn-mais.mais-lateral .icone-mais{position:relative;margin-left:8px;}
  .btn-mais.mais-cabecalho{
    top:10px;left:3.5vw;width:38px;height:38px;border-radius:50%;
  }
  .btn-mais.oculto{display:none !important;}
  /* aviso do correio: verde = aprovado, vermelho = recusado (a forma e o fundo seguem o tema) */
  .btn-mais.mais-aprovado{color:#2ecc71;}
  .btn-mais.mais-negado{color:#e5484d;}
  .btn-mais.mais-aprovado.mais-cabecalho{border-color:#2ecc71;box-shadow:0 0 10px rgba(46,204,113,.45);}
  .btn-mais.mais-negado.mais-cabecalho{border-color:#e5484d;box-shadow:0 0 10px rgba(229,72,77,.45);}
  .btn-mais.mais-aprovado.mais-lateral{filter:drop-shadow(-2px 0 5px rgba(46,204,113,.55));}
  .btn-mais.mais-negado.mais-lateral{filter:drop-shadow(-2px 0 5px rgba(229,72,77,.55));}
  .btn-mais.mais-aprovado.mais-lateral .forma-aba .contorno{stroke:#2ecc71;}
  .btn-mais.mais-negado.mais-lateral .forma-aba .contorno{stroke:#e5484d;}
  /* moldura da pasta (Drive/Mega) na lista de episódios */
  .bloco-pasta{margin:16px 0 6px;border-radius:22px;padding:2px;background:linear-gradient(145deg,var(--accent),var(--accent-dim) 55%,var(--line));box-shadow:0 8px 24px rgba(0,0,0,.35);}
  .bloco-pasta-in{border-radius:20px;background:var(--panel);overflow:hidden;}
  .bloco-pasta-cab{display:flex;align-items:center;gap:8px;padding:10px 14px;border-bottom:1px solid var(--line);}
  .bloco-pasta-selo{font-size:.62rem;font-weight:800;letter-spacing:.4px;padding:3px 9px;border-radius:12px;background:var(--accent);color:#1a1305;white-space:nowrap;}
  .bloco-pasta-tit{flex:1;min-width:0;font-size:.8rem;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .bloco-pasta-abrir{font-size:.72rem;color:var(--accent);text-decoration:none;white-space:nowrap;}
  .bloco-pasta-moldura{padding:10px;}
  .bloco-pasta-moldura iframe{display:block;width:100%;height:56vh;min-height:320px;border:0;border-radius:14px;background:var(--bg);}
  .espec-manual{display:flex;flex-wrap:wrap;gap:6px;margin:8px 0;}
  .espec-manual span{padding:3px 10px;border-radius:12px;background:var(--panel);border:1px solid var(--line);color:var(--ink);font-size:.72rem;}
  .espec-manual a,.espec-manual button.btn-parte-manual{padding:3px 10px;border-radius:12px;background:var(--accent);color:#1a1305;font-size:.72rem;font-weight:700;border:none;cursor:pointer;text-decoration:none;font-family:inherit;}

  /* ===== Ícone de pesquisa (transparente, sem cor) ao lado do perfil ===== */
  .btn-busca-icone{position:absolute;top:10px;right:calc(3.5vw + 40px);width:34px;height:34px;padding:0;
    background:none;border:none;color:var(--ink);opacity:.9;display:flex;align-items:center;justify-content:center;cursor:pointer;-webkit-tap-highlight-color:transparent;}
  .btn-busca-icone:active{opacity:.6;}
  header .search{display:none;}
  header.pesquisa-aberta .search{display:flex;}

  /* ===== Janela do logótipo + direitos reservados ===== */
  .modal-logo{display:none;position:fixed;inset:0;z-index:1250;background:rgba(0,0,0,.85);align-items:center;justify-content:center;padding:16px;overflow-y:auto;}
  .modal-logo.aberto{display:flex;}
  .modal-logo-caixa{position:relative;width:100%;max-width:360px;background:var(--panel);border:1px solid var(--line);border-radius:14px;padding:16px;text-align:center;}
  .modal-logo-caixa .logo-modal{height:56px;cursor:default;margin:10px auto 16px;}
  .modal-logo-fechar{position:absolute;top:6px;right:8px;background:none;border:none;color:var(--muted);font-size:1.3rem;line-height:1;cursor:pointer;padding:4px 8px;z-index:2;}
  .modal-logo-direitos{font-size:.8rem;font-weight:700;color:var(--ink);margin-top:6px;}
  .modal-logo-aviso{font-size:.74rem;color:var(--muted);margin-top:8px;line-height:1.5;}
</style>
<script>try{var _m=localStorage.getItem('webplay_tema_manual')!=='0';document.documentElement.setAttribute('data-tema',_m?(localStorage.getItem('cinesongo_tema')||'escuro'):'escuro');}catch(e){}</script>
<link rel="stylesheet" href="webplay-tema.css">
</head>
<body>

<header>
  <div class="pilula-topo" id="pilulaTopo">
    <button class="btn-feed" id="btnFeed" type="button" title="Feed" aria-label="Feed"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h13a1 1 0 0 1 1 1v13H6a2 2 0 0 1-2-2V5z"/><path d="M18 9h2v8a2 2 0 0 1-2 2"/><path d="M8 9h6M8 13h6"/></svg><span class="feed-badge" id="feedBadgeNaoLidas" style="display:none;">0</span></button>
    <button class="btn-cronograma" id="btnCronograma" type="button" title="Cronograma de lançamentos" aria-label="Cronograma de lançamentos"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><circle cx="12" cy="15.5" r="2.2"/></svg></button>
  </div>
  <button class="btn-mais mais-cabecalho oculto" id="btnMaisCabecalho" type="button" title="Mais" aria-label="Mais"><svg class="icone-mais" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></button>
  <button class="btn-mais mais-lateral" id="btnMaisLateral" type="button" title="Mais" aria-label="Mais"><svg class="forma-aba" viewBox="0 0 30 130" preserveAspectRatio="none" aria-hidden="true"><path class="fundo" d="M30 0C30 24 12 28 12 65C12 102 30 106 30 130Z"/><path class="contorno" d="M30 0C30 24 12 28 12 65C12 102 30 106 30 130"/></svg><svg class="icone-mais" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></button>
  <button class="btn-busca-icone" id="btnBuscaIcone" type="button" title="Pesquisar" aria-label="Pesquisar"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg></button>
  <button class="profile-btn" id="profileBtn" title="Meu perfil">👤</button>
  <h1 class="logo-webplay" id="logoWebplay" role="button" aria-label="Webplay" tabindex="0"><i class="logo-web"></i><i class="logo-play"></i><img class="logo-original" alt=""><span class="logo-texto">Web<b>play</b></span></h1>
  <div class="search">
    <input id="searchInput" type="text" placeholder="Buscar filmes, séries, animes, doramas...">
    <button class="history-btn" id="historyBtn" title="Ver histórico de pesquisas">🕒</button>
    <div class="search-suggestions" id="searchSuggestions"></div>
  </div>
</header>

<div class="modal-logo" id="modalLogo">
  <div class="modal-logo-caixa">
    <button class="modal-logo-fechar" id="fecharModalLogo" type="button" aria-label="Fechar">✕</button>
    <div class="logo-webplay logo-modal" role="img" aria-label="Webplay"><i class="logo-web"></i><i class="logo-play"></i><img class="logo-original" alt=""><span class="logo-texto">Web<b>play</b></span></div>
    <p class="modal-logo-direitos">© <span id="anoDireitos"></span> Webplay. Todos os direitos reservados.</p>
    <p class="modal-logo-aviso">Caro usuário, saiba que todo o conteúdo disponível neste site é de terceiros. O Webplay não hospeda nenhum arquivo nos seus servidores, e os direitos pertencem aos seus respectivos proprietários.</p>
  </div>
</div>

<div class="tela-historico" id="telaComentarios">
  <div class="tela-historico-cabecalho">
    <div class="tela-historico-titulo">💬 Todos os comentários</div>
    <div class="tela-historico-acoes"><span class="tela-historico-fechar" id="fecharTelaComentarios">✕</span></div>
  </div>
  <div class="tela-historico-corpo"><div class="lista-comentarios-cheia" id="telaComentariosLista"></div></div>
</div>

<div id="painel-cronograma" onclick="if(event.target===this) fecharCronograma()">
  <div class="cron-card">
    <div class="cron-topo">
      <h2>🗓 Cronograma de lançamentos</h2>
      <button class="feed-fechar" type="button" onclick="fecharCronograma()" aria-label="Fechar">✕</button>
    </div>
    <p class="cron-dica">Filmes, séries, animes e doramas do catálogo. As datas são as previstas pela TMDB e podem mudar.</p>
    <div class="feed-abas">
      <button type="button" class="feed-aba-btn ativa" id="cron-aba-proximos" onclick="trocarAbaCronograma('proximos')">Próximos</button>
      <button type="button" class="feed-aba-btn" id="cron-aba-lancados" onclick="trocarAbaCronograma('lancados')">Já lançados</button>
    </div>
    <div id="cron-lista"></div>
  </div>
</div>

<div id="painel-feed" onclick="if(event.target===this) fecharPainelFeed()">
  <div class="feed-card">
    <div class="feed-titulo">
      <h2>📰 Feed</h2>
      <button class="feed-fechar" onclick="fecharPainelFeed()">✕</button>
    </div>
    <div class="feed-abas">
      <button class="feed-aba-btn ativa" id="feed-aba-todos" onclick="trocarAbaFeed('todos')">Todos</button>
      <button class="feed-aba-btn" id="feed-aba-aviso" onclick="trocarAbaFeed('aviso')">📢 Avisos</button>
      <button class="feed-aba-btn" id="feed-aba-pergunta" onclick="trocarAbaFeed('pergunta')">❓ Perguntas</button>
      <button class="feed-aba-btn" id="feed-aba-enquete" onclick="trocarAbaFeed('enquete')">📊 Enquetes</button>
    </div>
    <div id="feed-lista-itens"></div>
  </div>
</div>

<div class="overlay" id="profileOverlay">
  <div class="profile-box">
    <div class="player-head">
      <h3 id="perfilTitulo">Iniciar conta</h3>
      <button type="button" id="btnEngrenagemPerfil" title="Opções do site" aria-label="Opções do site" aria-expanded="false"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h0a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h0a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v0a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></button>
      <button id="closeProfile">✕</button>
    </div>
    <div class="profile-body">
      <div class="perfil-topo">
        <div class="perfil-avatar-grande" id="perfilAvatarGrande"></div>
      </div>
      <!-- opções do site: só aparecem ao tocar na engrenagem -->
      <div class="perfil-menu" id="perfilMenuOpcoes" hidden>
        <button type="button" class="perfil-ico" id="btnPartilharApp" title="Partilhar a app" aria-label="Partilhar a app"><b>⤴</b><small>Partilhar</small></button>
        <button type="button" class="perfil-ico" id="btnEstiloSite" title="Como o site se mostra" aria-label="Estilo do site"><b>▦</b><small>Estilo</small></button>
        <button type="button" class="perfil-ico" id="btnCabecalhoSite" title="Mostrar ou ocultar o cabeçalho" aria-label="Cabeçalho"><b>▭</b><small>Cabeçalho</small></button>
        <button type="button" class="perfil-ico" id="btnListas" title="Minha lista e favoritos" aria-label="Minha lista e favoritos"><b>♡</b><small>Listas</small></button>
        <button type="button" class="perfil-ico" id="btnTextoSite" title="Tamanho e alinhamento do texto" aria-label="Texto"><b>Tt</b><small>Texto</small></button>
        <button type="button" class="perfil-ico" id="btnBordaSite" title="Forma da borda" aria-label="Borda"><b>◰</b><small>Borda</small></button>
      </div>
      <div class="balao-como-baixar" id="balaoComoBaixar" style="display:none"><span class="balao-txt"></span><button type="button"></button></div>

      <!-- sem conta iniciada -->
      <div id="perfilDeslogado">
      <div id="painelInicio">
        <button type="button" class="btn-google" id="btnGoogle">
          <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.9 6.1C12.4 13.5 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.2 5.5-4.7 7.2l7.6 5.9c4.4-4.1 6.9-10.1 6.9-17.6z"/><path fill="#FBBC05" d="M10.5 28.7A14.5 14.5 0 0 1 9.5 24c0-1.6.3-3.2.8-4.7l-7.9-6.1A24 24 0 0 0 0 24c0 3.9.9 7.5 2.6 10.8l7.9-6.1z"/><path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.6-5.9c-2.1 1.4-4.9 2.3-8.3 2.3-6.3 0-11.6-4-13.5-9.8l-7.9 6.1C6.5 42.6 14.6 48 24 48z"/></svg>
          Continuar com Google
        </button>
        <div class="perfil-ou"><span>ou</span></div>
        <button type="button" class="btn-google btn-email" id="btnAbrirEmail">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
          Continuar com e-mail / Criar conta
        </button>
        <p class="perfil-erro" id="perfilErroInicio"></p>
        <details class="perfil-local">
          <summary>Usar só neste aparelho, sem conta</summary>
          <div class="perfil-local-corpo">
            <div>
              <label>Nome (só neste aparelho)</label>
              <input type="text" id="profileName" placeholder="O teu nome">
            </div>
            <div>
              <label>Avatar</label>
              <div class="avatar-grid" id="avatarGrid"></div>
            </div>
            <button class="more-btn" id="saveProfile" style="align-self:flex-start;">💾 Guardar</button>
          </div>
        </details>
      </div><!-- /painelInicio -->

      <!-- aba nova: e-mail / criar conta -->
      <div id="painelEmail" style="display:none;">
        <button type="button" class="perfil-voltar" id="btnVoltarInicio">← Voltar</button>
        <div class="perfil-abas">
          <button type="button" id="abaEntrar" class="ativa">Entrar</button>
          <button type="button" id="abaCriar">Criar conta</button>
        </div>
        <p class="perfil-erro" id="perfilErro"></p>
        <div class="perfil-campo" id="campoNomeCriar" style="display:none;">
          <label>Nome</label>
          <input type="text" id="perfilNomeConta" placeholder="O teu nome" autocomplete="name">
        </div>
        <div class="perfil-campo">
          <label>E-mail</label>
          <input type="email" id="perfilEmail" placeholder="o-teu@email.com" autocomplete="email">
        </div>
        <div class="perfil-campo">
          <label>Palavra-passe</label>
          <input type="password" id="perfilSenha" placeholder="Mínimo 6 caracteres" autocomplete="current-password">
        </div>
        <div class="perfil-campo" id="campoFotoCriar" style="display:none;">
          <label>Link da foto de perfil (opcional)</label>
          <input type="url" id="perfilFotoConta" placeholder="https://...">
        </div>
        <button class="more-btn" id="btnEnviarConta" style="width:100%;">Entrar</button>
      </div><!-- /painelEmail -->
      </div>

      <!-- com conta iniciada -->
      <div id="perfilLogado" style="display:none;">
        <div class="perfil-resumo" id="perfilResumo" role="button" tabindex="0" title="Editar perfil">
          <div class="perfil-nome-logado" id="perfilNomeLogado"></div>
          <div class="perfil-email-logado" id="perfilEmailLogado"></div>
        </div>
        <div class="perfil-editar" id="perfilEditar">
          <button type="button" class="perfil-voltar" id="perfilEditarVoltar" aria-label="Voltar">← Voltar</button>
          <div class="perfil-campo">
            <label>Nome</label>
            <input type="text" id="perfilNomeEditar" placeholder="O teu nome">
          </div>
          <div class="perfil-campo">
            <label>Link da foto de perfil</label>
            <input type="url" id="perfilFotoEditar" placeholder="https://...">
          </div>
          <button class="more-btn" id="btnGuardarConta" style="width:100%;margin-bottom:10px;">💾 Guardar</button>
        </div>
        <button class="btn-sair" id="btnSair" style="width:100%;">Terminar sessão</button>
        <p class="perfil-erro" id="perfilErroLogado"></p>
      </div>

      <div class="perfil-rolagem" id="perfilRolagem">
      <div class="perfil-temas" id="perfilLetraSecao">
        <div class="cfg-titulo"><b>Aa</b> <span>Tipo de letra</span></div>
        <button type="button" class="perfil-letra-linha" id="btnMudarLetra2"><span id="letraAtualNome">Webplay (padrão)</span><em>Mudar ›</em></button>
      </div>
      <div class="perfil-temas" id="perfilComoBaixar">
        <div class="cfg-titulo">⬇ <span>Como baixar (1DM)</span></div>
        <div class="cfg-switches">
          <button type="button" class="perfil-letra-linha" id="btnVerComoBaixar" style="margin-top:0"><span>▶ Ver como baixar</span><em>Abrir ›</em></button>
          <label class="cfg-sw" for="chkComoBaixar"><span>Mostrar o "Como baixar" antes de baixar</span>
            <input type="checkbox" id="chkComoBaixar" class="sw-input" checked><span class="sw-trilho"><i></i></span></label>
        </div>
      </div>
      <div class="perfil-temas" id="perfilConfig">
        <div class="cfg-titulo">⚙️ <span>Temas</span><small id="temaAutoEstado"></small></div>
        <div class="cfg-switches">
          <label class="cfg-sw" for="chkTemaAuto"><span>🎨 Automático</span>
            <input type="checkbox" id="chkTemaAuto" class="sw-input" checked><span class="sw-trilho"><i></i></span></label>
          <label class="cfg-sw" for="chkTemaManual"><span>🖐 Manual</span>
            <input type="checkbox" id="chkTemaManual" class="sw-input" checked><span class="sw-trilho"><i></i></span></label>
        </div>
        <small class="cfg-dica" id="temaModoDica"></small>
      </div>

      <div class="perfil-temas">
        <label>Tema</label>
        <div class="perfil-temas-lista" id="perfilTemas">
          <button type="button" class="btn-tema" data-tema="escuro"><span class="amostra" style="background:#0d0f14;"><i style="background:#e0a33c;"></i></span>Escuro</button>
          <button type="button" class="btn-tema" data-tema="claro"><span class="amostra" style="background:#f4f1ea;"><i style="background:#c78410;"></i></span>Claro</button>
          <button type="button" class="btn-tema" data-tema="aqua"><span class="amostra" style="background:linear-gradient(145deg,#8fd3ff,#2b3a4d);"><i style="background:rgba(255,255,255,.55);"></i></span>Aqua</button>
          <button type="button" class="btn-tema" data-tema="oceano"><span class="amostra" style="background:#06131f;"><i style="background:#35c4e0;"></i></span>Oceano</button>
        </div>
      </div>
      </div><!-- /perfil-rolagem -->
    </div>
  </div>
</div>

<main id="main">
  <!-- ===== Aba de PESQUISA: abre sozinha quando o utilizador pesquisa, com a
       mesma grade de 4 por linha das outras abas (Filmes/Séries/...). ===== -->
  <section class="page" id="page-pesquisa">
    <div class="row">
      <div class="row-head">
        <h2 id="pesquisaTitulo">Resultados da pesquisa</h2>
        <button class="ver-tudo" id="btnFecharPesquisa">← Voltar</button>
      </div>
      <div class="track grade-catalogo" id="searchTrack"></div>
    </div>
  </section>

  <!-- ===== INÍCIO: só prévias de lançamentos recentes, não o catálogo todo ===== -->
  <section class="page ativa" id="page-inicio">
    <div class="banner-destaque-container" id="banner-destaques">
      <div class="banner-fade banner-fade-topo"></div>
      <div class="banner-fade banner-fade-esq"></div>
      <div class="banner-fade banner-fade-dir"></div>
      <div class="banner-indicadores" id="indicadores-destaques"></div>
    </div>
    <!-- NOVO: "Continuar Assistindo" — faixa do histórico de cliques deste
         aparelho, com botão ✕ para remover cada item. Fica escondida
         sozinha (montarContinuarAssistindo) quando não há nada no
         histórico ainda. -->
    <div class="row" id="linha-continuar-assistindo" style="display:none;">
      <div class="row-head">
        <div>
          <h2>Continuar Assistindo</h2>
          <div class="row-head-sub">Retome rapidamente o que você estava assistindo.</div>
        </div>
      </div>
      <div class="track" id="continuar-assistindo-track"></div>
    </div>
    <!-- NOVO: "Últimos Episódios" — episódios recém-lançados de séries,
         animes e doramas, com o still do episódio e a etiqueta "EP SxE".
         Fica escondida sozinha se ainda não houver nenhum. -->
    <div class="row" id="linha-ultimos-episodios" style="display:none;">
      <div class="row-head">
        <div>
          <h2>Últimos Episódios</h2>
          <div class="row-head-sub">Novos episódios — dos que você assiste e dos mais famosos.</div>
        </div>
      </div>
      <div class="track" id="ultimos-episodios-track"></div>
    </div>
    <!-- NOVO: "Últimas avaliações" — comentários mais recentes de QUALQUER
         título, vindos em tempo real do mesmo Firebase dos comentários por
         título. Fica escondida sozinha até chegar o primeiro comentário. -->
    <div class="row" id="linha-ultimas-avaliacoes" style="display:none;">
      <div class="row-head">
        <div>
          <h2>Comentários recentes</h2>
          <div class="row-head-sub">O que a comunidade está a comentar.</div>
        </div>
        <button class="ver-tudo" id="btnVerTodosComentarios" type="button">Ver todos →</button>
      </div>
      <div class="track" id="ultimas-avaliacoes-track"></div>
    </div>
    <div class="row">
      <div class="row-head">
        <h2>Últimos lançamentos <small>Filmes</small></h2>
        <button class="ver-tudo" data-ir-para="filmes">Ver tudo →</button>
      </div>
      <div class="track" id="recente-filme"><p class="loading">A carregar…</p></div>
    </div>
    <div class="row">
      <div class="row-head">
        <h2>Últimos lançamentos <small>Séries</small></h2>
        <button class="ver-tudo" data-ir-para="series">Ver tudo →</button>
      </div>
      <div class="track" id="recente-serie"><p class="loading">A carregar…</p></div>
    </div>
    <div class="row">
      <div class="row-head">
        <h2>Últimos lançamentos <small>Animes</small></h2>
        <button class="ver-tudo" data-ir-para="animes">Ver tudo →</button>
      </div>
      <div class="track" id="recente-anime"><p class="loading">A carregar…</p></div>
    </div>
    <div class="row">
      <div class="row-head">
        <h2>Últimos lançamentos <small>Doramas</small></h2>
        <button class="ver-tudo" data-ir-para="doramas">Ver tudo →</button>
      </div>
      <div class="track" id="recente-dorama"><p class="loading">A carregar…</p></div>
    </div>
    <!-- NOVO: "Mais Acessados" fica AQUI, como secção normal no fim da página
         (igual ao index 18) — deixou de ser um ecrã à parte aberto por um
         ícone. No Início mostra o ranking combinado de tudo. -->
    <div class="row bloco-mais-acessados" id="bloco-mais-acessados-geral">
      <div class="row-head">
        <h2>🔥 Mais Acessados</h2>
      </div>
      <div class="tabs-mais-acessados" id="tabsMaisAcessados-geral">
        <button class="tab-periodo ativa" data-dias="7">Semanal</button>
        <button class="tab-periodo" data-dias="30">Mensal</button>
        <button class="tab-periodo" data-dias="">Todos</button>
      </div>
      <div class="lista-mais-acessados" id="maisAcessadosLista-geral"></div>
    </div>
  </section>

  <!-- ===== Abas de catálogo completo (uma secção por categoria) ===== -->
  <section class="page" id="page-filmes">
    <div class="row">
      <h2>Filmes <small>catálogo completo</small></h2>
      <div class="track grade-catalogo" id="track-filme"><p class="loading">A carregar…</p></div>
      <div class="pag-controls" id="pag-filme" style="display:none;">
        <button class="nav-btn" data-dir="-1">← Voltar</button>
        <button class="nav-btn" data-dir="1">Próximo →</button>
      </div>
    </div>
    <div class="row bloco-mais-acessados" id="bloco-mais-acessados-filme">
      <div class="row-head">
        <h2>🔥 Mais Acessados <small>Filmes</small></h2>
      </div>
      <div class="tabs-mais-acessados" id="tabsMaisAcessados-filme">
        <button class="tab-periodo ativa" data-dias="7">Semanal</button>
        <button class="tab-periodo" data-dias="30">Mensal</button>
        <button class="tab-periodo" data-dias="">Todos</button>
      </div>
      <div class="lista-mais-acessados" id="maisAcessadosLista-filme"></div>
    </div>
  </section>

  <section class="page" id="page-series">
    <div class="row">
      <h2>Séries <small>catálogo completo</small></h2>
      <div class="track grade-catalogo" id="track-serie"><p class="loading">A carregar…</p></div>
      <div class="pag-controls" id="pag-serie" style="display:none;">
        <button class="nav-btn" data-dir="-1">← Voltar</button>
        <button class="nav-btn" data-dir="1">Próximo →</button>
      </div>
    </div>
    <div class="row bloco-mais-acessados" id="bloco-mais-acessados-serie">
      <div class="row-head">
        <h2>🔥 Mais Acessados <small>Séries</small></h2>
      </div>
      <div class="tabs-mais-acessados" id="tabsMaisAcessados-serie">
        <button class="tab-periodo ativa" data-dias="7">Semanal</button>
        <button class="tab-periodo" data-dias="30">Mensal</button>
        <button class="tab-periodo" data-dias="">Todos</button>
      </div>
      <div class="lista-mais-acessados" id="maisAcessadosLista-serie"></div>
    </div>
  </section>

  <section class="page" id="page-animes">
    <div class="row">
      <h2>Animes <small>catálogo completo</small></h2>
      <div class="track grade-catalogo" id="track-anime"><p class="loading">A carregar…</p></div>
      <div class="pag-controls" id="pag-anime" style="display:none;">
        <button class="nav-btn" data-dir="-1">← Voltar</button>
        <button class="nav-btn" data-dir="1">Próximo →</button>
      </div>
    </div>
    <div class="row bloco-mais-acessados" id="bloco-mais-acessados-anime">
      <div class="row-head">
        <h2>🔥 Mais Acessados <small>Animes</small></h2>
      </div>
      <div class="tabs-mais-acessados" id="tabsMaisAcessados-anime">
        <button class="tab-periodo ativa" data-dias="7">Semanal</button>
        <button class="tab-periodo" data-dias="30">Mensal</button>
        <button class="tab-periodo" data-dias="">Todos</button>
      </div>
      <div class="lista-mais-acessados" id="maisAcessadosLista-anime"></div>
    </div>
  </section>

  <section class="page" id="page-doramas">
    <div class="row">
      <h2>Doramas <small>catálogo completo</small></h2>
      <div class="track grade-catalogo" id="track-dorama"><p class="loading">A carregar…</p></div>
      <div class="pag-controls" id="pag-dorama" style="display:none;">
        <button class="nav-btn" data-dir="-1">← Voltar</button>
        <button class="nav-btn" data-dir="1">Próximo →</button>
      </div>
    </div>
    <div class="row bloco-mais-acessados" id="bloco-mais-acessados-dorama">
      <div class="row-head">
        <h2>🔥 Mais Acessados <small>Doramas</small></h2>
      </div>
      <div class="tabs-mais-acessados" id="tabsMaisAcessados-dorama">
        <button class="tab-periodo ativa" data-dias="7">Semanal</button>
        <button class="tab-periodo" data-dias="30">Mensal</button>
        <button class="tab-periodo" data-dias="">Todos</button>
      </div>
      <div class="lista-mais-acessados" id="maisAcessadosLista-dorama"></div>
    </div>
  </section>
</main>

<!-- ===== Navegação inferior fixa, estilo app ===== -->
<nav class="bottom-nav" id="bottomNav">
  <button data-pagina="inicio" class="ativa">
    <svg viewBox="0 0 24 24"><path d="M3 11.5 12 4l9 7.5"/><path d="M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9"/></svg>
    Início
  </button>
  <button data-pagina="filmes">
    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 4v16M17 4v16M3 9h4M3 15h4M17 9h4M17 15h4"/></svg>
    Filmes
  </button>
  <button data-pagina="series">
    <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M8 21h8M12 18v3"/></svg>
    Séries
  </button>
  <button data-pagina="animes">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18M6 6l3 3M18 18l-3-3M6 18l3-3M18 6l-3 3"/></svg>
    Animes
  </button>
  <button data-pagina="doramas">
    <svg viewBox="0 0 24 24"><path d="M8 4h8v3a4 4 0 0 1-4 4 4 4 0 0 1-4-4V4Z"/><path d="M12 11v3M8 20c0-2.5 1.8-4 4-4s4 1.5 4 4"/><path d="M6 4h2M16 4h2"/></svg>
    Doramas
  </button>
</nav>

<!-- ===== Ecrã cheio de Histórico — mesma ideia visual do index 38 (cards em
     grade, cabeçalho fixo com título e botão de fechar), preenchido pelos
     títulos que a pessoa já abriu neste aparelho. ===== -->
<div class="tela-historico" id="telaHistorico">
  <div class="tela-historico-cabecalho">
    <span class="tela-historico-titulo">🕒 Histórico</span>
    <div class="tela-historico-acoes">
      <button class="btn-limpar-historico" id="btnLimparHistorico">Limpar</button>
      <span class="tela-historico-fechar" id="fecharTelaHistorico" title="Fechar">✕</span>
    </div>
  </div>
  <div class="tela-historico-corpo">
    <div class="track grade-catalogo" id="historicoGrid"></div>
  </div>
</div>


<footer>
  <div id="redesFooter"></div>
  <p class="rodape-direitos">© <span id="anoRodape"></span> @webplay. Todos os direitos reservados. Os conteúdos que disponibilizamos e indexamos são de terceiros; o Webplay não hospeda nenhum ficheiro nos seus servidores.</p>
  <p>Conteúdo servido pela nossa API · dados de capas/títulos via TMDB</p>
  <script>document.getElementById("anoRodape").textContent = new Date().getFullYear();</script>
</footer>

<div class="modal-oculto" id="janelaDetalhes">
  <div class="conteudo-modal">
    <div class="modal-capa-fundo" id="detalhesCapaFundo">
      <div class="modal-capa-gradiente">
        <button class="btn-partilhar-detalhes" id="partilharDetalhes" title="Partilhar"></button>
        <button class="btn-fechar-detalhes" id="fecharDetalhes" aria-label="Voltar"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 4l-8 8 8 8"/></svg></button>
        <button class="btn-lista-detalhes btn-fav-detalhes" id="detalhesBtnFav" aria-label="Favorito" title="Adicionar aos favoritos"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 5.6a5.2 5.2 0 0 0-7.4 0L12 7l-1.4-1.4a5.2 5.2 0 0 0-7.4 7.4L12 21.8l8.8-8.8a5.2 5.2 0 0 0 0-7.4z"/></svg></button>
        <button class="btn-lista-detalhes" id="detalhesBtnLista" aria-label="Minha lista" title="Adicionar à minha lista"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h12M3 12h12M3 18h7M18 13v8M14 17h8"/></svg></button>
        <div class="det-poster-card"><img id="detalhesPoster" alt=""><span class="det-idade" id="detalhesIdade" style="display:none"></span></div>
      </div>
    </div>
    <div class="modal-info-corpo">
      <h2 class="modal-titulo-principal" id="detalhesTitulo"></h2>
      <div class="modal-meta-linha">
        <span class="modal-meta-item" id="detalhesTipo"></span>
        <span>•</span>
        <span id="detalhesAno"></span>
      </div>
      <button class="btn-play-principal" id="detalhesBtnAssistir">▶ Assistir Agora</button>
      <div class="detalhes-temporada-bloco" id="detalhesTemporadaBloco" style="display:none;">
        <label class="detalhes-temporada-label">Temporada
          <select id="detalhesSeasonSelect"></select>
        </label>
        <button class="btn-play-principal" id="detalhesBtnVerEpisodios">Ver Episódios →</button>
      </div>

      <div class="detalhes-acoes" id="detalhesAcoes">
        <button type="button" class="btn-acao-detalhes" id="detalhesBtnBaixar"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12M7 11l5 5 5-5M5 20h14"/></svg><span>Baixar</span></button>
        <button type="button" class="btn-acao-detalhes" id="detalhesBtnEspelhar"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6M2 12a9 9 0 0 1 8 8M2 16a5 5 0 0 1 4 4M2 20h.01"/></svg><span>Espelhar</span></button>
        <button type="button" class="btn-acao-detalhes" id="detalhesBtnAvaliar"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/></svg><span>Avaliar</span></button>
        <button type="button" class="btn-acao-detalhes" id="detalhesBtnPartilhar2"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg><span>Partilhar</span></button>
      </div>
      <div class="detalhes-abas" id="detalhesAbas">
        <button type="button" class="aba-det ativa" data-aba="geral">Visão geral</button>
        <button type="button" class="aba-det" data-aba="info">Informações</button>
        <button type="button" class="aba-det" data-aba="videos">Vídeos</button>
      </div>
      <div class="painel-det" id="painelDetGeral"><p class="modal-sinopse-texto" id="detalhesSinopse"></p></div>
      <div class="painel-det" id="painelDetInfo" style="display:none;"></div>
      <div class="painel-det" id="painelDetVideos" style="display:none;"></div>

      <div class="secao-comentarios">
        <div class="secao-comentarios-cabecalho">
          <div class="secao-tit-bloco"><div class="secao-comentarios-titulo">Avaliações</div><div class="secao-comentarios-sub">Notas e opiniões de quem já assistiu</div></div>
          <button type="button" class="btn-ver-todas-coment" id="btnVerTodasComent" style="display:none">Ver todas ›</button>
        </div>
        <div class="comentarios-media" id="comentariosMedia" style="margin:-4px 0 10px;font-size:.78rem;color:var(--muted);"></div>
        <div style="display:none">
        </div>
        <div class="comentarios-aviso" id="comentariosAvisoDesligado" style="display:none;">
          Os comentários ainda não estão ligados neste site (falta configurar o Firebase no código).
        </div>
        <div class="comentario-login-bloco" id="comentarioLoginBloco" style="display:none;">
          <p>Para comentar e avaliar, inicia conta primeiro.</p>
          <button type="button" id="btnComentarIniciarConta">Iniciar conta</button>
        </div>
        <div class="comentario-form" id="comentarioFormBloco">
          <div class="comentario-estrelas-input" id="comentarioEstrelasInput">
            <span class="estrela-input" data-valor="1">★</span>
            <span class="estrela-input" data-valor="2">★</span>
            <span class="estrela-input" data-valor="3">★</span>
            <span class="estrela-input" data-valor="4">★</span>
            <span class="estrela-input" data-valor="5">★</span>
          </div>
          <textarea class="comentario-textarea" id="comentarioTextoInput" placeholder="Escreve o que achaste..." rows="2"></textarea>
          <button type="button" class="btn-enviar-comentario" id="btnEnviarComentario">Publicar comentário</button>
        </div>
        <div class="lista-comentarios" id="listaComentarios"></div>
      </div>
    </div>
  </div>
</div>

<!-- ===== Lista de episódios da temporada escolhida — mesma ideia visual do
     Histórico (ecrã cheio, cabeçalho fixo com título e botão de fechar).
     Cada linha mostra a miniatura, "EP SxE", a sinopse do episódio e um
     ícone de baixar (só visual por agora, ainda sem função). ===== -->
<div class="tela-episodios" id="telaEpisodios">
  <div class="tela-episodios-cabecalho">
    <span class="tela-episodios-titulo" id="episodiosTitulo"></span>
    <span class="tela-episodios-fechar" id="fecharTelaEpisodios" title="Fechar">✕</span>
  </div>
  <div class="tela-episodios-corpo" id="episodiosLista"></div>
</div>

<!-- ===== Modal de servidor — aparece depois de escolher "Assistir Agora"
     (filme) ou um episódio (série/anime/dorama), antes do leitor abrir.
     Por agora só há a SuperFlixAPI, por isso só existe "Servidor 1", mas já
     fica pronto para mais servidores no futuro. ===== -->
<div class="modal-servidor" id="modalServidor">
  <div class="modal-servidor-caixa">
    <div class="modal-servidor-cabecalho">
      <span id="servidorTitulo"></span>
      <span class="modal-servidor-fechar" id="fecharModalServidor" title="Fechar">✕</span>
    </div>
    <div class="modal-servidor-lista" id="modalServidorLista"></div>
  </div>
</div>


<!-- Lista de escolha (temporadas etc.) — visual do picker nativo, tema do site -->
<div class="modal-lista-escolha" id="modalListaEscolha">
  <div class="modal-lista-escolha-caixa">
    <div class="modal-lista-escolha-cabecalho">
      <span class="modal-lista-escolha-titulo" id="modalListaEscolhaTitulo">Escolher</span>
      <button type="button" class="modal-lista-escolha-fechar" id="fecharModalListaEscolha" title="Fechar">✕</button>
    </div>
    <div class="modal-lista-escolha-opcoes" id="modalListaEscolhaOpcoes"></div>
  </div>
</div>

<!-- Baixar: Como baixar / Baixar → configurar o 1DM → vídeo do passo-a-passo -->
<div class="modal-como-baixar" id="modalComoBaixar">
  <div class="mcb-caixa">
    <div id="mcbEscolha">
      <h3>Baixar episódio</h3>
      <p class="mcb-txt">Se ainda não sabes baixar no 1DM, vê primeiro o passo-a-passo.</p>
      <div class="mcb-botoes">
        <button type="button" id="mcbComo">Como baixar</button>
        <button type="button" class="mcb-principal" id="mcbBaixar">Baixar</button>
      </div>
    </div>
    <div id="mcbConfig" style="display:none">
      <div class="mcb-topo"><span class="mcb-aviso">Isto não é um anúncio</span><button type="button" class="mcb-x" id="mcbConfigX" aria-label="Fechar">✕</button></div>
      <p class="mcb-txt"><b>Caro usuário,</b> antes de baixar, primeiro configure o 1DM. Escolha um local de armazenamento.</p>
      <img id="mcbImgArmaz" alt="Escolher o local de armazenamento no 1DM" style="display:none">
    </div>
    <div id="mcbVideoTela" style="display:none">
      <div class="mcb-topo"><b>Como baixar</b><button type="button" class="mcb-x" id="mcbVideoX" aria-label="Fechar">✕</button></div>
      <video id="mcbVideo" controls controlslist="nodownload" playsinline preload="metadata" style="display:none"></video>
      <div class="mcb-vel" id="mcbVel" style="display:none"><button type="button" id="mcbVelBtn" aria-label="Velocidade">Velocidade: 1×</button></div>
      <img id="mcbGif" alt="Passo-a-passo para baixar" style="display:none">
      <p class="mcb-txt" style="text-align:right;margin:0"><a href="#" id="mcbVerEscrita" style="color:var(--accent)">ver versão escrita</a></p>
      <ol class="mcb-txt">
        <li>O 1DM abre a página do vídeo.</li>
        <li>Espera o Cloudflare confirmar (fica verde).</li>
        <li>Escolhe o servidor e toca em ▶ — o 1DM captura o vídeo.</li>
        <li>Toca no botão de baixar do 1DM.</li>
      </ol>
    </div>
  </div>
</div>

<div class="overlay" id="overlay">
  <div class="player-box">
    <div class="player-head">
      <h3 id="playerTitle"></h3>
      <button class="btn-sem-legenda" id="btnSemLegenda" style="display:none" title="Servidores em inglês">🌐 <span>Em inglês</span></button>
      <button id="closePlayer">✕</button>
    </div>
    <div class="menu-sem-legenda" id="menuSemLegenda" style="display:none"></div>
    <button id="btnVoltarServidor" class="btn-voltar-servidor" style="display:none" title="Voltar">←</button>
    <div class="player-frame-wrap">
      <iframe id="playerFrame" src="" allow="autoplay *; encrypted-media *; picture-in-picture *; fullscreen *" allowfullscreen></iframe>
      <div class="mascara-voltar-embed" aria-hidden="true"><i></i></div>
    </div>
    <div class="player-servidores" id="playerServidores" style="display:none"></div>
    <div class="player-painel-inferior">
      <div class="player-info" id="playerInfo">
        <div class="player-info-linha">
          <span class="player-tipo" id="playerTipo"></span>
          <span class="player-genero" id="playerGenero"></span>
          <button class="btn-toggle-sinopse" id="btnToggleSinopse" title="Mostrar sinopse">👁 Sinopse</button>
        </div>
        <p class="player-sinopse" id="playerSinopse"></p>
      </div>
      <div class="ep-controls" id="epControls" style="display:none;">
        <label>Temporada <select id="seasonSelect"></select></label>
        <label>Episódio <select id="episodeSelect"></select></label>
        <button class="btn-proximo-episodio" id="btnProximoEpisodio" title="Ir para o próximo episódio">Próximo ▶</button>
      </div>
    </div>
  </div>
</div>

<!-- Firebase (comentários/estrelas por título + feed de avisos/perguntas/enquetes, em tempo real) -->
<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-database-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.2/firebase-auth-compat.js"></script>
<script>
/* ============ CONFIGURAÇÃO ============ */
// Várias chaves TMDB: se uma falhar (429, chave inválida, etc.), usa a seguinte.
const TMDB_API_KEYS = [
  "1acb1965653f5c352ae66fdab15f5a09",
  "2eb588cabfd607f4abfa001a72e65fcb"
];
let tmdbKeyIndex = 0; // chave ativa no momento (só fallback se o PHP falhar)
// Cache no servidor (InfinityFree) — 1 pedido à TMDB serve todos os visitantes
const TMDB_CACHE_PHP = "tmdb-cache.php";

/* ============ CACHE PERSISTENTE (TMDB + SuperFlixAPI) ============
   Guarda respostas em memória (rápido nesta sessão) e no localStorage
   (sobrevive a recarregar a página). Assim o mesmo título/pesquisa/lista
   não volta a pedir à API enquanto o TTL não expirar — reduz drasticamente
   o número de pedidos e ajuda a aguentar muito mais utilizadores.

   TTLs (quanto tempo cada tipo fica válido):
   - detalhes de título: 7 dias (quase não mudam)
   - temporadas/episódios: 3 dias
   - pesquisas por nome: 12 horas
   - listas SuperFlixAPI: 6 horas
*/
const CACHE_PREFIX = "cine_api_cache_v1_";
/* Limite realista para InfinityFree + telemóveis (~1,8 MB).
   Estratégia: "rede primeiro" no que muda (episódios, listas, séries).
   O utilizador entra → o site pede dados frescos → mostra o novo EP na hora.
   O cache serve de reserva se a API falhar e para acelerar pedidos repetidos. */
const CACHE_TTL_MS = {
  details: 7 * 24 * 60 * 60 * 1000,
  season:  30 * 60 * 1000,        // 30 min (só backup; episódios vão sempre à rede)
  search:  6 * 60 * 60 * 1000,
  lista:   15 * 60 * 1000,        // 15 min backup; listas também vão à rede ao abrir
  default: 12 * 60 * 60 * 1000
};
const CACHE_MEMORIA = new Map();
const CACHE_MAX_LOCALSTORAGE_CHARS = 1.8 * 1024 * 1024;
// Evita vários pedidos iguais em paralelo enquanto um já está a caminho
const CACHE_PEDIDOS_EM_CURSO = new Map();

function cacheTipoDoPath(path){
  if(!path) return "default";
  if(path.includes("/search/")) return "search";
  if(/\/tv\/\d+\/season\//.test(path)) return "season";
  if(/^\/(movie|tv)\/\d+/.test(path)) return "details";
  return "default";
}

/** Lê entrada completa { dados, expira } — mesmo que já tenha expirado (para fallback). */
function cacheLerEntrada(chave){
  if(CACHE_MEMORIA.has(chave)){
    return CACHE_MEMORIA.get(chave);
  }
  try{
    const bruto = localStorage.getItem(CACHE_PREFIX + chave);
    if(!bruto) return null;
    const entr = JSON.parse(bruto);
    if(!entr || typeof entr.expira !== "number") return null;
    CACHE_MEMORIA.set(chave, entr);
    return entr;
  }catch(e){
    return null;
  }
}

function cacheLer(chave){
  const entr = cacheLerEntrada(chave);
  if(!entr) return null;
  if(Date.now() >= entr.expira) return null; // só devolve se ainda fresco
  return entr.dados;
}

/** Devolve dados mesmo expirados (para mostrar algo se a rede falhar). */
function cacheLerQualquer(chave){
  const entr = cacheLerEntrada(chave);
  return entr ? entr.dados : null;
}

function cacheEstaFresco(chave){
  const entr = cacheLerEntrada(chave);
  return !!(entr && Date.now() < entr.expira);
}

function cacheEscrever(chave, dados, tipo){
  const ttl = CACHE_TTL_MS[tipo] || CACHE_TTL_MS.default;
  const entr = { expira: Date.now() + ttl, dados };
  CACHE_MEMORIA.set(chave, entr);
  try{
    const serializado = JSON.stringify(entr);
    try{
      localStorage.setItem(CACHE_PREFIX + chave, serializado);
    }catch(e){
      cacheLimparAntigas();
      try{ localStorage.setItem(CACHE_PREFIX + chave, serializado); }catch(e2){}
    }
  }catch(e){}
}

function cacheLimparAntigas(){
  try{
    const agora = Date.now();
    const chaves = [];
    for(let i = 0; i < localStorage.length; i++){
      const k = localStorage.key(i);
      if(k && k.startsWith(CACHE_PREFIX)) chaves.push(k);
    }
    for(const k of chaves){
      try{
        const entr = JSON.parse(localStorage.getItem(k));
        if(!entr || agora >= entr.expira) localStorage.removeItem(k);
      }catch(e){ localStorage.removeItem(k); }
    }
    let total = 0;
    const restantes = [];
    for(let i = 0; i < localStorage.length; i++){
      const k = localStorage.key(i);
      if(k && k.startsWith(CACHE_PREFIX)){
        const v = localStorage.getItem(k) || "";
        total += v.length;
        try{
          const entr = JSON.parse(v);
          restantes.push({ k, expira: entr.expira || 0, len: v.length });
        }catch(e){ localStorage.removeItem(k); }
      }
    }
    if(total > CACHE_MAX_LOCALSTORAGE_CHARS){
      restantes.sort((a,b) => a.expira - b.expira);
      for(const item of restantes){
        if(total <= CACHE_MAX_LOCALSTORAGE_CHARS * 0.7) break;
        localStorage.removeItem(item.k);
        total -= item.len;
      }
    }
  }catch(e){}
}

// --- Firebase dos comentários/estrelas — MESMO projeto usado no site
// principal (index__38_.html), para os comentários serem os mesmos dos
// dois sites em vez de ficarem separados.
const firebaseConfigComentarios = {
  apiKey: "AIzaSyBZHTkEHdj9z3Du5inOFvMH4Y-vjMM72P4",
  authDomain: "comentarios-54d87.firebaseapp.com",
  databaseURL: "https://comentarios-54d87-default-rtdb.firebaseio.com",
  projectId: "comentarios-54d87",
  storageBucket: "comentarios-54d87.firebasestorage.app",
  messagingSenderId: "936419999279",
  appId: "1:936419999279:web:751dcd4c94a52d2d1790da"
};
let firebaseAtivo = false;
try{
  if(firebaseConfigComentarios.databaseURL && firebaseConfigComentarios.apiKey){
    firebase.initializeApp(firebaseConfigComentarios, "comentarios");
    firebaseAtivo = true;
  }
}catch(erroFirebase){
  console.warn("Firebase dos comentários não pôde ser iniciado:", erroFirebase);
}
function dbComentarios(){ return firebase.app("comentarios").database(); }

// --- Firebase do Feed (avisos/perguntas/enquetes) — MESMO projeto do site
// principal, por isso o feed mostrado aqui é o mesmo publicado de lá.
const firebaseConfigFeed = {
  apiKey: "AIzaSyDBeLW3gMFPVU8CgvVrTcvfYvcZ_tAI5ZE",
  authDomain: "feed-app-fa204.firebaseapp.com",
  databaseURL: "https://feed-app-fa204-default-rtdb.firebaseio.com",
  projectId: "feed-app-fa204",
  storageBucket: "feed-app-fa204.firebasestorage.app",
  messagingSenderId: "490385185989",
  appId: "1:490385185989:web:87ef4324d59400488ae4ac"
};
let firebaseFeedAtivo = false;
try{
  if(firebaseConfigFeed.databaseURL && firebaseConfigFeed.apiKey){
    firebase.initializeApp(firebaseConfigFeed, "feed");
    firebaseFeedAtivo = true;
  }
}catch(erroFirebaseFeed){
  console.warn("Firebase do feed não pôde ser iniciado:", erroFirebaseFeed);
}
function dbFeed(){ return firebase.app("feed").database(); }

const SF_BASE = "https://superflixapi.monster";
// Servidores disponíveis para reproduzir — o modal de servidor mostra um
// botão por cada um destes (1, 2, 3... o que estiver aqui). Por agora só
// há a SuperFlixAPI; para adicionar outro servidor no futuro basta somar
// mais um objeto {nome, base} nesta lista.
const SERVIDORES = [
  { nome: "Servidor 1", grupo: "pt", ping: SF_BASE,
    filme: id => `${SF_BASE}/filme/${id}`,
    serie: (id,t,e,cat) => `${SF_BASE}/${cat === "dorama" ? "dorama" : "serie"}/${id}/${t}/${e}` },
  { nome: "VidSrc", grupo: "global", idioma: "Inglês · original (sem dublagem, sem legenda)", ping: "https://vidsrc.to",
    filme: id => `https://vidsrc.to/embed/movie/${id}`,
    serie: (id,t,e) => `https://vidsrc.to/embed/tv/${id}/${t}/${e}` },
  { nome: "2Embed", grupo: "global", idioma: "Inglês · original (sem dublagem, sem legenda)", ping: "https://www.2embed.cc",
    filme: id => `https://www.2embed.cc/embed/${id}`,
    serie: (id,t,e) => `https://www.2embed.cc/embedtv/${id}&s=${t}&e=${e}` }
];
// ORDEM = prioridade: se o 1 não responde, tenta o 2, depois o 3...
let servidorAtual = 0;
let barraPronta = false; // a lista só aparece depois do embed principal carregar (abrem juntos)
const _cacheServidor = {};
async function servidorResponde(idx){
  const c = _cacheServidor[idx];
  if(c && Date.now() - c.t < 120000) return c.ok;
  let ok = false;
  try{
    const ctrl = new AbortController();
    const tm = setTimeout(() => ctrl.abort(), 4500);
    await fetch(SERVIDORES[idx].ping, { mode: "no-cors", cache: "no-store", signal: ctrl.signal });
    clearTimeout(tm);
    ok = true;
  }catch(e){ ok = false; }
  _cacheServidor[idx] = { ok, t: Date.now() };
  return ok;
}
async function primeiroServidorDisponivel(){
  for(let i = 0; i < SERVIDORES.length; i++){
    if(await servidorResponde(i)) return i;
  }
  return 0;
}
// proxy.php (no teu próprio servidor) evita CORS por completo — é tentado primeiro
const OWN_PROXY = "proxy.php?url=";
// proxies públicos de terceiros, só como reserva caso o proxy.php não esteja disponível
const CORS_PROXIES = [
  url => "https://api.allorigins.win/raw?url=" + encodeURIComponent(url),
  url => "https://corsproxy.io/?url=" + encodeURIComponent(url),
  url => "https://thingproxy.freeboard.io/fetch/" + url
];

/* para pedidos à SuperFlixAPI: tenta o proxy próprio, depois pedido direto, depois proxies públicos.
   Listas (/lista) passam pelo cache persistente (TTL 6h) para não voltar a
   pedir a mesma página à SuperFlixAPI em cada visita. */
async function fetchJSON(url){
  const ehLista = typeof url === "string" && url.indexOf("/lista") !== -1;
  const chaveCache = ehLista ? ("sf:" + url) : null;

  // Listas: rede primeiro (título/EP novo entra na hora). Cache só se a rede falhar.
  // Outros pedidos SuperFlix: igual — tenta rede, cache como reserva.

  let lastErr;
  let dados = null;

  try{
    const r = await fetch(OWN_PROXY + encodeURIComponent(url));
    if(!r.ok) throw new Error("status " + r.status);
    dados = await r.json();
  }catch(e){ lastErr = e; }

  if(dados === null){
    try{
      const r = await fetch(url);
      if(!r.ok) throw new Error("status " + r.status);
      dados = await r.json();
    }catch(e){ lastErr = e; }
  }

  if(dados === null){
    for(const makeUrl of CORS_PROXIES){
      try{
        const r = await fetch(makeUrl(url));
        if(!r.ok) throw new Error("status " + r.status);
        dados = await r.json();
        break;
      }catch(e){ lastErr = e; }
    }
  }

  if(dados !== null){
    if(chaveCache) cacheEscrever(chaveCache, dados, "lista");
    return dados;
  }

  // Rede falhou → usa cache (mesmo antigo) para não partir o catálogo
  if(chaveCache){
    const antigo = cacheLerQualquer(chaveCache);
    if(antigo !== null && antigo !== undefined) return antigo;
  }
  throw lastErr;
}

// NOVO: a indexação da pesquisa (4 categorias em paralelo) + a grelha normal
// do catálogo podiam somar dezenas de pedidos à TMDB ao mesmo tempo — a
// TMDB começa a REJEITAR pedidos a meio (erro 429, "muitos pedidos") quando
// isso acontece, e esses títulos ficavam de fora do índice para sempre, sem
// aviso nenhum (por isso a busca "encontrava alguns e não outros"). Esta
// fila limita quantos pedidos à TMDB andam em curso ao mesmo tempo, NO
// SITE TODO (grelha + pesquisa), para nunca passar desse limite.
const LIMITE_PEDIDOS_SIMULTANEOS_TMDB = 6;
let pedidosTmdbEmAndamento = 0;
const filaEsperaTmdb = [];

function agendarPedidoTmdb(tarefa){
  return new Promise((resolve, reject) => {
    filaEsperaTmdb.push({ tarefa, resolve, reject });
    processarFilaTmdb();
  });
}

function processarFilaTmdb(){
  while(pedidosTmdbEmAndamento < LIMITE_PEDIDOS_SIMULTANEOS_TMDB && filaEsperaTmdb.length){
    const proximo = filaEsperaTmdb.shift();
    pedidosTmdbEmAndamento++;
    proximo.tarefa()
      .then(proximo.resolve, proximo.reject)
      .finally(() => { pedidosTmdbEmAndamento--; processarFilaTmdb(); });
  }
}

// NOVO: se a TMDB responder 429 (limite de pedidos atingido), espera um
// pouco e tenta de novo (até 3 vezes) em vez de desistir do título na
// hora — é isso que fazia alguns títulos nunca aparecerem na busca.
// Se a chave atual falhar de forma "definitiva" (401/403) ou esgotar as
// retentativas de 429, troca para a próxima chave da lista TMDB_API_KEYS.
async function tmdbFetchViaServidor(path, forcarRefresh){
  try{
    let qs = "path=" + encodeURIComponent(path);
    if(forcarRefresh) qs += "&refresh=1";
    const r = await fetch(TMDB_CACHE_PHP + "?" + qs);
    if(r.ok){
      try{ return await r.json(); }catch(e){}
    }
  }catch(e){}
  // PHP indisponível → fallback com a lógica antiga
  return tmdbFetchComRetentativa(path, 0, 0, true);
}

// 1º tmdb-cache.php (cache no servidor + chaves escondidas).
// Se o PHP não existir (abrir o HTML em ficheiro local), cai para a TMDB direta.
async function tmdbFetchComRetentativa(path, tentativa = 0, chaveTentada = 0, jaTentouPhp = false){
  // --- Via cache PHP no InfinityFree ---
  if(!jaTentouPhp){
    try{
      const qs = "path=" + encodeURIComponent(path);
      const r = await fetch(TMDB_CACHE_PHP + "?" + qs);
      if(r.ok){
        try{ return await r.json(); }catch(e){}
      }
      // 502/404 do PHP → tenta TMDB direta em baixo
    }catch(e){
      // offline ou ficheiro local sem PHP
    }
  }

  // --- Fallback: TMDB direta (desenvolvimento / se o PHP falhar) ---
  const key = TMDB_API_KEYS[tmdbKeyIndex];
  const url = `https://api.themoviedb.org/3${path}${path.includes("?")?"&":"?"}api_key=${key}&language=pt-BR`;
  let r;
  try{ r = await fetch(url); }catch(e){ return null; }

  if((r.status === 401 || r.status === 403) && chaveTentada < TMDB_API_KEYS.length - 1){
    tmdbKeyIndex = (tmdbKeyIndex + 1) % TMDB_API_KEYS.length;
    return tmdbFetchComRetentativa(path, 0, chaveTentada + 1, true);
  }

  if(r.status === 429){
    if(tentativa < 3){
      await new Promise(resolver => setTimeout(resolver, 500 * (tentativa + 1)));
      return tmdbFetchComRetentativa(path, tentativa + 1, chaveTentada, true);
    }
    if(chaveTentada < TMDB_API_KEYS.length - 1){
      tmdbKeyIndex = (tmdbKeyIndex + 1) % TMDB_API_KEYS.length;
      return tmdbFetchComRetentativa(path, 0, chaveTentada + 1, true);
    }
    return null;
  }

  if(!r.ok) return null;
  try{ return await r.json(); }catch(e){ return null; }
}

/* Rede primeiro no que importa (episódios / dados de série).
   - season: vai SEMPRE à TMDB → EP novo aparece na hora.
   - resto: se o cache ainda é fresco, usa-o (poupa a API); senão vai à rede.
   - se a rede falhar, usa o último cache (mesmo antigo) para não ficar em branco. */
async function tmdb(path, opcoes){
  const opts = opcoes || {};
  const chave = "tmdb:" + path;
  const tipo = cacheTipoDoPath(path);
  // Episódios e pedidos forçados: sempre rede. Filmes/pesquisas frescas: cache ok.
  const redePrimeiro = opts.redePrimeiro === true || tipo === "season" || opts.forcar === true;

  if(!redePrimeiro && cacheEstaFresco(chave)){
    return cacheLer(chave);
  }

  // Evita 10 pedidos iguais ao mesmo tempo para o mesmo path
  if(CACHE_PEDIDOS_EM_CURSO.has(chave)){
    return CACHE_PEDIDOS_EM_CURSO.get(chave);
  }

  const promessa = (async () => {
    try{
      // redePrimeiro (episódios): pede ao PHP com refresh=1 para ignorar cache do servidor
      const dados = await agendarPedidoTmdb(() => tmdbFetchViaServidor(path, redePrimeiro));
      if(dados !== null && dados !== undefined){
        cacheEscrever(chave, dados, tipo);
        return dados;
      }
    }catch(e){}
    return cacheLerQualquer(chave);
  })();

  CACHE_PEDIDOS_EM_CURSO.set(chave, promessa);
  try{
    return await promessa;
  }finally{
    CACHE_PEDIDOS_EM_CURSO.delete(chave);
  }
}

// NOVO: API de PESQUISA da TMDB (/search/movie e /search/tv) - responsável só
// por achar candidatos pelo nome digitado. A de detalhes (tmdb(), acima)
// continua responsável por "outra coisa": trazer capa/sinopse/género de um
// título já escolhido. Junta-se à SuperFlixAPI (que diz quais IDs o site
// realmente tem disponíveis) em runSearch(), mais abaixo.
async function tmdbSearch(query){
  const [filmes, series] = await Promise.all([
    tmdb(`/search/movie?query=${encodeURIComponent(query)}&include_adult=false`),
    tmdb(`/search/tv?query=${encodeURIComponent(query)}&include_adult=false`)
  ]);
  return {
    movie: (filmes && Array.isArray(filmes.results)) ? filmes.results : [],
    tv: (series && Array.isArray(series.results)) ? series.results : []
  };
}

const POSTER = id => `https://image.tmdb.org/t/p/w300${id}`;

/* categoria SuperFlixAPI -> tipo TMDB */
const TMDB_KIND = { filme:"movie", serie:"tv", anime:"tv", dorama:"tv" };

const PAGE_SIZE = 12; // cada clique em "Próximo" mostra mais 12 cards (3 colunas x 4 linhas no celular)
// Busca os detalhes na TMDB em pequenos grupos paralelos, com uma pausa
// curta entre grupos, em vez de tudo de uma vez — pedir demais ao mesmo
// tempo faz a TMDB começar a recusar pedidos a meio, e a página simplesmente
// para de carregar (mesma lógica usada no Webplay).
const TAMANHO_GRUPO_TMDB = 5;
const PAUSA_ENTRE_GRUPOS_TMDB = 300;
const catalogState = {}; // cat -> { allIds: [], currentPage: 0 }

/* Busca TODAS as páginas do /lista da SuperFlixAPI para uma categoria, não só a
   primeira. A API pagina o resultado (por isso aparecia "página 3 de 3" mas o
   site só usava a página 1). Aqui vamos passando &page=1,2,3... e juntando tudo
   num único array, até a API indicar que não há mais páginas — ou, se ela não
   mandar essa informação, até uma página vir repetida/vazia. */
async function fetchAllIdsForCategory(cat){
  const idsAcumulados = [];
  const vistos = new Set();
  let pagina = 1;
  const LIMITE_SEGURANCA_PAGINAS = 50; // trava de segurança, evita loop infinito
  let assinaturaPaginaAnterior = null;

  while(pagina <= LIMITE_SEGURANCA_PAGINAS){
    let resposta;
    try{
      // order=desc garante que os mais recentes vêm primeiro — usado tanto
      // pela grelha completa da aba como pela prévia "Últimos lançamentos"
      // do Início (que só usa os primeiros itens deste array).
      resposta = await fetchJSON(`${SF_BASE}/lista?category=${cat}&type=tmdb&format=json&order=desc&page=${pagina}`);
    }catch(e){
      break; // fica com o que já conseguiu buscar até aqui
    }

    const lote = Array.isArray(resposta) ? resposta : (resposta.results || resposta.data || resposta.items || []);
    if(!lote.length) break;

    // deteta se a API está a ignorar o "page" e a devolver sempre o mesmo conteúdo
    const assinaturaLote = lote.length + "|" + JSON.stringify(lote[0]);
    if(assinaturaLote === assinaturaPaginaAnterior) break;
    assinaturaPaginaAnterior = assinaturaLote;

    let novosNesteLote = 0;
    for(const item of lote){
      const chave = typeof item === "object" ? (item.id ?? item.tmdb_id) : item;
      if(chave == null || vistos.has(chave)) continue;
      vistos.add(chave);
      idsAcumulados.push(item);
      novosNesteLote++;
    }

    const totalPaginas = !Array.isArray(resposta)
      ? (resposta.total_pages || resposta.totalPages || resposta.pages)
      : null;

    if(totalPaginas && pagina >= totalPaginas) break;
    if(!totalPaginas && novosNesteLote === 0) break;

    pagina++;
  }

  return idsAcumulados;
}

// Cache partilhada dos detalhes de cada título (por categoria+ID), para nunca
// pedir o mesmo título duas vezes ao TMDB — tanto a grelha normal (por
// página) como o índice de pesquisa em segundo plano (mais abaixo) usam
// esta mesma cache, por isso um "ajuda" o outro a ficar pronto mais rápido.
const tmdbDetailsCache = new Map();
// NOVO: guarda os "Últimos lançamentos" já buscados de cada categoria, pra
// a faixa "Últimos Episódios" da Início poder juntar série+anime+dorama e
// ordenar por data de exibição, sem pedir tudo de novo à TMDB.
const ultimosLancamentosPorCategoria = {};

// Nome de exibição de cada categoria (usado no topo do leitor, junto da
// sinopse/género) — Filme/Série/Anime/Dorama.
const TIPO_LABEL = { filme:"Filme", serie:"Série", anime:"Anime", dorama:"Dorama" };

async function tmdbDetailsFor(cat, item, opcoes){
  const opts = opcoes || {};
  const tmdbId = typeof item === "object" ? (item.id || item.tmdb_id) : item;
  if(!tmdbId) return null;

  const chaveCache = cat + ":" + tmdbId;
  // forcar=true só quando o utilizador abre detalhes/episódios — a grelha
  // continua a usar cache para não disparar centenas de pedidos de uma vez.
  const forcarRede = opts.forcar === true;

  if(!forcarRede && tmdbDetailsCache.has(chaveCache)) return tmdbDetailsCache.get(chaveCache);

  const chavePersist = "det2:" + chaveCache;
  if(!forcarRede){
    const cachedDet = cacheLer(chavePersist);
    if(cachedDet !== null && cachedDet !== undefined){
      tmdbDetailsCache.set(chaveCache, cachedDet);
      return cachedDet;
    }
  }

  const kind = TMDB_KIND[cat];
  const details = await tmdb(`/${kind}/${tmdbId}`, { redePrimeiro: forcarRede });
  if(!details || (!details.poster_path && !details.title && !details.name)){
    tmdbDetailsCache.set(chaveCache, null);
    cacheEscrever(chavePersist, null, "details");
    return null;
  }
  const resultado = {
    tmdbId, cat,
    title: details.title || details.name || "Sem título",
    // NOVO: título original — muitos animes/séries são conhecidos por um
    // nome diferente do título em pt-BR (ex: "Kimetsu no Yaiba" vs. "Demon
    // Slayer"), e sem isto a busca não encontrava quem pesquisasse pelo
    // nome que realmente conhece.
    tituloOriginal: details.original_title || details.original_name || "",
    year: (details.release_date || details.first_air_date || "").slice(0,4),
    dataLancamento: details.release_date || "", // usado pelo Cronograma (filmes)
    // próximo episódio a sair (só séries/animes/doramas) — usado pelo Cronograma
    proximoEpisodio: details.next_episode_to_air ? {
      temporada: details.next_episode_to_air.season_number,
      episodio: details.next_episode_to_air.episode_number,
      dataExibicao: details.next_episode_to_air.air_date || "",
      nome: details.next_episode_to_air.name || ""
    } : null,
    poster: details.poster_path ? POSTER(details.poster_path) : null,
    seasons: details.number_of_seasons || null,
    // NOVO: género(s), sinopse e o tipo (Filme/Série/Anime/Dorama) — usados
    // no topo do leitor, ao abrir um título.
    genre: (details.genres || []).map(g => g.name).join(", "),
    overview: details.overview || "",
    tipoLabel: TIPO_LABEL[cat] || cat,
    // NOVO: nota da TMDB (0 a 10) — usada nas estrelas e no número do
    // "Mais Acessados".
    nota: typeof details.vote_average === "number" ? details.vote_average : 0,
    // NOVO: último episódio lançado (só existe em séries/animes/doramas —
    // a própria TMDB já devolve isto junto dos detalhes, sem pedido extra).
    // Usado pela faixa "Últimos Episódios" na Início.
    ultimoEpisodio: details.last_episode_to_air ? {
      temporada: details.last_episode_to_air.season_number,
      episodio: details.last_episode_to_air.episode_number,
      dataExibicao: details.last_episode_to_air.air_date || "",
      nome: details.last_episode_to_air.name || "",
      still: details.last_episode_to_air.still_path ? POSTER(details.last_episode_to_air.still_path) : null
    } : null
  };
  tmdbDetailsCache.set(chaveCache, resultado);
  cacheEscrever(chavePersist, resultado, "details");
  return resultado;
}

/* Executa "tarefa" para cada item de "lista", em lotes paralelos de
   "tamanhoLote" (em vez de 1 de cada vez, ou todos de uma vez), com uma
   pausa opcional entre lotes — para não demorar demais nem sobrecarregar
   o TMDB. Devolve os resultados (na mesma ordem de "lista"), já sem os
   que falharam. */
async function executarEmLotes(lista, tamanhoLote, tarefa, pausaMs = 0){
  const resultados = [];
  for(let i = 0; i < lista.length; i += tamanhoLote){
    const lote = lista.slice(i, i + tamanhoLote);
    const parciais = await Promise.all(lote.map(item => tarefa(item).catch(() => null)));
    resultados.push(...parciais);
    if(pausaMs && i + tamanhoLote < lista.length){
      await new Promise(resolver => setTimeout(resolver, pausaMs));
    }
  }
  return resultados;
}

/* ============ DISPONIBILIDADE POR CATEGORIA (SuperFlixAPI) ============
   A pesquisa (mais abaixo) usa a API de busca da TMDB para achar candidatos
   pelo nome, mas nem tudo que a TMDB conhece está disponível para assistir
   no site — só o que a SuperFlixAPI já listou (fetchAllIdsForCategory, em
   loadCategory()). catalogIdsProntos guarda, por categoria, um Set com os
   IDs TMDB que a SuperFlixAPI confirmou existir — a pesquisa cruza os dois
   pra só mostrar títulos realmente disponíveis. */
const catalogIdsProntos = {}; // cat -> Promise<Set<number>>, resolvida quando fetchAllIdsForCategory termina

async function loadCategory(cat){
  const track = document.getElementById("track-" + cat);
  const pag = document.getElementById("pag-" + cat);
  let resolverIdsProntos;
  catalogIdsProntos[cat] = new Promise(res => resolverIdsProntos = res);
  try{
    const allIds = await fetchAllIdsForCategory(cat);
    // NOVO: guarda os IDs desta categoria, prontos para a pesquisa cruzar
    // com o que a TMDB devolver (ver runSearch). Guarda cada ID em 3 formas
    // (valor original, Number e String) porque a SuperFlixAPI às vezes
    // devolve os IDs como texto ("1396") enquanto a TMDB devolve sempre como
    // número (1396) — Set.has() compara tipo e valor, então sem isto a
    // pesquisa falhava silenciosamente para TUDO, mesmo com o título disponível.
    const idsDisponiveisSet = new Set();
    allIds.forEach(item => {
      const bruto = typeof item === "object" ? (item.id ?? item.tmdb_id) : item;
      if(bruto == null) return;
      idsDisponiveisSet.add(bruto);
      idsDisponiveisSet.add(Number(bruto));
      idsDisponiveisSet.add(String(bruto));
    });
    resolverIdsProntos(idsDisponiveisSet);
    if(!allIds.length){ track.innerHTML = '<p class="empty">Sem itens disponíveis de momento.</p>'; return; }
    catalogState[cat] = { allIds, currentPage: 0 };

    if(pag){
      pag.style.display = "flex";
      pag.querySelectorAll(".nav-btn").forEach(btn=>{
        btn.addEventListener("click", () => navigatePage(cat, parseInt(btn.dataset.dir, 10)));
      });
    }

    // Prévia da aba Início — usa os primeiros itens (a API devolve por
    // ordem de lançamento mais recente primeiro), sem pedir nada à parte.
    renderRecentes(cat, allIds);

    await renderPage(cat);
  }catch(e){
    resolverIdsProntos(new Set()); // NOVO: mesmo falhando, libera quem está à espera (pesquisa) em vez de travar pra sempre
    console.error("Erro em " + cat + ":", e);
    track.innerHTML = `<p class="empty">Não foi possível carregar esta secção agora.<br><small>${(e && e.message) || e}</small></p>`;
    const recenteTrack = document.getElementById("recente-" + cat);
    if(recenteTrack) recenteTrack.innerHTML = `<p class="empty">Não foi possível carregar agora.</p>`;
  }
}

const QTD_RECENTES = 12;

/* Preenche a linha "Últimos lançamentos" da página Início para uma
   categoria, a partir dos primeiros IDs já buscados (mais recentes). */
async function renderRecentes(cat, allIds){
  const recenteTrack = document.getElementById("recente-" + cat);
  if(!recenteTrack) return;

  const lote = allIds.slice(0, QTD_RECENTES);
  const results = await executarEmLotes(lote, TAMANHO_GRUPO_TMDB, item => tmdbDetailsFor(cat, item), PAUSA_ENTRE_GRUPOS_TMDB);
  const validos = results.filter(Boolean);
  ultimosLancamentosPorCategoria[cat] = validos; // NOVO: guarda pra faixa "Últimos Episódios"

  recenteTrack.innerHTML = "";
  if(!validos.length){ recenteTrack.innerHTML = '<p class="empty">Sem lançamentos recentes de momento.</p>'; return; }
  validos.forEach(d => recenteTrack.appendChild(buildCard(d)));
}

/* ============ ÚLTIMOS EPISÓDIOS (faixa na Início) — junta série+anime+
   dorama já carregados acima, ordena pelo episódio mais recente já EXIBIDO
   (last_episode_to_air, vindo direto da TMDB) e mostra o still do episódio
   com a etiqueta "EP SxE" em vez do selo de tipo normal. ============ */
function buildCardEpisodio(d){
  const el = document.createElement("div");
  el.className = "card card-episodio-largo";
  const ep = d.ultimoEpisodio;
  // Still 16:9 no card grande de Últimos Episódios
  const imagem = (ep && ep.still) ? ep.still : (d.poster || "");
  const tag = ep ? `EP ${ep.temporada}x${String(ep.episodio).padStart(2,"0")}` : "";
  const tipo = d.tipoLabel || TIPO_LABEL[d.cat] || "";
  el.innerHTML = `
    <img class="poster" loading="lazy" src="${imagem || ''}" alt="${d.title}" onerror="this.style.opacity=0">
    ${tag ? `<span class="card-tipo-badge">${tag}</span>` : ""}
    <div class="meta">
      <div class="t">${d.title}</div>
      <div class="y">${tag ? tag + (tipo ? " · " + tipo : "") : tipo}</div>
    </div>`;
  el.addEventListener("click", () => {
    registrarCliqueHistorico(d);
    montarContinuarAssistindo();
    if(ep && ep.temporada && ep.episodio){
      // Vai direto ao episódio (sem passar pelo ecrã de detalhes)
      abrirModalServidor(d, ep.temporada, ep.episodio);
    } else {
      abrirDetalhes(d);
    }
  });
  return el;
}
const popularidadeEpisodios = {}; // "cat:id" -> popularidade TMDB (desempate na faixa Últimos Episódios)
let extraUltimosEpisodios = [];   // títulos famosos / assistidos, achados em segundo plano
function chaveTitulo(d){ return d.cat + ":" + d.tmdbId; }
function titulosAssistidos(){
  const set = new Set();
  obterHistoricoCliques().forEach(h => { if(h && h.cat && h.cat !== "filme" && h.tmdbId) set.add(h.cat + ":" + h.tmdbId); });
  return set;
}
function montarUltimosEpisodios(){
  const linha = document.getElementById("linha-ultimos-episodios");
  const track = document.getElementById("ultimos-episodios-track");
  if(!linha || !track) return;
  const hoje = new Date().toISOString().slice(0,10);
  const base = ["serie","anime","dorama"].flatMap(cat => ultimosLancamentosPorCategoria[cat] || []);
  const mapa = new Map();
  base.concat(extraUltimosEpisodios).forEach(d => { if(d) mapa.set(chaveTitulo(d), d); });
  const assistidos = titulosAssistidos();
  const comEpisodio = [...mapa.values()]
    .filter(d => d.ultimoEpisodio && d.ultimoEpisodio.dataExibicao && d.ultimoEpisodio.dataExibicao <= hoje)
    .sort((a,b) => {
      // 1º o que a pessoa já assistiu, depois o episódio mais recente, depois o mais famoso
      const wa = assistidos.has(chaveTitulo(a)), wb = assistidos.has(chaveTitulo(b));
      if(wa !== wb) return wa ? -1 : 1;
      const c = b.ultimoEpisodio.dataExibicao.localeCompare(a.ultimoEpisodio.dataExibicao);
      if(c) return c;
      return (popularidadeEpisodios[chaveTitulo(b)] || 0) - (popularidadeEpisodios[chaveTitulo(a)] || 0);
    })
    .slice(0, 30);
  if(!comEpisodio.length){ linha.style.display = "none"; return; }
  linha.style.display = "";
  track.innerHTML = "";
  comEpisodio.forEach(d => track.appendChild(buildCardEpisodio(d)));
}

/* Em segundo plano: junta à faixa os títulos FAMOSOS que lançaram episódio nos últimos
   dias (TMDB por popularidade ∩ catálogo da SuperFlix) e os que a pessoa JÁ ASSISTIU,
   mesmo que não sejam títulos novos no site. */
async function ampliarUltimosEpisodios(){
  try{
    const cats = ["serie","anime","dorama"];
    const sets = await Promise.all(cats.map(c => catalogIdsProntos[c] || Promise.resolve(new Set())));
    const ids = {}; cats.forEach((c,i) => ids[c] = sets[i]);
    const dia = 86400000, h = new Date(); h.setHours(0,0,0,0);
    const ate = cronIso(h.getTime()), de = cronIso(h.getTime() - 14*dia);

    const paginas = [1,2,3,4,5].map(n => `/discover/tv?sort_by=popularity.desc&air_date.gte=${de}&air_date.lte=${ate}&page=${n}`);
    const respostas = await executarEmLotes(paginas, 3, caminho => tmdb(caminho), 200);

    const candidatos = [], vistos = new Set();
    respostas.forEach(r => {
      if(!r || !Array.isArray(r.results)) return;
      r.results.forEach(it => {
        const cat = it && cats.find(c => ids[c].has(it.id));
        if(!cat) return;
        const k = cat + ":" + it.id;
        if(vistos.has(k)) return;
        vistos.add(k);
        popularidadeEpisodios[k] = it.popularity || 0;
        candidatos.push({ cat, id: it.id, forcar:false });
      });
    });
    const famosos = candidatos.slice(0, 30);

    // o que a pessoa assiste: pedido fresco, para apanhar o episódio novo logo que sai
    const assistidos = obterHistoricoCliques()
      .filter(x => x && x.cat && x.cat !== "filme" && x.tmdbId)
      .slice(0, 10).map(x => ({ cat: x.cat, id: x.tmdbId, forcar:true }));

    const todos = [], jaTem = new Set();
    assistidos.concat(famosos).forEach(c => { const k = c.cat + ":" + c.id; if(!jaTem.has(k)){ jaTem.add(k); todos.push(c); } });

    const limite = cronIso(h.getTime() - 21*dia);
    const novos = [];
    for(let k = 0; k < todos.length; k += 10){
      const parte = todos.slice(k, k + 10);
      const dets = (await executarEmLotes(parte, TAMANHO_GRUPO_TMDB, c => tmdbDetailsFor(c.cat, c.id, { forcar: c.forcar }), PAUSA_ENTRE_GRUPOS_TMDB)).filter(Boolean);
      dets.forEach(d => { if(d.ultimoEpisodio && d.ultimoEpisodio.dataExibicao >= limite) novos.push(d); });
      extraUltimosEpisodios = novos.slice();
      montarUltimosEpisodios();
    }
  }catch(e){ console.warn("Últimos Episódios (ampliação):", e); }
}

async function renderPage(cat){
  const track = document.getElementById("track-" + cat);
  const pag = document.getElementById("pag-" + cat);
  const state = catalogState[cat];
  const totalPaginas = Math.max(1, Math.ceil(state.allIds.length / PAGE_SIZE));

  track.innerHTML = '<p class="loading">A carregar…</p>';
  const inicio = state.currentPage * PAGE_SIZE;
  const lote = state.allIds.slice(inicio, inicio + PAGE_SIZE);
  const results = await executarEmLotes(lote, TAMANHO_GRUPO_TMDB, item => tmdbDetailsFor(cat, item), PAUSA_ENTRE_GRUPOS_TMDB);

  track.innerHTML = "";
  const validos = results.filter(Boolean);
  if(!validos.length){ track.innerHTML = '<p class="empty">Sem itens disponíveis nesta página.</p>'; }
  validos.forEach(d => track.appendChild(buildCard(d)));

  if(pag){
    const btnVoltar = pag.querySelector('[data-dir="-1"]');
    const btnProximo = pag.querySelector('[data-dir="1"]');
    btnVoltar.disabled = state.currentPage <= 0;
    btnProximo.disabled = state.currentPage >= totalPaginas - 1;
  }
}

function navigatePage(cat, dir){
  const state = catalogState[cat];
  const totalPaginas = Math.max(1, Math.ceil(state.allIds.length / PAGE_SIZE));
  const novaPagina = state.currentPage + dir;
  if(novaPagina < 0 || novaPagina >= totalPaginas) return;
  state.currentPage = novaPagina;
  renderPage(cat);
}

/* ============ PARTILHAR ============
   O link partilhado é o mesmo da barra de endereço (?cat=&id= e, nos
   episódios, &t=&ep=). A pré-visualização (capa / imagem do episódio) é
   gerada no servidor por og-meta.php, porque o WhatsApp/Telegram não
   executam JavaScript ao ler o link. */
const SVG_PARTILHAR = '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg>';

function linkPartilha(d, temporada, episodio){
  const base = location.origin + location.pathname.replace(/index\.(html|php)$/, "");
  let q = "?cat=" + encodeURIComponent(d.cat) + "&id=" + encodeURIComponent(d.tmdbId);
  if(temporada && episodio) q += "&t=" + temporada + "&ep=" + episodio;
  if(typeof ESTA_NO_APP !== "undefined" && ESTA_NO_APP){ // partilhado de dentro do aplicativo
    q += "&de=app";
    if(typeof PACOTE_DO_APP !== "undefined" && PACOTE_DO_APP) q += "&pk=" + encodeURIComponent(PACOTE_DO_APP);
  }
  return base + q;
}
function avisoPartilha(texto){
  const el = document.createElement("div");
  el.className = "aviso-partilha";
  el.textContent = texto;
  document.body.appendChild(el);
  setTimeout(() => el.remove(), 2200);
}
// Menu de partilha do próprio telemóvel (inclui Quick Share/Nearby, Bluetooth, WhatsApp...).
// Dentro do app Median usa a ponte nativa; no navegador usa o navigator.share.
async function partilhaNativa(titulo, url){
  try{
    if(window.median && median.share && median.share.sharePage){ median.share.sharePage({ url: url, text: titulo }); return true; }
  }catch(e){}
  try{
    if(navigator.share){ await navigator.share({ title: titulo, text: titulo, url: url }); return true; }
  }catch(e){
    if(e && e.name === "AbortError") return true; // a pessoa fechou o menu de partilha
  }
  return false;
}
async function partilharTitulo(d, temporada, episodio, nomeEp){
  if(!d || !d.tmdbId) return;
  const url = linkPartilha(d, temporada, episodio);
  const titulo = (temporada && episodio)
    ? `${d.title} · T${temporada} EP${episodio}${nomeEp ? " — " + nomeEp : ""}`
    : d.title;
  if(await partilhaNativa(titulo, url)) return;
  try{
    await navigator.clipboard.writeText(url);
    avisoPartilha("Link copiado!");
  }catch(e){
    prompt("Copia o link:", url);
  }
}

function buildCard(d, opcoes){
  opcoes = opcoes || {};
  const el = document.createElement("div");
  el.className = "card";
  const tipo = (d.tipoLabel || TIPO_LABEL[d.cat] || "").toUpperCase();
  let meta = [tipo, d.year].filter(Boolean).join(" • ");
  // NOVO: na faixa "Continuar Assistindo", troca a linha de baixo por
  // "T{temporada} · EP{episódio} · X min" (ou só "X min assistidos" num
  // filme), quando já sabemos isso guardado do histórico.
  if(opcoes.mostrarProgresso && d.minutosAssistidos){
    const epInfo = (d.temporadaEscolhida && d.episodioEscolhido) ? `T${d.temporadaEscolhida} · EP${d.episodioEscolhido} · ` : "";
    meta = `${epInfo}${d.minutosAssistidos} min assistidos`;
  }
  el.innerHTML = `
    <img class="poster" loading="lazy" src="${d.poster || ''}" alt="${d.title}" onerror="this.style.opacity=0">
    <div class="card-topo-esq">
      ${tipo ? `<span class="card-tipo-badge">${tipo}</span>` : ""}
      <button type="button" class="card-btn-partilhar" title="Partilhar">${SVG_PARTILHAR}</button>
    </div>
    ${opcoes.remover ? `<button type="button" class="card-btn-remover" title="Remover">✕</button>` : ""}
    <div class="meta"><div class="t">${d.title}</div><div class="y">${meta}</div></div>`;
  el.addEventListener("click", (e) => {
    if(e.target.closest(".card-btn-remover") || e.target.closest(".card-btn-partilhar")) return; // ✕ e partilhar são tratados à parte, não abrem a ficha
    abrirDetalhes(d);
  });
  el.querySelector(".card-btn-partilhar").addEventListener("click", (e) => {
    e.stopPropagation();
    partilharTitulo(d);
  });
  if(opcoes.remover){
    el.querySelector(".card-btn-remover").addEventListener("click", (e) => {
      e.stopPropagation();
      opcoes.remover(d, el);
    });
  }
  return el;
}

/* ============ CONTINUAR ASSISTINDO (faixa na Início, usa o mesmo histórico
   de cliques já guardado no aparelho - é a "continuação" mais fiel que dá
   pra oferecer sem um sistema de progresso de vídeo próprio). ============ */
function montarContinuarAssistindo(){
  const linha = document.getElementById("linha-continuar-assistindo");
  const track = document.getElementById("continuar-assistindo-track");
  if(!linha || !track) return;
  const lista = obterHistoricoCliques().slice(0, 12);
  if(!lista.length){ linha.style.display = "none"; return; }
  linha.style.display = "";
  track.innerHTML = "";
  lista.forEach(d => {
    const card = buildCard(d, {
      mostrarProgresso: true,
      remover: (item, cardEl) => {
        const restante = obterHistoricoCliques().filter(x => !(x.cat === item.cat && x.tmdbId === item.tmdbId));
        localStorage.setItem(CHAVE_HISTORICO_CLIQUES, JSON.stringify(restante));
        cardEl.remove();
        if(!restante.length) linha.style.display = "none";
      }
    });
    // Clique no card: filme ou EP guardado → leitor direto; senão detalhes
    card.addEventListener("click", (e) => {
      if(e.target.closest(".card-btn-remover") || e.target.closest(".card-btn-partilhar")) return;
      e.stopPropagation();
      abrirContinuarAssistindoItem(d);
    }, true);
    track.appendChild(card);
  });
}

function abrirContinuarAssistindoItem(d){
  if(!d) return;
  if(d.cat === "filme"){
    abrirModalServidor(d);
    return;
  }
  // Série/anime/dorama: se soubermos o EP (histórico ou último lançado), abre direto
  const temp = d.temporadaEscolhida || (d.ultimoEpisodio && d.ultimoEpisodio.temporada);
  const epi = d.episodioEscolhido || (d.ultimoEpisodio && d.ultimoEpisodio.episodio);
  if(temp && epi){
    abrirModalServidor(d, temp, epi);
  } else {
    abrirDetalhes(d);
  }
}

/* ===== NOVO: substitui um <select> nativo por um menu customizado (mesmo
   esquema de cores do site), porque no Android o <select> nativo abre a
   lista branca do próprio sistema, fora do nosso controlo/CSS. O <select>
   original continua a existir (só fica escondido) — guarda o valor
   verdadeiro e todo o código já existente que lê .value/.selectedIndex/
   .options continua a funcionar sem mudar mais nada. ===== */
const seletoresCustomRegistrados = [];

function abrirModalListaEscolha(titulo, opcoes, valorAtual, onEscolher){
  const modal = document.getElementById("modalListaEscolha");
  const caixaOpcoes = document.getElementById("modalListaEscolhaOpcoes");
  const tituloEl = document.getElementById("modalListaEscolhaTitulo");
  if(!modal || !caixaOpcoes) return;
  tituloEl.textContent = titulo || "Escolher";
  caixaOpcoes.innerHTML = "";
  opcoes.forEach(op => {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = "modal-lista-opcao" + (String(op.value) === String(valorAtual) ? " selecionada" : "");
    btn.innerHTML = `<span>${op.label}</span><span class="radio-bola"></span>`;
    btn.addEventListener("click", () => {
      modal.classList.remove("aberto");
      onEscolher(op.value);
    });
    caixaOpcoes.appendChild(btn);
  });
  modal.classList.add("aberto");
}
(function(){
  const fecharLista = document.getElementById("fecharModalListaEscolha");
  const modalLista = document.getElementById("modalListaEscolha");
  if(fecharLista) fecharLista.addEventListener("click", () => { if(modalLista) modalLista.classList.remove("aberto"); });
  if(modalLista) modalLista.addEventListener("click", (e) => {
    if(e.target.id === "modalListaEscolha") modalLista.classList.remove("aberto");
  });
})();

function estilizarSeletorNativo(select){
  if(!select || select.dataset.estilizado) return;
  select.dataset.estilizado = "1";
  select.style.display = "none";

  const wrap = document.createElement("div");
  wrap.className = "seletor-custom";
  const botao = document.createElement("button");
  botao.type = "button";
  botao.className = "seletor-custom-botao";
  wrap.appendChild(botao);
  select.insertAdjacentElement("afterend", wrap);

  function reconstruir(){
    const atual = select.options[select.selectedIndex];
    botao.textContent = atual ? atual.textContent : "—";
  }

  botao.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    const opcoes = Array.from(select.options).map(op => ({ value: op.value, label: op.textContent }));
    const titulo = (select.id || "").toLowerCase().includes("season") || (select.id || "").toLowerCase().includes("temporada")
      ? "Temporada" : ((select.id || "").toLowerCase().includes("episode") ? "Episódio" : "Escolher");
    abrirModalListaEscolha(titulo, opcoes, select.value, (valor) => {
      select.value = valor;
      select.dispatchEvent(new Event("change"));
      reconstruir();
    });
  });

  select.addEventListener("change", reconstruir);
  new MutationObserver(reconstruir).observe(select, { childList: true });
  reconstruir();

  seletoresCustomRegistrados.push(reconstruir);
}

// Alguns sítios do código mudam .selectedIndex diretamente (ex.: "Próximo
// episódio"), o que não dispara "change" nem mexe nos <option> — por isso
// não seria apanhado nem pelo listener nem pelo MutationObserver acima.
// Chama isto logo a seguir, para o botão customizado mostrar o valor certo.
function sincronizarTodosSeletoresCustom(){
  seletoresCustomRegistrados.forEach(fn => fn());
}

/* ============ PLAYER ============ */
const overlay = document.getElementById("overlay");
const playerFrame = document.getElementById("playerFrame");
const playerTitle = document.getElementById("playerTitle");
const epControls = document.getElementById("epControls");
const seasonSelect = document.getElementById("seasonSelect");
const episodeSelect = document.getElementById("episodeSelect");
estilizarSeletorNativo(seasonSelect);
estilizarSeletorNativo(episodeSelect);
const playerTipo = document.getElementById("playerTipo");
const playerGenero = document.getElementById("playerGenero");
const playerSinopse = document.getElementById("playerSinopse");

/* NOVO: a máscara preta do canto (.mascara-topo-iframe) tapa o botão de
   voltar que o servidor de vídeo mostra dentro do iframe deles. Como é
   cross-origin, não há como saber quando a pessoa clica no servidor dela
   lá dentro - por isso mostramos a máscara sempre que um vídeo novo é
   carregado (abrir filme, trocar de episódio, próximo episódio) e
   escondemos sozinhos depois de alguns segundos, tempo de sobra para a
   escolha já ter sido feita. Assim ela "desaparece depois de clicar num
   servidor" e "volta" sempre que se volta a carregar um vídeo. */
const mascaraTopoIframe = document.querySelector(".mascara-topo-iframe");
let timerMascaraTopoIframe = null;
function mostrarMascaraTopoIframe(){
  if(!mascaraTopoIframe) return;
  clearTimeout(timerMascaraTopoIframe);
  mascaraTopoIframe.style.display = "block";
  timerMascaraTopoIframe = setTimeout(() => {
    mascaraTopoIframe.style.display = "none";
  }, 30000);
}

// NOVO: guarda quando o leitor abriu e qual título, pra calcular quanto
// tempo ficou aberto ao fechar (aproximação de "quanto já assistiu" — não
// dá pra ler o tempo real do vídeo porque ele toca dentro do iframe de
// outro site, sem acesso nosso).
let momentoAberturaPlayer = null;
let dPlayerAtual = null;

function openPlayer(d){
  if(typeof d.servidorIdx === "number") servidorAtual = d.servidorIdx;
  barraPronta = false;
  momentoAberturaPlayer = Date.now();
  dPlayerAtual = d;
  playerTitle.textContent = ""; // já não mostra o nome — o usuário já sabe o que clicou
  // NOVO: tipo (Filme/Série/Anime/Dorama), género e sinopse no topo do leitor
  playerTipo.textContent = d.tipoLabel || TIPO_LABEL[d.cat] || "";
  playerGenero.textContent = d.genre || "";
  playerSinopse.textContent = d.overview || "";
  // A sinopse começa sempre escondida a cada título novo — o utilizador
  // decide se quer vê-la, clicando no botão de olho.
  playerSinopse.classList.remove("visivel");
  btnToggleSinopse.classList.remove("ativo");
  btnToggleSinopse.textContent = "👁 Sinopse";
  overlay.classList.add("open");
  // O leitor abre sempre em vertical/normal, com a sinopse cá em baixo.
  // O ecrã cheio/rotação para horizontal passou a ser feito pelos próprios
  // controlos do vídeo lá dentro do iframe (o servidor já tem essa opção) —
  // o botão que existia aqui para isso foi trocado pelo de Download.
  if(d.cat === "filme"){
    epControls.style.display = "none";
    playerFrame.src = SERVIDORES[servidorAtual].filme(d.tmdbId);
    mostrarMascaraTopoIframe();
    atualizarUrlFilmePlayer(d); // LINK DIRETO do filme no leitor
    desenharBarraServidores();
  } else {
    epControls.style.display = "flex";
    const totalSeasons = d.seasons || 1;
    seasonSelect.innerHTML = Array.from({length: totalSeasons}, (_,i)=>`<option value="${i+1}">${i+1}</option>`).join("");
    // NOVO: se veio da lista de episódios com uma temporada/episódio já
    // escolhidos, abre direto nesse episódio em vez de sempre 1x1.
    if(d.temporadaEscolhida && !Array.from(seasonSelect.options).some(o => o.value === String(d.temporadaEscolhida))){
      seasonSelect.add(new Option(String(d.temporadaEscolhida), String(d.temporadaEscolhida))); // link com temporada fora da lista
    }
    if(d.temporadaEscolhida) seasonSelect.value = String(d.temporadaEscolhida);
    fillEpisodes();
    if(d.episodioEscolhido && !Array.from(episodeSelect.options).some(o => o.value === String(d.episodioEscolhido))){
      episodeSelect.add(new Option(String(d.episodioEscolhido), String(d.episodioEscolhido))); // link com episódio acima de 30
    }
    if(d.episodioEscolhido) episodeSelect.value = String(d.episodioEscolhido);
    seasonSelect.onchange = fillEpisodes;
    episodeSelect.onchange = () => updateSeriesFrame(d.tmdbId, d.servidorBase);
    btnProximoEpisodio.onclick = () => irParaProximoEpisodio(d.tmdbId, d.servidorBase);
    updateSeriesFrame(d.tmdbId, d.servidorBase);
  }
}
const btnToggleSinopse = document.getElementById("btnToggleSinopse");
btnToggleSinopse.addEventListener("click", () => {
  const agoraVisivel = playerSinopse.classList.toggle("visivel");
  btnToggleSinopse.classList.toggle("ativo", agoraVisivel);
  btnToggleSinopse.textContent = agoraVisivel ? "🙈 Sinopse" : "👁 Sinopse";
});
const btnProximoEpisodio = document.getElementById("btnProximoEpisodio");
// Avança para o episódio seguinte; se já for o último da temporada, passa
// para o episódio 1 da temporada seguinte (quando houver). O utilizador
// continua a poder escolher manualmente pelos seletores acima a qualquer momento.
function irParaProximoEpisodio(tmdbId, servidorBase){
  if(episodeSelect.selectedIndex < episodeSelect.options.length - 1){
    episodeSelect.selectedIndex += 1;
  } else if(seasonSelect.selectedIndex < seasonSelect.options.length - 1){
    seasonSelect.selectedIndex += 1;
    fillEpisodes();
    episodeSelect.selectedIndex = 0;
  }
  updateSeriesFrame(tmdbId, servidorBase);
}
function fillEpisodes(){
  // sem endpoint de contagem exata de episódios por temporada disponível aqui; oferece 1-30 e o usuário ajusta
  episodeSelect.innerHTML = Array.from({length:30}, (_,i)=>`<option value="${i+1}">${i+1}</option>`).join("");
}
function updateSeriesFrame(tmdbId, servidorBase){
  sincronizarTodosSeletoresCustom();
  playerFrame.src = SERVIDORES[servidorAtual].serie(tmdbId, seasonSelect.value, episodeSelect.value, dPlayerAtual && dPlayerAtual.cat);
  desenharBarraServidores();
  mostrarMascaraTopoIframe();
  atualizarUrlEpisodio(); // LINK DIRETO do episódio
}
document.getElementById("closePlayer").addEventListener("click", () => {
  // NOVO: guarda o EP em que estava e uma estimativa de quantos minutos
  // ficou a assistir, pra faixa "Continuar Assistindo" mostrar isso.
  if(dPlayerAtual && momentoAberturaPlayer){
    const minutos = Math.round((Date.now() - momentoAberturaPlayer) / 60000);
    if(minutos >= 1){
      const dParaGuardar = Object.assign({}, dPlayerAtual, {
        temporadaEscolhida: dPlayerAtual.cat !== "filme" ? Number(seasonSelect.value) : null,
        episodioEscolhido: dPlayerAtual.cat !== "filme" ? Number(episodeSelect.value) : null,
        minutosAssistidos: minutos
      });
      registrarCliqueHistorico(dParaGuardar);
      montarContinuarAssistindo();
    }
  }
  momentoAberturaPlayer = null;
  dPlayerAtual = null;
  overlay.classList.remove("open");
  limparUrlDetalhes(); // LINK DIRETO: volta a URL para a página inicial
  playerFrame.src = "";
  clearTimeout(timerMascaraTopoIframe);
  sairEcraCheioGiratorio();
});
overlay.addEventListener("click", e => { if(e.target === overlay) document.getElementById("closePlayer").click(); });

/* ============ ECRÃ CHEIO GIRATÓRIO ============
   Ao tocar, o leitor entra em ecrã cheio e tenta rodar sozinho para a
   horizontal (paisagem) — em vez do usuário ter de girar o telemóvel à
   mão. Nem todos os navegadores permitem forçar a rotação (a Apple/Safari
   não deixa), por isso falha em silêncio nesses casos e fica só o ecrã
   cheio normal.
   NOVO: isto também corre SOZINHO assim que o leitor abre (dentro de
   openPlayer) — é o que faz o vídeo tapar mesmo a barra de endereço do
   telemóvel em vez de ficar espremido dentro dela. No iOS/Safari o sistema
   não deixa pedir ecrã cheio para um <iframe> (limitação da Apple, não é
   um bug daqui) — nesse caso fica só o layout normal, já ocupando o ecrã
   todo por baixo da barra. */
async function entrarEcraCheioGiratorio(){
  // NOVO: pede ecrã cheio na CAIXA TODA do leitor (.player-box), não só no
  // vídeo — assim o botão de fechar, a sinopse e o "Próximo episódio"
  // continuam visíveis e clicáveis mesmo em ecrã cheio real. Pedir ecrã
  // cheio só no <iframe> escondia esses controlos por baixo dele.
  const alvo = document.querySelector(".player-box");
  try{
    if(!document.fullscreenElement){
      await alvo.requestFullscreen();
      if(screen.orientation && screen.orientation.lock){
        try{ await screen.orientation.lock("landscape"); }catch(e){ /* navegador não deixa forçar — sem problema */ }
      }
    }
  }catch(e){
    console.warn("Ecrã cheio automático não foi possível neste navegador (normal no iOS/Safari):", e);
  }
}
// NOVO: este botão passou a ser de Download — o ecrã cheio/rotação
// automática continua a acontecer sozinho ao abrir o leitor (função
// entrarEcraCheioGiratorio(), chamada dentro de openPlayer), já não precisa
// de um botão manual para isso. A função de download em si fica para depois.
/* ============ DOWNLOAD DO EPISÓDIO / FILME ============
   O vídeo corre dentro de um iframe de OUTRO site, e o navegador não deixa
   a nossa página ver os pedidos de rede lá dentro. Por isso a captura do
   link (.m3u8 / .mp4) é feita no servidor, pelo resolver.php, que abre a
   página do embed e procura o link. Se encontrar, envia direto para o
   gestor de downloads do Android (1DM por defeito). */
const PACOTE_GESTOR_DOWNLOAD = "idm.internet.download.manager"; // 1DM. Para ADM: "com.dv.adm" · 1DM+: "idm.internet.download.manager.plus"
const RESOLVER_PHP = "resolver.php?url=";
let baixandoAgora = false;
function enviarParaGestorDownload(link){
  const u = new URL(link);
  const intent = "intent://" + u.host + u.pathname + u.search +
    "#Intent;scheme=" + u.protocol.replace(":", "") +
    ";action=android.intent.action.VIEW;package=" + PACOTE_GESTOR_DOWNLOAD + ";end";
  // Clique num <a> temporário: o Android abre o 1DM por cima e o site continua
  // aberto por baixo (ao voltar, a pessoa está no mesmo sítio onde estava).
  const a = document.createElement("a");
  a.href = intent; a.style.display = "none";
  document.body.appendChild(a); a.click(); a.remove(); // sem o app instalado, abre a Google Play
}
/* ============ DOWNLOAD NO 1DM (botão do leitor + botões ⬇ da lista de episódios) ============
   O botão está SEMPRE visível — não é preciso esperar pelo Cloudflare do embed. Ao tocar,
   o 1DM abre uma página deste site (baixar.php) que só tem o embed; lá o 1DM faz a
   verificação sozinho e captura o vídeo. */
/* Ficheiros do passo-a-passo (À PARTE do código, na mesma pasta do index — vais enviando):
   como-baixar-armazenamento.png → imagem "escolher local de armazenamento" do 1DM
   como-baixar.mp4               → vídeo com controlos (avançar/recuar)
   como-baixar.gif               → só usado se o vídeo não existir */
const COMO_BAIXAR_IMG_ARMAZENAMENTO = "como-baixar-armazenamento.png";
const COMO_BAIXAR_MP4 = "como-baixar.dat"; // o mesmo vídeo, com extensão .dat; abre aqui como vídeo (blob)
const COMO_BAIXAR_B64 = "AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAABbzdXVpZNj+w9YbDkg8kpdYKId+xIEAAAAAbWFuaWZlc3QAAAAAAAAAAAAAABbGanVtYgAAAB5qdW1kYzJwYQARABCAAACqADibcQNjMnBhAAAAFqBqdW1iAAAAR2p1bWRjMm1hABEAEIAAAKoAOJtxA3VybjpjMnBhOjM1ZjQyZjJhLWI0YWQtNDJmOS04M2VjLTQ3ZjZhZmQ1ZWZhMgAAAAPYanVtYgAAAClqdW1kYzJhcwARABCAAACqADibcQNjMnBhLmFzc2VydGlvbnMAAAAAuGp1bWIAAABEanVtZGNib3IAEQAQgAAAqgA4m3ETYzJwYS5pbmdyZWRpZW50LnYzAAAAABhjMnNoKsB0QNHfBGHkCpjBma4J0wAAAGxjYm9yo2lkYzpmb3JtYXRpdmlkZW8vbXA0amluc3RhbmNlSUR4LHhtcDppaWQ6MWJkYjhmZGEtNTdiMC00N2JhLThhOGEtNjRhNWVjNWFkZGE5bHJlbGF0aW9uc2hpcGhwYXJlbnRPZgAAAeJqdW1iAAAAQWp1bWRjYm9yABEAEIAAAKoAOJtxE2MycGEuYWN0aW9ucy52MgAAAAAYYzJzaDgI629/yOBYgq6fotjLjLQAAAGZY2JvcqJnYWN0aW9uc4KiZmFjdGlvbmtjMnBhLm9wZW5lZGpwYXJhbWV0ZXJzoWtpbmdyZWRpZW50c4GiY3VybHgtc2VsZiNqdW1iZj1jMnBhLmFzc2VydGlvbnMvYzJwYS5pbmdyZWRpZW50LnYzZGhhc2hYIB04lfflrJ+zNGzcD4Jy/gQi7a8EWzxannGpw0EXvP6PpGZhY3Rpb254HWNvbS5hbnRocm9waWMuY2xhdWRlLnByb3ZpZGVkanBhcmFtZXRlcnOheB9jb20uYW50aHJvcGljLm9yaWdpbi1jb25maWRlbmNlZ3Vua25vd25rZGVzY3JpcHRpb254ZkNsYXVkZSBwcm92aWRlZCB0aGlzIGZpbGUgYXQgdGhlIHJlcXVlc3Qgb2YgYSB1c2VyIGFuZCBtYXkgaGF2ZSBjcmVhdGVkIG9yIG1vZGlmaWVkIHRoZSBmaWxlIGNvbnRlbnRzLm1zb2Z0d2FyZUFnZW50oWRuYW1lZkNsYXVkZXJhbGxBY3Rpb25zSW5jbHVkZWT1AAABDWp1bWIAAABDanVtZGNib3IAEQAQgAAAqgA4m3ETYzJwYS5oYXNoLmJtZmYudjMAAAAAGGMyc2gWuJbkuuwP8yw1rHA1oeq5AAAAwmNib3KkY2FsZ2ZzaGEyNTZkaGFzaFggA0vOgU2FAuCftX42jDzFhuWjpaWNxP/ucIHMTSetRxBkbmFtZW5qdW1iZiBtYW5pZmVzdGpleGNsdXNpb25zhaJkZGF0YYGiZXZhbHVlUNj+w9YbDkg8kpdYKId+xIFmb2Zmc2V0CGV4cGF0aGUvdXVpZKFleHBhdGhlL2Z0eXChZXhwYXRoZS9tZnJhoWV4cGF0aGUvZnJlZaFleHBhdGhlL3NraXAAAAJBanVtYgAAACdqdW1kYzJjbAARABCAAACqADibcQNjMnBhLmNsYWltLnYyAAAAAhJjYm9ypWNhbGdmc2hhMjU2aXNpZ25hdHVyZXhNc2VsZiNqdW1iZj0vYzJwYS91cm46YzJwYTozNWY0MmYyYS1iNGFkLTQyZjktODNlYy00N2Y2YWZkNWVmYTIvYzJwYS5zaWduYXR1cmVqaW5zdGFuY2VJRHgseG1wOmlpZDozNzBmZTBlZi1mODM1LTQ5OWItODg1ZS1kZDg0MjI4MzJjM2FyY3JlYXRlZF9hc3NlcnRpb25zg6JjdXJseC1zZWxmI2p1bWJmPWMycGEuYXNzZXJ0aW9ucy9jMnBhLmluZ3JlZGllbnQudjNkaGFzaFggHTiV9+Wsn7M0bNwPgnL+BCLtrwRbPFqecanDQRe8/o+iY3VybHgqc2VsZiNqdW1iZj1jMnBhLmFzc2VydGlvbnMvYzJwYS5hY3Rpb25zLnYyZGhhc2hYIGmOTfipuXO7hb8n7RmxYYIUQekmSwPQDy7fVg2in0QdomN1cmx4LHNlbGYjanVtYmY9YzJwYS5hc3NlcnRpb25zL2MycGEuaGFzaC5ibWZmLnYzZGhhc2hYIJBjp+zSZTZX7ovnTvR/aXr0DBeTYpBvWZOXndYiwxHQdGNsYWltX2dlbmVyYXRvcl9pbmZvo2RuYW1lb0FudGhyb3BpYyBGaWxlc2d2ZXJzaW9uZTEuMC4wa3NwZWNWZXJzaW9uZTIuNC4wAAAQOGp1bWIAAAAoanVtZGMyY3MAEQAQgAAAqgA4m3EDYzJwYS5zaWduYXR1cmUAAAAQCGNib3LShFkCEqIBJhghWQIKMIICBjCCAY2gAwIBAgIUQOWgCu7COdC+uIP6BkIFPWdVEwAwCgYIKoZIzj0EAwMwSTEXMBUGA1UEChMOQW50aHJvcGljLCBQQkMxLjAsBgNVBAMTJUFudGhyb3BpYyBDb250ZW50IENyZWRlbnRpYWxzIFJvb3QgQ0EwHhcNMjYwODA3MTg0MzU2WhcNMjgwODA2MTk0MzU2WjBEMRcwFQYDVQQKEw5BbnRocm9waWMsIFBCQzEpMCcGA1UEAxMgQW50aHJvcGljIENsYXVkZSBDb250ZW50IFNpZ25pbmcwWTATBgcqhkjOPQIBBggqhkjOPQMBBwNCAASYegpry1AYBRTVNL1CpTlbROnY3dey+UrsF9C3phYrATN3ZHf93Mo8RQN0KOUuOn19P4oWNFWe5n2/She9N7eTo1gwVjAOBgNVHQ8BAf8EBAMCB4AwFQYDVR0lBA4wDAYKKwYBBAGD6F4CATAMBgNVHRMBAf8EAjAAMB8GA1UdIwQYMBaAFM5R4gSBTmRbI/jjxM+aPpzB11zCMAoGCCqGSM49BAMDA2cAMGQCMDFzHRSeAXrSy1WOzkbhPZ6Km2wGTmZ/2gK18k8BQGXyqz88Rdrz6CTX9flAnYNVxgIwcF9c3fVhqmJKpi+UhasNUMko69cyX6STPfta3Q8EjyzDjzoyrol46FP6VFHhvUcJoWNwYWRZDZ4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA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AAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAEAAAAAACAAAEAAAAAAEAAAwAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAgAACAAAAAABAAAMAAAAAAEAAAQAAAAAAQAACAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABAAAAAAAgAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAMAAAAAAEAAAQAAAAAAQAACAAAAAABAAAMAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAIAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAACAAAIAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAACAAAIAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABAAAAAAAgAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAEAAAAAACAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAAAgAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAEAAAAAACAAAEAAAAAAQAAAgAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAMAAAAAAEAAAQAAAAAAQAADAAAAAABAAAEAAAAAAIAAAgAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEAAAAAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAAAwAAAAAAQAABAAAAAABAAAUAAAAAAEAAAgAAAAAAQAAAAAAAAABAAAEAAAAAAEAABQAAAAAAQAACAAAAAABAAAAAAAAAAEAAAQAAAAAAQAAFAAAAAABAAAIAAAAAAEA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"; // versão EMBUTIDA: o vídeo vai dentro deste código (abre na hora); vazio = lê o ficheiro .dat
let _urlComoBaixar = null, _promComoBaixar = null;
function carregarVideoComoBaixar(vid){
  const pôr = u => { vid.src = u; };
  if(_urlComoBaixar){ pôr(_urlComoBaixar); return Promise.resolve(); }
  if(!_promComoBaixar){
    _promComoBaixar = (COMO_BAIXAR_B64
      ? Promise.resolve().then(() => { const bin = atob(COMO_BAIXAR_B64), n = bin.length, u8 = new Uint8Array(n); for(let i = 0; i < n; i++) u8[i] = bin.charCodeAt(i); return u8; })
      : fetch(COMO_BAIXAR_MP4, {cache:"force-cache"}).then(r => { if(!r.ok) throw 0; return r.arrayBuffer(); })
    ).then(buf => { _urlComoBaixar = URL.createObjectURL(new Blob([buf], {type:"video/mp4"})); return _urlComoBaixar; })
     .catch(err => { _promComoBaixar = null; throw err; });
  }
  return _promComoBaixar.then(pôr);
}
// pré-carrega em silêncio logo que o site abre, para o vídeo aparecer na hora
window.addEventListener("load", () => setTimeout(() => { carregarVideoComoBaixar(document.createElement("video")).catch(() => {}); }, 800));
const COMO_BAIXAR_GIF = "como-baixar.gif";
const CH_COMO_OFF = "webplay_como_baixar_off";   // "1" = desativado no perfil
const CH_BAIXOU = "webplay_baixou_uma_vez";       // depois do 1º download aparece o balão no perfil
function lerLS(k){ try{ return localStorage.getItem(k); }catch(e){ return null; } }
function gravarLS(k, v){ try{ localStorage.setItem(k, v); }catch(e){} }
function comoBaixarDesativado(){ return lerLS(CH_COMO_OFF) === "1"; }
// Balão (banda desenhada) no perfil: depois do 1º download, convida a desativar o "Como baixar"
function atualizarBalaoComoBaixar(){
  const b = document.getElementById("balaoComoBaixar");
  if(!b) return;
  const off = comoBaixarDesativado();
  if(lerLS(CH_BAIXOU) !== "1" && !off){ b.style.display = "none"; return; }
  b.style.display = "block";
  b.querySelector(".balao-txt").textContent = off
    ? "O \"Como baixar\" está desativado: os downloads vão direto para o 1DM."
    : "Caro usuário, como já sabe baixar no 1DM, pode desativar a função de \"Como baixar\".";
  const btn = b.querySelector("button");
  btn.textContent = off ? "Ativar o Como baixar" : "Desativar o Como baixar";
  btn.onclick = () => { gravarLS(CH_COMO_OFF, off ? "0" : "1"); atualizarBalaoComoBaixar(); };
}
function mostrarComoBaixar(seguir, soVideo){
  const m = document.getElementById("modalComoBaixar");
  const telas = ["mcbEscolha", "mcbConfig", "mcbVideoTela"];
  const tela = id => telas.forEach(t => { document.getElementById(t).style.display = (t === id) ? "block" : "none"; });
  const vid = document.getElementById("mcbVideo"), gif = document.getElementById("mcbGif"), arm = document.getElementById("mcbImgArmaz");
  const fechar = () => { try{ vid.pause(); }catch(e){} m.classList.remove("aberto"); };
  tela(soVideo ? "mcbVideoTela" : "mcbEscolha");
  arm.style.display = "none";
  arm.onload = () => { arm.style.display = "block"; };
  arm.onerror = () => { arm.style.display = "none"; };
  arm.src = COMO_BAIXAR_IMG_ARMAZENAMENTO;
  vid.style.display = "none"; gif.style.display = "none";
  vid.onloadedmetadata = () => { vid.style.display = "block"; };
  vid.onerror = () => {
    vid.style.display = "none";
    gif.onload = () => { gif.style.display = "block"; };
    gif.onerror = () => { gif.style.display = "none"; };
    gif.src = COMO_BAIXAR_GIF;
  };
  carregarVideoComoBaixar(vid).catch(() => vid.onerror());
  document.getElementById("mcbComo").onclick = () => { tela("mcbVideoTela"); try{ vid.currentTime = 0; vid.play().catch(()=>{}); }catch(e){} }; // Como baixar → direto para o vídeo
  document.getElementById("mcbConfigX").onclick = () => tela("mcbVideoTela");        // X → vídeo do passo-a-passo
  document.getElementById("mcbVideoX").onclick = () => { try{ vid.pause(); }catch(e){} if(soVideo) fechar(); else tela("mcbEscolha"); }; // X → volta às duas opções (ou fecha, se abriu sozinho)
  document.getElementById("mcbBaixar").onclick = () => { fechar(); if(seguir) seguir(); };
  m.onclick = e => { if(e.target === m && document.getElementById("mcbEscolha").style.display !== "none") fechar(); };
  m.classList.add("aberto");
}
// url = embed do vídeo (vai por baixar.php) · direto = true → link já direto/do catálogo, vai tal e qual para o 1DM
function baixarNo1DM(url, direto, nome){
  if(!/^https?:/.test(url || "")){ avisoPartilha("Nada para baixar."); return; }
  if(baixandoAgora) return;
  const seguir = async () => {
    baixandoAgora = true;
    try{
      if(direto){
        enviarParaGestorDownload(url);
      } else {
        avisoPartilha("A abrir no 1DM…");
        const r = await fetch("baixar.php?acao=novo&u=" + encodeURIComponent(url) + "&n=" + encodeURIComponent(nome || ""), { cache: "no-store" });
        const j = await r.json();
        if(j && j.ok && j.link) enviarParaGestorDownload(j.link);
        else avisoPartilha("Não foi possível preparar o download.");
      }
      gravarLS(CH_BAIXOU, "1");
      atualizarBalaoComoBaixar();
    }catch(e){ avisoPartilha("Não foi possível preparar o download."); }
    setTimeout(() => { baixandoAgora = false; }, 1500);
  };
  if(comoBaixarDesativado()) seguir(); else mostrarComoBaixar(seguir);
}
atualizarBalaoComoBaixar();

/* ============ LINKS PARTILHADOS PELO APLICATIVO ============
   Quem partilha de dentro do app (WebView) gera um link com &de=app. Quem abre esse link
   num navegador normal no Android: o site tenta abrir o app sozinho; só mostra aviso se não abrir. Links partilhados do
   site (sem &de=app) abrem no site, como sempre. Preenche as duas linhas abaixo para ligar. */
const APP_PACOTE = "co.median.android.dykpbqj";        // opcional: o site já descobre o pacote sozinho quando o link é partilhado de dentro do app
const APP_URL_DOWNLOAD = "";  // onde se baixa o app (link do APK ou da loja)
// O Android manda, em cada pedido de um app com WebView, o nome do pacote do app (X-Requested-With).
// O servidor passa-o para aqui: assim o site descobre SOZINHO se está dentro do app e qual é o pacote.
const XRW_DO_PEDIDO = <?= json_encode($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') ?>;
const PACOTE_DO_APP = (/^[a-z][a-z0-9_]*(\.[a-z0-9_]+)+$/i.test(XRW_DO_PEDIDO) &&
  !/^(com\.android\.chrome|com\.chrome\.|org\.mozilla\.|com\.brave\.|com\.opera\.|com\.sec\.android\.app\.sbrowser|com\.microsoft\.emmx|com\.google\.android\.apps\.chrome|com\.kiwibrowser|com\.duckduckgo|idm\.internet)/i.test(XRW_DO_PEDIDO)) ? XRW_DO_PEDIDO : "";
const ESTA_NO_APP = !!PACOTE_DO_APP || /; wv\)|WebPlayApp/i.test(navigator.userAgent);
// Para diagnosticar: abre o site com ?debugapp=1 e ele mostra o que detetou
try{ if(new URLSearchParams(location.search).get("debugapp") === "1") alert("Dentro do app: " + ESTA_NO_APP + "\nPacote: " + (PACOTE_DO_APP || "(não detetado)") + "\nX-Requested-With: " + (XRW_DO_PEDIDO || "(vazio)") + "\nUA: " + navigator.userAgent); }catch(e){}
(function abrirNoAppAuto(){
  try{
    const p = new URLSearchParams(location.search);
    const pk = APP_PACOTE || p.get("pk") || "";
    if(ESTA_NO_APP || p.get("de") !== "app" || !pk) return;
    if(!/Android/i.test(navigator.userAgent)) return;
    // Nunca vai à Play Store: se o app não responder ao link, o Chrome volta para este mesmo site.
    // Sem o app instalado, o Chrome vai para o link de download; com o app instalado, abre o app direto.
    const voltar = APP_URL_DOWNLOAD || (location.origin + location.pathname + location.search + (location.search.indexOf("tentado=1") < 0 ? "&tentado=1" : ""));
    const destino = "intent://" + location.host + location.pathname + location.search + "#Intent;scheme=https;package=" + pk + ";" +
      "S.browser_fallback_url=" + encodeURIComponent(voltar) + ";end";
    // Abre o app pelo ícone (launcher), sem depender de o app aceitar links deste site.
    const abrirApp = "intent:#Intent;action=android.intent.action.MAIN;category=android.intent.category.LAUNCHER;package=" + pk + ";" +
      "S.browser_fallback_url=" + encodeURIComponent(voltar) + ";end";
    // 1) Tenta abrir o app SOZINHO, sem perguntar. Se estiver instalado, abre direto no título.
    let jaTentou = false;
    try{ jaTentou = p.get("tentado") === "1" || sessionStorage.getItem("webplay_app_tentado") === "1"; sessionStorage.setItem("webplay_app_tentado", "1"); }catch(e){}
    let abriu = false;
    const marcar = () => { if(document.hidden) abriu = true; };
    document.addEventListener("visibilitychange", marcar);
    window.addEventListener("pagehide", () => { abriu = true; });
    if(!jaTentou) location.href = destino;
    // 2) Só se o app NÃO abriu (não instalado, ou o Chrome bloqueou o abrir automático) aparece um aviso.
    setTimeout(() => {
      if(abriu || document.hidden) return;
      if(document.getElementById("avisoAppCaixa")) return;
      const caixa = document.createElement("div");
      caixa.id = "avisoAppCaixa";
      caixa.style.cssText = "position:fixed;left:10px;right:10px;bottom:calc(10px + env(safe-area-inset-bottom,0px));z-index:3600;background:var(--panel);border:1px solid var(--accent-dim);border-radius:14px;padding:12px;color:var(--ink);box-shadow:0 8px 30px rgba(0,0,0,.5);font-size:.85rem;";
      caixa.innerHTML = '<div style="margin-bottom:10px;"><b>Este título está no aplicativo WebPlay</b><br><span style="color:var(--muted);font-size:.78rem;">Toca em Abrir para ir ao aplicativo.</span></div>' +
        '<div style="display:flex;gap:8px;"><button id="appAbrir" style="flex:1;border:none;border-radius:10px;padding:10px;font-weight:700;background:var(--accent);color:#1a1305;cursor:pointer;font-family:inherit;">Abrir no app</button>' +
        '<button id="appFechar" style="flex:1;border:1px solid var(--line);border-radius:10px;padding:10px;background:none;color:var(--ink);cursor:pointer;font-family:inherit;">Continuar no site</button></div>';
      document.body.appendChild(caixa);
      document.getElementById("appFechar").onclick = () => caixa.remove();
      document.getElementById("appAbrir").onclick = () => { location.href = abrirApp; };
      if(APP_URL_DOWNLOAD){ const b = document.createElement("a"); b.href = APP_URL_DOWNLOAD; b.textContent = "Ainda não tenho o app: baixar"; b.style.cssText = "display:block;text-align:center;margin-top:8px;color:var(--muted);font-size:.78rem;"; caixa.appendChild(b); }
    }, 2000);
  }catch(e){}
})();
function sairEcraCheioGiratorio(){
  if(document.fullscreenElement) document.exitFullscreen().catch(()=>{});
  if(screen.orientation && screen.orientation.unlock) { try{ screen.orientation.unlock(); }catch(e){} }
}

/* ============ MODAL DE DETALHES (abre ao clicar num card/banner, ANTES
   do leitor) + COMENTÁRIOS E ESTRELAS (Firebase, em tempo real) ============ */
const janelaDetalhes = document.getElementById("janelaDetalhes");
const detalhesCapaFundo = document.getElementById("detalhesCapaFundo");
const detalhesTitulo = document.getElementById("detalhesTitulo");
const detalhesTipo = document.getElementById("detalhesTipo");
const detalhesAno = document.getElementById("detalhesAno");
const detalhesSinopse = document.getElementById("detalhesSinopse");
const detalhesBtnAssistir = document.getElementById("detalhesBtnAssistir");
const detalhesTemporadaBloco = document.getElementById("detalhesTemporadaBloco");
const detalhesSeasonSelect = document.getElementById("detalhesSeasonSelect");
estilizarSeletorNativo(detalhesSeasonSelect);
const detalhesBtnVerEpisodios = document.getElementById("detalhesBtnVerEpisodios");
let detalhesAtualD = null; // NOVO: guarda o título aberto agora, pra usar ao publicar um comentário (faixa "Últimas avaliações")

/* ---- Minha lista (playlist) e Favoritos: guardados no aparelho ---- */
const CH_LISTA = "webplay_minha_lista", CH_FAV = "webplay_favoritos";
function chaveLista(d){ return d.cat + ":" + d.tmdbId; }
function lerLista(ch){ try{ return JSON.parse(localStorage.getItem(ch || CH_LISTA) || "[]"); }catch(e){ return []; } }
function atualizarBotaoLista(d){
  if(!d) return;
  [["detalhesBtnLista", CH_LISTA, "minha lista"], ["detalhesBtnFav", CH_FAV, "favoritos"]].forEach(([id, ch, nome]) => {
    const b = document.getElementById(id); if(!b) return;
    const dentro = lerLista(ch).some(x => x.k === chaveLista(d));
    b.classList.toggle("ativo", dentro); b.title = (dentro ? "Tirar d" : "Adicionar a") + (ch === CH_FAV ? "os " : "a ") + nome;
  });
}
function alternarNaLista(ch, rotulo){
  const d = detalhesAtualD; if(!d) return;
  let l = lerLista(ch); const k = chaveLista(d), i = l.findIndex(x => x.k === k);
  if(i >= 0){ l.splice(i, 1); avisoPartilha("Tirado de " + rotulo); }
  else { l.unshift({ k: k, cat: d.cat, tmdbId: d.tmdbId, title: d.title, poster: d.poster || "", year: d.year || "", tipoLabel: d.tipoLabel || "" }); avisoPartilha("Adicionado a " + rotulo); }
  try{ localStorage.setItem(ch, JSON.stringify(l)); }catch(e){}
  atualizarBotaoLista(d);
}
document.getElementById("detalhesBtnLista").addEventListener("click", () => alternarNaLista(CH_LISTA, "minha lista"));
document.getElementById("detalhesBtnFav").addEventListener("click", () => alternarNaLista(CH_FAV, "favoritos"));
function abrirDetalhes(d){
  detalhesAtualD = d;
  registrarCliqueHistorico(d);
  montarContinuarAssistindo(); // NOVO: atualiza a faixa "Continuar Assistindo" já com este clique
  registrarAcesso(d);
  renderizarTodosOsMaisAcessados(true); // NOVO: força reler do Firebase, para este acesso já entrar na contagem
  detalhesCapaFundo.style.backgroundImage = d.poster ? `url('${d.poster}')` : "none";
  { const p = document.getElementById("detalhesPoster"); p.src = d.poster || ""; p.style.opacity = d.poster ? 1 : 0;
    const ida = document.getElementById("detalhesIdade"), v = d.idade ? (String(d.idade).toUpperCase() === "L" ? "L" : String(d.idade).replace(/^\+/, "")) : "";
    ida.textContent = v; ida.style.display = v ? "" : "none";
    atualizarBotaoLista(d); }
  detalhesTitulo.textContent = d.title;
  detalhesTipo.textContent = d.tipoLabel || TIPO_LABEL[d.cat] || "";
  detalhesAno.textContent = d.year || "";
  detalhesSinopse.textContent = d.overview || "Sem sinopse disponível.";

  // Série/anime/dorama: ao abrir, atualiza em fundo (número de temporadas, último EP).
  // A UI já abriu com o cache; se a TMDB trouxer dados novos, refresca o seletor.
  if(d.cat === "serie" || d.cat === "anime" || d.cat === "dorama"){
    tmdbDetailsFor(d.cat, d.tmdbId, { forcar: true }).then(fresh => {
      if(!fresh || detalhesAtualD !== d) return;
      if(fresh.seasons && fresh.seasons !== d.seasons){
        d.seasons = fresh.seasons;
        if(typeof preencherSelectTemporadas === "function"){
          try{ preencherSelectTemporadas(d); }catch(e){}
        }else if(detalhesSeasonSelect){
          const atual = detalhesSeasonSelect.value;
          detalhesSeasonSelect.innerHTML = "";
          for(let s = 1; s <= (fresh.seasons || 1); s++){
            const opt = document.createElement("option");
            opt.value = s; opt.textContent = "Temporada " + s;
            detalhesSeasonSelect.appendChild(opt);
          }
          if(atual) detalhesSeasonSelect.value = atual;
        }
      }
      if(fresh.overview) detalhesSinopse.textContent = fresh.overview;
    }).catch(() => {});
  }

  // NOVO: filme continua com um só botão "Assistir Agora" (que agora passa
  // pelo modal de servidor antes de abrir o leitor). Série/anime/dorama
  // troca esse botão por "escolhe a temporada, depois vê os episódios".
  if(d.cat === "filme"){
    detalhesBtnAssistir.style.display = "block";
    detalhesTemporadaBloco.style.display = "none";
    detalhesBtnAssistir.onclick = () => { fecharDetalhes(); abrirModalServidor(d); };
  } else {
    detalhesBtnAssistir.style.display = "none";
    detalhesTemporadaBloco.style.display = "flex";
    const totalSeasons = d.seasons || 1;
    detalhesSeasonSelect.innerHTML = Array.from({length: totalSeasons}, (_,i)=>`<option value="${i+1}">${i+1}</option>`).join("");
    detalhesBtnVerEpisodios.onclick = () => { fecharDetalhes(); abrirTelaEpisodios(d, Number(detalhesSeasonSelect.value)); };
  }

  configurarAcoesEAbasDetalhes(d);
  janelaDetalhes.classList.add("aberto");
  atualizarUrlDetalhes(d); // LINK DIRETO: põe ?cat=...&id=... na barra de endereço
  carregarComentariosDoItem(d);
}

/* ============ AÇÕES (Baixar / Espelhar / Avaliar / Partilhar) + ABAS (Visão geral / Informações / Vídeos) ============ */
let detalhesAbasEstado = { d: null, info: false, videos: false };
function mudarAbaDetalhes(nome){
  document.querySelectorAll("#detalhesAbas .aba-det").forEach(b => b.classList.toggle("ativa", b.dataset.aba === nome));
  document.getElementById("painelDetGeral").style.display = nome === "geral" ? "" : "none";
  document.getElementById("painelDetInfo").style.display = nome === "info" ? "" : "none";
  document.getElementById("painelDetVideos").style.display = nome === "videos" ? "" : "none";
  const d = detalhesAbasEstado.d;
  if(nome === "info" && !detalhesAbasEstado.info){ detalhesAbasEstado.info = true; carregarInfoDetalhes(d); }
  if(nome === "videos" && !detalhesAbasEstado.videos){ detalhesAbasEstado.videos = true; carregarVideosDetalhes(d); }
}
document.querySelectorAll("#detalhesAbas .aba-det").forEach(b => b.addEventListener("click", () => mudarAbaDetalhes(b.dataset.aba)));
async function espelharTela(){
  try{
    if(window.PresentationRequest){ await new PresentationRequest([location.href]).start(); return; }
  }catch(e){ if(e && (e.name === "AbortError" || e.name === "NotAllowedError")) return; }
  avisoPartilha("Para espelhar, usa o \"Transmitir\" / espelhamento de ecrã do teu telemóvel.");
}
function configurarAcoesEAbasDetalhes(d){
  detalhesAbasEstado = { d, info: false, videos: false };
  document.getElementById("painelDetInfo").innerHTML = "";
  document.getElementById("painelDetVideos").innerHTML = "";
  mudarAbaDetalhes("geral");
  document.getElementById("detalhesBtnBaixar").onclick = () => {
    if(d.cat === "filme"){ baixarNo1DM(SERVIDORES[0].filme(d.tmdbId), false, d.title); return; }
    avisoPartilha("Toca no ⬇ do episódio que queres baixar.");
    fecharDetalhes(); abrirTelaEpisodios(d, Number(detalhesSeasonSelect.value) || 1);
  };
  document.getElementById("detalhesBtnEspelhar").onclick = espelharTela;
  document.getElementById("detalhesBtnAvaliar").onclick = () => {
    const el = document.getElementById("comentarioFormBloco");
    if(el) el.scrollIntoView({ behavior: "smooth", block: "center" });
  };
  document.getElementById("detalhesBtnPartilhar2").onclick = () => document.getElementById("partilharDetalhes").click();
}
function elDet(tag, texto, cls){ const e = document.createElement(tag); if(texto != null) e.textContent = texto; if(cls) e.className = cls; return e; }
function linhaDet(rotulo, valor){ const l = elDet("div", null, "det-linha"); l.appendChild(elDet("b", rotulo + ": ")); l.appendChild(document.createTextNode(valor)); return l; }
async function carregarInfoDetalhes(d){
  const box = document.getElementById("painelDetInfo");
  const kind = TMDB_KIND[d.cat];
  if(!d || !kind || !/^\d+$/.test(String(d.tmdbId))){ box.textContent = "Sem informações adicionais."; return; }
  box.textContent = "A carregar…";
  try{
    const [det, cr] = await Promise.all([ tmdb(`/${kind}/${d.tmdbId}`), tmdb(`/${kind}/${d.tmdbId}/credits`) ]);
    if(detalhesAtualD !== d) return;
    box.innerHTML = "";
    if(det && det.tagline) box.appendChild(elDet("div", det.tagline, "det-linha"));
    if(det && det.genres && det.genres.length){ const c = elDet("div", null, "det-chips"); det.genres.forEach(g => c.appendChild(elDet("span", g.name))); box.appendChild(c); }
    const dur = det && (det.runtime || (det.episode_run_time && det.episode_run_time[0]));
    if(dur) box.appendChild(linhaDet("Duração", dur + " min" + (kind === "tv" ? " por episódio" : "")));
    if(det && det.number_of_seasons) box.appendChild(linhaDet("Temporadas", det.number_of_seasons + " · " + (det.number_of_episodes || "?") + " episódios"));
    if(det && det.status) box.appendChild(linhaDet("Estado", det.status));
    if(det && det.vote_average) box.appendChild(linhaDet("Nota TMDB", det.vote_average.toFixed(1) + " / 10"));
    const paises = det && ((det.production_countries || []).map(p => p.name).join(", "));
    if(paises) box.appendChild(linhaDet("País", paises));
    const crew = (cr && cr.crew) || [];
    const dir = kind === "movie" ? crew.filter(p => p.job === "Director").map(p => p.name) : ((det && det.created_by) || []).map(p => p.name);
    if(dir.length) box.appendChild(linhaDet(kind === "movie" ? "Direção" : "Criação", dir.join(", ")));
    const cast = ((cr && cr.cast) || []).slice(0, 15);
    if(cast.length){
      const tit = elDet("div", "Elenco", "det-linha"); tit.style.color = "var(--ink)"; tit.style.fontWeight = "600"; box.appendChild(tit);
      const fila = elDet("div", null, "det-elenco");
      cast.forEach(p => {
        const a = elDet("div", null, "det-ator");
        if(p.profile_path){ const im = document.createElement("img"); im.loading = "lazy"; im.alt = p.name; im.src = "https://image.tmdb.org/t/p/w185" + p.profile_path; a.appendChild(im); }
        else a.appendChild(elDet("div", null, "sem-foto"));
        a.appendChild(elDet("div", p.name)); if(p.character) a.appendChild(elDet("small", p.character));
        fila.appendChild(a);
      });
      box.appendChild(fila);
    }
    if(!box.childNodes.length) box.textContent = "Sem informações adicionais.";
  }catch(e){ box.textContent = "Não foi possível carregar as informações."; }
}
async function carregarVideosDetalhes(d){
  const box = document.getElementById("painelDetVideos");
  const kind = d && TMDB_KIND[d.cat];
  if(!d || !kind){ box.textContent = "Sem vídeos."; return; }
  box.textContent = "A carregar…";
  try{
    // títulos publicados à mão não têm id da TMDB: procura pelo nome
    let id = String(d.tmdbId);
    if(!/^\d+$/.test(id)){
      const b = await tmdb(`/search/${kind}?query=${encodeURIComponent(d.title || "")}&language=pt-BR`);
      id = b && b.results && b.results[0] ? String(b.results[0].id) : "";
      if(!id){ box.textContent = "Sem trailer disponível."; return; }
    }
    let r = await tmdb(`/${kind}/${id}/videos?language=pt-BR&include_video_language=pt,en,null`);
    let yt = ((r && r.results) || []).filter(v => v.site === "YouTube");
    if(!yt.length){ r = await tmdb(`/${kind}/${id}/videos`); yt = ((r && r.results) || []).filter(v => v.site === "YouTube"); }
    if(detalhesAtualD !== d) return;
    const peso = v => (v.type === "Trailer" ? 0 : v.type === "Teaser" ? 10 : 20) + (v.iso_639_1 === "pt" ? 0 : v.iso_639_1 === "en" ? 1 : 2) + (v.official ? 0 : 3);
    const v = yt.sort((a, b) => peso(a) - peso(b))[0]; // só um trailer
    box.innerHTML = "";
    if(!v){ box.textContent = "Sem trailer disponível."; return; }
    const cx = elDet("div", null, "det-video");
    const im = document.createElement("img"); im.alt = v.name; im.src = "https://img.youtube.com/vi/" + encodeURIComponent(v.key) + "/hqdefault.jpg";
    cx.appendChild(im); cx.appendChild(elDet("div", "▶", "tocar"));
    cx.onclick = () => {
      const f = document.createElement("iframe");
      f.src = "https://www.youtube-nocookie.com/embed/" + encodeURIComponent(v.key) + "?autoplay=1&rel=0&playsinline=1&modestbranding=1";
      f.allow = "autoplay; encrypted-media; picture-in-picture; fullscreen";
      f.referrerPolicy = "strict-origin-when-cross-origin";
      f.allowFullscreen = true; cx.innerHTML = ""; cx.appendChild(f); cx.onclick = null;
    };
    box.appendChild(cx);
    box.appendChild(elDet("div", (v.type || "Vídeo") + " · " + v.name, "det-video-nome"));
    // se o leitor do YouTube não abrir dentro do app, abre no YouTube
    const a = document.createElement("a");
    a.className = "det-video-yt"; a.target = "_blank"; a.rel = "noopener";
    a.href = "https://www.youtube.com/watch?v=" + encodeURIComponent(v.key);
    a.textContent = "▶ Abrir no YouTube";
    box.appendChild(a);
  }catch(e){ box.textContent = "Não foi possível carregar o trailer."; }
}
document.getElementById("fecharDetalhes").addEventListener("click", fecharDetalhes);
const btnPartilharDetalhes = document.getElementById("partilharDetalhes");
btnPartilharDetalhes.innerHTML = SVG_PARTILHAR.replace('width="14" height="14"', 'width="18" height="18"');
btnPartilharDetalhes.addEventListener("click", () => partilharTitulo(detalhesAtualD));
function fecharDetalhes(){
  janelaDetalhes.classList.remove("aberto");
  pararComentariosAoFechar();
  limparUrlDetalhes(); // LINK DIRETO: volta a URL para a página inicial
}

/* ============ LINK DIRETO ============
   Cada título tem um link próprio: seusite.com/?cat=filme&id=634649
   Quem abrir esse link cai direto na capa do título. */
function atualizarUrlDetalhes(d){
  try{
    if(!d || !d.cat || !d.tmdbId) return;
    const nova = "?cat=" + encodeURIComponent(d.cat) + "&id=" + encodeURIComponent(d.tmdbId);
    if(location.search !== nova) history.pushState({cat: d.cat, id: d.tmdbId}, "", nova);
  }catch(e){}
}
function limparUrlDetalhes(){
  try{
    if(location.search.includes("id=")) history.pushState({}, "", location.pathname);
  }catch(e){}
}
async function abrirDetalhesPelaUrl(){
  const q = new URLSearchParams(location.search);
  const cat = q.get("cat"), id = q.get("id");
  const t = Number(q.get("t")), ep = Number(q.get("ep"));
  if(!cat || !id){ fecharTudoPelaUrl(); return; }
  const d = await tmdbDetailsFor(cat, id);
  if(!d) return;
  if((cat !== "filme" && t > 0 && ep > 0) || (cat === "filme" && q.get("play"))){
    // link de episódio: abre direto o leitor naquele episódio
    janelaDetalhes.classList.remove("aberto");
    abrirComFallback({ ...d, temporadaEscolhida: t, episodioEscolhido: ep });
  } else {
    if(overlay.classList.contains("open")) document.getElementById("closePlayer").click();
    abrirDetalhes(d);
  }
}
function fecharTudoPelaUrl(){
  if(overlay.classList.contains("open")) document.getElementById("closePlayer").click();
  janelaDetalhes.classList.remove("aberto");
  pararComentariosAoFechar();
  telaEpisodios.classList.remove("aberta");
}
// Filme no leitor: ?cat=filme&id=123&play=1  (a capa continua em ?cat=filme&id=123)
function atualizarUrlFilmePlayer(d){
  try{
    const nova = "?cat=" + encodeURIComponent(d.cat) + "&id=" + encodeURIComponent(d.tmdbId) + "&play=1";
    if(location.search !== nova) history.pushState({}, "", nova);
  }catch(e){}
}
// Episódio atual na URL: ?cat=serie&id=123&t=1&ep=3
function atualizarUrlEpisodio(){
  try{
    if(!dPlayerAtual || dPlayerAtual.cat === "filme") return;
    const nova = "?cat=" + encodeURIComponent(dPlayerAtual.cat) + "&id=" + encodeURIComponent(dPlayerAtual.tmdbId)
               + "&t=" + seasonSelect.value + "&ep=" + episodeSelect.value;
    if(location.search === nova) return;
    // 1ª vez que entra no leitor = nova entrada no histórico; trocar de episódio = só atualiza
    if(new URLSearchParams(location.search).get("ep")) history.replaceState({}, "", nova);
    else history.pushState({}, "", nova);
  }catch(e){}
}
window.addEventListener("popstate", () => { abrirDetalhesPelaUrl(); });


/* ============ LISTA DE EPISÓDIOS (entre o ecrã de detalhes e o modal de
   servidor) — busca os episódios reais da temporada escolhida na TMDB
   (nome, sinopse e miniatura de cada episódio), em vez de só uma lista de
   números. ============ */
const telaEpisodios = document.getElementById("telaEpisodios");
const episodiosTitulo = document.getElementById("episodiosTitulo");
const episodiosLista = document.getElementById("episodiosLista");
const STILL = caminho => caminho ? `https://image.tmdb.org/t/p/w300${caminho}` : null;

async function abrirTelaEpisodios(d, temporada){
  episodiosTitulo.textContent = `${d.title} · Temporada ${temporada}`;
  episodiosLista.innerHTML = '<p class="loading">A carregar episódios…</p>';
  telaEpisodios.classList.add("aberta");

  // Sempre rede: EP lançado há minutos tem de aparecer nesta lista
  const dados = await tmdb(`/tv/${d.tmdbId}/season/${temporada}`, { redePrimeiro: true });
  const episodios = (dados && Array.isArray(dados.episodes)) ? dados.episodes : [];

  if(!episodios.length){
    // Sem dados de episódios na TMDB para esta temporada — mesmo assim
    // deixa continuar, com uma lista genérica de 1 a 30, para a pessoa não
    // ficar travada sem conseguir escolher nenhum episódio.
    episodiosLista.innerHTML = "";
    for(let n = 1; n <= 30; n++){
      episodiosLista.appendChild(criarLinhaEpisodio(d, temporada, { episode_number: n, name: `Episódio ${n}` }));
    }
    return;
  }

  episodiosLista.innerHTML = "";
  episodios.forEach(ep => episodiosLista.appendChild(criarLinhaEpisodio(d, temporada, ep)));
}

function criarLinhaEpisodio(d, temporada, ep){
  const linha = document.createElement("div");
  linha.className = "episodio-linha";
  linha._ep = ep; // guarda os dados da TMDB: se um episódio publicado à mão tomar o lugar, mantém título, imagem, data e sinopse

  const thumbUrl = STILL(ep.still_path) || d.poster;
  const dataFormatada = ep.air_date ? new Date(ep.air_date + "T00:00:00").toLocaleDateString("pt-BR") : "";

  linha.innerHTML = `
    <div class="episodio-thumb" style="${thumbUrl ? `background-image:url('${thumbUrl}')` : ""}">
      <span class="episodio-play">▶</span>
    </div>
    <div class="episodio-info">
      <div class="episodio-num-nome">EP ${temporada}x${ep.episode_number} — ${ep.name || "Sem título"}</div>
      <div class="episodio-data">${dataFormatada}</div>
      <div class="episodio-sinopse">${ep.overview || "Sem sinopse disponível."}</div>
    </div>
    <button class="episodio-baixar" title="Baixar">⬇</button>
    <button class="episodio-partilhar" title="Partilhar episódio">${SVG_PARTILHAR}</button>
  `;

  // ⬇ do episódio: manda direto para o 1DM, sem precisar de assistir primeiro
  linha.querySelector(".episodio-baixar").addEventListener("click", e => {
    e.stopPropagation();
    baixarNo1DM(SERVIDORES[0].serie(d.tmdbId, temporada, ep.episode_number, d.cat), false, d.title + " T" + temporada + " EP" + ep.episode_number);
  });
  linha.querySelector(".episodio-partilhar").addEventListener("click", e => {
    e.stopPropagation();
    partilharTitulo(d, temporada, ep.episode_number, ep.name);
  });

  linha.addEventListener("click", () => {
    telaEpisodios.classList.remove("aberta");
    abrirModalServidor(d, temporada, ep.episode_number);
  });

  return linha;
}
document.getElementById("fecharTelaEpisodios").addEventListener("click", () => {
  telaEpisodios.classList.remove("aberta");
});

/* ============ MODAL DE SERVIDOR — passo final antes do leitor abrir, para
   filme (direto do "Assistir Agora") e para série/anime/dorama (depois de
   escolher o episódio). Guarda o que falta reproduzir em pendenteParaAbrir
   e só chama openPlayer() quando a pessoa escolhe "Servidor 1". ============ */
const modalServidor = document.getElementById("modalServidor");
const servidorTitulo = document.getElementById("servidorTitulo");
const modalServidorLista = document.getElementById("modalServidorLista");
let pendenteParaAbrir = null;

function abrirModalServidor(d, temporada, episodio){
  const payload = temporada
    ? { ...d, temporadaEscolhida: temporada, episodioEscolhido: episodio }
    : d;
  if(temporada && episodio){
    try{ registrarCliqueHistorico(payload); montarContinuarAssistindo(); }catch(e){}
  }

  abrirComFallback(payload);
}
// Lógica pedida: se não tem servidor 1, abre o 2; se não tem o 2, abre o 3...
// Mostra o nome de cada servidor enquanto verifica; no fim abre o 1º que responde.
function abrirComFallback(payload){
  // Abre sempre direto na SuperFlix (servidor 1). Os servidores em inglês só
  // abrem se a pessoa escolher no botão 🌐 "Em inglês".
  openPlayer({ ...payload, servidorIdx: 0 });
}
function trocarServidor(i){
  if(i === servidorAtual || !dPlayerAtual) return;
  servidorAtual = i;
  barraPronta = false;
  if(dPlayerAtual.cat === "filme"){
    playerFrame.src = SERVIDORES[i].filme(dPlayerAtual.tmdbId);
    mostrarMascaraTopoIframe();
    desenharBarraServidores();
  } else {
    updateSeriesFrame(dPlayerAtual.tmdbId);
  }
}
/* Faixa por baixo do vídeo: nome do título + servidor atual + botões para
   trocar de servidor à mão (se o vídeo não carregar dentro do iframe, que
   é de outro site e não dá para detetar por código). */
function desenharBarraServidores(){
  const btn = document.getElementById("btnSemLegenda");
  const menu = document.getElementById("menuSemLegenda");
  const btnVoltar = document.getElementById("btnVoltarServidor");
  const faixa = document.getElementById("playerServidores");
  if(faixa) faixa.style.display = "none"; // a faixa de baixo já não é usada
  if(!btn || !menu || !dPlayerAtual) return;
  const idxPt = SERVIDORES.findIndex(x => x.grupo === "pt");
  const noGlobal = SERVIDORES[servidorAtual].grupo !== "pt";
  btnVoltar.style.display = (noGlobal && idxPt >= 0) ? "flex" : "none";
  btnVoltar.onclick = () => trocarServidor(idxPt);
  const globais = SERVIDORES.map((srv, i) => ({ srv, i })).filter(x => x.srv.grupo === "global");
  // O botão 🌐 aparece junto com o embed principal (depois de carregar)
  btn.style.display = (globais.length && !noGlobal && barraPronta) ? "flex" : "none"; // já escolheu um servidor global → o 🌐 some (a seta ← serve para voltar)
  menu.innerHTML = "";
  menu.style.display = "none";
  const h = document.createElement("div");
  h.className = "ps-cabecalho";
  h.textContent = "Servidores em inglês";
  menu.appendChild(h);
  globais.forEach(({ srv, i }) => {
    const b = document.createElement("button");
    b.className = "ps-linha" + (i === servidorAtual ? " ativo" : "");
    b.innerHTML = '<span class="ps-icone"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="3"/><path d="M10 9l5 3-5 3z" fill="currentColor"/></svg></span>'
      + '<span class="ps-texto"><b></b><small>Inglês · original, sem dublagem</small></span><span class="ps-seta">›</span>';
    b.querySelector("b").textContent = srv.nome;
    b.onclick = () => { menu.style.display = "none"; trocarServidor(i); };
    menu.appendChild(b);
  });
  btn.onclick = () => { menu.style.display = menu.style.display === "none" ? "block" : "none"; };
}
// A lista só aparece quando o embed principal já carregou — aparecem os dois juntos.
playerFrame.addEventListener("load", () => {
  const src = playerFrame.getAttribute("src") || "";
  if(!/^https?:/.test(src) || !dPlayerAtual) return;
  if(SERVIDORES[servidorAtual].grupo !== "pt") return;
  if(!barraPronta){ barraPronta = true; desenharBarraServidores(); }
});
document.getElementById("fecharModalServidor").addEventListener("click", () => {
  modalServidor.classList.remove("aberto");
  pendenteParaAbrir = null;
});

let comentariosRefAtual = null;
let comentariosListenerAtual = null;
let estrelaSelecionadaComentario = 0;

function chaveComentariosDoItem(d){
  // Firebase não aceita '.', '#', '$', '[' , ']', '/' nas chaves.
  return `${d.cat}_${d.tmdbId}`;
}

const comentarioEstrelasInput = document.getElementById("comentarioEstrelasInput");
comentarioEstrelasInput.querySelectorAll(".estrela-input").forEach(el => {
  el.addEventListener("click", () => selecionarEstrelaComentario(Number(el.dataset.valor)));
});
function selecionarEstrelaComentario(valor){
  estrelaSelecionadaComentario = valor;
  comentarioEstrelasInput.querySelectorAll(".estrela-input").forEach(el => {
    el.classList.toggle("selecionada", Number(el.dataset.valor) <= valor);
  });
}

function formatarDataComentario(timestamp){
  if(!timestamp) return "";
  const dt = new Date(timestamp);
  const dois = n => String(n).padStart(2, "0");
  return `${dois(dt.getDate())}/${dois(dt.getMonth()+1)}/${dt.getFullYear()} ${dois(dt.getHours())}:${dois(dt.getMinutes())}`;
}

// Só quem tem conta iniciada vê o formulário; os outros veem o convite para iniciar conta.
function atualizarFormComentario(){
  const formEl = document.getElementById("comentarioFormBloco");
  const loginEl = document.getElementById("comentarioLoginBloco");
  if(!formEl || !loginEl || !firebaseAtivo) return;
  const logado = (typeof usuarioAtual !== "undefined") && !!usuarioAtual;
  formEl.style.display = logado ? "block" : "none";
  loginEl.style.display = logado ? "none" : "block";
}
document.getElementById("btnComentarIniciarConta").addEventListener("click", () => profileBtn.click());
function escaparNomeComentario(t){ return String(t || "").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"); }
// Avatar do comentário: inicial do nome; se houver link de foto, a foto fica por cima (se falhar, a inicial continua)
function avatarComentarioHtml(c, nome){
  const inicial = escaparNomeComentario(nome.charAt(0).toUpperCase());
  const foto = (!c.oficial && c.foto && /^https?:\/\/\S+$/i.test(c.foto)) ? escaparNomeComentario(c.foto) : "";
  return `<div class="comentario-avatar">${inicial}${foto ? `<img src="${foto}" referrerpolicy="no-referrer" loading="lazy" onerror="this.remove()" alt="">` : ""}</div>`;
}

function carregarComentariosDoItem(d){
  pararComentariosAoFechar();
  estrelaSelecionadaComentario = 0;
  comentarioEstrelasInput.querySelectorAll(".estrela-input").forEach(el => el.classList.remove("selecionada"));
  document.getElementById("comentarioTextoInput").value = "";

  const avisoEl = document.getElementById("comentariosAvisoDesligado");
  const formEl = document.getElementById("comentarioFormBloco");
  const listaEl = document.getElementById("listaComentarios");
  const mediaEl = document.getElementById("comentariosMedia");

  if(!firebaseAtivo){
    avisoEl.style.display = "block";
    formEl.style.display = "none";
    listaEl.innerHTML = "";
    mediaEl.textContent = "";
    return;
  }
  avisoEl.style.display = "none";
  atualizarFormComentario();

  const chave = chaveComentariosDoItem(d);
  comentariosRefAtual = dbComentarios().ref("comentarios/" + chave);
  comentariosListenerAtual = comentariosRefAtual.on("value", snapshot => {
    const dados = snapshot.val() || {};
    const lista = Object.entries(dados).map(([k,v]) => Object.assign({}, v, { _id: k })).sort((a,b) => (b.data||0) - (a.data||0));
    renderizarListaComentarios(lista);
    sincronizarMeusComentarios(snapshot, d);
  }, erro => {
    console.warn("Não consegui carregar os comentários:", erro);
    listaEl.innerHTML = '<p class="comentario-vazio">Não foi possível carregar os comentários agora.</p>';
  });
}

// Comentários feitos antes de existir a faixa "Comentários recentes" não estão no nó global.
// Quando o autor abre o título, copia-os para lá (uma vez, só se ainda não existirem).
function sincronizarMeusComentarios(snapshot, d){
  try{
    const uid = (typeof usuarioAtual !== "undefined" && usuarioAtual) ? usuarioAtual.uid : null;
    if(!uid || !firebaseAtivo || !d) return;
    snapshot.forEach(filho => {
      const c = filho.val();
      if(!c || c.uid !== uid) return;
      const ref = dbComentarios().ref("ultimosComentarios/" + filho.key);
      ref.once("value").then(existente => {
        if(existente.exists()) return;
        return ref.set(Object.assign({}, c, {
          cat: d.cat, tmdbId: d.tmdbId, titulo: d.title, poster: d.poster || "",
          tipoLabel: d.tipoLabel || TIPO_LABEL[d.cat] || "", year: d.year || ""
        }));
      }).catch(() => {});
    });
  }catch(e){}
}

function pararComentariosAoFechar(){
  if(comentariosRefAtual && comentariosListenerAtual) comentariosRefAtual.off("value", comentariosListenerAtual);
  comentariosRefAtual = null;
  comentariosListenerAtual = null;
}

/* ---- Conta oficial: aparece só como "Webplay" com selo de verificado (sem mostrar o e-mail) ---- */
const EMAIL_OFICIAL = "xenonff800@gmail.com";
const SELO_VERIFICADO = '<svg class="selo-verif" viewBox="0 0 24 24" width="16" height="16" role="img" aria-label="Verificado"><path fill="#3897f0" d="M12 1.5l2.6 1.9 3.2-.2 1 3 2.7 1.8-.9 3.1.9 3.1-2.7 1.8-1 3-3.2-.2L12 22.5l-2.6-1.9-3.2.2-1-3L2.5 16l.9-3.1-.9-3.1 2.7-1.8 1-3 3.2.2z"/><path d="M8 12.2l2.7 2.7L16 9.6" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
const AVISO_OFICIAL = "Pedimos respeito nos comentários e que utilizem este espaço para compartilhar opiniões e experiências sobre o aplicativo.";
function ehOficialAtual(){ try{ return !!(usuarioAtual && (usuarioAtual.email || "").toLowerCase() === EMAIL_OFICIAL); }catch(e){ return false; } }
function nomeComentarioHtml(c, nome){ return escaparNomeComentario(c.oficial ? "Webplay" : nome) + (c.oficial ? SELO_VERIFICADO : ""); }
function estrelasCheias(n){ n = Math.max(0, Math.min(5, Number(n)||0)); return "★".repeat(n) + '<span class="cmt-vazias">' + "★".repeat(5-n) + "</span>"; }
let comentariosVerTodos = false;
function renderizarListaComentarios(lista){
  const listaEl = document.getElementById("listaComentarios");
  const mediaEl = document.getElementById("comentariosMedia");
  const btnTodas = document.getElementById("btnVerTodasComent");
  // aviso fixo da Webplay, sempre no topo
  const fixo = `
    <div class="cmt cmt-oficial">
      <div class="cmt-topo">
        <div class="comentario-avatar">W</div>
        <div class="cmt-quem"><div class="cmt-nome">Webplay${SELO_VERIFICADO}</div></div>
        <span class="cmt-data">Fixado</span>
      </div>
      <div class="cmt-texto">${AVISO_OFICIAL}</div>
    </div>`;
  if(!lista.length){
    listaEl.innerHTML = fixo + '<p class="comentario-vazio">Ainda não há comentários. Sê o primeiro!</p>';
    mediaEl.textContent = ""; if(btnTodas) btnTodas.style.display = "none";
    return;
  }
  const soma = lista.reduce((acc,c) => acc + (Number(c.estrelas)||0), 0);
  const media = soma / lista.length;
  mediaEl.textContent = `★ ${media.toFixed(1)} (${lista.length} ${lista.length===1?"avaliação":"avaliações"})`;
  const mostrar = comentariosVerTodos ? lista : lista.slice(0, 3);
  if(btnTodas){ btnTodas.style.display = lista.length > 3 ? "" : "none"; btnTodas.textContent = comentariosVerTodos ? "Ver menos ‹" : "Ver todas ›"; }
  listaEl.innerHTML = fixo + mostrar.map(c => {
    const nome = (c.nome || "Anónimo").trim();
    const texto = escaparTextoComentario(c.texto || "");
    const longo = texto.length > 140;
    const nota = (Number(c.estrelas)||0).toFixed(1).replace(".", ",");
    return `
      <div class="cmt${c.oficial ? " cmt-oficial" : ""}"${c._id ? ` data-cid="${escaparNomeComentario(c._id)}"` : ""}>
        <div class="cmt-topo">
          ${avatarComentarioHtml(c, c.oficial ? "Webplay" : nome)}
          <div class="cmt-quem">
            <div class="cmt-nome">${nomeComentarioHtml(c, nome)}</div>
            <div class="cmt-estr">${estrelasCheias(c.estrelas)}<b>${nota}</b></div>
          </div>
          <span class="cmt-data">${formatarDataComentario(c.data)}</span>
        </div>
        ${texto ? `<div class="cmt-texto${longo ? " cmt-curto" : ""}">${texto}</div>${longo ? '<button type="button" class="cmt-mais">Ver mais</button>' : ""}` : ""}
        ${c._id ? `<div class="cmt-rodape"><button type="button" class="btn-voto" data-voto="util">${ICONE_UTIL} Útil <b>0</b></button></div>` : ""}
      </div>`;
  }).join("");
  listaEl.querySelectorAll(".cmt-mais").forEach(b => b.onclick = () => {
    const t = b.previousElementSibling; const curto = t.classList.toggle("cmt-curto"); b.textContent = curto ? "Ver mais" : "Ver menos";
  });
  try{ ligarVotos(listaEl); }catch(e){}
}
document.getElementById("btnVerTodasComent").addEventListener("click", () => {
  comentariosVerTodos = !comentariosVerTodos;
  if(comentariosRefAtual) comentariosRefAtual.once("value").then(snap => {
    const dados = snap.val() || {};
    renderizarListaComentarios(Object.entries(dados).map(([k,v]) => Object.assign({}, v, { _id: k })).sort((a,b) => (b.data||0) - (a.data||0)));
  });
});

document.getElementById("btnEnviarComentario").addEventListener("click", () => {
  if(!firebaseAtivo || !comentariosRefAtual){ alert("Os comentários ainda não estão ligados neste site."); return; }
  if(estrelaSelecionadaComentario < 1){ alert("Escolhe pelo menos 1 estrela antes de publicar."); return; }

  if(!usuarioAtual){ atualizarFormComentario(); profileBtn.click(); return; } // sem conta não há comentários
  const oficial = ehOficialAtual();
  let nome = (usuarioAtual.displayName || (usuarioAtual.email || "").split("@")[0] || "Utilizador").trim();
  if(oficial) nome = "Webplay";                                   // a conta oficial aparece só como "Webplay" (sem e-mail)
  else if(/webplay/i.test(nome)) nome = "Utilizador";             // ninguém mais se pode passar pela Webplay
  const foto = oficial ? "" : fotoUsuario(usuarioAtual);
  const uid = usuarioAtual.uid;
  const texto = (document.getElementById("comentarioTextoInput").value || "").trim();
  const btnEnviar = document.getElementById("btnEnviarComentario");
  btnEnviar.disabled = true; btnEnviar.textContent = "A publicar...";

  // O mesmo id é usado no nó do título e no nó global, para que os votos
  // "útil / não útil" sejam os mesmos em qualquer sítio onde o comentário aparece.
  const novoId = comentariosRefAtual.push().key;
  comentariosRefAtual.child(novoId).set(Object.assign({
    nome, foto, uid, estrelas: estrelaSelecionadaComentario, texto,
    data: firebase.database.ServerValue.TIMESTAMP
  }, oficial ? { oficial: true } : {})).then(() => {
    if(detalhesAtualD){
      dbComentarios().ref("ultimosComentarios/" + novoId).set({
        nome, foto, uid, oficial: oficial || null, estrelas: estrelaSelecionadaComentario, texto,
        data: firebase.database.ServerValue.TIMESTAMP,
        cat: detalhesAtualD.cat, tmdbId: detalhesAtualD.tmdbId,
        titulo: detalhesAtualD.title, poster: detalhesAtualD.poster,
        tipoLabel: detalhesAtualD.tipoLabel || TIPO_LABEL[detalhesAtualD.cat] || "",
        year: detalhesAtualD.year || ""
      }).catch(erro => console.warn("Não consegui atualizar os comentários recentes:", erro));
    }
    document.getElementById("comentarioTextoInput").value = "";
    selecionarEstrelaComentario(0);
  }).catch(erro => {
    alert("Não consegui publicar o comentário: " + erro.message);
  }).finally(() => {
    btnEnviar.disabled = false; btnEnviar.textContent = "Publicar comentário";
  });
});

/* ============ ÚLTIMAS AVALIAÇÕES (faixa na Início) — lê o nó global
   "ultimosComentarios" (ver acima), em tempo real, e mostra os mais
   recentes de qualquer título. Clicar num cartão abre a ficha daquele
   título (reconstruída só com os dados que foram guardados junto do
   comentário — o suficiente pra abrir a ficha e recarregar os comentários
   certos). ============ */
function uidAtual(){ try{ return usuarioAtual ? usuarioAtual.uid : null; }catch(e){ return null; } }
function escaparTextoComentario(t){ return String(t || "").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;"); }

/* --- Votos "útil / não útil": votosComentarios/<idComentario>/<uid> = "util" | "inutil" --- */
const votosCache = {};      // idComentario -> { uid: "util"|"inutil" }
const votosOuvintes = {};   // idComentario -> true (já a ouvir)
function pintarVotosDoCartao(el){
  const id = el.dataset.cid; if(!id) return;
  const v = votosCache[id] || {};
  let util = 0, inutil = 0;
  Object.values(v).forEach(x => { if(x === "util") util++; else if(x === "inutil") inutil++; });
  const meu = v[uidAtual()];
  const bu = el.querySelector('.btn-voto[data-voto="util"]');
  const bn = el.querySelector('.btn-voto[data-voto="inutil"]');
  if(bu){ bu.querySelector("b").textContent = util;   bu.classList.toggle("marcado", meu === "util"); }
  if(bn){ bn.querySelector("b").textContent = inutil; bn.classList.toggle("marcado", meu === "inutil"); }
}
function ligarVotos(container){
  if(!firebaseAtivo) return;
  container.querySelectorAll("[data-cid]").forEach(el => {
    const id = el.dataset.cid;
    pintarVotosDoCartao(el);
    if(votosOuvintes[id]) return;
    votosOuvintes[id] = true;
    dbComentarios().ref("votosComentarios/" + id).on("value", snap => {
      votosCache[id] = snap.val() || {};
      document.querySelectorAll('[data-cid="' + id + '"]').forEach(pintarVotosDoCartao);
    }, erro => console.warn("Não consegui ler os votos:", erro));
  });
}
function repintarTodosOsVotos(){ document.querySelectorAll("[data-cid]").forEach(pintarVotosDoCartao); }
document.addEventListener("click", e => {
  const btn = e.target.closest(".btn-voto");
  if(!btn) return;
  e.stopPropagation(); // não abrir a ficha do título ao votar
  const el = btn.closest("[data-cid]");
  if(!el || !firebaseAtivo) return;
  if(!usuarioAtual){ profileBtn.click(); return; } // sem conta não há votos
  const id = el.dataset.cid, tipo = btn.dataset.voto;
  const ref = dbComentarios().ref("votosComentarios/" + id + "/" + usuarioAtual.uid);
  const uid = usuarioAtual.uid;
  const atual = (votosCache[id] || {})[uid];
  const definir = valor => {
    votosCache[id] = votosCache[id] || {};
    if(valor) votosCache[id][uid] = valor; else delete votosCache[id][uid];
    document.querySelectorAll('[data-cid="' + id + '"]').forEach(pintarVotosDoCartao);
  };
  definir(atual === tipo ? null : tipo); // mostra logo, sem esperar pelo Firebase
  (atual === tipo ? ref.remove() : ref.set(tipo)).catch(erro => {
    definir(atual || null);
    alert("Não consegui registar o voto: " + erro.message);
  });
}, true);

const ICONE_UTIL = '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>';
const ICONE_INUTIL = '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/></svg>';

/* --- Cartão de comentário: título da série, data, estrelas, texto e útil/não útil --- */
function htmlCartaoComentario(c){
  const nome = (c.nome || "Anónimo").trim();
  const estrelasQtd = Math.max(0, Math.min(5, Number(c.estrelas)||0));
  const estrelasHtml = "★".repeat(estrelasQtd) + "☆".repeat(5-estrelasQtd);
  const textoSeguro = escaparTextoComentario(c.texto);
  const tituloSeguro = escaparTextoComentario(c.titulo);
  const tipo = (c.tipoLabel || TIPO_LABEL[c.cat] || "").toUpperCase();
  const ano = c.year || "";
  const poster = c.poster || "";
  const tags = [tipo ? `<span class="selo-tipo">${tipo}</span>` : "", ano].filter(Boolean).join(" · ");
  return `
    <div class="avaliacao-card" data-cid="${escaparNomeComentario(c._id || "")}" data-cat="${escaparNomeComentario(c.cat)}" data-id="${escaparNomeComentario(c.tmdbId)}">
      <div class="avaliacao-titulo-bloco">
        ${poster ? `<img class="avaliacao-poster-mini" src="${escaparNomeComentario(poster)}" alt="" loading="lazy" onerror="this.style.display='none'">` : ""}
        <div class="avaliacao-titulo-info">
          <div class="avaliacao-titulo-nome">${tituloSeguro}</div>
          <div class="avaliacao-titulo-tags">${tags}</div>
        </div>
      </div>
      <div class="avaliacao-cabecalho">
        ${avatarComentarioHtml(c, c.oficial ? "Webplay" : nome)}
        <div class="avaliacao-meta-user">
          <div class="comentario-nome">${nomeComentarioHtml(c, nome)}</div>
          <div>
            <span class="comentario-estrelas-exibidas">${estrelasHtml}</span>
            <span class="comentario-data">${formatarDataComentario(c.data)}</span>
          </div>
        </div>
      </div>
      ${textoSeguro ? `<div class="comentario-texto">${textoSeguro}</div>` : ""}
      ${c._id ? `<div class="avaliacao-votos">
        <span class="votos-pergunta">Foi útil?</span>
        <button type="button" class="btn-voto" data-voto="util">${ICONE_UTIL} Útil <b>0</b></button>
        <button type="button" class="btn-voto" data-voto="inutil">${ICONE_INUTIL} Não útil <b>0</b></button>
      </div>` : ""}
    </div>`;
}
function montarCartoesComentarios(container, lista, aoAbrir){
  container.innerHTML = lista.map(htmlCartaoComentario).join("");
  container.querySelectorAll(".avaliacao-card").forEach((el, i) => {
    el.addEventListener("click", () => {
      const c = lista[i];
      if(aoAbrir) aoAbrir();
      abrirDetalhes({ cat: c.cat, tmdbId: c.tmdbId, title: c.titulo, poster: c.poster, tipoLabel: c.tipoLabel, year: c.year });
    });
  });
  ligarVotos(container);
}
function listaDeSnapshotComentarios(snapshot){
  const lista = [];
  snapshot.forEach(filho => { lista.push(Object.assign({}, filho.val(), { _id: filho.key })); });
  return lista;
}
// ordem: "recentes" (agora). Quando quiseres "mais úteis", é só juntar aqui outro critério.
function ordenarComentarios(lista, ordem){
  return lista.slice().sort((a,b) => (b.data||0) - (a.data||0));
}

// Comentários apagados do nó do título (ex.: direto no Firebase) deixam de aparecer aqui,
// e a cópia órfã no nó global é removida (se o Firebase permitir).
function filtrarComentariosExistentes(lista){
  return Promise.all(lista.map(c => {
    if(!c || !c._id || !c.cat || !c.tmdbId) return Promise.resolve(c);
    return dbComentarios().ref("comentarios/" + c.cat + "_" + c.tmdbId + "/" + c._id).once("value").then(s => {
      if(s.exists()) return c;
      dbComentarios().ref("ultimosComentarios/" + c._id).remove().catch(() => {});
      return null;
    }).catch(() => c);
  })).then(r => r.filter(Boolean));
}
function iniciarListenerUltimasAvaliacoes(){
  if(!firebaseAtivo) return;
  const linha = document.getElementById("linha-ultimas-avaliacoes");
  if(linha) linha.style.display = "";
  dbComentarios().ref("ultimosComentarios").limitToLast(10).on("value", snapshot => {
    filtrarComentariosExistentes(ordenarComentarios(listaDeSnapshotComentarios(snapshot), "recentes")).then(renderizarUltimasAvaliacoes);
  }, erro => {
    console.warn("Não consegui carregar os comentários recentes:", erro);
    const track = document.getElementById("ultimas-avaliacoes-track");
    if(track) track.innerHTML = '<p class="comentario-vazio" style="width:100%;">Não foi possível carregar os comentários recentes (sem permissão no Firebase: nó "ultimosComentarios").</p>';
  });
}
function renderizarUltimasAvaliacoes(lista){
  const track = document.getElementById("ultimas-avaliacoes-track");
  if(!track) return;
  if(!lista.length){
    track.innerHTML = '<p class="comentario-vazio" style="width:100%;">Ainda não há comentários. Sê o primeiro!</p>';
    return;
  }
  montarCartoesComentarios(track, lista);
}
iniciarListenerUltimasAvaliacoes();

/* --- Tela "Ver todos os comentários" (por agora: os mais recentes) --- */
const telaComentarios = document.getElementById("telaComentarios");
function abrirTelaComentarios(){
  if(!firebaseAtivo) return;
  const lista = document.getElementById("telaComentariosLista");
  lista.innerHTML = '<p class="comentario-vazio">A carregar…</p>';
  telaComentarios.classList.add("aberta");
  dbComentarios().ref("ultimosComentarios").limitToLast(100).once("value").then(snapshot => {
    return filtrarComentariosExistentes(ordenarComentarios(listaDeSnapshotComentarios(snapshot), "recentes")).then(itens => {
      if(!itens.length){ lista.innerHTML = '<p class="comentario-vazio">Ainda não há comentários.</p>'; return; }
      montarCartoesComentarios(lista, itens, fecharTelaComentarios);
    });
  }).catch(erro => {
    console.warn("Não consegui carregar todos os comentários:", erro);
    lista.innerHTML = '<p class="comentario-vazio">Não foi possível carregar os comentários agora.</p>';
  });
}
function fecharTelaComentarios(){ telaComentarios.classList.remove("aberta"); }
document.getElementById("btnVerTodosComentarios").addEventListener("click", abrirTelaComentarios);
document.getElementById("fecharTelaComentarios").addEventListener("click", fecharTelaComentarios);

/* ============ BUSCA ============
   Duas APIs da TMDB juntas com a SuperFlixAPI:
   1) tmdbSearch() — API de PESQUISA da TMDB (/search/movie, /search/tv):
      acha candidatos pelo nome digitado, entre TUDO que a TMDB conhece.
   2) Os IDs que a SuperFlixAPI já confirmou existir em cada categoria
      (catalogIdsProntos, preenchido em loadCategory) — filtra os
      candidatos, mantendo só o que o site realmente tem para assistir.
   3) tmdbDetailsFor() — API de DETALHES da TMDB (/movie/{id}, /tv/{id}):
      busca capa/ano/sinopse só dos que sobraram (reaproveita a mesma cache
      do catálogo normal — se a pessoa já tiver navegado por ali, nem pede
      de novo à TMDB). */
const searchInput = document.getElementById("searchInput");
const pagePesquisa = document.getElementById("page-pesquisa");
const pesquisaTitulo = document.getElementById("pesquisaTitulo");
const searchTrack = document.getElementById("searchTrack");
let searchTimer;
let buscaAtualId = 0; // NOVO: identifica a busca mais recente, para ignorar respostas de buscas já ultrapassadas

// Mostra a aba de Pesquisa (mesma grade de 4 por linha das outras abas),
// sem passar pela trocarPagina() de baixo para não limpar o campo de busca.
function abrirAbaPesquisa(){
  document.querySelectorAll(".page").forEach(pg => pg.classList.toggle("ativa", pg === pagePesquisa));
  document.querySelectorAll(".bottom-nav button").forEach(btn => btn.classList.remove("ativa"));
  atualizarVisibilidadeFeed();
  window.scrollTo({ top: 0, behavior: "smooth" });
}
document.getElementById("btnFecharPesquisa").addEventListener("click", () => {
  // NOVO: cancela qualquer pesquisa agendada (o setTimeout do debounce) ou
  // já em curso — sem isto, uma pesquisa disparava alguns instantes depois
  // do clique e reabria esta aba sozinha, desfazendo o "Voltar".
  clearTimeout(searchTimer);
  buscaAtualId++;
  searchInput.value = "";
  searchSuggestions.style.display = "none";
  // CORRIGIDO: antes ia sempre para "inicio"; agora volta para a aba onde
  // o usuário estava quando pesquisou (abaAtualAtiva não muda ao abrir a
  // pesquisa, então já guarda "inicio", "filmes", "series", etc. certos).
  trocarPagina(abaAtualAtiva);
});

searchInput.addEventListener("input", () => {
  clearTimeout(searchTimer);
  const q = searchInput.value.trim();
  mostrarSugestoesHistorico(q);
  if(!q){ buscaAtualId++; return; }
  searchTimer = setTimeout(() => runSearch(q), 300);
});
searchInput.addEventListener("focus", () => mostrarSugestoesHistorico(searchInput.value.trim()));

async function runSearch(q){
  guardarNoHistoricoPesquisas(q);
  abrirAbaPesquisa();

  // NOVO: se o usuário estiver numa aba de catálogo (Filmes/Séries/Animes/
  // Doramas), a pesquisa passa a procurar SÓ naquele catálogo. Só no Início
  // é que continua a procurar em tudo, como já era.
  const categoriasAPesquisar = CATEGORIA_DA_ABA[abaAtualAtiva]
    ? [CATEGORIA_DA_ABA[abaAtualAtiva]]
    : Object.keys(TMDB_KIND);

  pesquisaTitulo.textContent = CATEGORIA_DA_ABA[abaAtualAtiva]
    ? `Resultados para "${q}" em ${TIPO_LABEL[CATEGORIA_DA_ABA[abaAtualAtiva]] || ""}`
    : `Resultados para "${q}"`;

  const minhaBusca = ++buscaAtualId;
  searchTrack.innerHTML = '<p class="loading">A pesquisar…</p>';

  let resultadosTmdb;
  try{
    resultadosTmdb = await tmdbSearch(q);
  }catch(e){
    if(minhaBusca !== buscaAtualId) return; // a pessoa já digitou outra coisa
    searchTrack.innerHTML = '<p class="empty">Não foi possível pesquisar agora. Tenta de novo em instantes.</p>';
    return;
  }
  if(minhaBusca !== buscaAtualId) return;

  const resultadosPorCategoria = await Promise.all(categoriasAPesquisar.map(async cat => {
    const idsDoCatalogo = await (catalogIdsProntos[cat] || Promise.resolve(null));
    if(minhaBusca !== buscaAtualId || !idsDoCatalogo || !idsDoCatalogo.size) return [];

    const kind = TMDB_KIND[cat]; // movie ou tv
    const candidatos = (resultadosTmdb[kind] || []).filter(r => idsDoCatalogo.has(r.id));
    if(!candidatos.length) return [];

    return executarEmLotes(candidatos, TAMANHO_GRUPO_TMDB, r => tmdbDetailsFor(cat, r.id), PAUSA_ENTRE_GRUPOS_TMDB);
  }));
  if(minhaBusca !== buscaAtualId) return;

  const encontrados = [];
  const vistos = new Set(); // evita repetir o mesmo título se ele aparecer em mais de uma categoria
  for(const detalhes of resultadosPorCategoria){
    for(const d of detalhes){
      if(!d) continue;
      const chave = d.cat + ":" + d.tmdbId;
      if(vistos.has(chave)) continue;
      vistos.add(chave);
      encontrados.push(d);
    }
  }

  searchTrack.innerHTML = "";
  if(!encontrados.length){
    searchTrack.innerHTML = '<p class="empty">Nada encontrado.</p>';
    return;
  }
  encontrados.slice(0, 60).forEach(d => searchTrack.appendChild(buildCard(d)));
}

/* ============ PERFIL (guardado neste aparelho) ============ */
const CHAVE_PERFIL = "cinesongo_perfil";
const AVATARES = ["🎬","🍿","🦸","🐉","🎮","👾","🌟","🎭","🧑‍🚀","🐱"];

function obterPerfil(){
  try{ return JSON.parse(localStorage.getItem(CHAVE_PERFIL)) || { nome:"", avatar:AVATARES[0] }; }
  catch(e){ return { nome:"", avatar:AVATARES[0] }; }
}
function guardarPerfil(perfil){
  localStorage.setItem(CHAVE_PERFIL, JSON.stringify(perfil));
  aplicarPerfilNoBotao();
}
const SVG_PERFIL = '<svg viewBox="0 0 24 24" width="100%" height="100%" aria-hidden="true"><circle cx="12" cy="12" r="12" fill="#3a3f4b"/><circle cx="12" cy="9.2" r="4" fill="#9aa0ad"/><path d="M4.6 20.2c.9-3.6 4-5.6 7.4-5.6s6.5 2 7.4 5.6A11.9 11.9 0 0 1 12 24a11.9 11.9 0 0 1-7.4-3.8z" fill="#9aa0ad"/></svg>';
let usuarioAtual = null; // conta iniciada (Firebase Auth), ou null
// Mostra o ícone de perfil genérico e, se houver link de foto válido, troca pela foto.
// Foto da conta: a definida no perfil ou, se não houver, a do provedor (ex.: foto do Google)
function fotoUsuario(u){
  if(!u) return "";
  if(u.photoURL) return u.photoURL;
  const pv = (u.providerData || []).find(x => x && x.photoURL);
  return pv ? pv.photoURL : "";
}
function inicialUsuario(u){
  const n = (u && (u.displayName || (u.email || "").split("@")[0])) || "";
  return n.trim().charAt(0).toUpperCase();
}
// inicial: letra a mostrar (em círculo) quando há conta mas ainda não há foto
function preencherAvatar(el, url, inicial){
  if(inicial){
    el.innerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--accent-dim);color:var(--ink);font-weight:700;font-size:1em;">' + inicial + '</div>';
  }else{
    el.innerHTML = SVG_PERFIL;
  }
  if(!url) return;
  const img = new Image();
  img.referrerPolicy = "no-referrer";
  img.onload = () => { el.innerHTML = ""; el.appendChild(img); };
  img.src = url;
}
function aplicarPerfilNoBotao(){
  const btn = document.getElementById("profileBtn");
  if(usuarioAtual){ preencherAvatar(btn, fotoUsuario(usuarioAtual), inicialUsuario(usuarioAtual)); return; }
  // sem conta: ícone genérico (ou o emoji, se a pessoa guardou um perfil só neste aparelho)
  if(localStorage.getItem(CHAVE_PERFIL)){ btn.textContent = obterPerfil().avatar || ""; if(btn.textContent) return; }
  preencherAvatar(btn, null);
}

const profileBtn = document.getElementById("profileBtn");
const profileOverlay = document.getElementById("profileOverlay");
const profileName = document.getElementById("profileName");
const avatarGrid = document.getElementById("avatarGrid");
let avatarSelecionado = AVATARES[0];

function montarGradeAvatares(){
  avatarGrid.innerHTML = AVATARES.map(av =>
    `<div class="avatar-opcao${av === avatarSelecionado ? " selecionado" : ""}" data-avatar="${av}">${av}</div>`
  ).join("");
}
avatarGrid.addEventListener("click", e => {
  const opcao = e.target.closest(".avatar-opcao");
  if(!opcao) return;
  avatarSelecionado = opcao.dataset.avatar;
  montarGradeAvatares();
});

profileBtn.addEventListener("click", () => {
  const perfil = obterPerfil();
  profileName.value = perfil.nome || "";
  avatarSelecionado = perfil.avatar || AVATARES[0];
  montarGradeAvatares();
  atualizarModalPerfil();
  profileOverlay.classList.add("open");
});
document.getElementById("closeProfile").addEventListener("click", () => profileOverlay.classList.remove("open"));
profileOverlay.addEventListener("click", e => { if(e.target === profileOverlay) profileOverlay.classList.remove("open"); });
document.getElementById("saveProfile").addEventListener("click", () => {
  guardarPerfil({ nome: profileName.value.trim(), avatar: avatarSelecionado });
  profileOverlay.classList.remove("open");
});

/* ============ CONTA (Firebase Authentication) ============
   Entrar com Google, ou criar conta / entrar com e-mail e palavra-passe.
   A foto de perfil é só um LINK (não há envio de ficheiros). Nome e foto
   ficam guardados na própria conta. */
function authPronta(){ return firebaseAtivo && typeof firebase.auth === "function"; }
function authFb(){ return firebase.app("comentarios").auth(); }
let modoCriarConta = false;
const $p = id => document.getElementById(id);
// Guarda o início de sessão neste aparelho (persiste mesmo depois de fechar a app).
let persistenciaAuthPronta = Promise.resolve();
if(authPronta()){
  persistenciaAuthPronta = authFb().setPersistence(firebase.auth.Auth.Persistence.LOCAL)
    .catch(e => console.warn("Não consegui guardar o início de sessão no aparelho:", e));
}

function textoErroAuth(e){
  const c = (e && e.code) || "";
  if(c === "auth/invalid-email") return "O e-mail não é válido.";
  if(c === "auth/missing-password") return "Escreve a palavra-passe.";
  if(c === "auth/weak-password") return "A palavra-passe é fraca (mínimo 6 caracteres).";
  if(c === "auth/email-already-in-use") return "Já existe uma conta com este e-mail. Usa 'Entrar'.";
  if(c === "auth/user-not-found" || c === "auth/wrong-password" || c === "auth/invalid-credential") return "E-mail ou palavra-passe incorretos.";
  if(c === "auth/too-many-requests") return "Demasiadas tentativas. Tenta mais tarde.";
  if(c === "auth/network-request-failed") return "Sem ligação à internet.";
  if(c === "auth/popup-closed-by-user" || c === "auth/cancelled-popup-request") return "";
  if(c === "auth/operation-not-allowed") return "Este método de entrada ainda não foi ativado no Firebase.";
  if(c === "auth/unauthorized-domain") return "Este domínio ainda não está autorizado no Firebase (Authentication › Definições › Domínios autorizados).";
  return "Não foi possível concluir: " + (e && e.message ? e.message : "erro desconhecido");
}
function mostrarErroPerfil(texto){ $p("perfilErroInicio").textContent = texto || ""; $p("perfilErro").textContent = texto || ""; $p("perfilErroLogado").textContent = texto || ""; }
function fotoValida(url){ return !url || /^https?:\/\/\S+$/i.test(url); }

const CH_EMAILS_GOOGLE = "webplay_emails_google";
function emailsGoogleDoAparelho(){ try{ return JSON.parse(localStorage.getItem(CH_EMAILS_GOOGLE) || "[]"); }catch(e){ return []; } }
function lembrarEmailGoogle(u){
  try{
    if(!u || !u.email || !(u.providerData || []).some(p => p.providerId === "google.com")) return;
    const l = emailsGoogleDoAparelho(), e = u.email.toLowerCase();
    if(l.indexOf(e) < 0){ l.push(e); localStorage.setItem(CH_EMAILS_GOOGLE, JSON.stringify(l)); }
  }catch(e){}
}
function mostrarPainelEmail(sim){
  $p("painelInicio").style.display = sim ? "none" : "";
  $p("painelEmail").style.display = sim ? "" : "none";
  mostrarErroPerfil("");
}
function definirModoConta(criar){
  modoCriarConta = criar;
  $p("abaEntrar").classList.toggle("ativa", !criar);
  $p("abaCriar").classList.toggle("ativa", criar);
  $p("campoNomeCriar").style.display = criar ? "" : "none";
  $p("campoFotoCriar").style.display = criar ? "" : "none";
  $p("btnEnviarConta").textContent = criar ? "Criar conta" : "Entrar";
  $p("perfilSenha").autocomplete = criar ? "new-password" : "current-password";
  mostrarErroPerfil("");
}
function atualizarModalPerfil(){
  const logado = !!usuarioAtual;
  $p("perfilDeslogado").style.display = logado ? "none" : "";
  $p("perfilLogado").style.display = logado ? "" : "none";
  $p("perfilTitulo").textContent = logado ? "Meu perfil" : "Iniciar conta";
  mostrarPainelEmail(false);
  preencherAvatar($p("perfilAvatarGrande"), logado ? fotoUsuario(usuarioAtual) : null, logado ? inicialUsuario(usuarioAtual) : "");
  if(logado){
    $p("perfilNomeLogado").textContent = usuarioAtual.displayName || "Sem nome";
    $p("perfilEmailLogado").textContent = usuarioAtual.email || "";
    $p("perfilNomeEditar").value = usuarioAtual.displayName || "";
    $p("perfilFotoEditar").value = usuarioAtual.photoURL || "";
  }
  mostrarErroPerfil("");
}

$p("btnAbrirEmail").addEventListener("click", () => mostrarPainelEmail(true));
$p("btnVoltarInicio").addEventListener("click", () => mostrarPainelEmail(false));
$p("abaEntrar").addEventListener("click", () => definirModoConta(false));
$p("abaCriar").addEventListener("click", () => definirModoConta(true));

$p("btnEnviarConta").addEventListener("click", async () => {
  if(!authPronta()){ mostrarErroPerfil("As contas não estão disponíveis neste momento."); return; }
  const email = $p("perfilEmail").value.trim();
  const senha = $p("perfilSenha").value;
  const nome = $p("perfilNomeConta").value.trim();
  const foto = $p("perfilFotoConta").value.trim();
  if(!email || !senha){ mostrarErroPerfil("Escreve o e-mail e a palavra-passe."); return; }
  // e-mail que já entrou com Google neste aparelho (sem palavra-passe): entra pelo Google
  if(!modoCriarConta && emailsGoogleDoAparelho().indexOf(email.toLowerCase()) >= 0){
    mostrarErroPerfil("Este e-mail já entrou com o Google neste aparelho. A entrar com o Google…");
    $p("btnGoogle").click(); return;
  }
  if(modoCriarConta && !fotoValida(foto)){ mostrarErroPerfil("O link da foto tem de começar por http:// ou https://"); return; }
  const btn = $p("btnEnviarConta"); btn.disabled = true; btn.textContent = "A processar…"; mostrarErroPerfil("");
  try{
    await persistenciaAuthPronta;
    if(modoCriarConta){
      const cred = await authFb().createUserWithEmailAndPassword(email, senha);
      if(nome || foto) await cred.user.updateProfile({ displayName: nome || null, photoURL: foto || null });
    }else{
      await authFb().signInWithEmailAndPassword(email, senha);
    }
    usuarioAtual = authFb().currentUser;
    aplicarPerfilNoBotao(); atualizarModalPerfil();
    $p("perfilSenha").value = "";
  }catch(e){
    let msg = textoErroAuth(e);
    if(!modoCriarConta && e && (e.code === "auth/invalid-credential" || e.code === "auth/wrong-password" || e.code === "auth/user-not-found")){
      try{
        const m = await authFb().fetchSignInMethodsForEmail(email);
        if(m && m.indexOf("google.com") >= 0 && m.indexOf("password") < 0) msg = "Este e-mail foi criado com o Google. Volta atrás e toca em \"Continuar com Google\".";
      }catch(e2){}
    }
    mostrarErroPerfil(msg);
  }
  finally{ btn.disabled = false; btn.textContent = modoCriarConta ? "Criar conta" : "Entrar"; }
});

$p("btnGoogle").addEventListener("click", async () => {
  if(!authPronta()){ mostrarErroPerfil("As contas não estão disponíveis neste momento."); return; }
  mostrarErroPerfil("");
  const provedor = new firebase.auth.GoogleAuthProvider();
  // Dentro do app (Median): login nativo do Google, sem abrir o Chrome. A sessão fica no próprio app.
  if(window.median && median.socialLogin && median.socialLogin.google){
    try{
      await persistenciaAuthPronta;
      const r = await new Promise(ok => median.socialLogin.google.login({ callback: ok }));
      if(r && r.idToken){
        await authFb().signInWithCredential(firebase.auth.GoogleAuthProvider.credential(r.idToken));
      }else{
        mostrarErroPerfil("Não foi possível entrar com o Google no app. Tenta outra vez.");
      }
    }catch(e){ mostrarErroPerfil(textoErroAuth(e)); }
    return;
  }
  try{
    await persistenciaAuthPronta;
    await authFb().signInWithPopup(provedor);
  }catch(e){
    if(e && (e.code === "auth/popup-blocked" || e.code === "auth/operation-not-supported-in-this-environment")){
      try{ await authFb().signInWithRedirect(provedor); return; }catch(e2){ e = e2; }
    }
    mostrarErroPerfil(textoErroAuth(e));
  }
});

$p("btnGuardarConta").addEventListener("click", async () => {
  if(!usuarioAtual) return;
  const nome = $p("perfilNomeEditar").value.trim();
  const foto = $p("perfilFotoEditar").value.trim();
  if(!fotoValida(foto)){ mostrarErroPerfil("O link da foto tem de começar por http:// ou https://"); return; }
  try{
    await usuarioAtual.updateProfile({ displayName: nome || null, photoURL: foto || null });
    usuarioAtual = authFb().currentUser;
    aplicarPerfilNoBotao(); atualizarModalPerfil();
    profileOverlay.classList.remove("open");
  }catch(e){ mostrarErroPerfil(textoErroAuth(e)); }
});

$p("btnSair").addEventListener("click", async () => {
  try{ await authFb().signOut(); }catch(e){}
  usuarioAtual = null;
  aplicarPerfilNoBotao(); atualizarModalPerfil();
  profileOverlay.classList.remove("open");
});

if(authPronta()){
  authFb().onAuthStateChanged(u => { usuarioAtual = u; lembrarEmailGoogle(u); aplicarPerfilNoBotao(); atualizarModalPerfil(); atualizarFormComentario(); repintarTodosOsVotos(); });
  authFb().getRedirectResult().catch(e => mostrarErroPerfil(textoErroAuth(e)));
}
definirModoConta(false);
aplicarPerfilNoBotao();
atualizarModalPerfil();

/* ============ LOGÓTIPO, PESQUISA EM ÍCONE E FEED SÓ NO INÍCIO ============ */
// O botão Feed só aparece na aba Início (não nas outras abas, nem na pesquisa).
function atualizarVisibilidadeFeed(){
  const btn = document.getElementById("pilulaTopo");
  const pg = document.getElementById("page-inicio");
  const noInicio = !!(pg && pg.classList.contains("ativa"));
  if(btn) btn.classList.toggle("oculto", !noInicio);
  // "+" lateral só na Início; nas outras abas aparece o "+" no cabeçalho
  const maisLat = document.getElementById("btnMaisLateral");
  const maisCab = document.getElementById("btnMaisCabecalho");
  if(maisLat) maisLat.classList.toggle("oculto", !noInicio);
  if(maisCab) maisCab.classList.toggle("oculto", noInicio);
}

// Ação do "+" (ainda por definir): ligar aqui a função desejada.
// "+" → Área de publicação. Se houver aviso por ler (verde = aprovado, vermelho = recusado),
// abre já o correio lá (?correio=1). URL_AREA_PUBLICACAO fica no bloco da ligação, mais abaixo.
function aoClicarMais(){
  const base = (typeof URL_AREA_PUBLICACAO !== "undefined") ? URL_AREA_PUBLICACAO : "index.html";
  const comAviso = (typeof estadoCorreioMais !== "undefined") && estadoCorreioMais;
  location.href = base + (comAviso ? "?correio=1" : "");
}
["btnMaisLateral","btnMaisCabecalho"].forEach(id => {
  const el = document.getElementById(id);
  if(el) el.addEventListener("click", aoClicarMais);
});
atualizarVisibilidadeFeed();

// Ícone de pesquisa: mostra/esconde a barra de pesquisa por baixo do logótipo.
document.getElementById("btnBuscaIcone").addEventListener("click", () => {
  const cab = document.querySelector("header");
  const aberto = cab.classList.toggle("pesquisa-aberta");
  if(aberto){ searchInput.focus(); }
  else { searchSuggestions.style.display = "none"; searchInput.blur(); }
});

// Logótipo: tenta as imagens do logótipo (máscaras); se não houver, usa a imagem azul; se nada existir, mostra o texto Webplay.
(function(){
  const logos = document.querySelectorAll(".logo-webplay");
  const dir = "<?= $logoDir ?>", ver = "<?= $logoVer ?>";
  const testar = (url, ok, falha) => { const im = new Image(); im.onload = ok; im.onerror = falha; im.src = url; };
  testar(dir + "webplay-web.png?v=" + ver, () => {
    testar(dir + "webplay-play.png?v=" + ver, () => logos.forEach(l => l.classList.add("logo-ok")), usarImagemOriginal);
  }, usarImagemOriginal);
  function usarImagemOriginal(){
    const url = dir + "webplay-azul.png?v=" + ver;
    testar(url, () => { logos.forEach(l => { l.querySelector(".logo-original").src = url; l.classList.add("logo-img"); }); }, () => {});
  }
})();

// Clicar no logótipo: mostra o logótipo na cor do tema e os direitos reservados.
const modalLogo = document.getElementById("modalLogo");
function abrirModalLogo(){
  document.getElementById("anoDireitos").textContent = new Date().getFullYear();
  modalLogo.classList.add("aberto");
}
function fecharModalLogo(){ modalLogo.classList.remove("aberto"); }
document.getElementById("logoWebplay").addEventListener("click", abrirModalLogo);
document.getElementById("logoWebplay").addEventListener("keydown", e => { if(e.key === "Enter" || e.key === " "){ e.preventDefault(); abrirModalLogo(); } });
document.getElementById("fecharModalLogo").addEventListener("click", fecharModalLogo);
modalLogo.addEventListener("click", e => { if(e.target === modalLogo) fecharModalLogo(); });

/* ============ TEMAS (guardado neste aparelho) ============ */
const CHAVE_TEMA = "cinesongo_tema";
const CHAVE_TEMA_MANUAL = "webplay_tema_manual"; // '0' = manual desligado; qualquer outra coisa = ligado (padrão)
const TEMAS_CONHECIDOS = ["escuro","claro","aqua","oceano"];
function temaManualLigado(){ try{ return localStorage.getItem(CHAVE_TEMA_MANUAL) !== "0"; }catch(e){ return true; } }
function temaGuardado(){ try{ const t = localStorage.getItem(CHAVE_TEMA); return TEMAS_CONHECIDOS.includes(t) ? t : "escuro"; }catch(e){ return "escuro"; } }
// Automático e Manual são independentes e podem estar ligados ao mesmo tempo ("ambos"):
// o manual é o tema de base; o automático entra por cima nas datas especiais.
function atualizarControlesTema(){
  const man = temaManualLigado();
  const auto = window.webplayTemaAutomatico ? window.webplayTemaAutomatico.ativo() : true;
  const chkMan = document.getElementById("chkTemaManual");
  if(chkMan) chkMan.checked = man;
  const lista = document.getElementById("perfilTemas");
  if(lista) lista.classList.toggle("desligado", !man); // continuam todos visíveis, só ficam mais claros
  const dica = document.getElementById("temaModoDica");
  if(dica) dica.textContent = (auto && man) ? "Ambos ligados: vale o tema que escolher abaixo e, nas datas especiais, o automático entra por cima."
    : auto ? "Só automático: muda sozinho nas datas especiais; no resto do ano usa o Escuro."
    : man ? "Só manual: usa o tema que escolher abaixo."
    : "Tudo desligado: usa o tema Escuro.";
}
window.atualizarControlesTema = atualizarControlesTema;
function aplicarTema(t){
  if(!TEMAS_CONHECIDOS.includes(t)) t = "escuro";
  try{ localStorage.setItem(CHAVE_TEMA, t); }catch(e){}
  document.documentElement.setAttribute("data-tema", temaManualLigado() ? t : "escuro");
  document.querySelectorAll("#perfilTemas .btn-tema").forEach(b => b.classList.toggle("ativo", b.dataset.tema === t));
  atualizarControlesTema();
}
document.getElementById("perfilTemas").addEventListener("click", e => {
  const b = e.target.closest(".btn-tema");
  if(!b) return;
  // escolher um tema à mão liga o modo manual
  try{ localStorage.setItem(CHAVE_TEMA_MANUAL, "1"); }catch(err){}
  aplicarTema(b.dataset.tema);
});
document.addEventListener("change", e => {
  if(e.target && e.target.id === "chkTemaManual"){
    try{ localStorage.setItem(CHAVE_TEMA_MANUAL, e.target.checked ? "1" : "0"); }catch(err){}
    aplicarTema(temaGuardado());
  }
});
aplicarTema(temaGuardado());

/* ============ HISTÓRICO DE PESQUISA (guardado neste aparelho) ============ */
const CHAVE_HISTORICO = "cinesongo_historico_pesquisas";
const LIMITE_HISTORICO = 30;

function obterHistoricoPesquisas(){
  try{ return JSON.parse(localStorage.getItem(CHAVE_HISTORICO)) || []; }
  catch(e){ return []; }
}
function guardarNoHistoricoPesquisas(termo){
  if(!termo) return;
  let lista = obterHistoricoPesquisas().filter(t => t.toLowerCase() !== termo.toLowerCase());
  lista.unshift(termo);
  if(lista.length > LIMITE_HISTORICO) lista = lista.slice(0, LIMITE_HISTORICO);
  localStorage.setItem(CHAVE_HISTORICO, JSON.stringify(lista));
}

const searchSuggestions = document.getElementById("searchSuggestions");

function mostrarSugestoesHistorico(filtro){
  const historico = obterHistoricoPesquisas();
  const filtrado = filtro
    ? historico.filter(t => t.toLowerCase().includes(filtro.toLowerCase()))
    : historico;

  if(!filtrado.length){
    searchSuggestions.style.display = "none";
    searchSuggestions.innerHTML = "";
    return;
  }

  searchSuggestions.innerHTML = filtrado.slice(0, 2).map(termo =>
    `<div class="sugestao-item" data-termo="${termo.replace(/"/g,"&quot;")}">
       <span class="icone-historico">🕒</span>
       <span class="texto-sugestao">${termo}</span>
       <span class="btn-remover-sugestao" data-remover="${termo.replace(/"/g,"&quot;")}" title="Remover do histórico">×</span>
     </div>`
  ).join("");
  searchSuggestions.style.display = "block";
}
function removerTermoHistorico(termo){
  const lista = obterHistoricoPesquisas().filter(t => t.toLowerCase() !== termo.toLowerCase());
  localStorage.setItem(CHAVE_HISTORICO, JSON.stringify(lista));
}
searchSuggestions.addEventListener("click", e => {
  const btnRemover = e.target.closest(".btn-remover-sugestao");
  if(btnRemover){
    removerTermoHistorico(btnRemover.dataset.remover);
    mostrarSugestoesHistorico(searchInput.value.trim());
    return;
  }
  const item = e.target.closest(".sugestao-item");
  if(!item) return;
  searchInput.value = item.dataset.termo;
  searchSuggestions.style.display = "none";
  runSearch(item.dataset.termo);
});

/* ============ TELA CHEIA DE HISTÓRICO (só visualização nova — mostra em
   cards, como nos resultados de pesquisa, os títulos que já abriste neste
   aparelho; não mexe em nada da pesquisa/sugestões acima). ============ */
const CHAVE_HISTORICO_CLIQUES = "cinesongo_historico_cliques";
const LIMITE_HISTORICO_CLIQUES = 60;

function obterHistoricoCliques(){
  try{ return JSON.parse(localStorage.getItem(CHAVE_HISTORICO_CLIQUES)) || []; }
  catch(e){ return []; }
}
function registrarCliqueHistorico(d){
  if(!d || !d.tmdbId) return;
  const listaAtual = obterHistoricoCliques();
  const existente = listaAtual.find(item => item.cat === d.cat && item.tmdbId === d.tmdbId);
  // Guarda também temporada/episódio se existirem — Continuar Assistindo abre direto nesse EP.
  // NOVO: se o clique atual não trouxer EP/minutos novos (ex: só reabriu a
  // ficha do título), mantém o que já estava guardado antes, senão um
  // clique comum apagava o progresso salvo da vez anterior.
  const copia = {
    cat: d.cat, tmdbId: d.tmdbId, title: d.title, poster: d.poster,
    year: d.year, tipoLabel: d.tipoLabel, genre: d.genre, overview: d.overview,
    seasons: d.seasons,
    temporadaEscolhida: d.temporadaEscolhida || (d.ultimoEpisodio && d.ultimoEpisodio.temporada) || (existente && existente.temporadaEscolhida) || null,
    episodioEscolhido: d.episodioEscolhido || (d.ultimoEpisodio && d.ultimoEpisodio.episodio) || (existente && existente.episodioEscolhido) || null,
    ultimoEpisodio: d.ultimoEpisodio || (existente && existente.ultimoEpisodio) || null,
    // NOVO: quantos minutos ficou a assistir da última vez (aproximado -
    // ver comentário em openPlayer/closePlayer) — usado pela faixa
    // "Continuar Assistindo" pra mostrar o EP e os minutos onde parou.
    minutosAssistidos: d.minutosAssistidos || (existente && existente.minutosAssistidos) || null
  };
  let lista = listaAtual.filter(item => !(item.cat === d.cat && item.tmdbId === d.tmdbId));
  lista.unshift(copia);
  if(lista.length > LIMITE_HISTORICO_CLIQUES) lista = lista.slice(0, LIMITE_HISTORICO_CLIQUES);
  localStorage.setItem(CHAVE_HISTORICO_CLIQUES, JSON.stringify(lista));
}

const telaHistorico = document.getElementById("telaHistorico");
const historicoGrid = document.getElementById("historicoGrid");

function abrirTelaHistorico(){
  searchSuggestions.style.display = "none";

  // NOVO: mesma regra da pesquisa — numa aba de catálogo, só mostra o
  // histórico daquele catálogo; no Início, mostra tudo.
  const categoriaFiltro = CATEGORIA_DA_ABA[abaAtualAtiva] || null;
  const lista = obterHistoricoCliques().filter(d => !categoriaFiltro || d.cat === categoriaFiltro);

  document.querySelector(".tela-historico-titulo").textContent = categoriaFiltro
    ? `🕒 Histórico — ${TIPO_LABEL[categoriaFiltro]}`
    : "🕒 Histórico";

  historicoGrid.innerHTML = lista.length
    ? ""
    : '<p class="empty" style="grid-column:1/-1;">Ainda não abriste nada por aqui.</p>';
  lista.forEach(d => historicoGrid.appendChild(buildCard(d)));
  telaHistorico.classList.add("aberta");
}
function fecharTelaHistorico(){
  telaHistorico.classList.remove("aberta");
}
document.getElementById("fecharTelaHistorico").addEventListener("click", fecharTelaHistorico);
document.getElementById("btnLimparHistorico").addEventListener("click", () => {
  // NOVO: se estiver filtrado por uma categoria, "Limpar" só apaga o
  // histórico DAQUELE catálogo — o resto continua guardado. No Início,
  // continua a limpar tudo, como antes.
  const categoriaFiltro = CATEGORIA_DA_ABA[abaAtualAtiva] || null;
  if(categoriaFiltro){
    const restante = obterHistoricoCliques().filter(d => d.cat !== categoriaFiltro);
    localStorage.setItem(CHAVE_HISTORICO_CLIQUES, JSON.stringify(restante));
  }else{
    localStorage.setItem(CHAVE_HISTORICO_CLIQUES, "[]");
  }
  abrirTelaHistorico();
});
document.getElementById("historyBtn").addEventListener("click", abrirTelaHistorico);
document.addEventListener("click", e => {
  if(!e.target.closest(".search")) searchSuggestions.style.display = "none";
});

/* ============ MAIS ACESSADOS (visualizações reais, via Firebase) ============
   Igual ao index 18: cada vez que um título é aberto (abrirDetalhes), fica
   registada uma visualização no MESMO Firebase já usado pelo Feed (dbFeed()),
   num nó à parte ("visualizacoes"), separado por data — isso é o que permite
   depois calcular Semanal / Mensal / Todos. Como fica guardado num servidor
   central (não no aparelho de cada pessoa), o ranking passa a ser o mesmo
   para todos os visitantes — a soma real de acessos do site inteiro. */
function chaveVisualizacao(d){
  // Firebase não aceita '.', '#', '$', '[', ']', '/' nas chaves — cat e
  // tmdbId nunca têm esses caracteres, por isso um "_" a juntar já chega.
  return d.cat + "_" + d.tmdbId;
}

function registrarAcesso(d){
  if(!firebaseFeedAtivo || !d || !d.cat || !d.tmdbId) return;
  try{
    dbFeed().ref("visualizacoes/" + chaveVisualizacao(d)).push({ ts: Date.now() });
  }catch(erro){
    console.warn("Não consegui registar a visualização:", erro);
  }
}

// Guarda uma cópia em memória de todas as visualizações já lidas do Firebase
// nesta visita — evita reler tudo do zero cada vez que se troca de aba de
// período ou se abre um novo título (é limpa nesse segundo caso, ver
// abrirDetalhes, para o número mais recente entrar na contagem).
let _cacheVisualizacoesTodas = null;
async function carregarVisualizacoesTodas(forcarRecarregar){
  if(!firebaseFeedAtivo) return {};
  if(_cacheVisualizacoesTodas && !forcarRecarregar) return _cacheVisualizacoesTodas;
  try{
    const snap = await dbFeed().ref("visualizacoes").once("value");
    _cacheVisualizacoesTodas = snap.val() || {};
  }catch(erro){
    console.warn("Não consegui carregar as visualizações:", erro);
    _cacheVisualizacoesTodas = {};
  }
  return _cacheVisualizacoesTodas;
}

function contarVisualizacoesPeriodo(dadosTodos, chave, diasAtras){
  const registo = dadosTodos[chave];
  if(!registo) return 0;
  if(!diasAtras) return Object.keys(registo).length; // "Todos"
  const limite = Date.now() - diasAtras * 24 * 60 * 60 * 1000;
  return Object.values(registo).filter(v => v && v.ts >= limite).length;
}

// Constrói o ranking (top 10) de uma categoria (ou combinado, sem
// categoriaFiltro) para uma janela de dias, a partir das chaves guardadas no
// Firebase — sem percorrer o catálogo todo (que aqui pode ter milhares de
// itens): só pede à TMDB os detalhes dos 10 que já sabemos que têm mais
// visualizações.
async function calcularRankingAcessos(categoriaFiltro, janelaDias, forcarRecarregar){
  const dados = await carregarVisualizacoesTodas(forcarRecarregar);
  const linhas = Object.keys(dados).map(chave => {
    const i = chave.indexOf("_");
    return { cat: chave.slice(0, i), tmdbId: chave.slice(i + 1), total: contarVisualizacoesPeriodo(dados, chave, janelaDias) };
  }).filter(l => l.total > 0 && (!categoriaFiltro || l.cat === categoriaFiltro));

  linhas.sort((a, b) => b.total - a.total);
  return linhas.slice(0, 10);
}

// Busca a média REAL de estrelas dadas pelos usuários deste site para um
// título (a partir dos comentários no Firebase) — nunca a nota da TMDB, que
// é global e nada tem a ver com quem usa o site. Devolve null quando ainda
// não há nenhuma avaliação real, para o "Mais Acessados" não incentivar
// (nem inventar) estrelas onde ainda não existe classificação nenhuma.
async function obterAvaliacaoRealDoItem(d){
  if(!firebaseAtivo) return null;
  try{
    const chave = chaveComentariosDoItem(d);
    const snapshot = await dbComentarios().ref("comentarios/" + chave).once("value");
    const dados = snapshot.val() || {};
    const lista = Object.values(dados);
    if(!lista.length) return null;
    const soma = lista.reduce((acc, c) => acc + (Number(c.estrelas) || 0), 0);
    return { media: soma / lista.length, total: lista.length };
  }catch(e){
    return null;
  }
}

function buildItemMaisAcessado(d, posicao, avaliacaoReal){
  const el = document.createElement("div");
  el.className = "item-mais-acessado";
  const linhaAvaliacao = avaliacaoReal
    ? `<div class="avaliacao-mais-acessado">
         <span class="estrelas" style="--pct:${Math.max(0, Math.min(100, avaliacaoReal.media * 20))}%">★★★★★</span>
         <span class="nota-numero">${avaliacaoReal.media.toFixed(1)} (${avaliacaoReal.total})</span>
       </div>`
    : ""; // sem avaliações reais ainda — não mostra estrela nenhuma
  el.innerHTML = `
    <div class="posicao-numero">${posicao}</div>
    <img class="poster-mini" loading="lazy" src="${d.poster || ''}" alt="${d.title}" onerror="this.style.opacity=0">
    <div class="info-mais-acessado">
      <div class="titulo-mais-acessado">${d.title}</div>
      <div class="generos-mais-acessado">${d.genre ? "Géneros: " + d.genre : ""}</div>
      ${linhaAvaliacao}
    </div>`;
  el.addEventListener("click", () => abrirDetalhes(d));
  return el;
}

// NOVO: "Mais Acessados" deixou de ser um ecrã aberto por um ícone — agora é
// uma secção normal, fixa no fim de cada página (igual ao index 18): o
// Início mostra o ranking combinado, e Filmes/Séries/Animes/Doramas mostram
// só o ranking daquela categoria. Cada uma guarda o seu próprio período
// (Semanal/Mensal/Todos) e os seus próprios elementos, pelo sufixo (que é a
// própria categoria — "geral" para o combinado).
const _configInstanciasMaisAcessados = {
  geral:  null,
  filme:  "filme",
  serie:  "serie",
  anime:  "anime",
  dorama: "dorama"
};
const _janelaMaisAcessadosPorInstancia = { geral:7, filme:7, serie:7, anime:7, dorama:7 };

async function renderizarMaisAcessados(instancia){
  const categoriaFiltro = _configInstanciasMaisAcessados[instancia];
  const bloco = document.getElementById("bloco-mais-acessados-" + instancia);
  const container = document.getElementById("maisAcessadosLista-" + instancia);
  if(!container || !bloco) return;

  if(!firebaseFeedAtivo){
    // Sem Firebase do feed configurado não há como contar visualizações
    // reais de todos os visitantes — esconde a secção em vez de mostrar
    // um ranking vazio ou enganoso.
    bloco.style.display = "none";
    return;
  }
  bloco.style.display = "";

  const janelaDias = _janelaMaisAcessadosPorInstancia[instancia];
  const ranking = await calcularRankingAcessos(categoriaFiltro, janelaDias);
  if(!ranking.length){
    container.innerHTML = '<p class="empty">Ainda não há acessos suficientes neste período.</p>';
    return;
  }

  container.innerHTML = '<p class="loading">A carregar…</p>';
  const comDetalhes = (await Promise.all(
    ranking.map(r => tmdbDetailsFor(r.cat, r.tmdbId))
  )).filter(Boolean);

  container.innerHTML = "";
  if(!comDetalhes.length){
    container.innerHTML = '<p class="empty">Ainda não há acessos suficientes neste período.</p>';
    return;
  }
  const avaliacoes = await Promise.all(comDetalhes.map(obterAvaliacaoRealDoItem));
  comDetalhes.forEach((d, i) => container.appendChild(buildItemMaisAcessado(d, i + 1, avaliacoes[i])));
}

// Chama o render das 5 instâncias de uma vez — usado no arranque da página e
// sempre que um novo acesso é registado, para os números ficarem sempre ao
// dia (mesmo sem a pessoa mexer nas abas de período). "forcarRecarregar"
// descarta a cópia em memória das visualizações, para a que acabou de ser
// registada já entrar na contagem.
function renderizarTodosOsMaisAcessados(forcarRecarregar){
  if(forcarRecarregar) _cacheVisualizacoesTodas = null;
  Object.keys(_configInstanciasMaisAcessados).forEach(renderizarMaisAcessados);
}

document.querySelectorAll(".tabs-mais-acessados").forEach(tabsEl => {
  const instancia = tabsEl.id.replace("tabsMaisAcessados-", "");
  tabsEl.addEventListener("click", e => {
    const btn = e.target.closest(".tab-periodo");
    if(!btn) return;
    tabsEl.querySelectorAll(".tab-periodo").forEach(b => b.classList.remove("ativa"));
    btn.classList.add("ativa");
    _janelaMaisAcessadosPorInstancia[instancia] = btn.dataset.dias ? parseInt(btn.dataset.dias, 10) : null;
    renderizarMaisAcessados(instancia);
  });
});

/* ============ NAVEGAÇÃO ENTRE ABAS (rodapé fixo) ============ */
// nome da aba (usado nos data-attributes/URL) -> id da categoria na API
const CATEGORIA_DA_ABA = { filmes:"filme", series:"serie", animes:"anime", doramas:"dorama" };

// NOVO: guarda em qual aba o usuário está (fora da aba de pesquisa, que é
// sobreposta por cima e não conta como "aba atual" para este efeito) —
// usado para filtrar a pesquisa e o histórico só pelo catálogo daquela aba.
// Continua "inicio" por padrão (mesma aba que já vem ativa no HTML).
let abaAtualAtiva = "inicio";

function trocarPagina(nomeAba){
  abaAtualAtiva = nomeAba;
  document.querySelectorAll(".page").forEach(pg => pg.classList.toggle("ativa", pg.id === "page-" + nomeAba));
  document.querySelectorAll(".bottom-nav button").forEach(btn => btn.classList.toggle("ativa", btn.dataset.pagina === nomeAba));
  atualizarVisibilidadeFeed();
  searchInput.value = "";
  window.scrollTo({ top: 0, behavior: "smooth" });
}

document.getElementById("bottomNav").addEventListener("click", e => {
  const btn = e.target.closest("button[data-pagina]");
  if(btn) trocarPagina(btn.dataset.pagina);
});
// CORRIGIDO: antes pegava em TODOS os ".ver-tudo", incluindo o botão
// "← Voltar" da pesquisa (que não tem data-ir-para) — isso disparava
// trocarPagina(undefined) logo depois do handler certo do "Voltar",
// escondendo todas as páginas (ecrã em branco/preto). Agora só pega nos
// botões "Ver tudo →" que realmente têm data-ir-para definido.
document.querySelectorAll(".ver-tudo[data-ir-para]").forEach(btn => {
  btn.addEventListener("click", () => trocarPagina(btn.dataset.irPara));
});

/* ============ BANNER DE DESTAQUES (Início) ============
   O "card grande" do WebPlay (index 18), adaptado: em vez de vários
   títulos por categoria, mostra só 1 slide por categoria — o título mais
   recente de Filme, Série, Anime e Dorama (4 no total), a rodar sozinho,
   com os mesmos indicadores/gradiente/botão "Assistir Agora" do original. */
const controleBannerDestaques = { slideAtual: 0, timer: null };

async function montarBannerDestaques(){
  const bannerContainer = document.getElementById("banner-destaques");
  const indicadoresContainer = document.getElementById("indicadores-destaques");
  if(!bannerContainer || !indicadoresContainer) return;

  const ordemCategorias = ["filme", "serie", "anime", "dorama"];
  const slidesInfo = [];
  for(const cat of ordemCategorias){
    const state = catalogState[cat];
    if(!state || !state.allIds.length) continue;
    // allIds já vem ordenado do mais recente para o mais antigo
    // (order=desc em fetchAllIdsForCategory), por isso o [0] é o mais novo.
    const detalhes = await tmdbDetailsFor(cat, state.allIds[0]);
    if(detalhes && detalhes.poster) slidesInfo.push(detalhes);
  }
  if(!slidesInfo.length) return;

  bannerContainer.querySelectorAll(".banner-slide").forEach(s => s.remove());
  indicadoresContainer.innerHTML = "";

  slidesInfo.forEach((d, index) => {
    const slide = document.createElement("div");
    slide.className = `banner-slide${index === 0 ? " ativo" : ""}`;
    slide.style.backgroundImage = `url('${d.poster}')`;
    slide.innerHTML = `
      <div class="banner-gradiente">
        <div class="banner-sub">🔥 ${d.tipoLabel || ""} • ${d.year || ""}</div>
        <div class="banner-titulo">${d.title}</div>
        <div class="banner-sinopse">${d.overview || ""}</div>
        <button class="banner-btn">▶ Assistir Agora</button>
      </div>`;
    slide.style.cursor = "pointer";
    slide.addEventListener("click", () => abrirDetalhes(d));
    bannerContainer.appendChild(slide);

    const ponto = document.createElement("div");
    ponto.className = `ponto${index === 0 ? " ativo" : ""}`;
    indicadoresContainer.appendChild(ponto);
  });

  if(controleBannerDestaques.timer) clearInterval(controleBannerDestaques.timer);
  controleBannerDestaques.slideAtual = 0;
  if(slidesInfo.length > 1){
    controleBannerDestaques.timer = setInterval(rodarProximoSlideDestaques, 4600);
  }
}

function rodarProximoSlideDestaques(){
  const bannerContainer = document.getElementById("banner-destaques");
  const indicadoresContainer = document.getElementById("indicadores-destaques");
  if(!bannerContainer) return;
  const slides = bannerContainer.querySelectorAll(".banner-slide");
  const pontos = indicadoresContainer.querySelectorAll(".ponto");
  if(!slides.length) return;

  slides[controleBannerDestaques.slideAtual].classList.remove("ativo");
  pontos[controleBannerDestaques.slideAtual].classList.remove("ativo");
  controleBannerDestaques.slideAtual = (controleBannerDestaques.slideAtual + 1) % slides.length;
  slides[controleBannerDestaques.slideAtual].classList.add("ativo");
  pontos[controleBannerDestaques.slideAtual].classList.add("ativo");
}

/* ============ FEED (avisos/perguntas/enquetes) — mesma lógica e o mesmo
   Firebase do site principal. Aqui dá para VER e RESPONDER (votar em
   enquetes, responder perguntas); publicar novos itens continua a ser
   feito só a partir do site principal (index__38_.html), como já era. ============ */
let feedItensCache = {};
let feedRefItens = null;
let feedListenerItens = null;
let abaFeedAtiva = "todos"; // 'todos' | 'aviso' | 'pergunta' | 'enquete'

function chaveDispositivoFeed(){
  let chave = localStorage.getItem("feed_device_id");
  if(!chave){
    chave = "dev_" + Date.now() + "_" + Math.random().toString(36).slice(2, 10);
    localStorage.setItem("feed_device_id", chave);
  }
  return chave;
}

function escaparHtmlFeed(texto){
  const div = document.createElement("div");
  div.textContent = String(texto == null ? "" : texto);
  return div.innerHTML;
}

function iniciarListenerFeed(){
  if(!firebaseFeedAtivo) return;
  feedRefItens = dbFeed().ref("feed_itens");
  feedListenerItens = feedRefItens.on("value", snapshot => {
    feedItensCache = snapshot.val() || {};
    atualizarBadgeFeedNaoLidas();
    if(document.getElementById("painel-feed").classList.contains("aberto")){
      renderizarItensFeed();
    }
  });
}

function atualizarBadgeFeedNaoLidas(){
  const ultimaVista = Number(localStorage.getItem("feed_ultima_vista") || 0);
  const naoLidas = Object.values(feedItensCache).filter(item => (item.data || 0) > ultimaVista).length;
  const badge = document.getElementById("feedBadgeNaoLidas");
  const btnF = document.getElementById("btnFeed");
  if(btnF) btnF.classList.toggle("tem-novo", naoLidas > 0);
  if(!badge) return;
  if(naoLidas > 0){
    badge.textContent = naoLidas > 9 ? "9+" : naoLidas;
    badge.style.display = "flex";
  }else{
    badge.style.display = "none";
  }
}

document.getElementById("btnFeed").addEventListener("click", () => {
  document.getElementById("painel-feed").classList.add("aberto");
  renderizarItensFeed();
  localStorage.setItem("feed_ultima_vista", Date.now().toString());
  atualizarBadgeFeedNaoLidas();
});

/* ============ CRONOGRAMA DE LANÇAMENTOS — usa o próprio catálogo (SuperFlixAPI) +
   datas da TMDB: filmes (data de estreia) e séries/animes/doramas (último e próximo
   episódio). Já lançado → abre direto no filme/episódio; ainda por sair → abre a ficha. ============ */
const CRON_PAGINAS_TMDB = 8;      // páginas (20 por página) de filmes e de séries pedidas à TMDB, por popularidade
const CRON_DIAS_PASSADO = 6, CRON_DIAS_FUTURO = 14;
let cronEventos = [], cronVisiveis = [], cronAba = "proximos", cronCarregadoEm = 0, cronCarregando = false;

function cronDia(str){ const [a,m,d] = String(str).split("-").map(Number); return new Date(a, m-1, d); }
function cronHoje(){ const h = new Date(); h.setHours(0,0,0,0); return h; }

function cronAdicionarEventos(d, saida){
  const hoje = cronHoje().getTime(), dia = 86400000;
  const min = hoje - CRON_DIAS_PASSADO*dia, max = hoje + CRON_DIAS_FUTURO*dia;
  const dentro = t => t >= min && t <= max;
  if(d.cat === "filme"){
    if(!d.dataLancamento) return;
    const t = cronDia(d.dataLancamento).getTime();
    if(dentro(t)) saida.push({ d, t, filme:true });
    return;
  }
  const vistos = new Set();
  [d.ultimoEpisodio, d.proximoEpisodio].forEach(ep => {
    if(!ep || !ep.dataExibicao || !ep.episodio) return;
    const chave = ep.temporada + "x" + ep.episodio;
    if(vistos.has(chave)) return;
    vistos.add(chave);
    const t = cronDia(ep.dataExibicao).getTime();
    if(dentro(t)) saida.push({ d, t, temporada: ep.temporada, episodio: ep.episodio });
  });
}

function cronIso(t){
  const d = new Date(t);
  return d.getFullYear() + "-" + String(d.getMonth()+1).padStart(2,"0") + "-" + String(d.getDate()).padStart(2,"0");
}

// Pergunta à TMDB o que sai na janela (por popularidade, várias páginas) e cruza com o
// que a SuperFlixAPI realmente tem no catálogo — assim entram também títulos famosos
// e antigos que continuam a lançar episódios, não só os adicionados há pouco.
async function cronColetar(aoProgredir){
  const cats = ["filme","serie","anime","dorama"];
  const espera = Promise.all(cats.map(c => (catalogIdsProntos[c] || Promise.resolve(new Set()))));
  const sets = await Promise.race([espera, new Promise(r => setTimeout(() => r(null), 30000))]);
  const ids = {};
  cats.forEach((c, i) => ids[c] = sets ? sets[i] : new Set());

  const hoje = cronHoje().getTime(), dia = 86400000;
  const de = cronIso(hoje - CRON_DIAS_PASSADO*dia), ate = cronIso(hoje + CRON_DIAS_FUTURO*dia);

  const pedidos = [];
  for(let pg = 1; pg <= CRON_PAGINAS_TMDB; pg++){
    pedidos.push(["tv", `/discover/tv?sort_by=popularity.desc&air_date.gte=${de}&air_date.lte=${ate}&page=${pg}`]);
    pedidos.push(["movie", `/discover/movie?sort_by=popularity.desc&primary_release_date.gte=${de}&primary_release_date.lte=${ate}&page=${pg}`]);
  }
  const respostas = await executarEmLotes(pedidos, 4, ([, caminho]) => tmdb(caminho), 200);

  const candidatos = [], vistos = new Set();
  respostas.forEach((r, i) => {
    if(!r || !Array.isArray(r.results)) return;
    const tipo = pedidos[i][0];
    r.results.forEach(it => {
      if(!it || it.id == null) return;
      const cat = tipo === "movie"
        ? (ids.filme.has(it.id) ? "filme" : null)
        : (["anime","dorama","serie"].find(c => ids[c].has(it.id)) || null);
      if(!cat) return;
      const chave = cat + ":" + it.id;
      if(vistos.has(chave)) return;
      vistos.add(chave);
      candidatos.push({ cat, id: it.id });
    });
  });

  const eventos = [];
  for(let k = 0; k < candidatos.length; k += 20){
    const parte = candidatos.slice(k, k + 20);
    const dets = (await executarEmLotes(parte, TAMANHO_GRUPO_TMDB, c => tmdbDetailsFor(c.cat, c.id), PAUSA_ENTRE_GRUPOS_TMDB)).filter(Boolean);
    dets.forEach(d => cronAdicionarEventos(d, eventos));
    aoProgredir(eventos);
  }
  return eventos;
}

function cronEstado(t){
  const dif = Math.round((t - cronHoje().getTime())/86400000);
  if(dif < 0) return "lançado";
  if(dif === 0) return "hoje";
  if(dif === 1) return "amanhã";
  return "em " + dif + " dias";
}

function cronRenderizar(eventos){
  const lista = document.getElementById("cron-lista");
  const hoje = cronHoje().getTime();
  const proximos = cronAba === "proximos";
  const itens = eventos.filter(e => proximos ? e.t >= hoje : e.t < hoje)
    .sort((a,b) => proximos ? a.t - b.t : b.t - a.t);
  cronVisiveis = itens;
  let html = "";
  if(!itens.length){
    html = cronCarregando ? "" : '<p class="cron-msg">' + (proximos ? "Sem lançamentos previstos de momento." : "Sem lançamentos nos últimos dias.") + '</p>';
  }else{
    let diaAtual = null;
    itens.forEach((e, idx) => {
      if(e.t !== diaAtual){
        if(diaAtual !== null) html += '</div>';
        diaAtual = e.t;
        const dia = new Date(e.t);
        const dif = Math.round((e.t - hoje)/86400000);
        let nome = dia.toLocaleDateString("pt-BR",{weekday:"long"});
        nome = nome.charAt(0).toUpperCase() + nome.slice(1);
        const rotulo = dif === 0 ? "Hoje" : dif === 1 ? "Amanhã" : dif === -1 ? "Ontem" : nome;
        html += '<div class="cron-dia">' + rotulo + '<small>' + dia.toLocaleDateString("pt-BR",{day:"2-digit",month:"2-digit"}) + '</small></div><div class="cron-grade">';
      }
      const d = e.d;
      const selo = e.filme ? "Filme" : ((e.temporada > 1 ? "T" + e.temporada + " · " : "") + String(e.episodio).padStart(2,"0"));
      html += '<div class="cron-item" data-idx="' + idx + '">'
        + '<div class="cron-poster">' + (d.poster ? '<img src="' + escaparHtmlFeed(d.poster) + '" alt="" loading="lazy">' : '')
        + '<div class="cron-poster-base"><span>' + cronEstado(e.t) + '</span><span class="cron-ep">' + selo + '</span></div></div>'
        + '<div class="cron-tit">' + escaparHtmlFeed(d.title) + '</div>'
        + '<div class="cron-hora">' + escaparHtmlFeed(d.tipoLabel || "") + '</div></div>';
    });
    html += '</div>';
  }
  if(cronCarregando) html += '<p class="cron-msg">A carregar…</p>';
  lista.innerHTML = html;
}

async function cronCarregar(forcar){
  if(cronCarregando) return;
  if(cronEventos.length && !forcar && Date.now() - cronCarregadoEm < 30*60*1000){ cronRenderizar(cronEventos); return; }
  cronCarregando = true;
  cronRenderizar([]);
  try{
    cronEventos = await cronColetar(ev => { cronEventos = ev; if(document.getElementById("painel-cronograma").classList.contains("aberto")) cronRenderizar(ev); });
    cronCarregadoEm = Date.now();
    cronCarregando = false;
    cronRenderizar(cronEventos);
  }catch(e){
    console.warn("Cronograma:", e);
    cronCarregando = false;
    document.getElementById("cron-lista").innerHTML = '<p class="cron-msg">Não foi possível carregar o cronograma agora.<br><button type="button" id="cronTentar">Tentar de novo</button></p>';
    document.getElementById("cronTentar").addEventListener("click", () => cronCarregar(true));
  }
}

function trocarAbaCronograma(aba){
  cronAba = aba;
  ["proximos","lancados"].forEach(a => document.getElementById("cron-aba-" + a).classList.toggle("ativa", a === aba));
  cronRenderizar(cronEventos);
}
function abrirCronograma(){
  document.getElementById("painel-cronograma").classList.add("aberto");
  cronCarregar(false);
}
function fecharCronograma(){
  document.getElementById("painel-cronograma").classList.remove("aberto");
}
document.getElementById("btnCronograma").addEventListener("click", abrirCronograma);
// Toque num cartão: já lançado → abre direto no filme/episódio; ainda por sair → ficha do título
document.getElementById("cron-lista").addEventListener("click", e => {
  const item = e.target.closest(".cron-item");
  if(!item) return;
  const ev = cronVisiveis[Number(item.dataset.idx)];
  if(!ev) return;
  fecharCronograma();
  const d = ev.d;
  const jaSaiu = ev.t <= cronHoje().getTime();
  if(!jaSaiu){ abrirDetalhes(d); return; }
  registrarCliqueHistorico(d);
  montarContinuarAssistindo();
  if(ev.filme) abrirModalServidor(d);
  else abrirModalServidor(d, ev.temporada, ev.episodio);
});

function fecharPainelFeed(){
  document.getElementById("painel-feed").classList.remove("aberto");
}

function trocarAbaFeed(tipo){
  abaFeedAtiva = tipo;
  ["todos","aviso","pergunta","enquete"].forEach(t => {
    const btn = document.getElementById("feed-aba-" + t);
    if(btn) btn.classList.toggle("ativa", t === tipo);
  });
  renderizarItensFeed();
}

function renderizarItensFeed(){
  const container = document.getElementById("feed-lista-itens");
  const itens = Object.entries(feedItensCache)
    .map(([id, dados]) => ({ id, ...dados }))
    .filter(item => abaFeedAtiva === "todos" || item.tipo === abaFeedAtiva)
    .sort((a, b) => (b.data || 0) - (a.data || 0));

  if(!firebaseFeedAtivo){
    container.innerHTML = '<div class="feed-vazio">O feed ainda não está ligado neste site.</div>';
    return;
  }
  if(!itens.length){
    container.innerHTML = '<div class="feed-vazio">Ainda não há nada por aqui.</div>';
    return;
  }

  const respostaChave = "feed_resposta_" + chaveDispositivoFeed();
  container.innerHTML = itens.map(item => {
    const selo = item.tipo === "aviso" ? "aviso" : (item.tipo === "pergunta" ? "pergunta" : "enquete");
    const seloTexto = item.tipo === "aviso" ? "AVISO" : (item.tipo === "pergunta" ? "PERGUNTA" : "ENQUETE");
    const dataFormatada = item.data ? new Date(item.data).toLocaleDateString("pt-PT", { day:"2-digit", month:"2-digit" }) : "";

    let corpo = "";
    if(item.tipo === "enquete" && Array.isArray(item.opcoes)){
      const respostasItem = item.respostas || {};
      const totalRespostas = Object.keys(respostasItem).length;
      const minhaResposta = localStorage.getItem(respostaChave + "_" + item.id);
      corpo = `<div class="feed-item-opcoes">` + item.opcoes.map((opcao, i) => {
        const votos = Object.values(respostasItem).filter(r => r.valor === opcao).length;
        const percentagem = totalRespostas ? Math.round((votos / totalRespostas) * 100) : 0;
        const marcada = minhaResposta === opcao;
        return `
          <button class="feed-opcao-btn ${marcada ? "marcada" : ""}" onclick="responderItemFeed('${item.id}', ${i})">
            ${minhaResposta ? `<span class="feed-opcao-barra" style="width:${percentagem}%;"></span>` : ""}
            <span class="feed-opcao-conteudo"><span>${escaparHtmlFeed(opcao)}${marcada ? " ✓" : ""}</span>${minhaResposta ? `<span>${percentagem}%</span>` : ""}</span>
          </button>`;
      }).join("") + "</div>"
      + (minhaResposta
        ? `<div class="feed-enquete-rodape">
             <span>${totalRespostas} ${totalRespostas === 1 ? "voto" : "votos"} até agora</span>
             <a onclick="cancelarRespostaFeed('${item.id}'); return false;" href="#">Cancelar o meu voto</a>
           </div>`
        : "");
    }else if(item.tipo === "pergunta"){
      const minhaResposta = localStorage.getItem(respostaChave + "_" + item.id);
      const respostasItem = item.respostas || {};
      const listaRespostas = Object.values(respostasItem).sort((a,b) => (a.data||0) - (b.data||0));
      corpo = (minhaResposta
        ? `<div style="color:#8ee08e;font-size:.72rem;margin-bottom:4px;">A tua resposta: "${escaparHtmlFeed(minhaResposta)}"</div>`
        : `<div class="feed-resposta-livre">
             <textarea id="feed-resposta-texto-${item.id}" rows="2" placeholder="Escreve a tua resposta..."></textarea>
             <button onclick="responderItemFeedTexto('${item.id}')">Responder</button>
           </div>`)
        + (listaRespostas.length
          ? `<div class="feed-respostas-publicas">
               <div class="feed-respostas-publicas-titulo">💬 ${listaRespostas.length} ${listaRespostas.length===1?"resposta":"respostas"}</div>
               ${listaRespostas.map(r => `<div class="feed-resposta-publica-item">${escaparHtmlFeed(r.valor)}</div>`).join("")}
             </div>`
          : "");
    }

    return `
      <div class="feed-item">
        <div class="feed-item-cabecalho">
          <span class="feed-item-selo ${selo}">${seloTexto}</span>
          <span class="feed-item-data">${dataFormatada}</span>
        </div>
        <div class="feed-item-titulo">${item.titulo || ""}</div>
        ${item.texto ? `<div class="feed-item-texto">${item.texto}</div>` : ""}
        ${corpo}
      </div>`;
  }).join("");
}

function responderItemFeed(itemId, indiceOpcao){
  if(!firebaseFeedAtivo) return;
  const item = feedItensCache[itemId];
  if(!item || !Array.isArray(item.opcoes)) return;
  const valor = item.opcoes[indiceOpcao];
  const chaveDispositivo = chaveDispositivoFeed();
  const chaveLocal = "feed_resposta_" + chaveDispositivo + "_" + itemId;
  if(localStorage.getItem(chaveLocal) === valor) return;
  dbFeed().ref("feed_itens/" + itemId + "/respostas/" + chaveDispositivo).set({
    valor, data: firebase.database.ServerValue.TIMESTAMP
  }).then(() => {
    localStorage.setItem(chaveLocal, valor);
  }).catch(erro => alert("Não consegui registar a tua resposta: " + erro.message));
}

function cancelarRespostaFeed(itemId){
  if(!firebaseFeedAtivo) return;
  const chaveDispositivo = chaveDispositivoFeed();
  dbFeed().ref("feed_itens/" + itemId + "/respostas/" + chaveDispositivo).remove().then(() => {
    localStorage.removeItem("feed_resposta_" + chaveDispositivo + "_" + itemId);
  }).catch(erro => alert("Não consegui cancelar o teu voto: " + erro.message));
}

function responderItemFeedTexto(itemId){
  if(!firebaseFeedAtivo) return;
  const campo = document.getElementById("feed-resposta-texto-" + itemId);
  const texto = (campo && campo.value || "").trim();
  if(!texto) return;
  const chaveDispositivo = chaveDispositivoFeed();
  dbFeed().ref("feed_itens/" + itemId + "/respostas/" + chaveDispositivo).set({
    valor: texto, data: firebase.database.ServerValue.TIMESTAMP
  }).then(() => {
    localStorage.setItem("feed_resposta_" + chaveDispositivo + "_" + itemId, texto);
  }).catch(erro => alert("Não consegui enviar a tua resposta: " + erro.message));
}

iniciarListenerFeed();

/* =====================================================================
   LIGAÇÃO WEBPLAY ⇄ ÁREA DE PUBLICAÇÃO
   1) Catálogo manual (catalogo.json, o mesmo da Área de publicação) entra no
      Webplay com a mesma apresentação de cards da SuperFlixAPI.
   2) Episódios publicados à mão aparecem na lista de episódios como se fossem
      da API; se a API já tiver aquele episódio, o da API prevalece.
   3) O "+" leva à Área de publicação e acende verde/vermelho com o correio.
   Ajuste os dois endereços abaixo se os ficheiros estiverem noutra pasta.
   ===================================================================== */
const URL_AREA_PUBLICACAO = "index.html";
const URL_CATALOGO_MANUAL = "catalogo.json";

// pastas (Google Drive / Mega) com vários episódios dentro: mostradas numa moldura (iframe)
function isPastaLink(l){
  return /drive\.google\.com\/(drive\/(u\/\d+\/)?folders|embeddedfolderview)|mega\.(nz|io)\/(folder\/|#F!)/i.test(l || "");
}
function embedDaPasta(link){
  let r = link.match(/drive\.google\.com\/drive\/(?:u\/\d+\/)?folders\/([\w-]+)/i) || link.match(/drive\.google\.com\/embeddedfolderview\?id=([\w-]+)/i);
  if(r) return "https://drive.google.com/embeddedfolderview?id=" + r[1] + "#list";
  r = link.match(/mega\.(?:nz|io)\/folder\/([^#?\s]+)(#[^\s]+)?/i);
  if(r) return "https://mega.nz/embed/" + r[1] + (r[2] || "");
  r = link.match(/mega\.nz\/#F!([^!\s]+)!([^\s]+)/i);
  if(r) return "https://mega.nz/embed/" + r[1] + "#" + r[2];
  return link;
}
function epsDaTemporada(m, t, incluirBlocos){
  return m.episodios.filter(e => {
    if(isPastaLink(e.link)) return false;
    if(e.bloco) return incluirBlocos && t >= e.t && t <= (e.tAte || e.t);
    return e.t === t;
  });
}
function pastasDaTemporada(m, t){
  const itens = [], vistos = new Set();
  m.episodios.forEach(e => {
    const fim = e.bloco ? (e.tAte || e.t) : e.t;
    if(t >= e.t && t <= fim && isPastaLink(e.link) && !vistos.has(e.link)){
      vistos.add(e.link);
      itens.push({ link: e.link, de: e.bloco ? null : e.e, ate: e.ate || null });
    }
  });
  if(m.linkPasta && m.episodios.length === 0) itens.push({ link: m.linkPasta });
  return itens;
}
function criarBlocoPasta(item, temporada, rotulo){
  const link = typeof item === "string" ? item : item.link;
  const faixa = (item && item.de) ? (item.ate && item.ate !== item.de ? " · Episódios " + item.de + " a " + item.ate : " · Episódio " + item.de) : "";
  const el = document.createElement("div");
  el.className = "bloco-pasta";
  el.innerHTML = '<div class="bloco-pasta-in"><div class="bloco-pasta-cab"><span class="bloco-pasta-selo"></span><span class="bloco-pasta-tit"></span><a class="bloco-pasta-abrir" target="_blank" rel="noopener">Abrir ↗</a></div><div class="bloco-pasta-moldura"><iframe loading="lazy" allowfullscreen referrerpolicy="no-referrer"></iframe></div></div>';
  el.querySelector(".bloco-pasta-selo").textContent = rotulo || "Servidor 1";
  el.querySelector(".bloco-pasta-tit").textContent = "Pasta · Temporada " + temporada + faixa;
  el.querySelector(".bloco-pasta-abrir").href = link;
  el.querySelector("iframe").src = embedDaPasta(link);
  return el;
}
function normTituloManual(t){
  return String(t || "").normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().replace(/[^a-z0-9]+/g, " ").trim();
}
function catDoTipoManual(tipo){
  const t = normTituloManual(tipo);
  if(t === "filme") return "filme";
  if(t === "anime") return "anime";
  if(t === "dorama") return "dorama";
  return "serie";
}
function normalizarItemManual(raw){
  if(!raw || !raw.titulo) return null;
  const cat = catDoTipoManual(raw.tipo);
  const m = {
    raw, cat,
    titulo: String(raw.titulo), ano: String(raw.ano || ""),
    slug: "m_" + cat + "_" + (normTituloManual(raw.titulo).replace(/ /g, "_") || "sem_titulo"),
    capa: raw.capa || "", sinopse: raw.sinopse || "", genero: raw.genero || "",
    idade: raw.idade || "", audio: raw.audio || "", status: raw.status || "",
    criador: raw.criador_nome || "", link: raw.drive || "",
    episodios: [], partes: [], apiId: null, d: null
  };
  m.linkPasta = isPastaLink(m.link) ? m.link : "";
  (raw.episodios || []).forEach(ep => {
    const tit = String(ep.titulo || "").toUpperCase().trim();
    const link = ep.link || "";
    if(!link) return;
    let r = tit.match(/^T(\d+)\s*EP\s*(\d+)(?:\s*[-–]\s*(\d+))?/);
    if(r){ m.episodios.push({ t: +r[1], e: +r[2], ate: r[3] ? +r[3] : null, link }); return; }
    r = tit.match(/^TEMPORADA\s*(\d+)(?:\s*[-–]\s*(\d+))?/);
    if(r){ m.episodios.push({ t: +r[1], e: 0, bloco: true, tAte: r[2] ? +r[2] : null, link }); return; }
    r = tit.match(/^FILME\s*(\d+)/);
    if(r){ m.partes.push({ n: +r[1], link }); return; }
    r = tit.match(/^EPIS[ÓO]DIO\s*(\d+)/);
    if(r){ m.episodios.push({ t: 1, e: +r[1], link }); return; }
    // título genérico (ex.: uma pasta única publicada com o nome da obra) → bloco da temporada 1
    if(m.cat !== "filme") m.episodios.push({ t: 1, e: 0, bloco: true, link });
  });
  return m;
}

let catalogoManual = [];
const manuaisPorApi = {}; // "cat:tmdbId" -> item manual que complementa um título da API
const catalogoManualPronto = (async () => {
  try{
    const r = await fetch(URL_CATALOGO_MANUAL, { cache: "no-store" });
    if(!r.ok) return;
    const j = await r.json();
    if(Array.isArray(j)) catalogoManual = j.map(normalizarItemManual).filter(Boolean);
  }catch(e){ console.warn("catalogo.json não carregou — só a SuperFlixAPI será mostrada.", e); }
})();
function manualPorSlug(slug){ return catalogoManual.find(m => m.slug === slug) || null; }

function detalheManual(m){
  if(m.d) return m.d;
  const temps = m.episodios.map(e => e.tAte || e.t);
  m.d = {
    tmdbId: m.slug, manual: true, cat: m.cat, title: m.titulo, tituloOriginal: "",
    year: m.ano, poster: m.capa || null, seasons: temps.length ? Math.max(...temps) : 1,
    genre: m.genero, overview: m.sinopse, tipoLabel: TIPO_LABEL[m.cat] || m.cat,
    nota: 0, ultimoEpisodio: null, idade: m.idade, audio: m.audio, status: m.status, criador: m.criador
  };
  return m.d;
}

// liga um título manual a um título da API só quando o admin gravou o tmdb_id (nunca pelo nome)
async function resolverManualComAPI(m, cat, idsSet){
  if(m.resolvido) return;
  m.resolvido = true;
  try{
    // o painel de administração grava o tmdb_id quando confirma a publicação: liga direto à API, sem adivinhar pelo nome
    if(m.raw && m.raw.tmdb_id){
      const idDireto = Number(m.raw.tmdb_id);
      if(idsSet.has(idDireto) || idsSet.has(String(idDireto))){ m.apiId = idDireto; manuaisPorApi[cat + ":" + idDireto] = m; return; }
    }
    // sem tmdb_id gravado pelo admin, NÃO se liga pelo nome: dois títulos com o mesmo nome podem ser obras diferentes
  }catch(e){}
}

// junta o catálogo manual à lista de IDs da API: 2026 (ano atual) entra nos últimos lançamentos
const _fetchAllIdsOriginal = fetchAllIdsForCategory;
fetchAllIdsForCategory = async function(cat){
  const apiIds = await _fetchAllIdsOriginal(cat);
  try{
    await catalogoManualPronto;
    const manuais = catalogoManual.filter(m => m.cat === cat);
    if(!manuais.length) return apiIds;
    const idsSet = new Set();
    apiIds.forEach(it => {
      const b = typeof it === "object" ? (it.id ?? it.tmdb_id) : it;
      if(b != null){ idsSet.add(b); idsSet.add(Number(b)); idsSet.add(String(b)); }
    });
    await Promise.race([
      executarEmLotes(manuais, 3, m => resolverManualComAPI(m, cat, idsSet)),
      new Promise(res => setTimeout(res, 5000))
    ]);
    const anoAtual = new Date().getFullYear();
    const soltos = manuais.filter(m => !m.apiId);
    const recentes = soltos.filter(m => Number(m.ano) >= anoAtual).map(m => ({ manual: true, slug: m.slug }));
    const antigos = soltos.filter(m => !(Number(m.ano) >= anoAtual)).map(m => ({ manual: true, slug: m.slug }));
    return [...recentes, ...apiIds, ...antigos];
  }catch(e){
    console.warn("Não consegui juntar o catálogo manual:", e);
    return apiIds;
  }
};

const _tmdbDetailsForOriginal = tmdbDetailsFor;
tmdbDetailsFor = async function(cat, item, opcoes){
  let slug = null;
  if(item && typeof item === "object" && item.manual) slug = item.slug;
  else if(typeof item === "string" && item.indexOf("m_") === 0) slug = item;
  if(slug){
    await catalogoManualPronto;
    const m = manualPorSlug(slug);
    return m ? detalheManual(m) : null;
  }
  const r = await _tmdbDetailsForOriginal(cat, item, opcoes);
  if(r){
    const m = manuaisPorApi[cat + ":" + r.tmdbId];
    if(m && m.episodios.length){
      const maxT = Math.max(...m.episodios.map(e => e.tAte || e.t));
      if(!r.seasons || r.seasons < maxT) r.seasons = maxT;
    }
  }
  return r;
};

/* ---- abrir o conteúdo de outro site (links do catálogo manual) ---- */
function linkManualDe(m, t, e){
  if(m.cat === "filme") return m.link || (m.partes[0] && m.partes[0].link) || "";
  const ep = m.episodios.find(x => x.t === Number(t) && x.e === Number(e) && !isPastaLink(x.link)) || m.episodios.find(x => x.bloco && Number(t) >= x.t && Number(t) <= (x.tAte || x.t));
  return ep ? ep.link : "";
}
function abrirLinkManual(link){
  if(!link){ alert("Este conteúdo ainda não tem link disponível."); return; }
  window.open(link, "_blank", "noopener");
}
const _abrirComFallbackOriginal = abrirComFallback;
abrirComFallback = function(payload){
  if(payload && payload.manual){
    const m = manualPorSlug(payload.tmdbId);
    if(m){ abrirLinkManual(linkManualDe(m, payload.temporadaEscolhida, payload.episodioEscolhido)); return; }
  }
  return _abrirComFallbackOriginal(payload);
};
const _openPlayerOriginal = openPlayer;
openPlayer = function(d){
  if(d && d.manual){ abrirComFallback(d); return; }
  return _openPlayerOriginal(d);
};

/* ---- ficha do título: especificações (idade, dublado/legendado...) dos publicados à mão ---- */
const _abrirDetalhesOriginal = abrirDetalhes;
abrirDetalhes = function(d){
  _abrirDetalhesOriginal(d);
  const antigo = document.getElementById("espec-manual");
  if(antigo) antigo.remove();
  if(!d || !d.manual) return;
  const m = manualPorSlug(d.tmdbId);
  const box = document.createElement("div");
  box.id = "espec-manual";
  box.className = "espec-manual";
  const audio = { "DUB": "Dublado", "SUB": "Legendado" }[String(d.audio).toUpperCase()] || (d.audio ? "Sem dublagem/legenda" : "");
  const idade = d.idade ? (String(d.idade).toUpperCase() === "L" ? "Livre" : "+" + d.idade) : "";
  [idade, audio, d.status, d.criador ? "por " + d.criador : ""].filter(Boolean).forEach(t => {
    const sp = document.createElement("span"); sp.textContent = t; box.appendChild(sp);
  });
  if(m && m.cat === "filme"){
    detalhesBtnAssistir.onclick = () => { fecharDetalhes(); abrirLinkManual(linkManualDe(m)); };
    document.getElementById("detalhesBtnBaixar").onclick = () => baixarNo1DM(linkManualDe(m), true);
    m.partes.filter(pt => pt.link && pt.link !== linkManualDe(m)).forEach(pt => {
      const b = document.createElement("button");
      b.type = "button"; b.className = "btn-parte-manual"; b.textContent = "Filme " + pt.n;
      b.onclick = () => abrirLinkManual(pt.link);
      box.appendChild(b);
    });
  }
  detalhesSinopse.insertAdjacentElement("beforebegin", box);
};

/* ---- episódios: manual puro, ou API + episódios publicados à mão ---- */
const _cacheApiTemEp = {};
async function apiTemEpisodio(d, t, e){
  const k = d.cat + ":" + d.tmdbId + ":" + t + ":" + e;
  if(k in _cacheApiTemEp) return _cacheApiTemEp[k];
  let res = null;
  try{
    const url = SERVIDORES[0].serie(d.tmdbId, t, e, d.cat);
    const r = await fetch(OWN_PROXY + encodeURIComponent(url));
    const txt = await r.text();
    if(!r.ok) res = (r.status === 404) ? false : null;
    else if(txt.trim().length < 300 || /n[ãa]o\s+encontrad|not\s+found|indispon[ií]vel|unavailable|em\s+breve|coming\s+soon/i.test(txt)) res = false;
    else res = true;
  }catch(err){ res = null; }
  _cacheApiTemEp[k] = res;
  return res;
}
function linhaEpisodioManual(d, temporada, ep, epTmdb){
  const n = ep.e || 1;
  const nome = ep.bloco ? "Temporada completa" : ((epTmdb && epTmdb.name) || "Episódio " + n);
  // mesma apresentação dos episódios da API: usa título/imagem/data/sinopse da TMDB quando existirem
  const dados = epTmdb ? Object.assign({}, epTmdb, { episode_number: n, name: nome }) : { episode_number: n, name: nome };
  const base = criarLinhaEpisodio(d, temporada, dados);
  const linha = base.cloneNode(true); // tira os cliques de reproduzir da API
  linha._ep = dados;
  linha.dataset.epManual = String(n);
  linha.querySelector(".episodio-baixar").addEventListener("click", e => { e.stopPropagation(); baixarNo1DM(ep.link, true); });
  linha.querySelector(".episodio-partilhar").addEventListener("click", e => { e.stopPropagation(); partilharTitulo(d, temporada, n, nome); });
  linha.addEventListener("click", () => {
    try{ registrarCliqueHistorico({ ...d, temporadaEscolhida: temporada, episodioEscolhido: n }); montarContinuarAssistindo(); }catch(e){}
    abrirLinkManual(ep.link);
  });
  return linha;
}
function numeroDaLinhaEpisodio(linha){
  if(linha.dataset.epManual) return Number(linha.dataset.epManual);
  const el = linha.querySelector(".episodio-num-nome");
  const r = el ? el.textContent.match(/EP\s*\d+x(\d+)/) : null;
  return r ? Number(r[1]) : null;
}
async function mesclarEpisodiosManuais(d, m, temporada){
  const eps = epsDaTemporada(m, temporada, false).sort((a, b) => a.e - b.e);
  for(const ep of eps){
    // o episódio publicado à mão prevalece: se a API também tiver este episódio, o dela é omitido e fica o do usuário
    if(!telaEpisodios.classList.contains("aberta")) return;
    const linhas = Array.from(episodiosLista.querySelectorAll(".episodio-linha"));
    const igual = linhas.find(l => numeroDaLinhaEpisodio(l) === ep.e);
    const nova = linhaEpisodioManual(d, temporada, ep, igual && igual._ep);
    if(igual){ igual.replaceWith(nova); continue; }
    const depois = linhas.find(l => (numeroDaLinhaEpisodio(l) || 0) > ep.e);
    if(depois) episodiosLista.insertBefore(nova, depois); else episodiosLista.appendChild(nova);
  }
}
const _abrirTelaEpisodiosOriginal = abrirTelaEpisodios;
abrirTelaEpisodios = async function(d, temporada){
  if(d && d.manual){
    const m = manualPorSlug(d.tmdbId);
    episodiosTitulo.textContent = `${d.title} · Temporada ${temporada}`;
    episodiosLista.innerHTML = "";
    telaEpisodios.classList.add("aberta");
    const eps = m ? epsDaTemporada(m, temporada, true).sort((a, b) => a.e - b.e) : [];
    const pastas = m ? pastasDaTemporada(m, temporada) : [];
    if(!eps.length && !pastas.length){ episodiosLista.innerHTML = '<p class="empty">Sem episódios nesta temporada.</p>'; return; }
    eps.forEach(ep => episodiosLista.appendChild(linhaEpisodioManual(d, temporada, ep)));
    pastas.forEach(it => episodiosLista.appendChild(criarBlocoPasta(it, temporada, eps.length ? "Servidor 1" : "Pasta")));
    return;
  }
  await _abrirTelaEpisodiosOriginal(d, temporada);
  const m = d && manuaisPorApi[d.cat + ":" + d.tmdbId];
  if(m){
    await mesclarEpisodiosManuais(d, m, temporada);
    const pastas = pastasDaTemporada(m, temporada);
    if(pastas.length && telaEpisodios.classList.contains("aberta")){
      // mostra só o que a API tem (1, 2, 3...) e a pasta logo a seguir, como uma continuação
      const linhas = Array.from(episodiosLista.querySelectorAll(".episodio-linha")).filter(l => !l.dataset.epManual);
      const sonda = await Promise.all(linhas.map(l => apiTemEpisodio(d, temporada, numeroDaLinhaEpisodio(l))));
      const primeiroFalta = sonda.findIndex(v => v === false);
      if(primeiroFalta >= 0) linhas.slice(primeiroFalta).forEach(l => l.remove());
      pastas.forEach(it => episodiosLista.appendChild(criarBlocoPasta(it, temporada, "Servidor 1")));
    }
  }
};

/* ---- pesquisa: também encontra os publicados à mão ---- */
const _runSearchOriginal = runSearch;
runSearch = async function(q){
  await _runSearchOriginal(q);
  try{
    await catalogoManualPronto;
    const alvo = normTituloManual(q);
    if(!alvo || searchTrack.querySelector(".loading")) return;
    const aba = CATEGORIA_DA_ABA[abaAtualAtiva];
    const achados = catalogoManual.filter(m => !m.apiId && (!aba || m.cat === aba) && normTituloManual(m.titulo).includes(alvo));
    if(!achados.length) return;
    const vazio = searchTrack.querySelector(".empty");
    if(vazio) vazio.remove();
    achados.slice(0, 20).forEach(m => searchTrack.appendChild(buildCard(detalheManual(m))));
  }catch(e){}
};

/* ---- "+": cor do correio (verde = aprovado, vermelho = recusado) ---- */
const CFG_FIREBASE_CHAT_PUB = {
  apiKey: "AIzaSyCAzGTh4cIXSRr-fbz1qW14yx_3W6QW000",
  authDomain: "sms2-6d64c.firebaseapp.com",
  databaseURL: "https://sms2-6d64c-default-rtdb.firebaseio.com",
  projectId: "sms2-6d64c",
  storageBucket: "sms2-6d64c.firebasestorage.app",
  messagingSenderId: "62215552810",
  appId: "1:62215552810:web:7ae3e69edcc8e9be41a853"
};
const CAMINHO_MENSAGENS_CHAT_PUB = "mensagens_yyago_chat";
const CHAVE_NOTIF_LIDAS_PUB = "webplay_notificacoes_lidas"; // a mesma da Área de publicação
let estadoCorreioMais = null; // "aprovado" | "negado" | null
const notificacoesPendentesMais = new Map();

function notificacoesLidasMais(){
  try{ return new Set(JSON.parse(localStorage.getItem(CHAVE_NOTIF_LIDAS_PUB) || "[]")); }catch(e){ return new Set(); }
}
function atualizarCorMais(){
  const lidas = notificacoesLidasMais();
  const valores = [];
  notificacoesPendentesMais.forEach((v, k) => { if(!lidas.has(k)) valores.push(v); });
  estadoCorreioMais = valores.includes("negado") ? "negado" : (valores.includes("aprovado") ? "aprovado" : null);
  ["btnMaisLateral", "btnMaisCabecalho"].forEach(id => {
    const el = document.getElementById(id);
    if(!el) return;
    el.classList.toggle("mais-aprovado", estadoCorreioMais === "aprovado");
    el.classList.toggle("mais-negado", estadoCorreioMais === "negado");
  });
}
function iniciarCorreioMais(){
  const nome = (localStorage.getItem("meu_nome_criador") || "").trim().toLowerCase();
  if(!nome) return; // este aparelho ainda não publicou nada
  try{
    const app = firebase.initializeApp(CFG_FIREBASE_CHAT_PUB, "chatpub");
    app.database().ref(CAMINHO_MENSAGENS_CHAT_PUB).on("child_added", snap => {
      const msg = snap.val();
      if(!msg || (msg.notificacao !== "aprovado" && msg.notificacao !== "negado")) return;
      if(String(msg.destinatario || "").trim().toLowerCase() !== nome) return;
      notificacoesPendentesMais.set(snap.key, msg.notificacao);
      atualizarCorMais();
    });
  }catch(e){ console.warn("Correio do + indisponível:", e); }
}
window.addEventListener("pageshow", atualizarCorMais); // ao voltar da Área de publicação, já vem lido
document.addEventListener("visibilitychange", () => { if(!document.hidden) atualizarCorMais(); });
iniciarCorreioMais();

/* ============ INÍCIO: carrega as 4 categorias em segundo plano ============
   Alimenta ao mesmo tempo: a grelha completa de cada aba, a prévia
   "Últimos lançamentos" da página Início, e o índice de pesquisa global —
   e, quando todas terminarem, monta o banner de destaques acima. */
Promise.all(Object.values(CATEGORIA_DA_ABA).map(loadCategory)).then(() => {
  montarBannerDestaques();
  montarUltimosEpisodios(); // NOVO: só dá pra ordenar por episódio mais recente depois de todas as categorias carregarem
  ampliarUltimosEpisodios(); // famosos e assistidos que lançaram episódio, mesmo não sendo novos no site
});
abrirDetalhesPelaUrl(); // LINK DIRETO: se a URL tem ?cat=&id=, abre direto a capa
renderizarTodosOsMaisAcessados(); // NOVO: já não depende de a pessoa clicar em nenhum ícone
montarContinuarAssistindo(); // NOVO: mostra logo o que já estava no histórico deste aparelho, antes mesmo de clicar em algo novo
</script>
<script>
/* =====================================================================
   TEMAS AUTOMÁTICOS (ligados ao temas.json gerido no index do ADM)
   Lê o temas.json da mesma pasta e aplica sozinho, ao vivo, o tema cuja
   data/hora bateu com o momento atual — exatamente a mesma regra do
   painel de administração. Se o ficheiro não existir, não faz nada.
   ===================================================================== */
(function () {
  var temas = [], idAtual = undefined, jsRodou = false;
  var CHAVE = 'webplay_tema_automatico'; // '0' = desligado; qualquer outra coisa = ligado (padrão)
  function ligado() { try { return localStorage.getItem(CHAVE) !== '0'; } catch (e) { return true; } }
  function atualizarEstadoNoPerfil(t) {
    var chk = document.getElementById('chkTemaAuto'), est = document.getElementById('temaAutoEstado');
    if (chk) chk.checked = ligado();
    if (typeof window.atualizarControlesTema === 'function') window.atualizarControlesTema();
    if (est) est.textContent = !ligado() ? 'Automático desligado.'
      : (t ? 'Agora ativo: ' + (t.nome || t.titulo || 'tema especial') : 'Ligado — nenhum tema especial hoje.');
  }
  window.webplayTemaAutomatico = {
    ativo: ligado,
    definir: function (v) {
      try { localStorage.setItem(CHAVE, v ? '1' : '0'); } catch (e) {}
      if (!v && jsRodou) { location.reload(); return; } // um tema com animação em JS só se desfaz recarregando
      aplicar();
    },
    atualizar: function () { atualizarEstadoNoPerfil(ativoAgora()); }
  };
  function ativoAgora() {
    var ag = new Date(), dia = ag.getDate(), mes = ag.getMonth() + 1, ano = ag.getFullYear();
    var hm = String(ag.getHours()).padStart(2, '0') + ':' + String(ag.getMinutes()).padStart(2, '0');
    return (temas || []).find(function (t) {
      if (!t || t.categoria === 'lixo') return false;
      if (!t.data || !t.data.mes) return false;
      if (t.data.ano && t.data.ano !== ano) return false;
      if (t.data.mes !== mes) return false;
      if (t.data.dia && t.data.dia !== dia) return false;
      if (t.data.horaInicio && t.data.horaFim && (hm < t.data.horaInicio || hm > t.data.horaFim)) return false;
      return true;
    }) || null;
  }
  function aplicar() {
    var t = ligado() ? ativoAgora() : null;
    var id = t ? String(t.id || t.nome || 'tema') : null;
    atualizarEstadoNoPerfil(t);
    if (id === idAtual) return;
    idAtual = id;
    var st = document.getElementById('tema-automatico-css');
    if (!st) { st = document.createElement('style'); st.id = 'tema-automatico-css'; document.head.appendChild(st); }
    st.textContent = t ? (t.css || '') : '';
    var bx = document.getElementById('tema-automatico-html');
    if (!bx) { bx = document.createElement('div'); bx.id = 'tema-automatico-html'; document.body.appendChild(bx); }
    bx.innerHTML = (t && t.html) ? t.html : '';
    if (t && t.js) { jsRodou = true; try { new Function(t.js)(); } catch (e) { console.warn('Erro no JS do tema automático:', e); } }
  }
  async function carregar() {
    try {
      var r = await fetch('temas.json', { cache: 'no-store' });
      if (r.ok) { var j = await r.json(); if (Array.isArray(j)) temas = j; }
    } catch (e) {}
    aplicar();
  }
  document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'chkTemaAuto') window.webplayTemaAutomatico.definir(e.target.checked);
  });
  carregar();
  setInterval(aplicar, 20000);
  setInterval(carregar, 5 * 60 * 1000);
})();
</script>


<style>
  #ligarServidor{position:fixed;inset:0;z-index:3000;background:radial-gradient(ellipse at 50% 40%,color-mix(in srgb,var(--accent,#e0a33c) 18%,var(--bg,#0d0f14)) 0%,var(--bg,#0d0f14) 64%);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:26px;transition:opacity .35s;}
  #ligarServidor.some{opacity:0;pointer-events:none;}
  #ligarServidor .roda{position:relative;width:78px;height:78px;border-radius:50%;box-shadow:inset 0 0 0 6px color-mix(in srgb,var(--line,#2a2f3a) 75%,transparent);}
  #ligarServidor .roda::before{content:"";position:absolute;inset:0;border-radius:50%;background:conic-gradient(from 0deg,transparent 0 30%,var(--accent,#e0a33c) 100%);-webkit-mask:radial-gradient(farthest-side,transparent calc(100% - 7px),#000 calc(100% - 6px));mask:radial-gradient(farthest-side,transparent calc(100% - 7px),#000 calc(100% - 6px));animation:girarServ 1s linear infinite;filter:drop-shadow(0 0 7px color-mix(in srgb,var(--accent,#e0a33c) 75%,transparent));}
  #ligarServidor .roda::after{content:"";position:absolute;inset:27px;border-radius:50%;background:var(--accent,#e0a33c);box-shadow:0 0 18px color-mix(in srgb,var(--accent,#e0a33c) 80%,transparent);animation:pulsoServ 1.4s ease-in-out infinite;}
  #ligarServidor span{color:var(--ink,#eee);font-size:1.02rem;font-weight:600;letter-spacing:.06em;min-width:12.5em;text-align:left;}
  #ligarServidor span::after{content:"";animation:pontosServ 1.4s steps(1,end) infinite;}
  @keyframes girarServ{to{transform:rotate(360deg);}}
  @keyframes pulsoServ{0%,100%{transform:scale(.55);opacity:.55;}50%{transform:scale(1);opacity:1;}}
  @keyframes pontosServ{0%{content:"";}25%{content:".";}50%{content:"..";}75%{content:"...";}}
</style>
<div id="ligarServidor"><div class="roda"></div><span>A ligar ao servidor</span></div>
<script>
(function(){
  var el = document.getElementById("ligarServidor"), inicio = Date.now(), feito = false;
  function fechar(){
    if(feito) return; feito = true;
    var espera = Math.max(0, 900 - (Date.now() - inicio)); // nunca pisca nem fica preso
    setTimeout(function(){ el.classList.add("some"); setTimeout(function(){ el.remove(); }, 400); }, espera);
  }
  // espera TODAS as capas que estão no ecrã abrirem (as de mais abaixo são "lazy" e só carregam
  // ao descer, por isso só contam as visíveis). Fecha quando não há nenhuma por abrir durante ~1,2 s.
  var estavel = 0;
  var vigiaCapas = setInterval(function(){
    if(feito){ clearInterval(vigiaCapas); return; }
    var imgs = document.querySelectorAll("#page-inicio .card img.poster, #page-inicio .card .poster img"), total = 0, faltam = 0;
    for(var i = 0; i < imgs.length; i++){
      var r = imgs[i].getBoundingClientRect();
      if(r.width === 0 || r.top > window.innerHeight || r.bottom < 0) continue;   // fora do ecrã
      total++; if(!imgs[i].complete) faltam++;
    }
    if(total > 0 && faltam === 0){ if(++estavel >= 3){ clearInterval(vigiaCapas); fechar(); } } else estavel = 0;
  }, 400);
  // segurança: em TODAS as entradas (1ª vez ou não) espera no máximo 15 s (se as capas não abrirem)
  var LIGAR_SERVIDOR_MAX_S = 15;
  setTimeout(fechar, LIGAR_SERVIDOR_MAX_S * 1000);
})();
</script>


<!-- ===== Aparência: Listas, Estilo (Netflix/Prime...), Texto e tamanho ===== -->
<style>
  /* Estilo do site (aproximação dos desenhos) */
  :root[data-layout="netflix"]{--accent:#e50914;--accent-dim:#8c0710;}
  :root[data-layout="netflix"]:not([data-tema="claro"]):not([data-tema="aqua"]):not([data-tema="oceano"]){--bg:#141414;--panel:#1f1f1f;--line:#2e2e2e;}
  html[data-layout="netflix"] .card,html[data-layout="netflix"] .card .poster{border-radius:4px !important;}
  html[data-layout="netflix"] .btn-play-principal,html[data-layout="netflix"] .banner-btn,html[data-layout="netflix"] .mcb-principal,html[data-layout="netflix"] .bv-btn.principal{color:#fff !important;border-radius:6px !important;}
  :root[data-layout="prime"]{--accent:#00a8e1;--accent-dim:#0b6f94;}
  :root[data-layout="prime"]:not([data-tema="claro"]):not([data-tema="aqua"]):not([data-tema="oceano"]){--bg:#0f171e;--panel:#1a242f;--line:#2b3846;}
  html[data-layout="prime"] .card,html[data-layout="prime"] .card .poster{border-radius:10px !important;}
  html[data-layout="prime"] .btn-play-principal,html[data-layout="prime"] .banner-btn,html[data-layout="prime"] .mcb-principal,html[data-layout="prime"] .bv-btn.principal{color:#fff !important;}
  html[data-layout="simples"] *{box-shadow:none !important;text-shadow:none !important;}
  html[data-layout="simples"] .card,html[data-layout="simples"] .card .poster{border-radius:6px !important;}
  html[data-layout="simples"] .btn-play-principal{border-radius:10px !important;}
  /* alinhamento do texto */
  html[data-texto="centro"] .card .t,html[data-texto="centro"] .card .meta,html[data-texto="centro"] .row-head h2,html[data-texto="centro"] .modal-sinopse-texto,html[data-texto="centro"] .cmt-texto{text-align:center;}
  html[data-texto="esq"] .modal-info-corpo,html[data-texto="esq"] .modal-titulo-principal{text-align:left;}
  html[data-texto="esq"] .modal-meta-linha{justify-content:flex-start;}
  /* janelas */
  #modalOpcoes,#modalListas{position:fixed;inset:0;z-index:4200;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;padding:18px;}
  #modalOpcoes.aberto,#modalListas.aberto{display:flex;}
  .mo-caixa{background:var(--panel);color:var(--ink);border:1px solid var(--line);border-radius:18px;max-width:380px;width:100%;max-height:90vh;display:flex;flex-direction:column;padding:18px;}
  .mo-caixa h2{margin:0 0 10px;font-size:1.15rem;}
  .mo-corpo{overflow-y:auto;}
  .mo-rotulo{font-size:.78rem;color:var(--muted);margin:10px 0 6px;}
  .mo-grupo{display:flex;flex-wrap:wrap;gap:8px;}
  .mo-op{flex:1 1 40%;text-align:left;border:1px solid var(--line);background:none;color:var(--ink);border-radius:12px;padding:10px 12px;cursor:pointer;font-family:inherit;font-weight:700;}
  .mo-op small{display:block;font-weight:400;color:var(--muted);font-size:.7rem;margin-top:2px;}
  .mo-op.ativa{border-color:var(--accent);box-shadow:0 0 0 1px var(--accent) inset;color:var(--accent);}
  .mo-fechar{margin-top:12px;padding:11px;border-radius:12px;border:1px solid var(--accent);background:var(--accent);color:#1a1305;font-weight:800;cursor:pointer;font-family:inherit;}
  .ml-abas{display:flex;gap:8px;margin-bottom:10px;}
  .ml-abas button{flex:1;padding:9px;border-radius:10px;border:1px solid var(--line);background:none;color:var(--muted);font-weight:700;cursor:pointer;font-family:inherit;}
  .ml-abas button.ativa{border-color:var(--accent);color:var(--accent);}
  .ml-grade{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;overflow-y:auto;}
  .ml-item{cursor:pointer;}
  .ml-item img{width:100%;aspect-ratio:2/3;object-fit:cover;border-radius:10px;background:#1d222c;display:block;}
  .ml-item span{display:block;font-size:.68rem;margin-top:3px;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .ml-vazio{color:var(--muted);font-size:.85rem;text-align:center;padding:24px 0;grid-column:1/-1;}
</style>
<div id="modalOpcoes"><div class="mo-caixa"><h2 id="moTitulo"></h2><div class="mo-corpo" id="moCorpo"></div><button type="button" class="mo-fechar" id="moFechar">Pronto</button></div></div>
<div id="modalListas"><div class="mo-caixa">
  <h2>As minhas listas</h2>
  <div class="ml-abas"><button type="button" id="mlAbaLista" class="ativa">Minha lista</button><button type="button" id="mlAbaFav">Favoritos</button></div>
  <div class="ml-grade" id="mlGrade"></div>
  <button type="button" class="mo-fechar" id="mlFecharListas">Fechar</button>
</div></div>
<script>
(function(){
  var K = "webplay_aparencia";
  function ler(){ try{ return JSON.parse(localStorage.getItem(K) || "{}"); }catch(e){ return {}; } }
  function gravar(o){ try{ localStorage.setItem(K, JSON.stringify(o)); }catch(e){} }
  var estado = ler();
  var TAM = { pequeno: "88%", normal: "100%", grande: "116%" };
  function aplicar(){
    var h = document.documentElement;
    ["layout","texto"].forEach(function(c){ if(estado[c] && estado[c] !== "auto") h.setAttribute("data-" + c, estado[c]); else h.removeAttribute("data-" + c); });
    h.style.fontSize = (estado.tam && TAM[estado.tam]) ? TAM[estado.tam] : "";
  }
  aplicar();
  var $ = function(id){ return document.getElementById(id); };
  function abrirOpcoes(titulo, grupos){
    $("moTitulo").textContent = titulo;
    var cx = $("moCorpo"); cx.innerHTML = "";
    grupos.forEach(function(g){
      var r = document.createElement("div"); r.className = "mo-rotulo"; r.textContent = g.rotulo; cx.appendChild(r);
      var box = document.createElement("div"); box.className = "mo-grupo"; cx.appendChild(box);
      function pintar(){
        box.innerHTML = "";
        g.ops.forEach(function(o){
          var b = document.createElement("button"); b.type = "button"; b.className = "mo-op" + ((estado[g.chave] || "auto") === o.id ? " ativa" : "");
          b.innerHTML = "<span></span><small></small>"; b.firstChild.textContent = o.nome; b.lastChild.textContent = o.desc || "";
          b.onclick = function(){ estado[g.chave] = o.id; gravar(estado); aplicar(); pintar(); };
          box.appendChild(b);
        });
      }
      pintar();
    });
    $("modalOpcoes").classList.add("aberto");
  }
  $("moFechar").onclick = function(){ $("modalOpcoes").classList.remove("aberto"); };
  $("btnEstiloSite").onclick = function(){
    abrirOpcoes("Como o site se mostra", [{ rotulo: "Desenho", chave: "layout", ops: [
      { id:"auto", nome:"Automático", desc:"O desenho da Webplay" },
      { id:"simples", nome:"Simples", desc:"Limpo, sem sombras" },
      { id:"netflix", nome:"Netflix", desc:"Preto e vermelho" },
      { id:"prime", nome:"Prime Video", desc:"Azul-escuro e azul" } ] }]);
  };
  $("btnTextoSite").onclick = function(){
    abrirOpcoes("Texto", [
      { rotulo: "Tamanho", chave: "tam", ops: [ { id:"pequeno", nome:"Pequeno" }, { id:"auto", nome:"Normal" }, { id:"grande", nome:"Grande" } ] },
      { rotulo: "Alinhamento", chave: "texto", ops: [ { id:"auto", nome:"Automático" }, { id:"centro", nome:"Centralizado" }, { id:"esq", nome:"Ao lado" } ] } ]);
  };
  // Listas
  var aba = "lista";
  function abrirFicha(it){ $("modalListas").classList.remove("aberto"); $("profileOverlay").classList.remove("open"); abrirDetalhes({ cat: it.cat, tmdbId: it.tmdbId, title: it.title, poster: it.poster, year: it.year, tipoLabel: it.tipoLabel }); }
  function desenharListas(){
    $("mlAbaLista").classList.toggle("ativa", aba === "lista"); $("mlAbaFav").classList.toggle("ativa", aba === "fav");
    var g = $("mlGrade"); g.innerHTML = "";
    var l = lerLista(aba === "fav" ? CH_FAV : CH_LISTA);
    if(!l.length){ var v = document.createElement("div"); v.className = "ml-vazio"; v.textContent = aba === "fav" ? "Ainda não tens favoritos. Toca no ♡ na ficha de um título." : "A tua lista está vazia. Toca no botão de lista (+) na ficha de um título."; g.appendChild(v); return; }
    l.forEach(function(it){
      var d = document.createElement("div"); d.className = "ml-item";
      var im = document.createElement("img"); im.src = it.poster || ""; im.alt = ""; im.loading = "lazy"; d.appendChild(im);
      var t = document.createElement("span"); t.textContent = it.title || ""; d.appendChild(t);
      d.onclick = function(){ abrirFicha(it); };
      g.appendChild(d);
    });
  }
  $("btnListas").onclick = function(){ desenharListas(); $("modalListas").classList.add("aberto"); };
  $("mlAbaLista").onclick = function(){ aba = "lista"; desenharListas(); };
  $("mlAbaFav").onclick = function(){ aba = "fav"; desenharListas(); };
  $("mlFecharListas").onclick = function(){ $("modalListas").classList.remove("aberto"); };
})();
</script>
<!-- ===== Tipo de letra: escolha no 1º início e no perfil ===== -->
<style>
  html[data-fonte] body,html[data-fonte] body *{font-family:var(--fonte-app),system-ui,sans-serif !important;}
  html[data-fonte] svg *{font-family:inherit !important;}
  #modalLetra{position:fixed;inset:0;z-index:4200;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;padding:18px;}
  #modalLetra.aberto{display:flex;}
  #modalLetra .ml-caixa{background:var(--panel);color:var(--ink);border:1px solid var(--line);border-radius:18px;max-width:380px;width:100%;max-height:90vh;display:flex;flex-direction:column;padding:18px;}
  #modalLetra h2{margin:0 0 4px;font-size:1.15rem;} #modalLetra p{margin:0 0 10px;font-size:.82rem;color:var(--muted);}
  #modalLetra .ml-lista{overflow-y:auto;display:flex;flex-direction:column;gap:8px;margin-bottom:12px;}
  #modalLetra .ml-op{text-align:left;border:1px solid var(--line);background:none;color:var(--ink);border-radius:12px;padding:10px 12px;cursor:pointer;}
  #modalLetra .ml-op.ativa{border-color:var(--accent);box-shadow:0 0 0 1px var(--accent) inset;}
  #modalLetra .ml-op b{display:block;font-size:1.05rem;} #modalLetra .ml-op small{color:var(--muted);font-size:.7rem;}
  #modalLetra .ml-bot{display:flex;gap:8px;} #modalLetra .ml-bot button{flex:1;padding:11px;border-radius:12px;border:1px solid var(--line);background:none;color:var(--ink);font-weight:700;cursor:pointer;font-family:inherit;}
  #modalLetra .ml-bot .princ{background:var(--accent);border-color:var(--accent);color:#1a1305;}
</style>
<div id="modalLetra"><div class="ml-caixa">
  <h2>Que tipo de letra preferes?</h2>
  <p>Toca numa opção para ver logo o resultado. Podes mudar depois no perfil (Aa).</p>
  <div class="ml-lista" id="mlLista"></div>
  <div class="ml-bot"><button type="button" id="mlPular">Pular</button><button type="button" class="princ" id="mlOk">Guardar</button></div>
</div></div>
<script>
(function(){
  var K = "webplay_fonte";
  var FONTES = [
    { id:"estilo",  nome:"Webplay (padrão)", css:"'Chakra Petch'", fam:"Chakra+Petch:wght@400;600;700" },
    { id:"rajdhani",nome:"Rajdhani",         css:"'Rajdhani'",     fam:"Rajdhani:wght@400;600;700" },
    { id:"poppins", nome:"Poppins",          css:"'Poppins'",      fam:"Poppins:wght@400;600;700" },
    { id:"montserrat",nome:"Montserrat",     css:"'Montserrat'",   fam:"Montserrat:wght@400;600;700" },
    { id:"space",   nome:"Space Grotesk",    css:"'Space Grotesk'",fam:"Space+Grotesk:wght@400;600;700" },
    { id:"quicksand",nome:"Quicksand",       css:"'Quicksand'",    fam:"Quicksand:wght@400;600;700" },
    { id:"playfair",nome:"Playfair Display", css:"'Playfair Display'", fam:"Playfair+Display:wght@400;600;700" },
    { id:"lora",    nome:"Lora",             css:"'Lora'",         fam:"Lora:wght@400;600;700" },
    { id:"classica",nome:"Clássica (a antiga)", css:null, fam:null }
  ];
  function ler(){ try{ return localStorage.getItem(K) || (document.cookie.match(/webplay_fonte=([^;]+)/) || [])[1] || "estilo"; }catch(e){ return "estilo"; } }
  function gravar(id){ try{ localStorage.setItem(K, id); }catch(e){} try{ document.cookie = K + "=" + id + "; max-age=315360000; path=/; SameSite=Lax"; }catch(e){} }
  var carregadas = {};
  function carregar(f){
    if(!f.fam || carregadas[f.id]) return; carregadas[f.id] = 1;
    var l = document.createElement("link"); l.rel = "stylesheet"; l.href = "https://fonts.googleapis.com/css2?family=" + f.fam + "&display=swap"; document.head.appendChild(l);
  }
  function achar(id){ for(var i=0;i<FONTES.length;i++) if(FONTES[i].id === id) return FONTES[i]; return FONTES[0]; }
  function aplicar(id){
    var f = achar(id), h = document.documentElement;
    if(!f.css){ h.removeAttribute("data-fonte"); h.style.removeProperty("--fonte-app"); return; }
    carregar(f); h.style.setProperty("--fonte-app", f.css); h.setAttribute("data-fonte", f.id);
  }
  aplicar(ler());
  var escolhida = ler(), depois = null, original = ler();
  var $ = function(id){ return document.getElementById(id); };
  function desenhar(){
    var cx = $("mlLista"); cx.innerHTML = "";
    FONTES.forEach(function(f){
      carregar(f);
      var b = document.createElement("button"); b.type = "button"; b.className = "ml-op" + (f.id === escolhida ? " ativa" : "");
      b.innerHTML = '<b style="font-family:' + (f.css ? f.css + ',' : '') + 'system-ui,sans-serif !important">Carrie, a Estranha</b><small></small>';
      b.querySelector("small").textContent = f.nome;
      b.onclick = function(){ escolhida = f.id; aplicar(f.id); desenhar(); };
      cx.appendChild(b);
    });
  }
  function fechar(){ $("modalLetra").classList.remove("aberto"); var cb = depois; depois = null; if(cb) cb(); }
  window.webplayAbrirLetra = function(cb){
    depois = cb || null; original = ler(); escolhida = original; desenhar(); $("modalLetra").classList.add("aberto");
  };
  $("mlOk").onclick = function(){ gravar(escolhida); rotulo(); fechar(); };
  $("mlPular").onclick = function(){ aplicar(original); gravar(original); rotulo(); fechar(); }; // pular = fica como estava (padrão)
  function rotulo(){ var e = document.getElementById("letraAtualNome"); if(e) e.textContent = achar(ler()).nome; }
  rotulo();
  $("btnMudarLetra2").onclick = function(){ window.webplayAbrirLetra(null); };
  $("btnPartilharApp").onclick = function(){
    var url = (typeof APP_URL_DOWNLOAD !== "undefined" && APP_URL_DOWNLOAD) ? APP_URL_DOWNLOAD : location.origin + location.pathname;
    partilhaNativa("Webplay — filmes e séries. Instala a app:", url).then(function(ok){
      if(!ok){ try{ navigator.clipboard.writeText(url); if(typeof avisoPartilha === "function") avisoPartilha("Link copiado!"); }catch(e){ prompt("Copia o link:", url); } }
    });
  };
})();
</script>
<!-- ===== Primeira entrada: 1) Bem-vindo  2) Aviso do download com contagem + vídeo ===== -->
<style>
  .bv{position:fixed;inset:0;z-index:4000;background:rgba(0,0,0,.88);display:none;align-items:center;justify-content:center;padding:18px;}
  .bv.aberto{display:flex;}
  .bv-caixa{background:var(--panel);color:var(--ink);border:1px solid var(--line);border-radius:18px;max-width:360px;width:100%;max-height:92vh;overflow-y:auto;padding:22px 18px;text-align:center;}
  .bv-caixa h2{margin:0 0 10px;font-size:1.3rem;}
  .bv-caixa p{margin:0 0 16px;font-size:.9rem;line-height:1.5;color:var(--muted);}
  .bv-btn{display:block;width:100%;margin-top:8px;padding:12px;border-radius:12px;border:1px solid var(--line);background:none;color:var(--ink);font-weight:700;font-size:.92rem;cursor:pointer;font-family:inherit;}
  .bv-btn.principal{background:var(--accent);border-color:var(--accent);color:#1a1305;}
  .bv-btn[disabled]{opacity:.45;cursor:not-allowed;}
  .bv-alerta{border:2px solid var(--accent);animation:bvPulso 1.4s ease-in-out infinite;}
  @keyframes bvPulso{0%,100%{box-shadow:0 0 0 0 rgba(224,163,60,.55);}50%{box-shadow:0 0 0 10px rgba(224,163,60,0);}}
  .bv-selo{display:inline-block;background:var(--accent);color:#1a1305;font-weight:800;font-size:.72rem;letter-spacing:.06em;border-radius:20px;padding:4px 12px;margin-bottom:12px;}
  .bv-topo{display:flex;align-items:center;gap:8px;margin-bottom:10px;text-align:left;}
  .bv-topo b{flex:1;font-size:1.05rem;}
  .bv-conta{font-size:.82rem;font-weight:700;color:var(--accent);}
  .bv-x{width:34px;height:34px;border-radius:50%;border:1px solid var(--line);background:none;color:var(--ink);font-size:.95rem;cursor:pointer;}
  .bv-caixa video,.bv-caixa img{width:100%;border-radius:10px;margin:0 0 10px;background:#000;}
  .bv-caixa ol{text-align:left;font-size:.82rem;line-height:1.5;color:var(--muted);padding-left:20px;margin:0 0 12px;}
</style>
<style>
/* ===== Tamanhos iguais às capturas do app (referência: ecrã 360px = captura 720px ÷ 2) ===== */

/* Cards de poster (Início, Top 10, Recomendações): ~3 por ecrã, 2:3 */
.track{gap:8px;}
.card{flex:0 0 33vw;max-width:160px;min-width:110px;border-radius:12px;}
.card .meta{padding:6px 4px 4px;}
.card .meta .t{font-size:.8rem;}
.card .meta .y{font-size:.68rem;}
.row h2,.row-head h2{font-size:1.1rem;}
.row-head .row-head-sub,.row-head-sub{font-size:.75rem;}

/* Ficha do título */
.modal-info-corpo{padding:0 8px 30px;}
.det-poster-card{width:119px;border-radius:12px;}
.modal-titulo-principal{font-size:1.3rem;line-height:1.2;margin:6px 0 10px;}
.modal-info-corpo .btn-play-principal{border-radius:12px;padding:0;height:44px;font-size:.82rem;letter-spacing:.8px;}
.detalhes-temporada-bloco{gap:8px;margin-bottom:8px;}
.detalhes-temporada-bloco .btn-play-principal{padding:0;height:44px;}
.detalhes-temporada-bloco .seletor-custom,.detalhes-temporada-bloco .seletor-custom-botao{height:44px;border-radius:12px;font-size:.82rem;letter-spacing:.6px;}
.detalhes-temporada-bloco > *{flex:1 1 0;min-width:0;}
.seletor-custom-botao{width:100%;}
.detalhes-acoes{gap:8px;margin:8px 0 10px;}
.btn-acao-detalhes{height:42px;padding:0 8px;border-radius:12px;font-size:.82rem;letter-spacing:.6px;}
.detalhes-abas{border-radius:12px;margin-bottom:8px;}
.aba-det{padding:0;height:46px;font-size:.82rem;letter-spacing:.8px;}
.modal-info-corpo .painel-det#painelDetGeral{border-radius:12px;padding:12px 14px;margin-bottom:12px;}
.modal-sinopse-texto{font-size:.82rem;line-height:1.4;}

/* Avaliações */
.secao-comentarios{margin-top:14px;}
.secao-comentarios-titulo{font-size:1.1rem;font-weight:800;}
.secao-comentarios-sub{font-size:.75rem;}
.btn-ver-todas-coment{font-size:.78rem;}
.cmt{border-radius:12px;padding:9px 9px 8px;margin-bottom:7px;}
.cmt-topo{gap:8px;}
.cmt .comentario-avatar{width:35px;height:35px;font-size:.95rem;}
.cmt-nome{font-size:.82rem;font-weight:700;}
.cmt-estr{font-size:.75rem;gap:6px;}
.cmt-estr b{font-size:.72rem;}
.cmt-data{font-size:.68rem;}
.cmt-texto{margin-top:6px;font-size:.72rem;line-height:1.35;}
.cmt-mais{font-size:.72rem;}
.cmt-rodape{margin-top:6px;}
.cmt .btn-voto{font-size:.72rem;}

.secao-recom{margin-top:14px;text-align:left;}
.secao-recom .secao-comentarios-cabecalho{margin-bottom:10px;}
.secao-recom .track{padding-bottom:6px;}
</style>

<div class="bv" id="bvBemVindo"><div class="bv-caixa">
  <h2>Seja bem-vindo à Webplay</h2>
  <p>Inicia sessão para guardares o teu perfil, votos e comentários. Se preferires, podes fazê-lo mais tarde.</p>
  <button type="button" class="bv-btn principal" id="bvIniciar">Iniciar sessão</button>
  <button type="button" class="bv-btn" id="bvAgoraNao">Agora não</button>
</div></div>
<div class="bv" id="bvDownload"><div class="bv-caixa">
  <div class="bv-topo"><b>Como baixar</b><span class="bv-conta" id="bvConta"></span><button type="button" class="bv-x" id="bvConcluir" aria-label="Fechar" style="display:none">✕</button></div>
  <video id="bvVideo" controls controlslist="nodownload" playsinline preload="auto" style="display:none"></video>
  <img id="bvGif" alt="Passo-a-passo para baixar" style="display:none">
  <ol>
    <li>Configura o 1DM: escolhe um local de armazenamento.</li>
    <li>Toca em ⬇ no episódio ou filme; o 1DM abre a página do vídeo.</li>
    <li>Espera o Cloudflare confirmar, escolhe o servidor e toca em ▶.</li>
    <li>Toca no botão de baixar do 1DM.</li>
  </ol>
</div></div>
<script>
(function(){
  var K1 = "webplay_bv_boasvindas", K2 = "webplay_bv_download", SEG = 10;
  // guarda em 3 sítios (localStorage + cookie de 10 anos + sessão) para o app nunca esquecer
  function ler(k){
    try{ if(localStorage.getItem(k)) return "1"; }catch(e){}
    try{ if(sessionStorage.getItem(k)) return "1"; }catch(e){}
    return (document.cookie.indexOf(k + "=1") >= 0) ? "1" : null;
  }
  function gravar(k){
    try{ localStorage.setItem(k, "1"); }catch(e){}
    try{ sessionStorage.setItem(k, "1"); }catch(e){}
    try{ document.cookie = k + "=1; max-age=315360000; path=/; SameSite=Lax"; }catch(e){}
  }
  var $ = function(id){ return document.getElementById(id); };
  function abrir(id, sim){ $(id).classList.toggle("aberto", sim); }
  function passoLetra(){
    abrir("bvBemVindo", false);
    if(window.webplayAbrirLetra) window.webplayAbrirLetra(null);
  }
  // vídeo primeiro; o X só aparece quando o vídeo termina (uns 39 s); depois pergunta o tipo de letra
  function passoDownload(){
    abrir("bvBemVindo", false); abrir("bvDownload", true);
    var v = $("bvVideo"), g = $("bvGif"), conta = $("bvConta"), x = $("bvConcluir"), pronto = false, tFim = null;
    function liberar(){ if(pronto) return; pronto = true; clearTimeout(tFim); conta.style.display = "none"; x.style.display = ""; }
    function contar(){
      if(pronto) return;
      var rest = Math.ceil((v.duration || 0) - v.currentTime);
      if(rest > 0) conta.textContent = "Podes fechar em " + rest + " s"; else liberar();
    }
    conta.textContent = ""; x.style.display = "none";
    v.addEventListener("timeupdate", contar); v.addEventListener("ended", liberar);
    v.onloadedmetadata = function(){ v.style.display = "block"; contar(); };
    v.onerror = function(){ v.style.display = "none"; g.onload = function(){ g.style.display = "block"; }; g.src = "como-baixar.gif"; setTimeout(liberar, 8000); };
    carregarVideoComoBaixar(v).then(function(){ v.play().catch(function(){ v.muted = true; v.play().catch(function(){}); }); }).catch(function(){ v.onerror(); });
    tFim = setTimeout(liberar, 90000); // segurança: nunca prende a pessoa
    x.onclick = function(){ try{ v.pause(); }catch(e){} gravar(K2); abrir("bvDownload", false); passoLetra(); };
  }
  function passoBemVindo(){
    abrir("bvBemVindo", true);
    $("bvAgoraNao").onclick = function(){ gravar(K1); passoDownload(); };
    $("bvIniciar").onclick = function(){
      gravar(K1); abrir("bvBemVindo", false);
      var ov = $("profileOverlay"), btn = $("profileBtn");
      if(!ov || !btn){ passoDownload(); return; }
      btn.click();
      var mo = new MutationObserver(function(){
        if(!ov.classList.contains("open")){ mo.disconnect(); passoDownload(); }
      });
      mo.observe(ov, { attributes: true, attributeFilter: ["class"] });
    };
  }
  function iniciar(){
    // só aparece UMA vez: marca logo ao mostrar, mesmo que a pessoa volte atrás ou feche o app
    if(ler(K1) || ler(K2)) return;
    gravar(K1); gravar(K2);
    passoBemVindo();
  }
  if(document.readyState === "complete") setTimeout(iniciar, 400); else window.addEventListener("load", function(){ setTimeout(iniciar, 400); });
})();
</script>
<script>
/* ===== Recomendações na ficha do título =====
   - Título da SuperFlixAPI  -> "Recomendações" (TMDB recomendados/semelhantes, só os que existem no catálogo)
   - Título publicado à mão  -> "Outras obras que ele publicou" (mesmo criador no catalogo.json) */
(function(){
  const corpoModal = document.querySelector("#janelaDetalhes .conteudo-modal");
  const blocoComentarios = document.querySelector("#janelaDetalhes .secao-comentarios");
  if(!blocoComentarios) return;

  const sec = document.createElement("div");
  sec.className = "secao-recom";
  sec.id = "secaoRecomendacoes";
  sec.style.display = "none";
  sec.innerHTML = '<div class="secao-comentarios-cabecalho"><div class="secao-tit-bloco">' +
    '<div class="secao-comentarios-titulo" id="recomTitulo"></div>' +
    '<div class="secao-comentarios-sub" id="recomSub"></div></div></div>' +
    '<div class="track" id="recomTrack"></div>';
  blocoComentarios.insertAdjacentElement("afterend", sec);
  const elTitulo = sec.querySelector("#recomTitulo");
  const elSub = sec.querySelector("#recomSub");
  const elTrack = sec.querySelector("#recomTrack");

  const esperar = (ms, v) => new Promise(r => setTimeout(() => r(v), ms));

  async function recomendadosDaApi(d){
    const kind = TMDB_KIND[d.cat];
    if(!kind || !/^\d+$/.test(String(d.tmdbId))) return [];
    let lista = [];
    const juntar = r => ((r && r.results) || []).forEach(x => {
      if(x && x.id && String(x.id) !== String(d.tmdbId) && !lista.some(y => y.id === x.id)) lista.push(x);
    });
    juntar(await tmdb("/" + kind + "/" + d.tmdbId + "/recommendations?language=pt-BR"));
    if(lista.length < 8) juntar(await tmdb("/" + kind + "/" + d.tmdbId + "/similar?language=pt-BR"));
    if(!lista.length) return [];

    // só entra o que a SuperFlixAPI realmente tem (filme -> filme; tv -> série/anime/dorama)
    const cats = kind === "movie" ? ["filme"] : [d.cat, "serie", "anime", "dorama"].filter((c, i, a) => a.indexOf(c) === i);
    const sets = await Promise.all(cats.map(c => Promise.race([catalogIdsProntos[c] || Promise.resolve(null), esperar(6000, null)])));
    const temCatalogo = sets.some(s => s && s.size);
    const escolhidos = [];
    for(const x of lista){
      let cat = null;
      if(temCatalogo){
        const i = sets.findIndex(s => s && (s.has(x.id) || s.has(String(x.id))));
        if(i < 0) continue;
        cat = cats[i];
      } else cat = d.cat;
      escolhidos.push({ id: x.id, cat });
      if(escolhidos.length >= 12) break;
    }
    const dets = await executarEmLotes(escolhidos, 4, it => tmdbDetailsFor(it.cat, it.id));
    return dets.filter(x => x && x.poster);
  }

  function outrasObrasDoCriador(d){
    const nome = normTituloManual(d.criador);
    if(!nome) return [];
    return catalogoManual.filter(m => m.slug !== d.tmdbId && normTituloManual(m.criador) === nome).map(m => detalheManual(m));
  }

  let token = 0;
  async function montarRecomendacoes(d){
    const meu = ++token;
    sec.style.display = "none";
    elTrack.innerHTML = "";
    if(!d) return;
    try{
      let itens, titulo, sub;
      if(d.manual){
        await catalogoManualPronto;
        itens = outrasObrasDoCriador(d);
        titulo = "Outras obras que ele publicou";
        sub = "Publicado por " + d.criador;
      } else {
        itens = await recomendadosDaApi(d);
        titulo = "Recomendações";
        sub = "Baseado no que você está vendo";
      }
      if(meu !== token || !itens.length) return;
      elTitulo.textContent = titulo;
      elSub.textContent = sub;
      itens.forEach(it => elTrack.appendChild(buildCard(it)));
      sec.style.display = "";
    }catch(e){ console.warn("Recomendações não carregaram:", e); }
  }

  const abrirDetalhesAnterior = abrirDetalhes;
  abrirDetalhes = function(d){
    abrirDetalhesAnterior(d);
    if(corpoModal) corpoModal.scrollTop = 0; // ao tocar numa recomendação, a nova ficha abre desde o topo
    montarRecomendacoes(d);
  };
})();
</script>
<style>
/* ===== logo do cabeçalho acompanha o tamanho do texto (rem em vez de px) ===== */
.logo-webplay{height:2.125rem;}
@media (min-width:640px){ .logo-webplay{height:2.75rem;} }
/* ===== cabeçalho oculto (opção no perfil) ===== */
html[data-sem-cab] .logo-webplay{display:none !important;}
html[data-sem-cab] header{background:none;border-bottom:0;padding:0 4vw;min-height:46px;}
html[data-sem-cab] header.pesquisa-aberta{padding-top:50px;padding-bottom:10px;}
html[data-nome-cab] .logo-webplay{aspect-ratio:auto;width:auto;max-width:56vw;min-height:2.125rem;}
html[data-nome-cab] .logo-webplay i,html[data-nome-cab] .logo-webplay .logo-original{display:none !important;}
html[data-nome-cab] .logo-webplay .logo-texto{display:flex !important;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:1.35rem;}
#modalCab{position:fixed;inset:0;z-index:4200;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;padding:18px;}
#modalCab.aberto{display:flex;}
#cabPrev{margin:4px 0 12px;height:54px;border:1px solid var(--line);border-radius:12px;background:var(--bg);display:flex;align-items:center;justify-content:center;color:var(--ink);font-weight:900;font-size:1.3rem;letter-spacing:-.5px;padding:0 12px;overflow:hidden;white-space:nowrap;}
#cabPrev b{color:var(--accent);font-weight:900;} #cabPrev.vazio{font-size:.8rem;font-weight:600;color:var(--muted);letter-spacing:0;}
#modalCab .cab-campo{width:100%;padding:11px 12px;border-radius:12px;border:1px solid var(--line);background:var(--bg);color:var(--ink);font-family:inherit;font-size:.95rem;margin-top:2px;}
#modalCab .cab-campo:focus{outline:2px solid var(--accent);}
#modalCab .cab-repor{margin-top:6px;background:none;border:none;color:var(--accent);font-weight:700;font-size:.8rem;cursor:pointer;font-family:inherit;padding:4px 0;}
#modalCab .bd-bot{display:flex;gap:8px;margin-top:12px;}
#modalCab .bd-bot button{flex:1;margin-top:0;padding:11px;border-radius:12px;border:1px solid var(--line);background:none;color:var(--ink);font-weight:800;cursor:pointer;font-family:inherit;}
#modalCab .bd-bot .mo-fechar{background:var(--accent);border-color:var(--accent);color:#1a1305;}
#btnCabecalhoSite.oculto{border-color:var(--accent);color:var(--accent);}
/* ===== forma da borda (ficha do título + botões ao lado da seta de voltar) ===== */
html[data-borda="media"]{--bd-modal:10px;--bd-btn:10px;}
html[data-borda="quadrada"]{--bd-modal:0px;--bd-btn:4px;}
html[data-borda] .conteudo-modal,html[data-borda] .modal-capa-fundo{border-top-left-radius:var(--bd-modal) !important;border-top-right-radius:var(--bd-modal) !important;}
html[data-borda] .btn-fechar-detalhes,html[data-borda] .btn-lista-detalhes,html[data-borda] .btn-partilhar-detalhes{border-radius:var(--bd-btn) !important;}
#modalBorda{position:fixed;inset:0;z-index:4200;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;padding:18px;}
#modalBorda.aberto{display:flex;}
#bdPrev{--bd-modal:22px;--bd-btn:50%;margin:4px 0 12px;height:132px;overflow:hidden;background:var(--bg);border:1px solid var(--line);border-radius:12px;display:flex;align-items:flex-end;justify-content:center;padding-top:14px;}
#bdPrev[data-forma="media"]{--bd-modal:10px;--bd-btn:10px;}
#bdPrev[data-forma="quadrada"]{--bd-modal:0px;--bd-btn:4px;}
#bdPrev .bd-card{width:78%;height:100%;background:var(--panel);border:1px solid var(--line);border-bottom:0;border-top-left-radius:var(--bd-modal);border-top-right-radius:var(--bd-modal);position:relative;overflow:hidden;transition:border-radius .2s;}
#bdPrev .bd-capa{height:62px;background:linear-gradient(135deg,var(--accent-dim,#555),var(--accent,#999));opacity:.8;}
#bdPrev .bd-b{position:absolute;top:8px;width:26px;height:26px;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:.95rem;border-radius:var(--bd-btn);transition:border-radius .2s;}
#bdPrev .bd-voltar{left:8px;} #bdPrev .bd-fav{right:8px;}
#bdPrev .bd-linhas{padding:10px 12px;display:flex;flex-direction:column;gap:6px;}
#bdPrev .bd-linhas i{display:block;height:7px;border-radius:4px;background:var(--line);} #bdPrev .bd-linhas i:last-child{width:60%;}
#modalBorda .bd-bot{display:flex;gap:8px;margin-top:12px;}
#modalBorda .bd-bot button{flex:1;margin-top:0;padding:11px;border-radius:12px;border:1px solid var(--line);background:none;color:var(--ink);font-weight:800;cursor:pointer;font-family:inherit;}
#modalBorda .bd-bot .mo-fechar{background:var(--accent);border-color:var(--accent);color:#1a1305;}
</style>
<div id="modalBorda"><div class="mo-caixa">
  <h2>Forma da borda</h2>
  <div class="mo-rotulo">Pré-visualização (toca numa opção para ver logo)</div>
  <div id="bdPrev" data-forma="auto"><div class="bd-card"><div class="bd-capa"></div><span class="bd-b bd-voltar">‹</span><span class="bd-b bd-fav">♡</span><div class="bd-linhas"><i></i><i></i></div></div></div>
  <div class="mo-grupo" id="bdOps"></div>
  <div class="bd-bot"><button type="button" id="bdCancelar">Cancelar</button><button type="button" class="mo-fechar" id="bdOk">Guardar</button></div>
</div></div>
<div id="modalCab"><div class="mo-caixa">
  <h2>Cabeçalho</h2>
  <div class="mo-rotulo">Pré-visualização</div>
  <div id="cabPrev"></div>
  <div class="mo-rotulo">Nome no topo (deixa vazio para ficar Webplay)</div>
  <input type="text" id="cabNome" class="cab-campo" maxlength="24" placeholder="Webplay" autocomplete="off">
  <button type="button" class="cab-repor" id="cabRepor">Repor Webplay</button>
  <div class="mo-rotulo">Mostrar</div>
  <div class="mo-grupo" id="cabOps"></div>
  <div class="bd-bot"><button type="button" id="cabCancelar">Cancelar</button><button type="button" class="mo-fechar" id="cabOk">Guardar</button></div>
</div></div>
<script>
(function(){
  var $ = function(id){ return document.getElementById(id); };
  var h = document.documentElement;
  function ler(k){ try{ return localStorage.getItem(k); }catch(e){ return null; } }
  function gravar(k, v){ try{ localStorage.setItem(k, v); }catch(e){} }
  function aviso(t){ if(typeof avisoPartilha === "function") avisoPartilha(t); }

  /* ---- cabeçalho: nome próprio e/ou ocultar (tudo opcional, só nas definições) ---- */
  var bCab = $("btnCabecalhoSite");
  var cabOriginal = { nome: "", oculto: false }, cabAtual = { nome: "", oculto: false };
  // Nome do cabeçalho com o estilo do logótipo: antes da letra do meio = cor normal; dali para a frente = cor do tema;
  // a letra do meio (3.ª em nomes de 4-5 letras, 4.ª em "Webplay") leva o "play".
  function escCab(t){ var d = document.createElement("div"); d.textContent = t; return d.innerHTML; }
  function nomeHTML(n){
    var ch = Array.from(String(n)), len = ch.length;
    if(len < 2) return escCab(n);
    var i = Math.floor(len / 2);
    return escCab(ch.slice(0, i).join("")) + "<b><span class=\"letra-play\">" + escCab(ch[i]) + "</span>" + escCab(ch.slice(i + 1).join("")) + "</b>";
  }
  function lerCab(){ return { nome: (ler("webplay_nome_cab") || "").trim(), oculto: ler("webplay_sem_cab") === "1" }; }
  function aplicarCab(c){
    var nome = (c.nome || "").trim();
    document.querySelectorAll(".logo-webplay .logo-texto").forEach(function(sp){
      if(nome) sp.innerHTML = nomeHTML(nome); else sp.innerHTML = "Web<b>play</b>";
    });
    if(nome) h.setAttribute("data-nome-cab", "1"); else h.removeAttribute("data-nome-cab");
    if(c.oculto) h.setAttribute("data-sem-cab", "1"); else h.removeAttribute("data-sem-cab");
    if(bCab) bCab.classList.toggle("oculto", !!(c.oculto || nome));
  }
  function pintarPrevCab(){
    var pv = $("cabPrev"), n = (cabAtual.nome || "").trim();
    pv.classList.toggle("vazio", cabAtual.oculto);
    if(cabAtual.oculto) pv.textContent = "Sem nome no topo — o conteúdo sobe";
    else if(n) pv.innerHTML = nomeHTML(n); else pv.innerHTML = "Web<b>play</b>";
  }
  function desenharCabOps(){
    var cx = $("cabOps"); cx.innerHTML = "";
    [{ v:false, nome:"Mostrar", desc:"Nome visível no topo" }, { v:true, nome:"Ocultar", desc:"Tira o nome e sobe para o topo" }].forEach(function(o){
      var b = document.createElement("button"); b.type = "button"; b.className = "mo-op" + (cabAtual.oculto === o.v ? " ativa" : "");
      b.innerHTML = "<span></span><small></small>"; b.firstChild.textContent = o.nome; b.lastChild.textContent = o.desc;
      b.onclick = function(){ cabAtual.oculto = o.v; aplicarCab(cabAtual); pintarPrevCab(); desenharCabOps(); };
      cx.appendChild(b);
    });
  }
  aplicarCab(lerCab());
  if(bCab) bCab.onclick = function(){
    cabOriginal = lerCab(); cabAtual = { nome: cabOriginal.nome, oculto: cabOriginal.oculto };
    $("cabNome").value = cabAtual.nome; pintarPrevCab(); desenharCabOps(); $("modalCab").classList.add("aberto");
  };
  $("cabNome").addEventListener("input", function(){ cabAtual.nome = this.value; aplicarCab(cabAtual); pintarPrevCab(); });
  $("cabRepor").onclick = function(){ cabAtual.nome = ""; $("cabNome").value = ""; aplicarCab(cabAtual); pintarPrevCab(); };
  $("cabOk").onclick = function(){
    gravar("webplay_nome_cab", (cabAtual.nome || "").trim()); gravar("webplay_sem_cab", cabAtual.oculto ? "1" : "0");
    $("modalCab").classList.remove("aberto");
  };
  $("cabCancelar").onclick = function(){ aplicarCab(cabOriginal); $("modalCab").classList.remove("aberto"); };

  /* ---- borda: opções com pré-visualização ---- */
  var OPS = [
    { id:"auto",     nome:"Arredondada", desc:"Como está agora" },
    { id:"media",    nome:"Média",       desc:"Cantos suaves" },
    { id:"quadrada", nome:"Quadrada",    desc:"Sem curvas no topo" }
  ];
  var original = "auto", escolhida = "auto";
  function aplicarBorda(id){
    if(id && id !== "auto") h.setAttribute("data-borda", id); else h.removeAttribute("data-borda");
    $("bdPrev").setAttribute("data-forma", id || "auto");
  }
  function desenhar(){
    var cx = $("bdOps"); cx.innerHTML = "";
    OPS.forEach(function(o){
      var b = document.createElement("button"); b.type = "button"; b.className = "mo-op" + (o.id === escolhida ? " ativa" : "");
      b.innerHTML = "<span></span><small></small>"; b.firstChild.textContent = o.nome; b.lastChild.textContent = o.desc;
      b.onclick = function(){ escolhida = o.id; aplicarBorda(o.id); desenhar(); };
      cx.appendChild(b);
    });
  }
  var bBor = $("btnBordaSite");
  if(bBor) bBor.onclick = function(){
    original = ler("webplay_borda") || "auto"; escolhida = original;
    aplicarBorda(escolhida); desenhar(); $("modalBorda").classList.add("aberto");
  };
  $("bdOk").onclick = function(){ gravar("webplay_borda", escolhida); $("modalBorda").classList.remove("aberto"); };
  $("bdCancelar").onclick = function(){ aplicarBorda(original); $("modalBorda").classList.remove("aberto"); };

  /* ---- partilhar: menu do telemóvel (Quick Share / Wi-Fi Direct); sem ele, Play Store com apps de partilha ---- */
  var partilhaNativaAnterior = partilhaNativa;
  partilhaNativa = async function(titulo, url){
    if(await partilhaNativaAnterior(titulo, url)) return true;
    if(!/android/i.test(navigator.userAgent)) return false; // fora do Android mantém o "copiar link"
    try{ await navigator.clipboard.writeText(url); }catch(e){}
    aviso("Sem partilha direta neste aparelho. Link copiado — a abrir a Play Store…");
    setTimeout(function(){
      var q = encodeURIComponent("partilhar ficheiros wifi direct");
      window.open("https://play.google.com/store/search?q=" + q + "&c=apps", "_blank");
    }, 900);
    return true;
  };
})();
</script>
<style>
  /* ===== Aviso "toque para o próximo anúncio" (entre um anúncio e o seguinte) ===== */
  #anuncioOverlay{position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;padding:max(20px,env(safe-area-inset-top)) 20px max(20px,env(safe-area-inset-bottom));background:rgba(13,15,20,.93);-webkit-tap-highlight-color:transparent;cursor:pointer;}
  #anuncioOverlay.ativo{display:flex;}
  #anuncioOverlay .an-caixa{width:min(100%,340px);background:var(--panel,#161a22);border:1px solid var(--accent-dim,#7a5a20);border-radius:14px;padding:22px 20px 20px;text-align:center;box-shadow:0 12px 36px rgba(0,0,0,.55);}
  #anuncioOverlay .an-pontos{display:flex;justify-content:center;gap:8px;margin-bottom:14px;}
  #anuncioOverlay .an-pontos i{width:10px;height:10px;border-radius:50%;border:1.5px solid var(--accent,#e0a33c);box-sizing:border-box;}
  #anuncioOverlay .an-pontos i.feito{background:var(--accent,#e0a33c);}
  #anuncioOverlay .an-titulo{font-family:Georgia,'Times New Roman',serif;font-size:1.15rem;font-weight:bold;color:var(--ink,#eae6dd);margin-bottom:8px;}
  #anuncioOverlay .an-texto{font-size:.82rem;line-height:1.45;color:var(--muted,#8a8f9c);margin-bottom:18px;}
  #anuncioOverlay .an-botao{background:var(--accent,#e0a33c);color:#1a1305;border:0;border-radius:25px;padding:11px 26px;font-size:.85rem;font-weight:bold;cursor:pointer;}
  #anuncioOverlay .an-titulo:empty,#anuncioOverlay .an-texto:empty{display:none;}
  #anuncioOverlay .an-pontos{margin-bottom:18px;}
  #anuncioOverlay.espera .an-botao{opacity:.5;}
  #anuncioOverlay .an-botao:focus-visible{outline:2px solid var(--ink,#eae6dd);outline-offset:3px;}
</style>
<script>
/* ===== Anúncios =====
   QUANDO: em qualquer toque no site (cartões, abas, botões, banner, episódios...), desde que já
   tenham passado ANUNCIO_A_CADA_MIN minutos desde o último anúncio concluído. Toques no banner
   da Início usam ANUNCIO_BANNER_A_CADA_MIN minutos. O toque que acionou o anúncio é refeito
   sozinho quando o último anúncio acaba.
   COMO: no toque abrem-se ANUNCIO_VEZES anúncios de uma só vez (cada um numa aba; enquanto a pessoa
   vê o 1.º, o 2.º e o 3.º já estão a carregar). Quando ela volta ao site, o toque original é refeito.
   O Chrome por vezes só deixa abrir 1 aba por toque: se isso acontecer e ANUNCIO_COMPLETAR = true,
   os que faltam abrem um por toque, num aviso a ecrã inteiro ("Anúncio 2 de 3").
   Se voltar depressa demais (não viu), repete. Se os pop-ups forem bloqueados 2 vezes seguidas, deixa passar.
   Para desligar tudo: ANUNCIO_ATIVO = false. */
(function(){
  var ANUNCIO_ATIVO = true;
  var ANUNCIO_URLS = ["ponte-anuncio.php?u=" + encodeURIComponent("https://uplcm.com/4/11767932")]; // página-ponte com contagem; o mesmo link serve para todas as etapas
  var ANUNCIO_VEZES = 2;               // 2 anúncios em sequência, um de cada vez
  var ANUNCIO_COMPLETAR = true;        // se o Chrome só abrir alguns, abre os que faltam (1 por toque)
  var ANUNCIO_A_CADA_MIN = 5;          // intervalo geral (qualquer toque): 5 minutos
  var ANUNCIO_BANNER_A_CADA_MIN = 5;   // intervalo para toques no banner: 5 minutos
  var ANUNCIO_MIN_FORA_ETAPAS = [7000, 7000]; // tempo mínimo (ms) fora do site em cada anúncio: 7 segundos
  var ANUNCIO_AUMENTO_MS = 2000;       // se o usuário voltar por conta própria antes do tempo, o tempo exigido sobe 2 s a cada vez...
  var ANUNCIO_MAX_FORA_MS = 15000;     // ...até este limite
  var ANUNCIO_ESPERA_S = 3;            // ao voltar cedo: contagem 3, 2, 1 antes de poder abrir o anúncio de novo
  var ANUNCIO_AVISO = true;            // aviso inicial (aparece só uma vez); false = desativa, o resto funciona igual
  var ANUNCIO_FALHAS_MAX = 2;          // pop-ups bloqueados quantas vezes até deixar passar
  if(!ANUNCIO_ATIVO || !ANUNCIO_URLS.length) return;

  var K_ULTIMO = "webplay_ad_ultimo";
  var K_INTRO = "webplay_ad_intro";   // aviso inicial: aparece só uma vez
  // toques que NUNCA geram anúncio: campos de escrita, fechar/voltar, baixar/partilhar, o próprio aviso
  var IGNORAR = 'input,textarea,select,label,[data-sem-anuncio],#anuncioOverlay,.mascote-partilha,' +
                '.episodio-baixar,.episodio-partilhar,.btn-download-episodio,[class*="fechar"],[class*="voltar"]';

  function lerN(k){ try{ return Number(localStorage.getItem(k)) || 0; }catch(e){ return 0; } }
  function gravarN(k, v){ try{ localStorage.setItem(k, String(v)); }catch(e){} }

  var fase = "ocioso";   // ocioso | aberto (anúncio numa aba) | pedindo (aviso à espera de um toque)
  var etapa = 0;         // anúncios já vistos nesta ronda
  var falhas = 0, saiuEm = 0, tTimeout = null, gatilho = null, lote = 0, extra = 0, espera = false, tCont = null;
  function minFora(){
    var b = ANUNCIO_MIN_FORA_ETAPAS[Math.min(etapa, ANUNCIO_MIN_FORA_ETAPAS.length - 1)];
    return Math.min(b + extra, ANUNCIO_MAX_FORA_MS);
  }

  function intervaloMs(t){
    return (t.closest("#banner-destaques") ? ANUNCIO_BANNER_A_CADA_MIN : ANUNCIO_A_CADA_MIN) * 60000;
  }
  function urlN(n){
    var base = ANUNCIO_URLS[n % ANUNCIO_URLS.length];
    return base + (base.indexOf("?") < 0 ? "?" : "&") + "r=" + Date.now() + "_" + (n + 1) +
           "&n=" + (n + 1) + "&t=" + ANUNCIO_VEZES + "&s=" + Math.round(minFora() / 1000);
  }

  /* ----- aviso entre anúncios ----- */
  function criarOverlay(){
    var o = document.getElementById("anuncioOverlay");
    if(o) return o;
    o = document.createElement("div");
    o.id = "anuncioOverlay";
    o.setAttribute("role", "dialog");
    o.setAttribute("aria-live", "polite");
    o.innerHTML = '<div class="an-caixa"><div class="an-pontos"></div><div class="an-titulo"></div>' +
                  '<div class="an-texto"></div><button type="button" class="an-botao"></button></div>';
    // um toque em QUALQUER parte do aviso conta: é um toque novo, por isso o Chrome deixa abrir a aba
    o.addEventListener("click", function(ev){
      ev.preventDefault(); ev.stopPropagation();
      if(fase === "pedindo" && !espera) abrirAbas(1);
    });
    document.body.appendChild(o);
    return o;
  }
  function mostrarOverlay(modo){
    var o = criarOverlay(), tit, txt, btn, h = "";
    clearInterval(tCont); espera = false; o.classList.remove("espera");
    var n = "Anúncio " + (etapa + 1) + " de " + ANUNCIO_VEZES;
    if(modo === "intro"){ tit = "Caro usuário"; txt = "Se aparecer “Verificar se é humano”, clique nele e deixe o anúncio carregar por completo (" + Math.round(minFora()/1000) + " segundos). Esta mensagem aparece só uma vez."; btn = "Assistir anúncio"; }
    else if(modo === "proximo"){ tit = n; txt = "Se aparecer “Verificar se é humano”, clique nele e deixe o anúncio carregar por completo."; btn = "Assistir anúncio"; }
    else if(modo === "repetir"){ tit = n; txt = "Caro usuário, são " + Math.round(minFora()/1000) + " segundos. Clique em “Verificar se é humano”, se aparecer, e deixe o anúncio carregar por completo."; btn = "Assistir anúncio"; }
    else { tit = "Anúncio bloqueado"; txt = "O navegador bloqueou a janela do anúncio. Permita os pop-ups para este site e toque para tentar de novo."; btn = "Tentar de novo"; }
    for(var i = 0; i < ANUNCIO_VEZES; i++) h += '<i class="' + (i < etapa ? "feito" : "") + '"></i>';
    o.querySelector(".an-pontos").innerHTML = h;
    o.querySelector(".an-titulo").textContent = tit;
    o.querySelector(".an-texto").textContent = txt;
    o.querySelector(".an-botao").textContent = btn;
    if(modo === "repetir" && ANUNCIO_ESPERA_S > 0){      // contagem 3, 2, 1 antes de poder tocar
      var seg = ANUNCIO_ESPERA_S, b = o.querySelector(".an-botao");
      espera = true; o.classList.add("espera");
      b.textContent = btn + " (" + seg + ")";
      tCont = setInterval(function(){
        seg--;
        if(seg <= 0){ clearInterval(tCont); espera = false; o.classList.remove("espera"); b.textContent = btn; }
        else b.textContent = btn + " (" + seg + ")";
      }, 1000);
    }
    o.classList.add("ativo");
    fase = "pedindo";
  }
  function esconderOverlay(){
    var o = document.getElementById("anuncioOverlay");
    if(o) o.classList.remove("ativo");
  }

  /* ----- fluxo ----- */
  function liberar(){                       // acabou (ou pop-ups bloqueados): o site continua
    clearTimeout(tTimeout);
    fase = "ocioso"; etapa = 0; falhas = 0; extra = 0;
    esconderOverlay();
    gravarN(K_ULTIMO, Date.now());
    var g = gatilho; gatilho = null;
    // refaz o toque original (o clique programático não gera novo anúncio)
    if(g && document.contains(g)) setTimeout(function(){ try{ g.click(); }catch(e){} }, 150);
  }
  function bloqueado(){
    falhas++;
    if(falhas >= ANUNCIO_FALHAS_MAX) liberar(); else mostrarOverlay("bloqueado");
  }
  function abrirAbas(quantas){              // TEM de correr dentro de um toque da pessoa
    var abertas = 0;
    for(var i = 0; i < quantas; i++){
      var w = null;
      try{ w = window.open(urlN(etapa + i), "_blank"); }catch(err){}
      if(w) abertas++;
    }
    if(!abertas){ bloqueado(); return; }
    lote = abertas;
    fase = "aberto"; saiuEm = 0;
    esconderOverlay();
    // se em 3,5 s o site não passou para segundo plano, a aba não abriu à frente: conta como bloqueado
    clearTimeout(tTimeout);
    tTimeout = setTimeout(function(){
      if(fase === "aberto" && !saiuEm && document.visibilityState === "visible") bloqueado();
    }, 3500);
  }

  document.addEventListener("visibilitychange", function(){
    if(fase !== "aberto") return;
    if(document.visibilityState === "hidden"){ saiuEm = Date.now(); clearTimeout(tTimeout); return; }
    var fora = saiuEm ? Date.now() - saiuEm : 0;
    saiuEm = 0;
    if(fora >= minFora()){
      etapa += lote || 1; lote = 0; extra = 0;
      if(etapa >= ANUNCIO_VEZES || !ANUNCIO_COMPLETAR) liberar(); else mostrarOverlay("proximo");
    } else {
      lote = 0; extra += ANUNCIO_AUMENTO_MS;   // voltou cedo: da próxima exige mais tempo
      mostrarOverlay("repetir");            // voltou depressa demais: repete este anúncio
    }
  });

  document.addEventListener("click", function(e){
    if(!e.isTrusted) return;                // cliques feitos por código do site passam sempre
    var t = e.target;
    if(!t || !t.closest) return;
    if(t.closest(IGNORAR)) return;
    if(fase !== "ocioso"){ e.stopImmediatePropagation(); e.preventDefault(); return; }   // anúncio em curso
    if(Date.now() - lerN(K_ULTIMO) < intervaloMs(t)) return;                              // ainda livre
    e.stopImmediatePropagation(); e.preventDefault();
    gatilho = t; etapa = 0; falhas = 0;
    if(ANUNCIO_AVISO && !lerN(K_INTRO)){ gravarN(K_INTRO, 1); mostrarOverlay("intro"); }   // 1.ª vez: aviso antes do anúncio
    else abrirAbas(1);                       // abre UM anúncio por toque (um de cada vez, em sequência)
  }, true);
})();
</script>
<style>
  /* ===== Mascote "Partilhe o nosso aplicativo" — é o "+" lateral que ganha vida: mesma forma de aba,
     mas com um ícone de partilhar no lugar do "+". Sai do "+", sobe e desce pela borda
     direita durante cerca de 1 minuto e volta a encaixar no "+". ===== */
  .mascote-partilha{position:fixed;right:0;z-index:3100;width:30px;height:130px;display:none;cursor:pointer;-webkit-tap-highlight-color:transparent;will-change:transform;filter:drop-shadow(-2px 0 5px rgba(0,0,0,.4));}
  .mascote-partilha svg{position:absolute;inset:0;width:100%;height:100%;display:block;overflow:visible;}
  .mascote-partilha .mp-fundo{fill:var(--panel);}
  .mascote-partilha .mp-contorno{fill:none;stroke:var(--accent);stroke-width:1.4;}
  .mascote-partilha .mp-share line{stroke:var(--accent);stroke-width:1.5;stroke-linecap:round;}
  .mascote-partilha .mp-share circle{fill:var(--accent);}
  .mascote-partilha .mp-fala{position:absolute;right:100%;top:50%;margin-right:8px;transform:translateY(-50%) scale(.85);transform-origin:right center;
    width:max-content;max-width:104px;background:var(--panel);color:var(--ink);border:1px solid var(--accent-dim);border-radius:8px;
    padding:4px 7px;font-size:.56rem;line-height:1.2;text-align:left;opacity:0;pointer-events:none;transition:opacity .3s,transform .3s;box-shadow:0 4px 12px rgba(0,0,0,.45);}
  .mascote-partilha .mp-fala::after{content:"";position:absolute;left:100%;top:50%;margin-top:-5px;border:5px solid transparent;border-left-color:var(--accent-dim);}
  .mascote-partilha.falando .mp-fala{opacity:1;transform:translateY(-50%) scale(1);}
</style>
<script>
/* ===== Mascote que pede para partilhar o aplicativo =====
   Só na aba Início. É o "+" lateral com vida: a mesma aba, com um ícone de partilhar.
   Aparece logo na entrada e sempre que a pessoa volta à Início vindo de outra aba, já com a frase ao lado, e durante MASC_DURACAO_S segundos sobe e desce
   pela borda direita (passando por cima do "+"); no fim sobe, pára um instante no meio do ecrã
   e volta a entrar no "+". Volta MASC_A_CADA_MIN minutos depois de terminar.
   Tocar no mascote abre a partilha do app e ele descansa MASC_APOS_PARTILHAR_DIAS dias.
   Para desligar tudo: MASC_ATIVO = false. */
(function(){
  var MASC_ATIVO = true;
  var MASC_PRIMEIRA_S = 0;            // logo que a pessoa entra no site: começa a mexer-se já
  var MASC_DURACAO_S = 30;            // duração total do passeio (30 segundos)
  var MASC_A_CADA_MIN = 5;            // volta de 5 em 5 minutos (depois de terminar)
  var MASC_APOS_PARTILHAR_DIAS = 3;
  var MASC_TEXTO = "Partilhe o nosso aplicativo, por favor 💛";
  if(!MASC_ATIVO || !Element.prototype.animate) return;

  var K_PROX = "webplay_masc_prox";
  function lerN(k){ try{ return Number(localStorage.getItem(k)) || 0; }catch(e){ return 0; } }
  function gravarN(k,v){ try{ localStorage.setItem(k,String(v)); }catch(e){} }
  var aba = document.getElementById("btnMaisLateral");
  if(!aba) return;

  var el = document.createElement("div");
  el.className = "mascote-partilha";
  el.setAttribute("role","button"); el.setAttribute("aria-label","Partilhar o aplicativo");
  el.innerHTML =
    '<svg viewBox="0 0 30 130" preserveAspectRatio="none" aria-hidden="true">' +
    '<path class="mp-fundo" d="M30 0C30 24 12 28 12 65C12 102 30 106 30 130Z"/>' +
    '<path class="mp-contorno" d="M30 0C30 24 12 28 12 65C12 102 30 106 30 130"/>' +
    '<g class="mp-share"><line x1="17" y1="72" x2="26" y2="66"/><line x1="17" y1="72" x2="26" y2="78"/>' +
    '<circle cx="26" cy="66" r="2.3"/><circle cx="17" cy="72" r="2.3"/><circle cx="26" cy="78" r="2.3"/></g></svg>' +
    '<div class="mp-fala"></div>';
  el.querySelector(".mp-fala").textContent = MASC_TEXTO;
  document.body.appendChild(el);

  var rodando = false, cancelado = false, vigia = null, proximo = 0;
  function T(y){ return "translateY(" + y + "px)"; }
  function naInicio(){ var pg = document.getElementById("page-inicio"); return !!(pg && pg.classList.contains("ativa")); }
  function podeMostrar(){
    if(!naInicio() || document.visibilityState !== "visible") return false;
    var r = aba.getBoundingClientRect();
    return r.width > 0 && r.height > 0;                                    // "+" lateral visível
  }
  function limpar(){
    el.getAnimations().forEach(function(a){ try{ a.cancel(); }catch(e){} });
    el.classList.remove("falando");
    el.style.display = "none";
    clearInterval(vigia); rodando = false;
    if(!cancelado) proximo = Date.now() + MASC_A_CADA_MIN * 60000;     // só conta a espera se o passeio chegou ao fim
  }

  async function rodar(){
    rodando = true; cancelado = false;
    var r = aba.getBoundingClientRect();
    el.style.top = r.top + "px";                         // nasce exatamente em cima do "+"
    el.style.display = "block";
    el.classList.add("falando");               // já aparece com a frase
    // se a pessoa sair da Início / abrir algo por cima, o mascote encaixa de volta no "+" e some
    vigia = setInterval(function(){ if(!podeMostrar()){ cancelado = true; limpar(); } }, 500);
    var alto = Math.min(-20, 90 - r.top);                               // até perto do cabeçalho
    var baixo = Math.max(20, window.innerHeight - 150 - r.top);         // até perto do fundo
    var meio = window.innerHeight / 2 - 65 - r.top;                     // meio do ecrã
    // trajeto: sobe, desce, sobe, desce, sobe, para no meio, e volta a entrar no "+" (peso = tempo relativo)
    var trajeto = [[alto,3.5],[baixo,5.5],[alto,5.5],[baixo,5.5],[alto,4],[meio,2],[meio,1.5],[0,2.5]];
    var soma = 0; trajeto.forEach(function(t){ soma += t[1]; });
    var kf = [{ transform:T(0), offset:0, easing:"ease-in-out" }], acum = 0;
    trajeto.forEach(function(t, i){
      acum += t[1];
      kf.push({ transform:T(t[0]), offset:(i === trajeto.length - 1) ? 1 : acum / soma, easing:"ease-in-out" });
    });
    try{
      await el.animate(kf, { duration:MASC_DURACAO_S * 1000, fill:"forwards" }).finished;
    }catch(e){ /* animação cancelada */ }
    limpar();
  }

  el.addEventListener("click", function(e){
    e.stopPropagation();
    gravarN(K_PROX, Date.now() + MASC_APOS_PARTILHAR_DIAS * 86400000);
    cancelado = true; limpar();
    var b = document.getElementById("btnPartilharApp");
    if(b) b.click();                                   // mesmo código do botão "Partilhar" do perfil
  });

  // Aparece: 1) logo na entrada no site; 2) sempre que a pessoa sai da Início (outras abas) e VOLTA;
  // 3) de MASC_A_CADA_MIN em MASC_A_CADA_MIN minutos enquanto está na Início.
  // Só fica calado (dias) se a pessoa já tiver partilhado o app (K_PROX).
  var primeira = Date.now() + MASC_PRIMEIRA_S * 1000, forcar = false;
  var pgIni = document.getElementById("page-inicio");
  if(pgIni && window.MutationObserver){
    var estavaAtiva = naInicio();
    new MutationObserver(function(){
      var ativa = naInicio();
      if(ativa && !estavaAtiva) forcar = true;          // voltou à Início → mostra outra vez
      estavaAtiva = ativa;
    }).observe(pgIni, { attributes:true, attributeFilter:["class"] });
  }
  setInterval(function(){
    if(rodando) return;
    if(Date.now() < lerN(K_PROX)) return;               // já partilhou: descansa uns dias
    if(!forcar && Date.now() < Math.max(primeira, proximo)) return;
    if(!podeMostrar()) return;
    forcar = false;
    rodar();
  }, 300);
})();
</script>
<style>
  /* Nome personalizado (Definições → cabeçalho): parte normal + parte na cor do tema; a letra do meio leva o "play" */
  .logo-webplay .logo-texto .letra-play{position:relative;display:inline-block;}
  .logo-webplay .logo-texto .letra-play::after{content:"";position:absolute;left:100%;top:.12em;margin-left:.04em;border-left:.3em solid currentColor;border-top:.18em solid transparent;border-bottom:.18em solid transparent;}
  .logo-webplay .logo-texto b .letra-play{margin-right:.28em;}
  #cabPrev .letra-play{position:relative;display:inline-block;margin-right:.28em;}
  #cabPrev .letra-play::after{content:"";position:absolute;left:100%;top:.12em;margin-left:.04em;border-left:.3em solid currentColor;border-top:.18em solid transparent;border-bottom:.18em solid transparent;}
</style>
<style>
  /* ===== Redes sociais: "Siga-nos" (janela após partilhar + secção no logótipo) ===== */
  .redes-lista{display:flex;flex-direction:column;gap:8px;margin-top:12px;}
  .redes-lista a{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:12px;background:transparent;border:1px solid var(--line);color:var(--ink);text-decoration:none;font-size:.88rem;font-weight:600;text-align:left;}
  .redes-lista a:active,.redes-lista a:hover{border-color:var(--accent);}
  .redes-lista a .rede-ico{display:flex;width:20px;height:20px;color:var(--accent);}
  .redes-lista a .rede-ico svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.9;stroke-linecap:round;stroke-linejoin:round;}
  .redes-rodape{padding:6px 0 14px;text-align:center;}
  .redes-rodape h3{font-size:.9rem;color:var(--ink);margin:0 0 2px;}
  .redes-rodape .redes-lista{flex-direction:row;flex-wrap:wrap;justify-content:center;margin-top:10px;}
  .redes-rodape .redes-lista a{padding:8px 12px;font-size:.78rem;}
  .modal-logo-redes{margin-top:14px;padding-top:12px;border-top:1px solid var(--line);}
  .modal-logo-redes h4{font-size:.85rem;color:var(--ink);margin:0;}
  .modal-redes{display:none;position:fixed;inset:0;z-index:1300;background:rgba(0,0,0,.8);align-items:center;justify-content:center;padding:16px;overflow-y:auto;}
  .modal-redes.aberto{display:flex;}
  .modal-redes-caixa{position:relative;width:100%;max-width:340px;background:var(--panel);border:1px solid var(--line);border-radius:16px;padding:20px 16px 16px;text-align:center;}
  .modal-redes-caixa h3{font-size:1.1rem;margin:0 0 4px;color:var(--ink);}
  .modal-redes-caixa p{font-size:.8rem;color:var(--muted);margin:0;line-height:1.4;}
  .modal-redes-fechar{position:absolute;top:6px;right:8px;background:none;border:none;color:var(--muted);font-size:1.3rem;line-height:1;cursor:pointer;padding:4px 8px;}
</style>
<script>
/* ===== REDES SOCIAIS =====
   Os teus links NÃO estão aqui: ficam no ficheiro  redes-sociais.json  (mesma pasta do index).
   É só abrir esse ficheiro e colar as tuas contas — não precisas de procurar nada neste código.
   Onde aparece "Siga-nos nas redes sociais":
     1) numa janela, logo depois de a pessoa partilhar o aplicativo;
     2) ao clicar no logótipo Webplay (por baixo dos direitos reservados);
     3) no rodapé, lá no fundo, antes dos direitos reservados e da informação da TMDB. */
(function(){
  // Ícones desenhados só com linha (sem cor própria): seguem sempre a cor do tema do aplicativo.
  var ICONES = {
    telegram:  '<svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',
    instagram: '<svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
    whatsapp:  '<svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
    facebook:  '<svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
    youtube:   '<svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>',
    tiktok:    '<svg viewBox="0 0 24 24"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>',
    link:      '<svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.07 0l3-3a5 5 0 0 0-7.07-7.07l-1.5 1.5"/><path d="M14 11a5 5 0 0 0-7.07 0l-3 3a5 5 0 0 0 7.07 7.07l1.5-1.5"/></svg>'
  };
  var NOMES = { telegram:"Telegram", instagram:"Instagram", whatsapp:"WhatsApp", facebook:"Facebook", youtube:"YouTube", tiktok:"TikTok" };
  // JSON simples: { "telegram": "https://...", "instagram": "https://..." } — chaves começadas por _ são só notas
  function redesDoJson(cfg){
    var out = [];
    if(!cfg || typeof cfg !== "object") return out;
    Object.keys(cfg).forEach(function(k){
      if(k.charAt(0) === "_") return;
      var url = String(cfg[k] || "").trim();
      if(!/^https?:\/\//i.test(url)) return;
      var chave = k.toLowerCase().replace(/\s+/g, "");
      out.push({ nome: NOMES[chave] || (k.charAt(0).toUpperCase() + k.slice(1)), icone: ICONES[chave] ? chave : "link", url: url });
    });
    return out;
  }
  function montar(cfg){
  var ativas = redesDoJson(cfg);
  if(!ativas.length) return;

  function lista(){
    var d = document.createElement("div"); d.className = "redes-lista";
    ativas.forEach(function(r){
      var a = document.createElement("a");
      a.href = r.url; a.target = "_blank"; a.rel = "noopener noreferrer";
      var i = document.createElement("span"); i.className = "rede-ico"; i.innerHTML = ICONES[r.icone] || ICONES.link;
      a.appendChild(i); a.appendChild(document.createTextNode(r.nome));
      d.appendChild(a);
    });
    return d;
  }

  // 2) secção dentro da janela do logótipo
  var caixaLogo = document.querySelector("#modalLogo .modal-logo-caixa");
  if(caixaLogo){
    var sec = document.createElement("div"); sec.className = "modal-logo-redes";
    var h = document.createElement("h4"); h.textContent = "Siga-nos nas redes sociais";
    sec.appendChild(h); sec.appendChild(lista()); caixaLogo.appendChild(sec);
  }

  // 3) no rodapé, lá no fundo, antes dos direitos reservados e da informação da TMDB
  var fimPagina = document.getElementById("redesFooter");
  if(fimPagina){
    var rod = document.createElement("div"); rod.className = "redes-rodape";
    var t = document.createElement("h3"); t.textContent = "Siga-nos nas redes sociais";
    rod.appendChild(t); rod.appendChild(lista());
    fimPagina.appendChild(rod);
  }

  // 1) janela depois de partilhar
  var m = document.createElement("div"); m.className = "modal-redes"; m.id = "modalRedes";
  m.innerHTML = '<div class="modal-redes-caixa"><button type="button" class="modal-redes-fechar" aria-label="Fechar">✕</button>' +
    '<h3>Obrigado por partilhar! 💛</h3><p>Siga-nos nas redes sociais</p></div>';
  m.querySelector(".modal-redes-caixa").appendChild(lista());
  document.body.appendChild(m);
  function fechar(){ m.classList.remove("aberto"); }
  m.querySelector(".modal-redes-fechar").onclick = fechar;
  m.addEventListener("click", function(e){ if(e.target === m) fechar(); });
  window.webplayAbrirRedes = function(){ m.classList.add("aberto"); };

  // depois de partilhar o APLICATIVO (botão do perfil ou mascote), mostra "Siga-nos"
  if(typeof partilhaNativa === "function"){
    var anterior = partilhaNativa;
    partilhaNativa = async function(titulo, url){
      var ok = await anterior(titulo, url);
      if(ok && /Instala a app/.test(titulo || "")) setTimeout(window.webplayAbrirRedes, 600);
      return ok;
    };
  }
  }
  fetch("redes-sociais.json?v=" + Date.now(), { cache: "no-store" })
    .then(function(r){ return r.ok ? r.json() : null; })
    .catch(function(){ return null; })
    .then(function(cfg){ if(cfg) montar(cfg); });
})();
</script>
<script>
(function(){
  var g=document.getElementById("btnEngrenagemPerfil"), m=document.getElementById("perfilMenuOpcoes");
  if(!g||!m) return;
  g.onclick=function(){
    var abrir=m.hasAttribute("hidden");
    if(abrir) m.removeAttribute("hidden"); else m.setAttribute("hidden","");
    g.setAttribute("aria-expanded", abrir?"true":"false");
  };
})();
</script>
<script>
(function(){
  var l=document.getElementById("perfilLogado"), r=document.getElementById("perfilResumo"), v=document.getElementById("perfilEditarVoltar");
  if(!l||!r||!v) return;
  function abrir(){ l.classList.add("editando"); }
  r.onclick=abrir;
  r.onkeydown=function(e){ if(e.key==="Enter"||e.key===" "){ e.preventDefault(); abrir(); } };
  v.onclick=function(){ l.classList.remove("editando"); };
  var f=document.getElementById("closeProfile"); if(f) f.addEventListener("click",function(){ l.classList.remove("editando"); });
  var t=document.getElementById("perfilTitulo");
  if(t&&window.MutationObserver) new MutationObserver(function(){ l.classList.remove("editando"); }).observe(t,{childList:true,characterData:true,subtree:true});
})();
</script>
<script>
(function(){
  var v=document.getElementById("mcbVideo"), w=document.getElementById("mcbVel"), bt=document.getElementById("mcbVelBtn");
  if(!v||!w||!bt) return;
  var VEL=[1,1.5,2], i=0;
  function aplicar(){ v.playbackRate=VEL[i]; bt.textContent="Velocidade: "+VEL[i]+"×"; }
  bt.onclick=function(){ i=(i+1)%VEL.length; aplicar(); };
  v.addEventListener("loadedmetadata",function(){ i=0; aplicar(); w.style.display=""; });
  v.addEventListener("error",function(){ w.style.display="none"; });
  var l=document.getElementById("mcbVerEscrita");
  if(l) l.onclick=function(e){ e.preventDefault(); try{ v.pause(); }catch(x){}
    document.getElementById("mcbVideoTela").style.display="none"; document.getElementById("mcbConfig").style.display="block"; };
})();
</script>

<script>
(function(){
  var ver=document.getElementById("btnVerComoBaixar"), chk=document.getElementById("chkComoBaixar");
  if(!ver||!chk) return;
  function ler(){ try{ return localStorage.getItem(CH_COMO_OFF)==="1"; }catch(e){ return false; } }
  chk.checked=!ler();
  chk.onchange=function(){ try{ localStorage.setItem(CH_COMO_OFF, chk.checked?"0":"1"); }catch(e){} if(typeof atualizarBalaoComoBaixar==="function") atualizarBalaoComoBaixar(); };
  var pf=document.getElementById("profileBtn"); if(pf) pf.addEventListener("click",function(){ chk.checked=!ler(); });
  ver.onclick=function(){ if(typeof mostrarComoBaixar==="function") mostrarComoBaixar(null,true); };
})();
</script>
<script src="atualizacao.js"></script>
</body>
</html>
