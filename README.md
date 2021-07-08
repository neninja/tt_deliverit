# teste_deliverit

![Tests](https://github.com/nenitf/teste_deliverit/actions/workflows/tests.yml/badge.svg)

Teste do processo seletivo para a [Deliver It](http://deliverit.com.br/).

- [Orientações](orientacoes.md)
- [Referência da API](docs)

## Setup

- Crie os containers ``docker-compose up -d --build``
    - Pare o container com ``docker-compose down``
- Baixe as dependências do composer ``docker-compose exec app composer install``
- Crie as tabelas no banco ``docker-compose exec app php artisan migrate``

## Teste

- Para testes durante o desenvolvimento:
    - Acesse o container ``docker exec -it app bash``
    - Execute os testes ``composer test``
    > `composer test:filter CadastroCorredor` filtra os testes de `app/Core/Tests/UseCases/CadastroCorredorTest`
- Para ci ``docker-compose exec app composer ci``
