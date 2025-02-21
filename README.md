# SuperMarket
## Objetivo
Esse projeto tem como objetivo criar um sistema replicável de supermercados.

## Ferramentas
O sistema foi desenvolvido utilizando:
- PHP 8.4.4
- PostgreSQL
- Angular
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
2. Execute o comando pg_restore apontando para o caminho do arquivo super_market.dump dentro da pasta db do repositório e altere os parâmetros para os configurados no PostgreSQL da sua máquina
```
pg_restore -U <usuario> -h <host>  -p <porta> -d <nome_do_banco > --clean --if-exists --verbose "<caminho_do_arquivo>"
```
3. Exemplo:
```
pg_restore -U postgres -h localhost -p 5432 --create --clean --if-exists --verbose -d postgres "C:\Users\yuri\Documents\SuperMarket\db\super_market.dump"
```
4. Conecte-se ao banco de dados super_market criado e deixe-o acessível e rodando

### Rodando a API
1. Em outra janela de terminal, acesse a raiz da pasta api do repositório clonado
2. No arquivo database.php no caminho <pasta_do_repositorio>\api\core\database.php, altere os valores das variáveis $host, $port, $dbname, $user e $password de acordo com os parâmetros para os configurados no PostgreSQL da sua máquina e como fizemos já na etapa da **Restauração e Setup do BD**
3. Para rodar nosso servidor local, digite o comando
```
php -S localhost:8080 -t public
```

### Rodando o Client
1. Para rodar o projeto, você precisará do node.js instalado na máquina
    - Caso não possua, instale-o, por favor: https://nodejs.org/pt/download
2. Mais uma vez, abra outra janela do terminal de sua escolha
3. Acesse a pasta super-market dentro da pasta client, localizada na raiz do repositório
4. Digite o comando para instalar as dependências:
```
npm install
```
5. Digite o comando para rodar o projeto ângular:
```
npm start
```
6. Acesse a URL https:/

### Mãos a obra!!
Pronto, com os três projetos disponíveis e rodando, basta utilizar o sistema!


## Checklist
- Infraestrutura
    - Criar repositório
    - Criar README
        - Descrever como reproduzir o ambiente e rodar a aplicação
            - DB
            - API
            - Client
- DB
    - Estruturar tabelas e relacionamentos
        - Versionar os scripts executados
        - Tabela: users_types
        - Tabela: users
        - Tabela: products_types
        - Tabela: products
        - Tabela: products_images
        - Tabela: payment_types
        - Tabela: sales
        - Tabela: products_sales

- API
    - Adaptar projeto para a estrutura do banco de dados, criando todos os endpoints necessários
        - Mapear todos os endpoints
    - CRUDs
        - users
        - products_types
        - products
    - Autenticação de usuário
    - Listagem de produtos
    - Listagem de tipos de produtos
    - 
- Client
    - Definir como será a interface gráfica
    - Criar projeto Angular
  

## Todo
## api
- Testar operações no banco pelo postman
- Criar endpoint para vendas

### client
- Carrinho
    - Salvar Produtos no carrinho ao sair da página
    - Verificar se já existe uma compra sendo realizada pela metade e permitir restaurar
- Validar se o produto ainda está disponível antes de realizar a venda
    - Consultar objetos antes de atualizar
- Snackbar com mensagens

### Melhorias fora de escopo
- Estruturar projeto em commands e queries
- Autenticação de usuário
- CRUD de usuário
- Tratamentos de quem pode realizar que ações:
    - Somente staff pode visualizar as listagens, criar e atualizar produtos, tipos de produtos e usuários
    - Clientes somente poderão atualizar seus próprios perfis e não poderão alterar seu tipo de usuário
- Inserir usuários padrão (staff, client e sys_admin)

## Fora do escopo inicial (próximas atualizações)
- Possibilitar o cadastro e associação de múltiplos mercados, cada um com seu próprio estoque e log de vendas
- Implementar two-factor authentication opcional para logar e obrigatório para alteração de senha
- E-mail disparado com código em caso de esquecimento de senha
- Produtos favoritos
- Histórico de compras
- Permitir troca de tipo do usuário via sistema
- Transformar consultas em procedures
- Permitir à staff visualizar usuários removidos e editar as informações deles
- Permitir à staff visualizar produtos removidos e editar as informações deles
- Consultar objetos antes de atualizar e atualizar somente registros alterados