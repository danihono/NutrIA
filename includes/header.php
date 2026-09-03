<?php
/**
 * includes/header.php — Cabeçalho reutilizável
 * Espera variável $pageTitle opcional.
 */
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = $pageTitle ?? 'NutrIA · Inteligência que nutre você';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="NutrIA é a startup de IA para alimentação que cria dietas personalizadas e analisa seus pratos por foto." />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=Instrument+Serif&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body data-hero="split">

<header>
  <nav class="navbar navbar-expand-lg nt-navbar fixed-top" aria-label="Navegação principal">
    <div class="container">
      <a class="navbar-brand nt-brand" href="index.php#top">
        <img class="nt-brand-mark" src="assets/img/logo-nutria.png" alt="Logo NutrIA" />
        Nutr<em>IA</em>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ntNav" aria-controls="ntNav" aria-expanded="false" aria-label="Abrir menu">
        <span class="nt-toggler-icon" aria-hidden="true"></span>
      </button>
      <div class="collapse navbar-collapse" id="ntNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#historia">História</a></li>
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#fazemos">O que fazemos</a></li>
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#solucoes">Soluções</a></li>
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#feedbacks">Feedbacks</a></li>
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#blog">Blog</a></li>
          <li class="nav-item"><a class="nav-link nt-nav-link" href="index.php#contato">Contato</a></li>
        </ul>
        <a href="index.php#contato" class="nt-btn nt-btn-orange nt-btn-sm">Começar agora</a>
      </div>
    </div>
  </nav>
</header>

<main id="top">
