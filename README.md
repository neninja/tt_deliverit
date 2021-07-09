# teste_deliverit

![Tests](https://github.com/nenitf/teste_deliverit/actions/workflows/tests.yml/badge.svg)

Teste do processo seletivo para a [Deliver It](http://deliverit.com.br/).

- [Orientações](orientacoes.md)

## Setup

- Duplique `.env.example` e renomeie para `.env`
- Crie os containers ``docker-compose up -d --build``
    > Você pode parar os containers com ``docker-compose down``
- Baixe as dependências do composer ``docker-compose exec app composer install``
- Crie as tabelas no banco ``docker-compose exec app php artisan migrate --seed``
    > Você pode limpar as tabelas ``docker-compose exec app php artisan migrate:refresh --seed``
- Crie a documentação de suporte ``docker-compose exec app composer swagger`` e a acesse em ``localhost:8080/public/swagger``

## Teste

- Para testes durante o desenvolvimento:
    - Acesse o container ``docker exec -it app bash``
    - Execute os testes ``composer test``
        > `composer test:filter <filtro>` filtra testes
- Para ci ``docker-compose exec app composer ci``
