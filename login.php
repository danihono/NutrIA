<?php
/**
 * login.php — Autenticação simples para a área admin
 */
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $erro = 'Usuário ou senha inválidos.';
    }
}

$pageTitle = 'Login · NutrIA';
include __DIR__ . '/includes/header.php';
?>
<section class="nt-section nt-contact" style="padding-top: 180px; min-height: 90vh;">
  <div class="container" style="max-width: 520px;">
    <span class="nt-eyebrow">Área admin</span>
    <h1 class="nt-h2 mt-3">Entrar.</h1>
    <p class="nt-lead mt-3">Acesso restrito para o time NutrIA.</p>

    <?php if ($erro): ?>
      <div class="nt-form-ok show" style="background: #B4300A;">
        <span class="dot"></span> <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
      <div class="nt-field">
        <label for="user">Usuário</label>
        <input type="text" id="user" name="user" required autocomplete="username" />
      </div>
      <div class="nt-field">
        <label for="pass">Senha</label>
        <input type="password" id="pass" name="pass" required autocomplete="current-password" />
      </div>
      <button type="submit" class="nt-btn nt-btn-orange">Entrar</button>
    </form>

    <p style="font-family: var(--nt-mono); font-size: 12px; color: var(--nt-muted); margin-top: 24px;">
      demo · usuário <strong>admin</strong> · senha <strong>nutria2026</strong>
    </p>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
