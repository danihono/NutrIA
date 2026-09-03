<?php
/**
 * db.php — Conexão SQLite + inicialização de tabelas
 * Uso: require_once __DIR__ . '/db.php'; depois use $pdo
 */

$dbPath = __DIR__ . '/nutria.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON;');
} catch (PDOException $e) {
    die('Erro ao conectar ao banco: ' . htmlspecialchars($e->getMessage()));
}

/* Cria tabelas se não existirem */
$pdo->exec("
    CREATE TABLE IF NOT EXISTS itens (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        categoria TEXT NOT NULL,
        descricao TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS contatos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        telefone TEXT,
        assunto TEXT NOT NULL,
        mensagem TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

/* Seed inicial de itens (apenas se vazio) */
$count = $pdo->query('SELECT COUNT(*) FROM itens')->fetchColumn();
if ((int)$count === 0) {
    $seed = $pdo->prepare('INSERT INTO itens (nome, categoria, descricao) VALUES (?, ?, ?)');
    $seed->execute(['NutrIA Plan', 'Produto', 'Dietas personalizadas geradas por IA a partir da rotina, idade, peso e altura.']);
    $seed->execute(['NutrIA Scan', 'Produto', 'Análise por foto: calorias, proteínas, carboidratos e gorduras em segundos.']);
    $seed->execute(['Lista inteligente', 'Serviço', 'Lista de compras semanal otimizada por geolocalização e orçamento.']);
}

/* Credenciais do admin — troque em produção! */
if (!defined('ADMIN_USER')) define('ADMIN_USER', 'admin');
if (!defined('ADMIN_PASS')) define('ADMIN_PASS', 'nutria2026');
