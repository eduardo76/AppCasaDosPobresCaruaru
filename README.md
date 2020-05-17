# AppCasaDosPobresCaruaru
Aplicativo para auxiliar nas doações à Casa dos Pobres de Caruaru

Endereço base: http://casadospobrescaruaru.ml/public

OBS: a pasta do projeto deve estar na pasta htdocs da posta XAMP

         -- Rotas para uso da API em ambiente localhost --

Login de acesso à API:

    Metodo: POST, Rota: /doador/login
    Exemplo: http://casadospobrescaruaru.ml/public/doador/login

Listar todos os doadores registrados na base de dados:

    Metodo: GET, Rota: /doadores
    Exemplo: http://casadospobrescaruaru.ml/public/doadores

Listar um doador específico: 

    Metodo: GET, Rota: /doador/id

Cadastrar um novo doador: 

    Metodo: POST, Rota: /doador/new

Deletar um doador:

    Metodo: DELETE, Rota: /doador/id/delete

Alterar um doador:

    Metodo: PUT, Rota: /doador/id/update
    
    
--> Agendamento de Doações <--

    Exemplo: http://casadospobrescaruaru.ml/public/doacao/agendar
    
Registrar agendamento de doações na base de dados:

    Metodo: POST, Rota: /doacao/agendar
    
Listar todas as doações cadastradas como ADM:

    Metodo: GET, Rota: /doacao/agendamentos/adm

Listar agendamento de um usuário específico como ADM:

    Metodo: GET, Rota: /doacao/agendamentos/doador/id/adm

Listar agendamento de um usuário específico, como usuário comum:

    Metodo: GET, Rota: /doacao/agendamentos/doador/id

Alterar um agendamento já cadastrado:

    Metodo: PUT, Rota: /doacao/agendamentos/id/update
    
Excluir um agendamento já cadastrado:

    Metodo: DELETE, Rota: /doacao/agendamentos/id/delete

 --> Doações pelo PagSeguro <--
 
                        ->Em Desenvolvimento<-
