# Orientações

## Premissa

Desenvolver um serviço REST para tratar as regras de negócios descritas abaixo.
- [x] Linguagens: PHP (a partir da versão 5.6)
- [x] Framework: Opcional
- [x] Informações devem ser persistidas em um banco relacional
- [x] Deverá ser criado o dockerfile para a montagem do ambiente
- [x] Os arquivos devem ser disponibilizados em um repositório GIT.

Utilização das seguintes tecnologias será considerada um diferencial:
- [ ] O código PHP estar seguindo os padrões de desenvolvimento PSR-1, PSR-2 e PSR-5.
- [ ] Classes de testes para PHPUnit

## Serviços a serem criados:

- [x] Inclusão de corredores para uma corrida
    - ID único
    - Nome
    - CPF
    - Data de nascimento
- [x] Inclusão de provas
    - Id da prova
    - Tipo de prova (3, 5, 10, 21, 42km)
    - Data
- [x] Inclusão de corredores em provas
    - ID do corredor
    - ID da prova
- [x] Inclusão de resultados dos corredores
    - ID do corredor
    - ID da prova
    - Horário de início da prova
    - Horário de conclusão da prova
- [ ] Listagem de classificação das provas por idade
    - ID da prova
    - Tipo de prova
    - ID do corredor
    - Idade
    - Nome do corredor
    - Posição

- [ ] Listagem de classificação das provas gerais
    - ID da prova
    - Tipo de prova
    - ID do corredor
    - Idade
    - Nome do corredor
    - Posição

## Regras de negócio

- [x] Todos os campos são obrigatórios.
- [x] Não é permitido cadastrar o mesmo corredor em duas provas diferentes na mesma data.
    > Por exemplo, o corredor Barry Allen não pode estar cadastrado nas provas de 21km e 42km no dia 05/10/2019.
- [x] Não é permitida a inscrição de menores de idade.
- [ ] As classificações são definidas pelo menor tempo de prova.
- [ ] A listagem de classificações por idade deve apresentar as posições dos candidatos dentro dos seguintes grupos em cada tipo de prova:
    - 18 – 25 anos
    - 25 – 35 anos
    - 35 – 45 anos
    - 45 – 55 anos
    - Acima de 55 anos
    > Por exemplo, as colocações de 18 -25 na prova de 3km apresentarão os 1º, 2º, 3º, ..., nesta faixa de idade, o mesmo para as outras faixas e tipos de provas.
- [ ] A listagem de classificações gerais deve ser separada por tipos de provas.

