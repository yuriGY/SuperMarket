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
2. Execute o comando pg_restore apontando para o caminho do arquivo super_market.dump dentro da raiz do repositório e altere os parâmetros do comando abaixo para os configurados no PostgreSQL instalado na sua máquina
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
2. No arquivo config.php no caminho <pasta_do_repositorio>\Api\Core\config.php, altere os valores das variáveis $host, $port, $dbname, $user e $password de acordo com os parâmetros para os configurados no PostgreSQL da sua máquina e como fizemos já na etapa da **Restauração e Setup do BD**
3. Para rodar nosso servidor local, na raiz da api, <pasta_do_repositorio>\Api, digite o comando
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
5. Acesse a URL http://localhost:4200/

### Mãos a obra!!
Pronto, com os três projetos disponíveis e rodando, basta utilizar o sistema!


## Checklist
### client
- Carrinho
    - Salvar Produtos no carrinho ao sair da página
    - Verificar se já existe uma compra sendo realizada pela metade e permitir restaurar
- Validar se o produto ainda está disponível antes de realizar a venda
    - Consultar objetos antes de atualizar
- Snackbar com mensagens

## Fora do escopo inicial (próximas atualizações)
- Higienizar input de dados para evitar SQL Injection
- Transformar consultas em procedures
- Consultar objetos antes de atualizar e atualizar somente registros alterados
- Implementar $action nas controllers para realizar operações diferentes

### Implementação de usuários
- Autenticação de usuário
- Tratamentos de quem pode realizar que ações:
    - Somente staff pode visualizar as listagens, criar e atualizar produtos, tipos de produtos e usuários
    - Clientes somente poderão atualizar seus próprios perfis e não poderão alterar seu tipo de usuário
- Produtos favoritos
- Histórico de compras
- Permitir troca de tipo do usuário via sistema
- Permitir à staff visualizar usuários removidos e editar as informações deles
- Implementar two-factor authentication opcional para logar e obrigatório para alteração de senha
- E-mail disparado com código em caso de esquecimento de senha
- Possibilitar o cadastro e associação de múltiplos mercados, cada um com seu próprio estoque e log de vendas
