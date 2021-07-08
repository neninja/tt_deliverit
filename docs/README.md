# Endpoints

- [Exemplos](https://raw.githubusercontent.com/nenitf/teste_deliverit/main/api.rest)

## Lista corredores

```http
GET /corredores
```

| Parameter | Description |
| :-------- | :-----------|
| `nome`    | Nome        |
| `cpf`     | CPF         |


## Cria corredor

```http
POST /corredores
```

```json
{
  "nome": "string*",
  "cpf": "string*",
  "dataNascimento": "yyyymmdd*"
}
```
