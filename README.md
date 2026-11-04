# Organograma GW

Sistema web de organograma corporativo da General Water: visualização hierárquica interativa e cadastro de colaboradores.

**Versão:** v1.7.2

---

## Funcionalidades

- Acesso direto, sem autenticação.
- Organograma em estilo planilha, com colunas por área (Produção e Apoio) e hierarquia por linhas.
- Cards com cor, rótulo curto, nível, região, grupo e gestor direto.
- Foto do colaborador ao lado do nome, com placeholder de pessoa do Bootstrap e modal para envio/troca da foto.
- Gestão compartilhada (RIC) com cards separados.
- Zoom, busca por nome/cargo e filtros por área.
- Tema claro/escuro com persistência.
- Botão para minimizar topbar/sidebar e botão flutuante para restaurar.
- CRUD de colaboradores.
- Lista em DataTable com filtros, ordenação e exportação (Excel, PDF, impressão e cópia).
- Cadastros de unidades/clientes (ETA/EPAR) em DataTable, com cadastro/edição, gestor, sistema e campos operacionais.
- Ao clicar no cadastro, um modal exibe todos os dados.
- No organograma, o modal do gestor lista os cadastros; cada card mostra o nome do cadastro com um botão + para expandir os detalhes (sistema, operação, operadores, poços e quantidade).
- Arrastar e soltar cards do organograma para reorganizar, com posição salva automaticamente no banco.
- Sistemas 3 e 4 independentes: colunas, cards, cadastros e filtros separados.

---

## Como o organograma é alimentado

A tabela `colaboradores` é a única fonte dos cards. Campos usados:

| Campo | Uso |
|---|---|
| `nome_completo` | Nome exibido (quando não há rótulo) |
| `foto_path` | Foto exibida no card (placeholder Bootstrap quando vazio) |
| `rotulo` | Rótulo curto do card (ex.: `PEDRO ALC.`) |
| `cargo` | Cargo do colaborador |
| `regiao` | Terceira linha do card (ex.: `Bahia`, `Integrados RMSP`) |
| `nivel` | Nível hierárquico (`direcao`, `superintendencia`, `gerencia`, `coordenacao`, `supervisao`, `operador_lider`, `trainee`) |
| `nivel_card` | Texto de nível exibido no card (ex.: `Gestão Op.`) |
| `area` | `producao`, `apoio` ou `corporativo` |
| `cor` | Identificador de cor: `roxo`, `azul` ou `laranja` |
| `ordem` | Ordem dentro do setor |
| `ric` | Participa da gestão compartilhada RIC |
| `card_coluna` | Coluna do card no grid (salva pelo drag-and-drop) |
| `card_linha` | Linha do card no grid |
| `card_colspan` | Quantidade de colunas que o card ocupa |
| `setor` | Sistema/Área (ex.: `Sistemas 1`, `LABOR`) |
| `gestor_id` | Gestor direto |
| `grupo_id` | Grupo corporativo |

As cores são mapeadas no modelo (`Colaborador::CORES`) para as classes CSS do tema, funcionando no modo claro e escuro.

### Drag and drop

Arraste um card e solte sobre outro **da mesma área** e com o **mesmo número de colunas** para trocar as posições. A troca é salva automaticamente em `card_coluna`, `card_linha` e `card_colspan` e permanece após recarregar a página. Barras de cabeçalho (superintendências) e os cards compactos da RIC não são arrastáveis.

---

## Cadastros (ETA/EPAR)

A tabela `cadastros` armazena as unidades/clientes do grupo:

| Campo | Uso |
|---|---|
| `nome` | Nome da unidade/cliente |
| `tipo` | `ETA` ou `EPAR` |
| `gestor_id` | Gestor responsável (colaborador) |
| `sistema` | Sistema atribuído (Sistemas 1 a 9) |
| `operacao` | Operação (opcional) |
| `operadores` | Até 4 operadores (JSON) |
| `numero_pocos` | Número de poços (opcional) |
| `quantidade_operadores` | Quantidade de operadores (opcional) |

A página **Cadastros** (`/cadastros`) lista os registros em DataTable, com busca, filtros por tipo/gestor/sistema, cadastro/edição e exportação. Ao clicar em uma linha, um modal exibe todos os dados. Campos sem informação ficam vazios. Acesso pelo menu lateral, abaixo de Colaboradores.

No **organograma**, ao abrir o card de um gestor, o modal lista os cadastros. Cada card aparece recolhido, mostrando o nome do cadastro e um botão **+** para expandir os detalhes (sistema, operação, operadores, poços e quantidade).

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

- **v1.7.2** — Removido o Organograma 2 (alternativo) e todo o código associado (rota, controller, views, link do menu e scripts).
- **v1.7.1** — João (Sistemas 3) movido para o espaço vazio abaixo de Julio, preenchendo a grade da coluna.
- **v1.7.0** — Sistemas 3 e 4 independentes em todos os pontos: colunas, cards, cadastros (ETA/EPAR) e filtros do organograma separados.
- **v1.6.3** — Card do gestor no organograma: cada cadastro aparece recolhido com o próprio nome e um botão + para expandir os detalhes (sistema, operação, operadores, poços e quantidade).
- **v1.6.2** — Card do gestor no organograma: cadastros agrupados por sistema, exibindo apenas o nome do sistema e um botão + para expandir os detalhes.
- **v1.6.1** — Removidos os campos contrato, data do contrato e informações da gestão dos cadastros (banco, formulário, lista, modal e card do gestor).
- **v1.6.0** — Cadastros com gestor, sistema, contrato, data e informações da gestão; modal de detalhes ao clicar na linha; card do gestor no organograma lista os contratos/cadastros sob sua responsabilidade.
- **v1.5.0** — Drag and drop dos cards do organograma, com troca de posição e persistência automática (coluna, linha e span).
- **v1.4.0** — Cadastros com botão Novo, edição por linha e campos operacionais (Operação, até 4 Operadores, Nº de Poços e Qtd. de Operadores), vazios quando não informados.
- **v1.3.0** — Tabela `cadastros` (ETA/EPAR) com 156 registros, página em DataTable e item no menu abaixo de Colaboradores.
- **v1.2.1** — Lista de colaboradores passa a exibir todos os registros (removido o limite de 20 da paginação; DataTable mostra todos por padrão).
- **v1.2.0** — Foto do colaborador ao lado do nome (placeholder Bootstrap) e modal para envio/troca da foto direto do organograma.
- **v1.1.0** — Base de colaboradores passa a alimentar os cards (cor, rótulo e nível vêm do banco); layout estilo planilha; tamanhos proporcionais à tela; botão de restaurar UI minimizada.
- **v1.0.0** — Correções de layout, migrations, modal e remoção de autenticação/rotas mortas.
