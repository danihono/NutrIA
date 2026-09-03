<?php
/**
 * contato.php — Processa o formulário de contato
 */
require_once __DIR__ . '/db.php';

$erros = [];
$ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $assunto  = trim($_POST['assunto']  ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($nome === '')     $erros[] = 'Preencha seu nome.';
    if ($email === '')    $erros[] = 'Preencha seu e-mail.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'E-mail inválido.';
    if ($assunto === '')  $erros[] = 'Selecione um assunto.';
    if ($mensagem === '') $erros[] = 'Escreva uma mensagem.';

    if (empty($erros)) {
        $stmt = $pdo->prepare('INSERT INTO contatos (nome, email, telefone, assunto, mensagem) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nome, $email, $telefone, $assunto, $mensagem]);
        $ok = true;
    }
}

$pageTitle = 'Contato enviado · NutrIA';
include __DIR__ . '/includes/header.php';
?>
<section class="nt-section nt-contact" style="padding-top: 180px;">
  <div class="container">
    <?php if ($ok): ?>
      <span class="nt-eyebrow">Obrigado</span>
      <h1 class="nt-h2 mt-3">Mensagem <span class="nt-italic nt-orange">recebida</span>.</h1>
      <p class="nt-lead mt-4">
        Olá, <?= htmlspecialchars($nome) ?>! Recebemos seu contato e respondemos em até um dia útil no e-mail <strong><?= htmlspecialchars($email) ?></strong>.
      </p>
    <?php else: ?>
      <span class="nt-eyebrow">Ops</span>
      <h1 class="nt-h2 mt-3">Não conseguimos <span class="nt-italic nt-orange">enviar</span>.</h1>
      <ul class="nt-lead mt-4">
        <?php foreach ($erros as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <div class="mt-4">
      <a href="index.php" class="nt-btn nt-btn-orange">← Voltar para o site</a>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
