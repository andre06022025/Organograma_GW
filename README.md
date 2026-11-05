# Organograma GW

Sistema web de organograma corporativo da General Water: visualização hierárquica interativa e cadastro de colaboradores.

**Versão:** v1.9.4

---

## Funcionalidades

- Acesso direto, sem autenticação.
- Organograma em estilo planilha, com colunas por área (Produção e Apoio) e hierarquia por linhas.
- Cards com cor, nome completo, nível, região, grupo e gestor direto.
- Foto do colaborador ao lado do nome, com placeholder de pessoa do Bootstrap e modal para envio/troca da foto.
- Gestão compartilhada (RIC) com cards separados.
- Zoom, busca por nome/cargo e filtros por área.
- Tema claro/escuro com persistência.
- Botão para minimizar topbar/sidebar e botão flutuante para restaurar.
- CRUD de colaboradores.
- Lista em DataTable com filtros, ordenação e exportação (Excel, PDF, impressão e cópia).
- Cadastros de unidades/clientes (ETA/EPAR) em DataTable, com cadastro/edição, gestor, sistema e campos operacionais.
- Data de contratação no cadastro de colaboradores.
- Ao clicar no cadastro, um modal exibe todos os dados.
- No organograma, o modal do gestor lista os cadastros; cada card mostra o nome do cadastro com um botão + para expandir os detalhes (sistema, operação, operadores, poços e quantidade).
- Arrastar e soltar cards do organograma para reorganizar, com posição salva automaticamente no banco.
- Modo edição no organograma: painel lateral para renomear e ajustar posição/largura de todos os cards, inclusive as barras fixas, com persistência automática.
- Sistemas 3 e 4 independentes: colunas, cards, cadastros e filtros separados.

---

## Como o organograma é alimentado

A tabela `colaboradores` é a única fonte dos cards. Campos usados:

| Campo | Uso |
|---|---|
| `nome_completo` | Nome exibido no card |
| `foto_path` | Foto exibida no card (placeholder Bootstrap quando vazio) |
| `cargo` | Cargo do colaborador (exibido no card) |
| `regiao` | Terceira linha do card (ex.: `Bahia`, `Integrados RMSP`) |
| `area` | `producao`, `apoio` ou `corporativo` |
| `cor` | Identificador de cor: `roxo`, `azul` ou `laranja` |
| `ordem` | Ordem dentro do setor |
| `ric` | Participa da gestão compartilhada RIC |
| `card_coluna` | Coluna do card no grid (salva pelo drag-and-drop) |
| `card_linha` | Linha do card no grid |
| `card_colspan` | Quantidade de colunas que o card ocupa |
| `setor` | Sistema/Área (ex.: `Sistemas 1`, `LABOR`) |
| `data_contratacao` | Data de contratação (opcional) |
| `gestor_id` | Gestor direto |
| `grupo_id` | Grupo corporativo |

As cores são mapeadas no modelo (`Colaborador::CORES`) para as classes CSS do tema, funcionando no modo claro e escuro.

### Drag and drop

Arraste um card e solte sobre outro **da mesma área** e com o **mesmo número de colunas** para trocar as posições. A troca é salva automaticamente em `card_coluna`, `card_linha` e `card_colspan` e permanece após recarregar a página. As barras fixas (Direção, Superintendência e Gerência) também podem ser movidas e editadas.

### Modo edição

Clique no botão **Editar** na barra superior para ativar o modo edição. Com ele ativo:

- Clique em qualquer card, inclusive nas barras fixas, para abrir o painel **Editar card**.
- **Arraste o próprio card** para qualquer coluna/linha da mesma área. Uma moldura tracejada mostra o destino. Ao soltar, a posição é salva automaticamente; se o destino estiver ocupado, os cards trocam de posição.
- No painel, altere o nome/texto no campo superior.
- Use **←** / **→** para mover o card entre as colunas (a legenda mostra a posição atual, ex.: `1/9`) e **↑** / **↓** para mover entre as linhas.
- Use **−** / **+** para ajustar a largura em colunas.
- Ajuste o **alinhamento horizontal** (Esquerda, Centro, Direita) e o **alinhamento vertical** (Topo, Meio, Base), ou clique em **Centralizar tudo**.
- A pré-visualização é em tempo real. Clique em **Salvar** para aplicar ou em **Voltar** para desfazer.
- A barra de Direção ocupa a largura total: nela apenas o texto e o alinhamento podem ser alterados.

As alterações são salvas no banco (`nome_completo` para pessoas, `card_texto` para barras, `card_coluna`, `card_linha`, `card_colspan`, `card_align` e `card_valign`).

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

### Como iniciar no Windows

Dê duplo clique em **`start.bat`** (ou rode `powershell -ExecutionPolicy Bypass -File .\start.ps1`). O script:

- encerra qualquer processo antigo na porta 8080 (evita conflito);
- inicia o servidor em `http://localhost:8080/organograma`;
- reinicia automaticamente se o servidor cair.

Para parar, use **`stop.ps1`** ou pressione `Ctrl+C`.

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

- **v1.9.4** — Nomes "Áreas de Produção" e "Áreas de Apoio" reposicionados logo abaixo da barra de Direção (Thiago).
- **v1.9.3** — O próprio card pode ser arrastado para qualquer coluna/linha da grade, com moldura de destino e troca automática se a posição estiver ocupada.
- **v1.9.2** — Editor com alinhamento horizontal/vertical, botão Centralizar tudo, setas ←/→ e ↑/↓ para mover o card e pré-visualização em tempo real.
- **v1.9.1** — Painel de edição reposicionado e corrigido: campos e botões −/+ para coluna, linha e largura, com botões Salvar e Voltar.
- **v1.9.0** — Modo edição reformulado com painel lateral: clique em qualquer card, inclusive nas barras fixas, para alterar texto, coluna, linha e largura, com persistência automática.
- **v1.7.9** — Módulo de edição no organograma: botão Editar ativa arrastar, renomear e ajustar largura dos cards, com salvamento automático.
- **v1.7.8** — Removido o campo Nível; o informativo do card passa a usar apenas o cargo do colaborador.
- **v1.7.7** — Reestruturado o campo Nível: agora é um texto livre exibido no card; removido o campo "Nível no card".
- **v1.7.6** — Rótulo do card passa a ser sempre o nome completo do colaborador (removido o rótulo curto).
- **v1.7.5** — Scripts `start.bat`, `start.ps1` e `stop.ps1` para iniciar o servidor com reinício automático e evitar conflito na porta 8080.
- **v1.7.4** — Barras do organograma (Direção, Superintendência, Gerência Corporativa) passam a exibir o nome do colaborador conforme o cadastro, refletindo alterações no CRUD.
- **v1.7.3** — Data de contratação no cadastro de colaboradores (campo no formulário, na lista e no modal do organograma).
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
