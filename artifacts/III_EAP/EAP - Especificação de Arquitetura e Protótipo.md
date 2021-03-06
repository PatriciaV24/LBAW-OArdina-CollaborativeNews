# **EAP - Especificação de Arquitetura e Protótipo**

Neste terceiro componente queremos apresentar a especificação da arquitetura do nosso website, ou seja, a esquematização de como irá funcionar o website em termos de respostas e pedidos. Vamos construir um protótipo com algumas user stories para perceber como irá ser construído a versão final do Ardina.

# **A7: Especificação dos Recursos Web**

Neste artefacto iremos documentar a arquitetura da aplicação web a desenvolver, indicando o catalógo de recursos e propriedades de cada recurso, incluindo:
    *Referências a interfaces gráficas;
    *O formato das resposta JSON. Em adição a isso, este artefacto irá apresentar a documentação para o Ardina, incluindo as seguintes operações : criar, ler, atualizar ou apagar.
  
## **1.Visão geral**

A visão geral da aplicação web para implementar será apresentada nesta secção. Os módulos serão identificados e resumidamente descritos. Os recursos web serão associados a cada módulo e serão descritos na documentação individual de cada módulo.

|**Módulo**|**Descrição**|
|----------|-------------|
|M01:Autenticação e Perfil Individual| Recursos Web associados com a autenticação do utilizador e gestão do perfil: login, logout, registo, recuperação de password, ver e editar informação pessoal.|
|M02: Criar e Editar Noticia/Comentário|Recursos Web associados a criação e edição de conteúdo|
|M03: Ver utilizadores/Conteúdo| Recursos Web associados a ver notícias, comentários ou utilizadores|
|M04: Procura utilizadores/Conteúdo| Recursos Web associados a pesquisa de notícias, comentários ou utilizadores|
|M05: Notificações|Recursos Web associados com notificações, inclusivo visualização e eliminar|
|M06: Admistração de "_Admin_"| Recursos Web associados a gestão do administrador, como gestão de bans e de notícias, comentários dos utilizadores|
|M07: Páginas Estáticas| Recursos Web associados a conteúdo estático associados a este módulo: Sobre Nós e FAQ|

## **2.Permissões**

Esta secção define as permissões usadas nos módulos acimas para estabelecer as condições de acesso aos conteúdos.

|**ID**|**Nome**|**Descrição**|
|------------|------|-------------|
|PUB|Public|Utilizadores não registados e sem privilégios|
|USR|Utilizador|Utilizador Autenticado|
|AUT|Autor|Autores do Conteúdo|
|BAN|Banido|Utilizador Banido|
|ADM|Administrador|Utilizador Administrador|

## **3.Especificação da OpenAPI**

Esta secção contém a especificação completa da API in OpenAPI(YAML).

OpenAPI YAML: <https://git.fe.up.pt/lbaw/lbaw2122/lbaw2163/-/blob/main/webSite/Ardina-1.0.yaml>

OpenAPI Swagger: <https://app.swaggerhub.com/apis/edgarlourenco/OArdina/1.0.0>

```yaml
openapi: 3.0.0
info:
  version: 1.0.0
  title: LBAW O Ardina Web API
  description: Especificação de Recursos Web (A7) para "O Ardina"
servers:
  - description: 'Production Server'
    url: http://lbaw2163.lbaw.fe.up.pt/

tags:
  - name: 'M01: Autenticação e Perfil Individual'
  - name: 'M02: Criar e Editar Noticia/Comentário'
  - name: 'M03: Ver utilizadores/Conteúdo'
  - name: 'M04: Procura utilizadores/Conteúdo'
  - name: 'M05: Notificações'
  - name: 'M06: Pedidos Administracao'
  - name: 'M07: Adminstração do Admin'
  - name: 'M08: Páginas Estáticas'
  
  
  
paths: 
  # -------------------- M01 --------------------  
  /login/:
    get:
      operationId: R101
      summary: 'R101: Formulário de Login'
      description: 'Providenciar Formulário de Login. Acesso: PUB'
      tags: 
        - 'M01: Autenticação e Perfil Individual'
      responses:
       '200':
        description: 'Ok. Mostrar US09'
    post:
      operationId: R102
      summary: 'R102: Ação de Login'
      description: 'Processa o pedido de Login. Acesso: PUB'
      tags:
      - 'M01: Autenticação e Perfil Individual'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                Username:
                  type: string
                Password:
                  type: string
              required:
                - Username
                - Password
                
      responses:
        '303':
          description: 'Redirecionar depois de login'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'OK. Redirect to US12 - Homepage'
                  value: '/'
                303Error:
                  description: 'Autenticação Falhada.Redirecionar para Formulário de Login'
                  value: '/login/'
  
  /logout/:
    post:
      operationId: R103
      summary: 'R103: Ação de Logout'
      description: 'Logout do Utilizador Autenticado. Acesso: USR,ADM, BAN'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      
      responses:
        '303':
          description: 'Redirecionar depois de processar logout'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para Formulário de Login'
                  value: '/login/'
                303Error:
                  description: 'Logout Falhado. Tente novamente'
                  value: '/'
                
  /recuperacao_password/:
    post:
      operationId: R104
      summary: 'R104: Recuperação de Password'
      description: 'Ação de recuperação de Password. Access: PUB'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                Username:
                  type: string
              required:
                - Username
  
      responses:
        '303':
          description: 'Pedido de recuperação de password efetuado. Redirecionar para Login'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para US09'
                  value: '/login/'
                303Error:
                  description: 'Recuperação de password falhada.'
                  value: '/login/'

  /signup/:
    get:
      operationId: R105
      summary: 'R105: Ver Formulário de Registo'
      description: 'Providenciar formulário para novo registo'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      responses:
        '200':
          description: 'Ok. Mostrar US10'
          
    post:
      operationId: R106
      summary: 'R106: Ação de Registo'
      description: 'Processa a informação de registo para submissão. Acesso: PUB'
      tags: 
        - 'M01: Autenticação e Perfil Individual'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                Username:
                  type: string
                Email:
                  type: string
                Password:
                  type: string
                Foto:
                  type: string
                Contato:
                  type: integer
              required:
                - Username
                - Email
                - Password
                - Contato
      
      responses:
        '303':
          description: 'Redirecionar após registo'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok Redirecionar para Login'
                  value: '/login/'
                303Error:
                  description: 'Erro. Tente novamente'
                  value: '/signup/'
                  
  /utilizador/{nome}/edit/:
    get:
      operationId: R107
      summary: 'R107: Editar Formulário de Perfil de Utilizador'
      description: 'Formulário para Editar Perfil. Acesso: USR'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      parameters: 
        - in: path
          name: nome
          schema:
            type: string
          required: true
          
      responses:
        '200':
          description: 'Ok. Mostrar US21'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/EditarUser'
      
    patch:
      operationId: R108
      summary: 'R108: Editar Perfil de Utilizador'
      description: 'Processa a Edição editada pelo utilizador. Acesso:USR'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      parameters:
        - in: path
          name: nome
          schema: 
            type: string
          required: true
     
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                nome:
                  type: string
                email:
                  type: string
                contacto:
                  type: integer
              required:
                - nome
                - email
                - contacto
      
      responses:
        '303':
          description: 'Redirecionar após edição de utilizador'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para US21'
                  value: '/utilizador/{nome}/edit'
                303Error:
                  description: 'Edição falhada. Redirecionar para US21'
                  value: '/utilizador/{nome}/edit'

  /utilizador/{nome}/edit/mudanca-password/:
    
    patch:
      operationId: R109
      summary: 'R109: Alteracao de password'
      description: 'Processa o formulário de mudança de palavra-passe'
      tags:
        - 'M01: Autenticação e Perfil Individual'
      
      parameters:
        - in: path
          name: nome
          schema:
            type: string
          required: true
      
      requestBody:
        required: True
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                pass_antiga:
                  type: string
                  format: password
                pass_nova:
                  type: string
                  format: password
              required:
                - pass_antiga
                - pass_nova
        
      responses:
        '303':
          description: 'Redirecionar após mudança de password'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para US21'
                  value: 'utilizador/{nome}/edit/'
                303Error:
                  description: 'Erro a mudar password. Redirecionar para US21'
                  value: 'utilizador/{nome}/edit/'
                    
  /utilizador/{nome}/apagar_conta/:
    patch:
      operationId: R111
      summary: 'R110: Apagar utilizador'
      description: 'Apagar conta. Acesso: USR'
      tags: 
        - 'M01: Autenticação e Perfil Individual'
      
      parameters: 
        - in: path
          name: nome
          schema:
            type: string
          required: true
          
      responses:
        '303':
          description: 'Redirecionar após eliminação de conta.'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para US09'
                  value: '/'
                303Error:
                  description: 'Erro a eliminar conta. Tente novamente'
                  value: '/username/{nome}/edit/'
                  
                  
# -------------------- M02 --------------------

  /noticia/criar/:
  
    post:
      operationId: R201
      summary: 'R201: Criar noticia'
      description: 'Criar notícia nova. Acesso: USR'
      tags: 
        - 'M02: Criar e Editar Noticia/Comentário'
      
      requestBody:
        required: true
        content:
          multipart/form-data:
            schema:
                type: object
                properties:
                  titulo:
                    type: string
                  descricao:
                    type: string
                  image:
                    type: string
                    format: binary
                required:
                  - titulo
                  - descricao
      
      responses:
        '303':
          description: 'Redirecionar após criação de noticia'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para noticia criada.'
                  value: 'noticia/{id}⁄'
                303Error:
                  description: 'Falha ao criar notícia. Tentar novamente'
                  value: '/noticia/criar/'
  
  /comentarios/criar/:
    post:
      operationId: R202
      summary: 'R202: Criar comentário'
      description: 'Criar comentário. Acesso: USR'
      tags:
        - 'M02: Criar e Editar Noticia/Comentário'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: string
              properties:
                texto:
                  type: string
              required:
                - texto
      
      responses:
        '303':
          description: 'Redirecionar após comentário'
          headers:
            Location:
              schema: 
                type: string
              examples:
                303Success: 
                  description: 'Ok. Redirecionar para noticia'
                  value: '/noticia/{id}/'
                303Error:
                  description: 'Falha ao criar comentário. Redirecionar noticia'
                  value: '/noticia/{id}/'
  
  /noticia/{id}/:
    patch:
      operationId: R203
      summary: 'R203: Editar noticia'
      description: 'Editar conteúdo de noticia. Acesso: AUT'
      tags:
        - 'M02: Criar e Editar Noticia/Comentário'
        
      parameters: 
        - in: path
          name: id
          schema:
            type: integer
          required: true
        
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                titulo:
                  type: string
                descricao:
                  type: string
                imagem:
                  type: string
              required:
                - descricao
                
      responses:
        '303':
          description: 'Redirecionar após editar noticia'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para a noticia editada.'
                  value: '/noticia/{id}/'
                303Error:
                  description: 'Falha ao criar noticia. Redirecionar para a noticia'
                  value: '/noticia/{id}/'
                    
    delete:
      operationId: R204
      summary: 'R204: Apagar notícia'
      description: 'Apagar noticia. Acesso: AUT'
      tags: 
        - 'M02: Criar e Editar Noticia/Comentário'
      
      parameters: 
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '303':
          description: 'Redirecionar após eliminar noticia'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para página inicial'
                  value: '/'
                303Error:
                  description: 'Ok. Redirecionar para noticia'
                  value: '/noticia/{id}'
                  
  /comentarios/:
    patch:
      operationId: R205
      summary: 'R205: Editar comentario'
      description: 'Editar comentario. Acesso: AUT'
      tags: 
      - 'M02: Criar e Editar Noticia/Comentário'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
                texto:
                  type: string
              required:
                - texto
      
      responses:
        '303':
          description: 'Redirecionar após editar comentário'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para noticia comentada'
                  value: '/noticia/{id}'
                303Error:
                  description: 'Erro ao editar comentario. Redirecionar para noticia'
                  value: '/noticia/{id}'
  
    delete:
      operationId: R206
      summary: 'R206: Apagar comentário'
      description: 'Apagar comentário em noticia. Acesso: AUT'
      tags:
        - 'M02: Criar e Editar Noticia/Comentário'
        
      parameters:
        - in: header
          name: id
          schema:
            type: integer
          required: true
      
      responses:
        '303':
          description: 'Redirecionar após eliminar comentario'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para noticia'
                  value: '/noticia/{id}'
                303Error:
                  description: 'Erro. Redirecionar para noticia'
                  value: '/noticia/{id}'
                  
    # -------------------- M03 -------------------- 
    
  /:
    get:
      operationId: R301
      summary: 'R301: Pagina Inicial'
      description: 'Mostrar Pagina Inicial. Acesso: PUB, USR, ADM'
      tags:
        - 'M03: Ver utilizadores/Conteúdo'
      
      responses:
        '200':
          description: 'Ok. IF PUB: Mostrar página inicial sem log-in; ELSE: Mostrar página inical logado com o perfil no topo direito'
          content:
            application/json:
              schema:
                type: object
                properties:
                  ultimas_noticias:
                    type: array
                    items:
                      $ref: '#/components/schemas/Noticia'
                  pesquisa:
                    type: array
                    items:
                      type: string
  
  /noticia/{id}:
    get:
      operationId: R302
      summary: 'R302: Ver uma noticia especifica'
      description: 'Ver uma noticia especifica. Acesso: PUB, USR, ADM, AUT'
      tags:
       - 'M03: Ver utilizadores/Conteúdo'
       
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      
      responses:
        '200':
          description: 'Ok. Mostrar a noticia escolhida'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Noticia'
        '404':
          description: 'Noticia não encontrada'
          
  /utilizador/{nome}:
    get:
      operationId: R303
      summary: 'R303: Ver perfil de utilizador'
      description: 'Ver perfil de utilizador. Acesso: PUB, USR, ADM'
      tags:
        - 'M03: Ver utilizadores/Conteúdo'
        
      parameters:
        - in: path
          name: nome
          schema:
            type: string
          required: true
        
      responses:
        '200':
          description: 'Ok. Mostrar perfil do utilizador pretendido'
          content:
            application/json:
              schema:
                type: object
                properties:
                  utilizador:
                    $ref: '#/components/schemas/Utilizador'
                  publicacoes:
                    $ref: '#/components/schemas/Noticia'
                  a_seguir:
                    $ref: '#/components/schemas/Seguir'
        '404':
          description: 'Utilizador não encontrado'
          
  /api/carregar-noticias:
    get:
      operationId: R304
      summary: 'R304: Carregar mais noticias'
      description: 'Carregar mais noticias. Acesso: PUB, USR, ADM'
      tags:
        - 'M03: Ver utilizadores/Conteúdo'
      parameters:
        - in: query
          name: paginacao
          schema:
            type: integer
          required: false
        - in: query
          name: pagina
          schema:
            type: integer
          required: false
        - in: query
          name: sortBy
          schema:
            type: integer
          required: false
      
      responses:
        '200':
          description: 'Retorna noticias para paginacao'
          content:
            application/json:
              schema:
                type: object
                properties:
                  noticias:
                    type: array
                    items:
                      $ref: '#/components/schemas/Noticia'
        '400':
          description: 'Erro nos parametros'
          
  /api/carregar-utilizadores:
    get:
      operationId: R305
      summary: 'R305: Carregar mais utilizadores'
      description: 'Carregar mais utilizadores. Acesso: PUB, USR'
      tags: 
        - 'M03: Ver utilizadores/Conteúdo'
      parameters:
        - in: query
          name: paginacao
          schema:
            type: integer
          required: false
        - in: query
          name: pagina
          schema:
            type: integer
          required: false
        - in: query
          name: sortBy
          schema:
            type: integer
          required: false
      
      responses:
        '200':
          description: 'Retorna utilizadores para paginacao'
          content:
            application/json:
              schema:
                type: object
                properties:
                  utilizadores:
                    type: array
                    items:
                      $ref: '#/components/schemas/Utilizador'
  
  /api/carregar-comentarios:
    get:
      operationId: R306
      summary: 'R306: Carregar mais comentários'
      description: 'Carregar mais comentários da noticia. Acesso: PUB, USR'
      tags:
        - 'M03: Ver utilizadores/Conteúdo'
      parameters:
        - in: query
          name: paginacao
          schema:
            type: integer
          required: false
        - in: query
          name: pagina
          schema:
            type: integer
          required: false
        - in: query
          name: id
          schema:
            type: integer
          required: false
      
      responses:
        '200':
          description: 'Retorna comentários da noticia para paginacao'
          content:
            application/json:
              schema:
                type: object
                properties:
                  comentarios:
                    type: array
                    items:
                      $ref: '#/components/schemas/Comentario'
        '400': 
          description: 'Erro nos parametros'
      
  # -------------------- M04 -------------------- 
  /pesquisa/:
    get:
      operationId: R401
      summary: 'R401: Pesquisa de utilizadores/conteudo'
      description: 'Providencia conteudo ou utilizadores pesquisados. Acesso: PUB, USR, ADM'
      tags:
        - 'M04: Procura utilizadores/Conteúdo'
      
      parameters:
        - in: query
          name: pesquisa
          schema:
            type: string
          required: false
          allowReserved: true
      
      responses:
        '200':
          description: 'Ok. Mostrar resultado da pesquisa'
          content:
            application/json:
              schema:
                type: object
                properties:
                  noticias:
                    type: array
                    items:
                      $ref: '#/components/schemas/Noticia'
                  comentarios:
                    type: array
                    items:
                      $ref: '#/components/schemas/Comentario'
                  utilizadores:
                    type: array
                    items:
                      $ref: '#/components/schemas/Utilizador'
                      
  # -------------------- M05 -------------------- 
  /notificacoes/:
    get:
      operationId: R501
      summary: 'R501: Ver Notificacoes do Utilizador'
      description: 'Providenciar Notifacoes ao Utilizador. Access: USR, ADM'
      tags: 
        - 'M05: Notificações'
      
      responses:
        '200': 
          description: 'Ok. Mostrar Notifacoes'
          content:
            application/json:
              schema:
                type: object
                properties:
                  seguidor:
                    type: array
                    items:
                      $ref: '#/components/schemas/NSeguidor'
                  votos:
                    type: array
                    items:
                      $ref: '#/components/schemas/NVotos'
                  comentarios:
                    type: array
                    items:
                      $ref: '#/components/schemas/NComentario'
                  bloqueado:
                    type: array
                    items:
                      $ref: '#/components/schemas/NBloqueado'
        '401':
          description: 'Login para ver notificacoes'
          
    patch:
      operationId: R502
      summary: 'R502: Marcar notificacoes como lidas'
      description: 'R502: Marcar as notificacoes do utilizador como lidas. Acesso: USR, ADM'
      tags:
        - 'M05: Notificações'
        
      parameters:
        - in: header
          name: notificacao
          schema:
            type: object
            properties:
              tipo_notificacao:
                type: string
              id_notificacao:
                type: integer
            required:
              - tipo_notificacao
              - id_notificacao
          required: true
      
      responses:
        '201':
          description: 'Notificacao lida'
        '404':
          description: 'Notificacao nao lida'
    
    delete:
      operationId: R503
      summary: 'R503: Apagar notificacao'
      description: 'Apagar notificacao do utilizador'
      tags: 
        - 'M05: Notificações'
      
      parameters:
        - in: header
          name: notificacao
          schema:
            type: object
            properties:
              tipo_notificacao:
                type: string
              id_notificacao:
                type: integer
            required:
              - tipo_notificacao
              - id_notificacao
          required: true
      
      responses:
        '201':
          description: 'Notificacao apagada'
        '404':
          description: 'Notificacao expirada'

 # -------------------- M06 -------------------- 

  /comentario/report/:
    post:
      operationId: R601
      summary: 'R601: Reportar Comentario'
      description: 'R601: Reportar comentario de utilizador. Acesso: USR'
      tags:
        - 'M06: Pedidos Administracao'
      
      parameters:
        - in: header
          name: id
          schema:
              type: integer
          required: true
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                descricao:
                  type: string
              required:
                - descricao
      
      responses:
        '201':
          description: 'Report criado'
        '401':
          description: 'Login para reportar'
  
  /noticia/{id}/report/:
    post:
      operationId: R602
      summary: 'R602: Reportar noticia'
      description: 'R602: Reportar noticia de utilizador. Acesso: USR'
      tags: 
        - 'M06: Pedidos Administracao'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                descricao:
                  type: string
              required:
                - descricao
      
      responses:
        '201':
          description: 'Report criado'
        '401':
          description: 'Login para reportar'
          
  /utilizador/{nome}/report/:
    post:
      operationId: R603
      summary: 'R603: Reportar utilizador'
      description: 'Reportar utilizador. Acesso: USR'
      tags:
        - 'M06: Pedidos Administracao'
      
      parameters:
        - in: path
          name: nome
          schema:
            type: string
          required: true
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                descricao:
                  type: string
              required:
                - descricao
      
      responses:
        '201':
          description: 'Report criado'
        '401':
          description: 'Login para reportar'
  

  # -------------------- M07 --------------------         
  /pedidos/noticia/{id}/aceitar/:
    patch:
      operationId: R701
      summary: 'R701: Aceitar report'
      description: 'Aceitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: header
          name: tempo_ban
          schema:
            type: integer
          required: false
      
      responses:
        '201':
          description: 'Report aceite'
        '401':
          description: 'Só pode ser aceite por um moderador'
  
  /pedidos/comentario/{id}/aceitar/:
    patch:
      operationId: R702
      summary: 'R702: Aceitar report'
      description: 'Aceitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: header
          name: tempo_ban
          schema:
            type: integer
          required: false
      
      responses:
        '201':
          description: 'Report aceite'
        '401':
          description: 'Só pode ser aceite por um moderador'
          
  /pedidos/utilizador/{id}/aceitar/:
    patch:
      operationId: R703
      summary: 'R703: Aceitar report'
      description: 'Aceitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: header
          name: tempo_ban
          schema:
            type: integer
          required: false
      
      responses:
        '201':
          description: 'Report aceite'
        '401':
          description: 'Só pode ser aceite por um moderador'
  
  /pedidos/noticia/{id}/rejeitar/:
    patch:
      operationId: R704
      summary: 'R704: Rejeitar report'
      description: 'Rejeitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '201':
          description: 'Report rejeitado'
        '401':
          description: 'Só pode ser rejeitado por um moderador'

  /pedidos/comentario/{id}/rejeitar/:
    patch:
      operationId: R705
      summary: 'R705: Rejeitar report'
      description: 'Rejeitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '201':
          description: 'Report rejeitado'
        '401':
          description: 'Só pode ser rejeitado por um moderador'

  /pedidos/utilizador/{id}/rejeitar/:
    patch:
      operationId: R706
      summary: 'R706: Rejeitar report'
      description: 'Rejeitar report. Acesso: ADM'
      tags:
        - 'M07: Adminstração do Admin'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '201':
          description: 'Report rejeitado'
        '401':
          description: 'Só pode ser rejeitado por um moderador'
  
  # -------------------- M08 --------------------
  /faq/:
    get:
      operationId: R801
      summary: 'R801: Ver FAQ'
      description: 'Pagina de Perguntas Frequentes. Acesso: PUB, USR, ADM'
      tags:
        - 'M08: Páginas Estáticas'

      responses:
        '200':
          description: 'Ok. IF PUB, USR Mostrar Pergunta e Resposta
                            IF ADM Mostrar edição da pergunta e resposta'
          content: 
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/Faq'
                      
    post:
      operationId: R802
      summary: 'R802: Criar FAQ'
      description: 'Criar pergunta e resposta frequente. Access: ADM'
      tags:
        - 'M08: Páginas Estáticas'
      
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - id
                - pergunta
                - resposta
              properties:
                id:
                  type: integer
                autor_id:
                  type: integer
                pergunta:
                  type: string
                resposta:
                  type: string
                  
      responses:
        '303':
          description: 'Redirecionar após criar faq.'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para FAQ'
                  value: '/faq/'
                303Error:
                  description: 'Falha ao criar FAQ. Redirecionar para FAQ'
                  value: '/faq/'
          
    patch:
      operationId: R803
      summary: 'R803: Editar FAQ'
      description: 'Editar pergunta e resposta frequente. Access: ADM'
      tags:
        - 'M08: Páginas Estáticas'
      
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - id
                - question
                - answer
              properties:
                id:
                  type: integer
                autor_id:
                  type: integer
                question:
                  type: string
                answer:
                  type: string
                  
      responses:
        '303':
          description: 'Redirecionar após editar FAQ.'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para FAQ'
                  value: '/faq/'
                303Error:
                  description: 'Falha ao Editar FAQ. Redirecionar para FAQ'
                  value: '/faq/'
                  
    delete:
      operationId: R804
      summary: 'R804: Apagar FAQ'
      description: 'Apagar pergunta e resposta frequente. Access: ADM'
      tags:
        - 'M08: Páginas Estáticas'
          
      parameters:
        - in: query
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '303':
          description: 'Redirecionar após apagar FAQ.'
          headers:
            Location:
              schema:
                type: string
              examples:
                303Success:
                  description: 'Ok. Redirecionar para FAQ'
                  value: '/faq/'
                303Error:
                  description: 'Falha ao criar FAQ. Redirecionar para FAQ'
                  value: '/faq/'
                  
  /sobrenos/:
    get:
      operationId: R805
      summary: 'R805: Sobre nós'
      description: 'Sobre nós. Acesso: PUB, USR, ADM'
      tags:
        - 'M08: Páginas Estáticas'
      
      responses:
        '200':
          description: 'Ok. Mostrar página Sobre Nós'
  
  
components:
  schemas:
    Faq:
      type: object
      properties:
        id:
          type: integer
        autor_id:
          type: integer
        pergunta:
          type: string
        resposta:
          type: string
  
  
    NBloqueado:
      type: object
      properties:
        id:
          type: integer
        bloq_id:
          type: integer
        motivo:
          type: string
        lido:
          type: boolean
        data:
          type: string
        
    NComentario:
      type: object
      properties:
        comentario_id:
          type: integer
        lido:
          type: boolean
        data:
          type: string
      
    NVotos:
      type: object
      properties:
        utilizadorvoto_id:
          type: integer
        noticia_id:
          type: integer
        lido:
          type: boolean
        date:
          type: string
        
    NSeguidor:
      type: object
      properties:
        follower_id:
          type: integer
        novo_seguidor:
          type: boolean
        lido:
          type: boolean
        date:
          type: string
      
    Utilizador:
      type: object
      properties:
        nome:
          type: string
        email:
          type: string
        photo:
          type: string
        permissao:
          type: string
          
    EditarUser:
      type: object
      properties:
        nome: 
          type: string
        email:
          type: string
        password:
          type: string
        foto:
          type: string
        contacto:
          type: integer
    
    Noticia:
      type: object
      properties:
        id:
          type: integer
        autor_id:
          type: integer
        titulo:
          type: string
        descricao:
          type: string
        data:
          type: string
        tags:
          type: array
          items:
            type: string
        comentario:
          type: array
          items:
            $ref: '#/components/schemas/Comentario'
          default: []
    
    Comentario:
      type: object
      properties:
        id:
          type: integer
        autor_id:
          type: integer
        not_id:
          type: integer
        texto:
          type: string
        data:
          type: string
    
    Seguir:
      type: object
      properties:
        id: 
          type: integer
        nome:
          type: string
        photo:
          type: string

```

# **A8: Prótipo Vertical**

O artefacto A8, inclui a implementação de algumas user stories e com o objetivo de validar a arquitetura presente.

## **1. Features Implementadas**

### **1.1. User Stories Implementadas**

|**Referência a User Storie**|**Nome**|**Prioridade**|**Descrição**|
|----------------------------|--------|--------------|-------------|
| US05 |Pesquisar por notícias e comentários|Alta|Como utilizador genérico, desejo pesquisar algumas notícias ou comentários de utilizadores|
| US09 | Sign In | alta | Como utilizador não autenticado, quero autenticar-me no sistema para poder aceder a informações privilegiadas |
| US10 | Sign Up | alta | Como utilizador não autenticado, quero registar no sistema para que possa me autenticar |
| US15 | Criar Notícia | alta | Como utilizador autenticado, quero poder criar uma notícia para adicionar ao site |
| US29 | Editar Notícia | alta | Como Autor da Notícia, quero poder editar a mesma para corrigir ou alterar certas informações |
| US30 | Apagar Notícia | alta | Como Autor da Notícia, quero poder apagar a mesma de forma a elimina-la do site |
| US13 | Ver notícia | alta | Como utilizador autenticado, quero ver uma noticia |
| US25 | Sign Out | alta | Como utilizador, pretendo sair do sistema para poder encerrar a minha conta |

### **1.2. Web Resources Implementados**

### **M01: Autenticacao e Perfil Indivual**

|**Web Resource Referência**|**URL**|
|---------------------------|-------|
|R101: Formulário de Login| GET /login/|
|R102: Ação de Login| POST /login/|
|R103: Ação de Logout| POST /logout/|
|R105: Ver Formulário de Registo| GET /register/|
|R106: Ação de Registo|POST /register/|

### **M02: Criar e Editar Noticia/Comentario**

|**Web Resource Referência**|**URL**|
|---------------------------|-------|
|R201: Criar noticia| POST /noticia/criar|
|R203: Editar noticia| PATCH/noticia/{id}/|
|R204: Apagar noticia| DELETE /noticia/{id}/|

### **M03: Ver utilizadores/Conteúdo**

|**Web Resource Referência**|**URL**|
|---------------------------|-------|
|R302: Ver uma notícia especifica| GET /noticia/{id}|
|R303: Ver utilizador especifico| GET /utilizador/{nome}|

### **M04: Procura utilizadores/Conteúdo**

|**Web Resource Referência**|**URL**|
|---------------------------|-------|
|R401: Pesquisa de utilizadores/conteudo| GET /pesquisa/|

## 2.Protótipo

O prótipo está disponível em <http://lbaw2163.lbaw.fe.up.pt/>

* **Administrador**
  * Username : admin
  * Passowrd: Admin1234

* **Utilizador Autenticado**
  * Username: grupo63
  * Password: Test1234

O código encontra-se disponível em: <https://git.fe.up.pt/lbaw/lbaw2122/lbaw2163/-/tree/main/webSite>

**_Grupo 63, Data :_** 4/01/2022

* <span dir="">António Ferreira Cabral de Barbosa Campelo</span>, [<span dir="">up201704987@fc.up.pt</span>](mailto:up201704987@fc.up.pt)
* <span dir="">Edgar Miguel Pinto Lourenço</span>, [<span dir="">up201604910@fc.up.pt</span>](mailto:up201604910@fc.up.pt)
* <span dir="">Manuel da Silva Sá</span>, [<span dir="">up201805273@fc.up.pt</span>](mailto:up201805273@fc.up.pt)
* <span dir="">Patrícia Daniela Tavares Vieira</span>, [up201805238@fc.up.pt](mailto:up201805238@fc.up.pt)

**Em termos de edição, todos os elementos colaboraram, portantos consideramos que os 4 são editores do documento**