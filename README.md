# API-REST Eventos e Palestras | Symfony 5

## API para criação de eventos e palestras pertencentes aos eventos.

Dev.: Tito Delerino Filho

### Pré-Requisitos

> ╚ PHP 8.0+<br>
> ╚ PostgreSQL 13<br>
> ╚ Composer 2.2.4<br>
> ╚ Git<br>

## Modo de Instalação

Após a instalação dos clientes acima listados como pré-requisitos para o uso, iremos começar:

###### 1º Download do Repositório:

> Link: https://github.com/titodelerinofilho/api_rest_events.git

ou

> '$ git clone https://github.com/titodelerinofilho/api_rest_events.git'

###### 2º Execução do composer

O mesmo baixará todas os pacotes necessários para rodar a aplicação

> $ composer install

###### 3º Iremos configurar nosso .env para conexão do banco de dados

No arquivo .env na raiz do projeto, possui a linha de configuração da conexão com o PostgreSQL, indicando o servidor, usuário, senha e o banco de dados a ser utilizado pela API.

> ** DATABASE_URL="postgresql://postgres:8y17tzps@127.0.0.1:5432/api_events?serverVersion=13&charset=utf8" **

Você deverá antes de alterar esse arquivo, em seu servidor PostgreSQL, criar um usuário e senha do banco de dados para podermos criar nosso banco.

###### 4° Criação do schemda do banco de dados

No seu terminal, você deverá usar o comando abaixo para criação do database da aplicação.

> $ php bin/console doctrine:database:create

Assim, será criado o database principal e após isso poderemos criar nossas tabelas.

###### 5º Execução das migrations

Com nosso database criado e nossas bibliotecas instaladas pelo composer, agora iremos rodar nossas migrations para criar nossas tabelas

> $ php bin/console doctrine:migrations:migrate

Lembrando que as nossas migrations se encontram na pasta migrations/

## Finalização

Agora nossa aplicação está pronta para ser utilizada, abaixo, segue as rotas para utilização.

###### Eventos

event_index = Listar todos os eventos<br>
event_showOnly = Listar um evento (busca por ID)<br>
event_create = Criar um evento<br>
event_update = Atualizar dados de um evento (por id)<br>
event_delete = Deletar um evento e todas as suas palestras (por id)<br>

Descrição

event_index GET ANY ANY /event/<br>
event_showOnly GET ANY ANY /event/{EventId}<br>
event_create POST ANY ANY /event/<br>
event_update PUT|PATCH ANY ANY /event/{EventId}<br>
event_delete DELETE ANY ANY /event/{EventId}<br>

###### Palestras

lecture_index = Listar todos as palestras<br>
lecture_showOnly = Listar uma palestra (busca por ID)<br>
lecture_create = Criar uma palestra<br>
lecture_update = Atualizar dados de uma palestra (por id)<br>
lecture_delete = Deletar uma palestra (por id)<br>

Descrição

lecture_index GET ANY ANY /lecture/<br>
lecture_showOnlyLecture GET ANY ANY /lecture/{LectureId}<br>
lecture_create POST ANY ANY /lecture/<br>
lecture_update PUT|PATCH ANY ANY /lecture/{LectureId}<br>
lecture_delete DELETE ANY ANY /lecture/{LectureId}<br>

## Testes da API

### Recomendamos o uso do POSTMAN

###### Para testes, segue abaixo a estrutura de nossas tabelas;

###### Events

Exemplo de Json:

> {<br>
> "event":<br>
> [<br> ><br>
>
> > 'title' => 'Evento PHP com Rapadura',<br>
> > 'date_start' => '05/02/2022 08:00:00',<br>
> > 'date_end' => '10/02/2022 18:00:00',<br>
> > 'description' => 'O melhor evento da maior comunidade de PHP do Ceará',<br>
> > 'status' => 1<br>
> > ]<br>
> > }<br>

OBS: o status tem como seguinte referência

> 1 => Agendado,<br>
> 2 => Em Andamento,<br>
> 3 => Finalizado,<br>
> 4 => Cancelado<br>

###### Palestras (Lectures)

Exemplo de Json:

> {<br>
> "lecture":<br>
> [<br> ><br>
>
> > 'event_id' => 1 (ID de evento existente),<br>
> > 'title' => 'Laravel para Newbies',<br>
> > 'date' => '10/02/2022 18:00:00',<br>
> > 'time_start' => '08:00:00',<br>
> > 'time_end' => '10:00:00',<br>
> > 'description' => 'Veja um pouco de laravel para você que é iniciante.',<br>
> > 'speaker' => 'Tito Delerino Filho'<br>
> > ]<br>
> > }<br>
