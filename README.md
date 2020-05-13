# AppCasaDosPobresCaruaru
Aplicativo para auxiliar nas doações à Casa dos Pobres de Caruaru

Endereço base: http://localhost/AppCasaDosPobresCaruaru/public

OBS: a pasta do projeto deve estar na pasta htdocs da posta XAMP

         -- Rotas para uso da API em ambiente localhost --


Listar todos os usuários registrados na base de dados:

    Metodo: GET, Rota: /usuarios
    Exemplo: http://localhost/AppCasaDosPobresCaruaru/public/usuarios

Listar um usuário específico: 

    Metodo: GET, Rota: /usuarios/id

Cadastrar um novo usuário: 

    Metodo: POST, Rota: /usuarios/new

Deletar um usuário:

    Metodo: DELETE, Rota: /usuarios/id/delete

Alterar um usuário:

    Metodo: PUT, Rota: /usuarios/id/update
    
Listar e registrar doações na base de dados:

                        ->Em Desenvolvimento<-
