# Organograma GW

Sistema web de organograma corporativo da General Water: visualização hierárquica interativa e cadastro de colaboradores.

**Versão:** v1.1.0

---

## Funcionalidades

- Acesso direto, sem autenticação.
- Organograma em estilo planilha, com colunas por área (Produção e Apoio) e hierarquia por linhas.
- Cards com cor, rótulo curto, nível, região, grupo e gestor direto.
- Gestão compartilhada (RIC) com cards separados.
- Zoom, busca por nome/cargo e filtros por área.
- Tema claro/escuro com persistência.
- Botão para minimizar topbar/sidebar e botão flutuante para restaurar.
- CRUD de colaboradores.
- Lista em DataTable com filtros, ordenação e exportação (Excel, PDF, impressão e cópia).

---

## Como o organograma é alimentado

A tabela `colaboradores` é a única fonte dos cards. Campos usados:

| Campo | Uso |
|---|---|
| `nome_completo` | Nome exibido (quando não há rótulo) |
| `rotulo` | Rótulo curto do card (ex.: `PEDRO ALC.`) |
| `cargo` | Cargo do colaborador |
| `regiao` | Terceira linha do card (ex.: `Bahia`, `Integrados RMSP`) |
| `nivel` | Nível hierárquico (`direcao`, `superintendencia`, `gerencia`, `coordenacao`, `supervisao`, `operador_lider`, `trainee`) |
| `nivel_card` | Texto de nível exibido no card (ex.: `Gestão Op.`) |
| `area` | `producao`, `apoio` ou `corporativo` |
| `cor` | Identificador de cor: `roxo`, `azul` ou `laranja` |
| `ordem` | Ordem dentro do setor |
| `ric` | Participa da gestão compartilhada RIC |
| `setor` | Sistema/área (ex.: `Sistemas 1`, `LABOR`) |
| `gestor_id` | Gestor direto |
| `grupo_id` | Grupo corporativo |

As cores são mapeadas no modelo (`Colaborador::CORES`) para as classes CSS do tema, funcionando no modo claro e escuro.

---

## Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate

# configure DB_DATABASE, DB_USERNAME e DB_PASSWORD no .env

php artisan migrate --seed
npm install
npm run build
php artisan serve --host=0.0.0.0 --port=8080
```

Acesso: <http://localhost:8080/organograma>

---

## Stack

- Laravel 13 / PHP 8.3
- AdminLTE 3 / Bootstrap 4 / FontAwesome 6
- Tailwind CSS 4 (Vite)
- MySQL / MariaDB

---

## Estrutura principal

```
app/Models/Colaborador.php             # níveis, cores, árvore e rótulos
app/Http/Controllers/OrganogramaController.php
app/Http/Controllers/ColaboradorController.php
resources/views/organograma/index.blade.php
resources/views/organograma/partials/_cell.blade.php
resources/views/organograma/partials/_attrs.blade.php
database/seeders/ColaboradorSeeder.php
```

---

## Histórico

- **v1.1.0** — Base de colaboradores passa a alimentar os cards (cor, rótulo e nível vêm do banco); layout estilo planilha; tamanhos proporcionais à tela; botão de restaurar UI minimizada.
- **v1.0.0** — Correções de layout, migrations, modal e remoção de autenticação/rotas mortas.
