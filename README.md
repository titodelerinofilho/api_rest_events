# API-REST Eventos e Palestras

## API para criação de eventos e palestras pertencentes aos eventos.

Dev.: Tito Delerino Filho

### Pré-Requisitos

╚ PHP 8.0+
╚ PostgreSQL 13
╚ Composer 2.2.4
╚ Git

### Modo de Instalação

Após a instalação dos clientes acima listados como pré-requisitos para o uso, iremos começar:

###### 1º Download do Repositório:

Link: https://github.com/titodelerinofilho/api_rest_events.git

ou

'$ git clone https://github.com/titodelerinofilho/api_rest_events.git'

###### 2º Execução do composer

O mesmo baixará todas os pacotes necessários para rodar a aplicação

'$ composer install'

###### 3º Iremos configurar nosso .env para conexão do banco de dados

No arquivo .env na raiz do projeto, possui a linha de configuração da conexão com o PostgreSQL, indicando o servidor, usuário, senha e o banco de dados a ser utilizado pela API.

** DATABASE_URL="postgresql://postgres:8y17tzps@127.0.0.1:5432/api_events?serverVersion=13&charset=utf8" **

Você deverá antes de alterar esse arquivo, em seu servidor PostgreSQL, criar um usuário e senha do banco de dados para podermos criar nosso banco.

###### 4° Criação do schemda do banco de dados

No seu terminal, você deverá usar o comando abaixo para criação do database da aplicação.

'$ php bin/console doctrine:database:create'

Assim, será criado o database principal e após isso poderemos criar nossas tabelas.

###### 5º Execução das migrations

Com nosso database criado e nossas bibliotecas instaladas pelo composer, agora iremos rodar nossas migrations para criar nossas tabelas

'$ php bin/console doctrine:migrations:migrate'

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
