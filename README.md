# SuperMarket
## Objetivo
Esse projeto tem como objetivo criar um sistema replicável de supermercados.

## Ferramentas
O sistema será desenvolvido utilizando:
- PHP 7.4 ou superior
- PostgreSQL
- Angular
- Material Design

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
    - Listagem de usuários
    - Listagem de produtos
    - Listagem de tipos de produtos
    - 
- Client
    - Definir como será a interface gráfica
    - Criar projeto Angular
  

## Todo
- Carrinho
    - Salvar Produtos no carrinho ao sair da página
    - Verificar se já existe uma compra sendo realizada pela metade e permitir restaurar
- Validar se o produto ainda está disponível antes de realizar a venda
- Randomizador de IDs que aceita números e letras apenas


## Fora do escopo inicial (próximas atualizações)
- Possibilitar o cadastro e associação de múltiplos mercados, cada um com seu próprio estoque e log de vendas
- Implementar two-factor authentication opcional para logar e obrigatório para alteração de senha
- E-mail disparado com código em caso de esquecimento de senha
- Produtos favoritos
- Histórico de compras

