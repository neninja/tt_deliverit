# teste_deliverit

![Tests](https://github.com/nenitf/teste_deliverit/actions/workflows/tests.yml/badge.svg)

Teste do processo seletivo para a [Deliver It](http://deliverit.com.br/).

- [Orientações](orientacoes.md)

## Setup

1. Duplique `.env.example` e renomeie para `.env`
2. Crie os containers ``docker-compose up -d --build``
    > Você pode parar os containers com ``docker-compose down``
3. Baixe as dependências do composer ``docker-compose exec app composer install``
4. Crie as tabelas no banco ``docker-compose exec app php artisan migrate --seed``
    > Você pode limpar as tabelas ``docker-compose exec app php artisan migrate:refresh --seed``
5. Crie a documentação de suporte ``docker-compose exec app composer swagger`` e a acesse em ``localhost:8080/public/swagger``

> `docker-compose exec app php artisan db:seed --class FakeSeeder` irá criar +3 corredores e +5 provas

## Teste

- Para testes durante o desenvolvimento:
    - Acesse o container ``docker exec -it app bash``
    - Execute os testes ``composer test``
        > `composer test:filter <filtro>` filtra testes

- Para ci ``docker-compose exec app composer ci``

> Testes que contenham `@group db` resetarão as migrations, portanto caso queira fazer testes manuais após o phpunit utilize ``docker-compose exec app php artisan migrate --seed``
