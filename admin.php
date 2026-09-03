<?php
/**
 * admin.php — Área admin: CRUD de itens + listagem de contatos
 * Verifica sessão no topo. Usa prepared statements e htmlspecialchars.
 */
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/db.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$msg = '';

/* CREATE */
if ($acao === 'criar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    if ($nome && $categoria && $descricao) {
        $stmt = $pdo->prepare('INSERT INTO itens (nome, categoria, descricao) VALUES (?, ?, ?)');
        $stmt->execute([$nome, $categoria, $descricao]);
        $msg = 'Item criado.';
    } else {
        $msg = 'Preencha todos os campos.';
    }
}

/* UPDATE */
if ($acao === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    if ($id && $nome && $categoria && $descricao) {
        $stmt = $pdo->prepare('UPDATE itens SET nome=?, categoria=?, descricao=? WHERE id=?');
        $stmt->execute([$nome, $categoria, $descricao, $id]);
        $msg = 'Item atualizado.';
    }
}

/* DELETE */
if ($acao === 'excluir') {
    $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM itens WHERE id=?');
        $stmt->execute([$id]);
        $msg = 'Item excluído.';
    }
}

/* Edição — item carregado */
$itemEdit = null;
if ($acao === 'edit-form') {
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT * FROM itens WHERE id=?');
    $stmt->execute([$id]);
    $itemEdit = $stmt->fetch();
}

/* Listagens */
$itens = $pdo->query('SELECT * FROM itens ORDER BY id DESC')->fetchAll();
$contatos = $pdo->query('SELECT * FROM contatos ORDER BY id DESC LIMIT 20')->fetchAll();

$pageTitle = 'Admin · NutrIA';
include __DIR__ . '/includes/header.php';
?>

<section class="nt-section" style="padding-top: 140px;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
      <div>
        <span class="nt-eyebrow">Admin</span>
        <h1 class="nt-h2 mt-3">Painel <span class="nt-italic nt-orange">NutrIA</span></h1>
      </div>
      <a href="logout.php" class="nt-btn nt-btn-ghost nt-btn-sm">Sair</a>
    </div>

    <?php if ($msg): ?>
      <div class="nt-form-ok show"><span class="dot"></span><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Formulário criar/editar -->
    <div class="nt-fb-card" style="margin-bottom: 40px;">
      <h3 class="nt-h3 mb-3"><?= $itemEdit ? 'Editar item' : 'Novo item' ?></h3>
      <form method="POST" action="admin.php">
        <input type="hidden" name="acao" value="<?= $itemEdit ? 'editar' : 'criar' ?>">
        <?php if ($itemEdit): ?>
          <input type="hidden" name="id" value="<?= (int)$itemEdit['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="nt-field">
              <label for="a_nome">Nome</label>
              <input id="a_nome" name="nome" required value="<?= htmlspecialchars($itemEdit['nome'] ?? '') ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="nt-field">
              <label for="a_cat">Categoria</label>
              <input id="a_cat" name="categoria" required value="<?= htmlspecialchars($itemEdit['categoria'] ?? '') ?>">
            </div>
          </div>
          <div class="col-12">
            <div class="nt-field">
              <label for="a_desc">Descrição</label>
              <textarea id="a_desc" name="descricao" required><?= htmlspecialchars($itemEdit['descricao'] ?? '') ?></textarea>
            </div>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="nt-btn nt-btn-orange" type="submit"><?= $itemEdit ? 'Salvar alterações' : 'Criar item' ?></button>
            <?php if ($itemEdit): ?>
              <a href="admin.php" class="nt-btn nt-btn-ghost">Cancelar</a>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>

    <!-- Lista de itens -->
    <h3 class="nt-h3 mb-3">Itens cadastrados</h3>
    <div class="table-responsive" style="border: 1px solid var(--nt-line); border-radius: 18px; overflow: hidden;">
      <table class="table mb-0" style="background: #fff;">
        <thead style="background: var(--nt-cream);">
          <tr>
            <th style="font-family: var(--nt-mono); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; color: var(--nt-muted);">#</th>
            <th style="font-family: var(--nt-mono); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; color: var(--nt-muted);">Nome</th>
            <th style="font-family: var(--nt-mono); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; color: var(--nt-muted);">Categoria</th>
            <th style="font-family: var(--nt-mono); font-size: 12px; text-transform: uppercase; letter-spacing: .1em; color: var(--nt-muted);">Descrição</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($itens as $i): ?>
          <tr>
            <td><?= (int)$i['id'] ?></td>
            <td><strong><?= htmlspecialchars($i['nome']) ?></strong></td>
            <td><?= htmlspecialchars($i['categoria']) ?></td>
            <td style="max-width: 420px;"><?= htmlspecialchars($i['descricao']) ?></td>
            <td class="text-end">
              <a href="admin.php?acao=edit-form&id=<?= (int)$i['id'] ?>" class="nt-btn nt-btn-ghost nt-btn-sm">Editar</a>
              <a href="admin.php?acao=excluir&id=<?= (int)$i['id'] ?>" class="nt-btn nt-btn-sm" style="background:#B4300A; color:#fff; border-color:#B4300A;" onclick="return confirm('Excluir este item?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Contatos -->
    <h3 class="nt-h3 mb-3 mt-5">Últimas mensagens</h3>
    <div class="row g-3">
      <?php foreach ($contatos as $c): ?>
        <div class="col-md-6">
          <div class="nt-fb-card">
            <div style="font-family: var(--nt-mono); font-size: 11.5px; color: var(--nt-muted); text-transform: uppercase; letter-spacing: .1em;">
              <?= htmlspecialchars($c['criado_em']) ?> · <?= htmlspecialchars($c['assunto']) ?>
            </div>
            <blockquote style="font-size: 16px; margin: 12px 0;">“<?= htmlspecialchars($c['mensagem']) ?>”</blockquote>
            <div class="nt-fb-person">
              <div class="nt-fb-avatar"><?= htmlspecialchars(mb_strtoupper(mb_substr($c['nome'],0,1))) ?></div>
              <div>
                <div class="nt-fb-name"><?= htmlspecialchars($c['nome']) ?></div>
                <div class="nt-fb-role"><?= htmlspecialchars($c['email']) ?><?= $c['telefone'] ? ' · ' . htmlspecialchars($c['telefone']) : '' ?></div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($contatos)): ?>
        <div class="col-12"><p class="nt-lead">Nenhuma mensagem ainda.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
