# Desafio - Dev Back-End

## Resumo
Conforme solicitado no desafio, foram criados os endpoints para cadastro, listagem e edição de produtos, além desses, 
também foram criados endpoints de visualização e remoção dos produtos.

Link com ducumentação dos endpoints https://documenter.getpostman.com/view/11654668/TVzREcvW

## Regras adicionadas, que foram definidas no escopo do teste e são obrigatórias
- Os produtos foram divididos em 4 tipos, sendo:
    - Produto simples, que listam apenas os atributos `nome`, `descricao`, `valor`, `criado_em` e `atualizado_em`;
    - Produto digital, que são produtos digitais e precisam de um link para download, composto de `nome`, `descricao`, 
      `valor`, `link`, `criado_em` e `atualizado_em`;
    - Produto configuravel, tem os mesmos atributos dos produtos simples, porém permitem o cadastro de configurações, 
      como tamanho, cor, peso, etc. Compostos pelos atributos `nome`, `descricao` , `valor`, `criado_em`, 
      `atualizado_em` e um array de `caracteristicas` (essas com os valores `atributo` (exemplo Tamanho) e `valor` 
      (exemplo M));
    - Produto agrupado, que trata-se de um produto que agrupa diversos outros produtos do tipo simples (apenas do tipo 
      simples), contendo as informações `nome`, `descricao`, `valor`, `criado_em`, `atualizado_em` e 
      `produtos_agrupados` (que retorna um array com a visualização de cada produto simples atribuido ao grupo).
- Nenhum produto pode possuir o mesmo nome;
- O Produto Configurável não pode ter menos do que duas características (deve-se informar, por exemplo o tamanho e 
  o peso do produto);
- O Produto Digital não pode ser cadastrado sem um link para download;
- O Produto Agrupado não pode ter menos do que dois produtos simples vinculado à ele;
- O valor do Produto Agrupado deve ser informado no seu cadastro e não possui relação com os valores dos produtos
  vinculados à ele.

## Itens Opcionais
- [x] Criação de log para edição do produto, contendo `data`, `hora`, `valor_anterior` e `valor_atual` do produto;
- [x] Criação de um campo booleano que marque um produto como visitado ao visualizá-lo;
- [x] Criação de um valor promocional para os produtos, com tempo determinado no cadastro da promoção.

## Outros itens opcionais
- [x] Desenvolver autenticação na API;
- [x] Utilização de Padrões de Projetos;
- [x] Testes Automatizados;
- [x] Documentação de todos os endpoints.

## Tecnologias Utilizadas
- PHP 7;
- Laravel 7;
- MySQL;
- Autenticação JWT.

## Configurações
- Clonar o projeto para ambiente local: `git clone https://github.com/pedrodalvy/cadastro_produtos.git cadastro_produtos`;
- Abrir o projeto e criar o `.env` a partir do `.env.example`: `cd cadastro_produtos && cp .env.example .env`;
- Instalar as dependências do composer: `composer install`;
- Configurar o banco de dados no .env e executar a migration com os seeds: `php artisan migrate --seed`;

## Executar os testes
- Na raiz do projeto, executar o comando: `vendor/bin/phpunit`;

## Listando os produtos
- Inicializar o servidor através do comando: `php artisan serve`;
- Enviar uma requisição via GET para http://localhost:8000/api/v1/produtos;

## Fazendo login
Ao executar a migration com os seeds, um usuário já vem cadastrado para utilização da api.
- fazer uma requisição via POST para http://localhost:8000/api/auth/login, com o body:
    ```json
    {
        "email": "user@example.com",
        "password": "123456"
    }
    ```
  

Link com documentação completa dos endpoints: https://documenter.getpostman.com/view/11654668/TVzREcvW
