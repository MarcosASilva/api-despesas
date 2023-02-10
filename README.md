<h1 align="center"> API Despesas </h1>

API para cadastro de despesas, utilizando laravel


<h2> Rotas Login </h2>
<p> Rotas pra login e logout, Se for bem sucedido retorna um token a ser usado pelo usuario para fazer as operaçoes </p>

| Rota          | Resource                           | Retorno |
| ------------- | -------------                      | --------|
| /api/login (POST)| Login do usaurio passando email e senha | Retorna um token em caso de login com sucesso
| /api/logour (POST)| Desloga o usuario e apaga todos os tokens relacionados a ele | -

<h2> Rotas Despesa </h2>

<p> Rotas pra CRUD de despesas, em qualquer das rotas o usuario deve estar autenticado e passar um authorization Bearen {token}, com o token retornado no momento do login </p>

| Rota          | Resource                           | 
| ------------- | -------------                      |
| /api/despesas (GET)| Mostrar despesas do usuario logado |  
| /api/despesas (POST)| Criar uma nova despesa (Parametros obrigatorios:[descricao(max. 191 caracteres), valor(Inteiro positivo), datadespesa(data formato YYYY-MM-DD), user_id(inteiro)]).  Um email é enviado ao usuario para qual foi cadastrado a despesa| 
| /api/despesas/:id (GET)| Mostrar uma despesa especifica(Um usuario somente pode ver despesas dele) |
| /api/despesas/:id (PUT)| Alterar uma despesa especifica(Um usuario somente pode alterar despesas dele) (Parametros:[descricao(max. 191 caracteres), valor(Inteiro positivo), datadespesa(data formato YYYY-MM-DD)])|
| /api/despesas/:id (DELETE)| Deletar uma despesa especifica(Um usuario somente pode deletar despesas dele) |

<h2> Rotas User </h2>
<p> Rotas pra CRUD de usuarios, em qualquer das rotas o usuario deve estar autenticado e passar um authorization Bearen {token}, com o token retornado no momento do login </p>

| Rota          | Resource                           |
| ------------- | -------------                      |
| /api/users (GET)| Mostrar todos usuarios cadastrados |
| /api/users (POST)| Criar um novo usuario (Parametros obrigatorios:[name(max. 255 caracteres), email(max. 255 caracteres, unico pra cada usuario), password(max. 255 caracteres)]). |
| /api/users/:id (GET)| Mostrar um usuario especifico |
| /api/users/:id (PUT)| Alterar um usuario especifico (Parametros:[name(max. 255 caracteres), email(max. 255 caracteres, unico pra cada usuario), password(max. 255 caracteres)]|
| /api/users/:id (DELETE)| Deletar um usuario |
