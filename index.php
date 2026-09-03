<?php
/**
 * index.php — Landing page dinâmica (puxa itens do banco)
 * A versão index.html é a mockada para preview; esta é a oficial.
 */
require_once __DIR__ . '/db.php';
$itens = $pdo->query('SELECT * FROM itens ORDER BY id ASC')->fetchAll();

$pageTitle = 'NutrIA · Inteligência que nutre você';
include __DIR__ . '/includes/header.php';
?>

<!-- Hero idêntico ao index.html, simplificado -->
<section class="nt-hero">
  <div class="container" style="padding-top: 100px;">
    <div class="nt-hero-grid">
      <div class="nt-hero-copy">
        <span class="nt-eyebrow">Startup · IA para alimentação</span>
        <h1 class="nt-display mt-4">
          <span class="line">Inteligência que</span>
          <span class="line"><span class="accent">nutre</span> você.</span>
        </h1>
        <p class="nt-lead mt-4">
          A NutrIA transforma sua rotina em um plano alimentar feito sob medida —
          e entende seu prato só com uma foto.
        </p>
        <div class="nt-hero-cta">
          <a href="#solucoes" class="nt-btn nt-btn-orange">Ver soluções</a>
          <a href="#contato" class="nt-btn nt-btn-ghost">Fale com a gente</a>
        </div>
      </div>
      <div class="nt-hero-visual">
        <img src="assets/img/hero-placeholder.svg" alt="Mockup do app NutrIA mostrando calorias do dia e refeições" />
      </div>
    </div>
  </div>
</section>

<!-- Soluções vindas do banco -->
<section class="nt-section nt-solutions" id="solucoes">
  <div class="container">
    <div class="nt-section-head">
      <div>
        <span class="nt-eyebrow">Soluções</span>
        <h2 class="nt-h2 mt-3">Nossos <span class="nt-italic" style="color: var(--nt-orange);">produtos</span> e serviços.</h2>
      </div>
      <p class="nt-lead">Cadastrados no painel admin e exibidos aqui em tempo real.</p>
    </div>
    <div class="row g-4">
      <?php foreach ($itens as $i): ?>
        <div class="col-lg-4 col-md-6">
          <article class="nt-sol-card">
            <span class="tag"><?= htmlspecialchars($i['categoria']) ?></span>
            <h3><?= htmlspecialchars($i['nome']) ?></h3>
            <p><?= htmlspecialchars($i['descricao']) ?></p>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Contato -->
<section class="nt-section nt-contact" id="contato">
  <div class="container">
    <div class="nt-section-head">
      <div>
        <span class="nt-eyebrow">Contato</span>
        <h2 class="nt-h2 mt-3">Vamos <span class="nt-italic nt-orange">conversar</span>?</h2>
      </div>
      <p class="nt-lead">A gente responde em até um dia útil.</p>
    </div>

    <form id="ntForm" action="contato.php" method="POST" novalidate>
      <div class="row g-3">
        <div class="col-md-6"><div class="nt-field">
          <label for="nome">Nome</label>
          <input id="nome" name="nome" type="text" required />
          <span class="err">Preencha seu nome.</span>
        </div></div>
        <div class="col-md-6"><div class="nt-field">
          <label for="email">E-mail</label>
          <input id="email" name="email" type="email" required />
          <span class="err">E-mail inválido.</span>
        </div></div>
        <div class="col-md-6"><div class="nt-field">
          <label for="telefone">Telefone</label>
          <input id="telefone" name="telefone" type="tel" />
        </div></div>
        <div class="col-md-6"><div class="nt-field">
          <label for="assunto">Assunto</label>
          <select id="assunto" name="assunto" required>
            <option value="">Selecione</option>
            <option value="beta">Quero testar</option>
            <option value="parceria">Parceria</option>
            <option value="imprensa">Imprensa</option>
          </select>
          <span class="err">Selecione um assunto.</span>
        </div></div>
        <div class="col-12"><div class="nt-field">
          <label for="mensagem">Mensagem</label>
          <textarea id="mensagem" name="mensagem" required></textarea>
          <span class="err">Escreva uma mensagem.</span>
        </div></div>
        <div class="col-12"><button type="submit" class="nt-btn nt-btn-orange">Enviar</button></div>
      </div>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
