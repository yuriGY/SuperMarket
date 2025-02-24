# SuperMarket

## Objetivo

Esse projeto tem como objetivo criar um sistema replicável de supermercados.

## Ferramentas

O sistema foi desenvolvido utilizando:

- PHP 8.4.4
- PostgreSQL 17
- Angular 19.1
- Material Design

## Passo a passo para rodar o projeto

### Setup Inicial

1. Será necessário ter algumas tecnologias instaladas na máquina para rodar o projeto, caso não possua alguma, instale-a, por favor!
   - PostgreSQL: https://www.postgresql.org/download/
   - PHP: https://www.php.net/downloads.php
   - Node.js: https://nodejs.org/pt/download
2. Clone este repositório

### Restauração e Setup do BD

1. Abra um terminal de sua escolha
2. Execute o comando pg_restore apontando para o caminho do arquivo super_market.dump dentro da raiz do repositório clonado e altere os parâmetros do comando abaixo para os configurados no PostgreSQL instalado na sua máquina

```
pg_restore -U <usuario> -h <host>  -p <porta> -d <nome_do_banco > --clean --if-exists --verbose "<caminho_do_arquivo>"
```

3. Exemplo:

```
pg_restore -U postgres -h localhost -p 5432 --create --clean --if-exists --verbose -d postgres "C:\Users\yuri\Documents\SuperMarket\super_market.dump"
```

4. Conecte-se ao banco de dados super_market criado e deixe-o acessível e rodando

### Rodando a API

1. Em outra janela de terminal, acesse a raiz da pasta api do repositório clonado
2. No arquivo config.php no caminho <pasta_do_repositorio>\Api\Core\config.php, altere os valores das variáveis $host, $port, $dbname, $user e $password de acordo com os parâmetros configurados no PostgreSQL de sua máquina e como fizemos já na etapa da **Restauração e Setup do BD**
3. Para rodar nosso servidor local, na pasta Api localizada na raiz do repositório, digite o comando

```
php -S localhost:8080 -t public
```

### Rodando o Client

1. Mais uma vez, abra outra janela do terminal de sua escolha
2. Acesse a pasta superMarket dentro da pasta client, localizada na raiz do repositório
3. Digite o comando para instalar as dependências:

```
npm install
```

4. Digite o comando para rodar o projeto Angular:

```
npm start
```

5. Acesse a URL do client configurada (Padrão: http://localhost:4200/)

### Mãos a obra!!

Pronto, com as duas aplicações e o banco de dados disponíveis e rodando, basta utilizar o sistema!

## Fora do escopo inicial (próximas atualizações)

O período de desenvolvimento deste desafio foi de uma semana, por esse motivo várias melhorias que pensei em implementar acabaram ficando para próximas atualizações.
A seguir estão listadas as ideias de melhorias que tive, mas acabei que não implementando.

### Geral

- Adicionar imagens aos produtos
- Melhorar retornos de erros
- Paginação nas listagens
  - Filtros passando para as queries para serem paginados

### API

- Utilizar uma ORM
  - Higienizar input de dados para evitar SQL Injection
  - Consultar objetos antes de atualizar e atualizar somente registros alterados
    - Utilizar transactions em todas as commands
- Transformar consultas em procedures
- Implementar $action nas controllers para realizar operações diferentes com o mesmo tipo de requisição (GET, POST, PUT, DELETE)
- Criar interfaces para retornos de dados de cada commands/query
- Implementar mensagens de retorno técnicas, após, tratar as mensagens no front baseado no código retornado pela requisição
- Utilizar Namespaces

### Client

- Implementar tela de checkout
- Implementar barra de busca no carrinho
- Implementar responsividade completa Mobile
- Consertar carregamento das páginas (Elas piscam e redimensionam ao carregar)/ngOnInit da ListProducts é carregado duas vezes
  - Implementar loading spinners para suavizar a experiência do cliente
  - Tagear tipos de produtos removidos, ns listagem de produtos
- Componentização
  - Criar arquivo environment.json para guardar URL da API e alterá-la em apenas um lugar
  - Centralizar estilos compartilhados (Paleta de cores, ícones, etc)
  - Listagem
    - Grid
  - Bottomsheets
  - Dialogs com confirmações
  - Snackbar com feedback de sucesso/erro baseado no código retornado pela requisição
- Trocar subscribes por Promises
  - Utilização de classes contendo Queries e Commands únicas, seus tratamentos e validações sendo feitas nas suas próprias classes
- Implementar validações adicionais
  - Dialog de confirmação: "Você tem itens no carrinho, deseja mesmo sair da página? A compra será perdida! Deseja Continuar?"
  - Dialog de confirmação: "Atenção o produto <nome-do-item> possui um tipo excluído e pode estar com a taxa de imposto desatualizada! Deseja Continuar?"
    - Necessário mudança de regra de negócio, não se pode comprar algo com a taxa de imposto incorreta sob hipótese alguma!
  - Dialog de confirmação: "Deseja excluir o item <nome-do-item>? Essa operação não pode ser defeita!"
  - Dialog de confirmação: "Tem certeza que deseja limpar o carrinho ? Essa operação não pode ser defeita!"
  - Tratar valores 0 e casas demais nos formulários para receber até no máximo duas casas, como é na tabela do banco
- Ajustar filtro para filtrar apenas por propriedades exibidas na grid
- Ajustar scroll das listagens para manter sempre os nomes das colunas visíveis

### Implementação de usuários

- Segurança
  - Autenticação de usuário
  - Implementar two-factor authentication opcional para logar e obrigatório para alteração de senha
  - E-mail disparado com código em caso de esquecimento de senha
  - Tratamentos de quem pode realizar que ações:
    - Somente staff pode visualizar as listagens, criar e atualizar produtos, tipos de produtos e usuários
    - Clientes somente poderão atualizar seus próprios perfis e não poderão alterar seu tipo de usuário
- Funcionalidades/Features
  - Produtos favoritos
  - Histórico de compras
  - Permitir troca de tipo do usuário via sistema
  - Permitir à staff visualizar usuários removidos e editar as informações deles
  - Possibilitar o cadastro e associação de múltiplos mercados, cada um com seu próprio estoque e log de vendas
