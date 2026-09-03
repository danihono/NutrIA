# NutrIA — Landing Page + Portfólio

Projeto acadêmico: startup de IA para alimentação.

## Estrutura

```
index.html         → Preview estática (abra direto no navegador / preview)
index.php          → Versão oficial (puxa itens do banco)
db.php             → Conexão SQLite + criação das tabelas
contato.php        → Processa o formulário de contato
login.php          → Autenticação da área admin
logout.php         → Encerra sessão
admin.php          → CRUD de itens + listagem de contatos
includes/
  header.php       → Cabeçalho reutilizável (include)
  footer.php       → Rodapé reutilizável (include)
assets/
  css/style.css    → 1 único arquivo CSS externo
  js/script.js     → Validação de form + animações
  js/tweaks.jsx    → Painel de variações (opcional, só no preview HTML)
tweaks-panel.jsx   → (opcional)
```

## Como rodar localmente

Precisa de PHP 7.4+ com SQLite habilitado (ex: XAMPP, Laragon, ou `php -S`).

```bash
# na pasta do projeto
php -S localhost:8000
```

Depois abra `http://localhost:8000/index.php`.

## Credenciais do admin

- **URL:** `http://localhost:8000/login.php`
- **Usuário:** `admin`
- **Senha:** `nutria2026`

(Definidos em `db.php` — troque antes de publicar.)

## Requisitos atendidos

### HTML5
- [x] `<header>`, `<nav>`, `<main>`, `<footer>` semânticos
- [x] `<label>` em todos os campos
- [x] `alt` em todas as imagens

### CSS3
- [x] `assets/css/style.css` externo e único
- [x] `box-sizing: border-box` global
- [x] Paleta (laranja + branco) e tipografia (Space Grotesk + Inter + Instrument Serif) consistentes
- [x] Pseudo-classes `:hover` e `:focus`

### Bootstrap (≥ 2 de 3)
- [x] Navbar responsiva com colapso mobile
- [x] Cards para produtos/serviços (`.nt-sol-card`, `.nt-fb-card`, `.nt-blog-card`)
- [x] Grid com `.row`/`.col-lg-*`/`.col-md-*`

### JavaScript (≥ 2 de 3)
- [x] Validação do formulário no navegador (campos vazios + e-mail)
- [x] Interações visuais: menu mobile, alerta de envio, contadores animados, reveal on scroll

### PHP (3 de 3)
- [x] `include` de header/footer em todas as páginas
- [x] `$_POST` no formulário + validação server-side
- [x] Login com verificação usuário/senha
- [x] CRUD completo no admin (criar, listar, editar, excluir)
- [x] `htmlspecialchars()` em toda saída
- [x] Prepared statements em todas as queries
- [x] `session_start()` e checagem no topo de `admin.php`

### Banco
- [x] 2 tabelas (`itens`, `contatos`)
- [x] `db.php` único com a conexão SQLite
- [x] Itens cadastrados no admin aparecem em `index.php`
