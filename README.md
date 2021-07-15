# teste_deliverit

![Tests](https://github.com/nenitf/teste_deliverit/actions/workflows/tests.yml/badge.svg)

[Teste](orientacoes.md) do processo seletivo para a [Deliver It](http://deliverit.com.br/).

## Setup

1. Duplique `.env.example` e renomeie para `.env`
```sh
cp .env.example .env
```

2. Crie os containers
```sh
docker-compose up -d --build

# Parar os containers
#docker-compose down
```

3. Baixe as dependências do composer
```sh
docker-compose exec app composer install
```

4. Crie as tabelas no banco
```sh
docker-compose exec app php artisan migrate --seed

# Limpar as tabelas e atualizar banco de acordo com as migrations
#docker-compose exec app php artisan migrate:refresh --seed
```

5. Crie a documentação de suporte (ficará disponível em `localhost:8080/public/swagger`)
```sh
docker-compose exec app composer swagger

# Para criar +3 corredores e +5 provas aleatórias
#docker-compose exec app php artisan db:seed --class FakeSeeder
```

## Teste

- Para testes durante o desenvolvimento
```sh
docker-compose exec app bash # acessa o container
composer test # executa testes dentro do container

# Filtrar
#composer test:filter <filtro>
```

- Para ci 
```sh
docker-compose exec app composer ci
```

> Testes que contenham `@group db` resetarão as migrations, portanto caso queira fazer testes manuais após o phpunit utilize ``docker-compose exec app php artisan migrate --seed``
