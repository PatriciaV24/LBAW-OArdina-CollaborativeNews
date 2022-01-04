# ER: Componentes de Especificação de Requisitos

<span dir="">Este projeto consiste na criação de um website que contém uma plataforma de gestão de notícias.</span> O público-alvo desta plataforma são pessoas com interesse em ler, criar e partilhar artigos, independentemente do seu tema.

A nossa intenção é conseguir trazer muita informação e laços sociais a uma nova comunidade criada por esta plataforma. É uma das melhores maneiras de nos mantermos informados acerca não só do que nos rodeia como também das comunidades e assuntos que, embora mais distantes, são igualmente interessantes e importantes para a construção de um futuro melhor. 

# **<span dir="">A1: O Ardina</span>**

<span dir="">Os objetivos principais desta plataforma é dar aos utilizadores a oportunidade de partilhar e ler notícias que sejam do seu interesse, tal como a interação deste com tais notícias, seja ela em forma de comentários, votos, etc. O utilizador poderá também seguir outros utilizadores e/ou temas que sejam relevantes para si. Estes são fundamentais para que esta seja uma plataforma útil e eficiente para os seus utilizadores. Para que seja um sistema colaborativo, a interação dos utilizadores sobre todo o conteúdo e sobre outros utilizadores é imperativo. O sistema de votação é uma boa maneira de destacar conteúdo valioso.</span>

<span dir="">Este utilizador poderá editar e eliminar as suas notícias, comentários e votos, tal como reportar conteúdo de outros utilizadores. Poderá também alterar a sua password, nickname e foto de perfil.</span>

<span dir="">Um utilizador com estatuto de administrador será também capaz de eliminar todo tipo de conteúdo, sendo o autor deste conteúdo notificado com a respetiva justificação. Será o administrador também o responsável por gerir reportes efetuados, podendo, se se justificar, eliminar o conteúdo reportado.</span>

**<span dir="">Quando autenticado o utilizador poderá:</span>**

* <span dir="">Visualizar o seu feed de notícias;</span>
* <span dir="">Visualizar autor, data de publicação e votos de uma notícia;</span>
* <span dir="">Visualizar autor, data de publicação e votos de um comentário;</span>
* <span dir="">Publicar uma notícia;</span>
* <span dir="">Deixar um voto numa notícia, editar ou eliminar esse voto;</span>
* <span dir="">Deixar um voto num comentário, editar ou eliminar esse voto;</span>
* <span dir="">Comentar uma notícia;</span>
* <span dir="">Visualizar o perfil de outros utilizadores;</span>
* <span dir="">Visualizar a reputação de outros utilizadores;</span>
* <span dir="">Seguir ou não outros utilizadores;</span>
* <span dir="">Visualizar _tags_ numa notícia;</span>
* <span dir="">Adicionar/remover notícias dos favoritos;</span>
* <span dir="">Reportar notícias e comentários.</span>

**<span dir="">Um utilizador não autenticado poderá:</span>**

* <span dir="">Ver um feed de notícias ordenado com base na importância destas, ou então ordenado pelas datas de criação;</span>
* <span dir="">Visualizar uma notícia;</span>
* <span dir="">Visualizar os comentários de uma notícia.</span>

**<span dir="">Quando autenticado, um utilizador receberá notificações quando:</span>**

* <span dir="">Receber likes (votos positivos), em notícias ou comentários;</span>
* <span dir="">Alguém pode comentar o seu conteúdo.</span>

**<span dir="">Será também possível fazer pesquisas avançadas através de uma barra de pesquisa. Poderá pesquisar:</span>**

* <span dir="">Utilizadores através do seu username ou nickname;</span>
* <span dir="">Notícias através do seu autor ou _tags_, será mostrado primeiro a notícia mais recente;</span>
* <span dir="">Comentários através do seu autor, será mostrado primeiro o comentário mais recente desse autor.</span>

<span dir="">Um utilizador autenticado terá uma reputação assemelhada a ele. Essa reputação dependerá da quantidade de votos positivos e negativos recebidos no seu conteúdo.</span>

<span dir="">Uma notícia ou comentário não poderá ser eliminado pelo seu autor se estes tiverem votos e/ou comentários.</span>

# A2: Atores e _User Stories_

Este artefacto contém a especificação dos atores e as histórias associadas aos mesmos, servindo como documentação ágil dos requisitos do projeto.

## 1. Atores

![Atores_Ardina](uploads/53ad2f0b1d279d1a118d6a968b7e9001/Atores_Ardina.png)

### Esquema de Atores
| Identificador | Descrição | Exemplo |
|---------------|-----------|---------|
| Utilizador | <span dir="">Utilizador genérico; Tem acesso a informações públicas, como visualização do feed de notícias principais, notícias recentes, comentários e pesquisa de outras notícias ou comentários.</span> | n/a |
| Utilizador Não Autenticado | Pode-se registar ou autenticar no sistema. | n/a |
| Utilizador Autenticado | Pode ver notícias e comentários, detalhes de notícias e comentários. Pode criar notícias e comentários, visualizar categorias de notícias, pesquisar e avaliar. Seguir / deixar de seguir tags e usuários. Pode ver o perfil criado e estatísticas. | Alfredocosta |
| Autor da Notícia | Pode editar ou excluir notícias criadas por ele mesmo. | Alfredocosta |
| Autor do Comentário | Pode editar ou excluir comentários criados por ele mesmo | Alfredocosta |
| Bloqueado | Utilizador Autenticado que não pode publicar notícias e comentários. | n/a |
| Administrador | Utilizador autenticado que pode gerir reports, banir utilizadores, remover notícias, comentários e utilizadores e gerir FAQ's. | n/a |

## 2. _User Stories_

**Utilizador**
| Identificador | Nome | Prioridade | Descrição |
|---------------|------|------------|-----------|
| US01 | Ver o Feed de Notícias Principais | alta | Como utilizador genérico, quero ver o feed de notícias principais para obter as notícias em tendência |
| US02 | Ver Feed de Notícias Recentes | alta | Como utilizador genérico, quero ver o feed de notícias recentes para obter as últimas notícias do site |
| US03 | Ver notícia | alta | Como utilizador genérico, quero abrir a notícia para ver todas as suas informações |
| US04 | Ver comentários de notícias | alta | Como utilizador genérico, quero abrir a notícia para ver os seus comentários |
| US05 | Pesquisar por notícias e comentários | alta | Como utilizador genérico, desejo pesquisar algumas notícias ou comentários de utilizadores |
| US06 | Página de contactos | média | Como utilizador genérico, pretendo poder contactar a loja através de um formulário pré-configurado para poder tirar dúvidas, dar sugestões ou reclamar de um serviço |
| US07 | FAQ Page | média | Como utilizador genérico, desejo aceder a página de perguntas frequentes, para que possa esclarecer algumas de minhas dúvidas facilmente |
| US08 | Sobre nós | média | Como um utilizador, desejo aceder uma página sobre, para poder ver a descrição completa do site |

**Utilizador não Autenticado**
| Identifier | Name | Priority | Description |
|------------|------|----------|-------------|
| US09 | Sign In | alta | Como utilizador não autenticado, quero autenticar-me no sistema para poder aceder a informações privilegiadas |
| US10 | Sign Up | alta | Como utilizador não autenticado, quero registar no sistema para que possa me autenticar |
| US11 | Recuperar Password | alta | Como utilizador não autenticado, desejo poder recuperar a password para conseguir autenticar-me no sistema |

**Utilizador Autenticado**
| Identifier | Name | Priority | Description |
|------------|------|----------|-------------|
| US12 | Homepage | alta | Como utilizador autenticado, desejo aceder à página inicial e ver as notícias em tendência |
| US13 | Ver notícia | alta | Como utilizador autenticado, quero ver uma noticia |
| US14 | Ver comentário | alta | Como utilizador autenticado, quero ver os comentários das notícias |
| US15 | Criar Notícia | alta | Como utilizador autenticado, quero poder criar uma notícia para adicionar ao site |
| US16 | Criar comentário | alta | Como utilizador autenticado, quero poder criar um comentário numa notícia para expressar a minha opinião |
| US17 | Ver Categorias | alta | Como utilizador autenticado, quero ver as categorias das notícias e selecionar certa categoria para ver |
| US18 | Apagar conta | alta | Como utilizador autenticado, quero poder apagar a minha conta porque não pretendo utilizar mais |
| US19 | Procurar Notícias/Comentários/Utilizadores | alta | Como utilizador autenticado, quero procurar por certas notícias, comentários ou utilizadores de forma a manobrar no site |
| US20 | Classificar Notícias/Comentários | alta | Como utilizador autenticado, quero poder classificar notícias ou comentários de forma a expressar o meu sentimento |
| US21 | Ver/Editar Perfil | alta | Como utilizador autenticado, quero poder ver ou editar o meu perfil de forma a alterar a foto de perfil, password, dados pessoais ou apenas consultar as informações dele |
| US22 | Sign Out | alta | Como utilizador autenticado, quero poder fechar a conta de forma a sair do site sem o deixar com a minha conta aberta |
| US23 | Ver Perfil de outro utilizador | alta | Como utilizador autenticado, quero poder ver o perfil de outro utilizador e consultar a sua informação pertinente |
| US24 | Reportar Utilizador/Comentário | média | Como utilizador autenticado, quero poder reportar um utilizador ou comentário por não cumprir com as regras do site |
| US25 | Follow/Unfollow Utilizadores | média | Como utilizador autenticado, pretendo seguir ou deixar de seguir utilizadores, gerindo a minha rede de amigos |
| US26 | Follow/Unfollow _Tags_ | média | Como utilizador autenticado, pretendo seguir ou deixar de seguir tags, gerindo o meu feed |
| US27 | Filtrar Noticias | média | Como utilizador autenticado, pretendo filtrar as notícias de forma a selecionar aquilo que pretendo ver no momento |
| US28 | Ver estatísticas | média | Como utilizador autenticado, pretendo ver o meu progresso relativo no site |

**Autor da Notícia**
| Identifier | Name | Priority | Description |
|------------|------|----------|-------------|
| US29 | Editar Notícia | alta | Como Autor da Notícia, quero poder editar a mesma para corrigir ou alterar certas informações |
| US30 | Apagar Notícia | alta | Como Autor da Notícia, quero poder apagar a mesma de forma a elimina-la do site |

**Autor do Comentário**
| Identifier | Name | Priority | Description |
|------------|------|----------|-------------|
| US31 | Editar Comentário | alta | Como Autor do Comentário, quero poder editar o mesmo de forma a alterar a minha opinião relativa a notícia |
| US32 | Apagar Comentário | alta | Como Autor do Comentário, quero poder apagar o mesmo de forma a já não achar relevante o comentário |

**Administrador**
| Identifier | Name | Priority | Description |
|------------|------|----------|-------------|
| US33 | Sign Out | alta | Como Administrador, pretendo sair do sistema para poder encerrar a minha conta |
| US34 | Ver reportes | alta | Como Administrador, desejo ver todos os comentários relatados para poder verificar se são ofensivos |
| US35 | Ban/Unban Utilizador | alta | Como Administrador, pretendo banir um utilizador por infringir as regras do site ou remover o bloqueio após certo tempo definido. |
| US36 | Remover Utilizador | alta | Como Administrador, pretendo remover a conta de um utilizador por constantemente infringir as regras do site (Bans consecutivos, scam,...) |
| US37 | Remover Comentários Impróprios | alta | Como Administrador, pretendo remover comentários por serem ofensivos ou violar as regras do site |
| US38 | Remover Notícia | média | Como Administrador, pretendo remover uma notícia sendo que o autor na mesma recebe uma notificação com a justificação da mesma |
| US39 | Adicionar FAQ | média | Como Administrador, pretendo adicionar FAQ's, para que os utilizadores não precisem de entrar em contato comigo sobre esse assunto |
| US40 | Remover FAQ | média | Como Administrador, pretendo excluir um FAQ porque não é pertinente para o site |
| US41 | Rever Notícias | baixa | Como Administrador, pretendo rever as notícias para verificar se cumprem as regras do site |

## 3. Requisitos Suplementares

**Regras do Negócio**
| Identifier | Name | Description |
|------------|------|-------------|
| BR01 | Reputação do Utilizador | A reputação do utilizador depende dos gostos e desgostos recebidos em suas notícias ou comentários |
| BR02 | Impossibilidade de Apagar | Uma notícia ou comentário não pode ser excluído pelo autor se tiver votos ou comentários |
| BR03 | Partilha de dados do Utilizador | Após a exclusão da conta, os dados compartilhados do utilizador (por exemplo, comentários, avaliações, gostos) são mantidos, mas tornam-se anónimos |

**Restrições Técnicas**
| Identifier | Name | Description |
|------------|------|-------------|
| TR01 | Disponibilidade | O sistema deve estar disponível 99% do tempo em cada período de 24 horas |
| TR02 | Acessibilidade | O sistema deve garantir que todos possam aceder as páginas, independentemente de terem alguma deficiência ou não, ou do navegador que usam |
| TR03 | Usabilidade | O sistema deve ser simples e fácil de usar |
| TR04 | Performance | O sistema deve ter tempos de resposta menores que 2s para garantir a atenção do utilizador |
| TR05 | Aplicação da Web | O sistema deve ser implementado como uma aplicação da Web com páginas dinâmicas (HTML5, JavaScript, CSS3 e PHP) |
| TR06 | Portabilidade | O sistema do servidor deve funcionar em várias plataformas (Linux, Mac OS, etc.) |
| TR07 | Base de Dados | Deve ser utilizado o sistema de base de dados PostgreSQL, com versão 11 ou superior. |
| TR08 | Segurança | O sistema deve proteger as informações de acesso não autorizado através do uso de um sistema de autenticação e verificação |
| TR09 | Robustez | O sistema deve estar preparado para lidar e continuar em operação quando ocorrerem erros de tempo de execução |
| TR10 | Escalabilidade | O sistema deve estar preparado para lidar com o crescimento do número de utilizadores e suas ações |
| TR11 | Ética | O sistema deve respeitar os princípios éticos no desenvolvimento de software (por exemplo, a senha deve ser armazenada criptografada para garantir que apenas o proprietário a saiba) |

**Restrições**
| Identifier | Name | Description |
|------------|------|-------------|
| C01 | Deadline | O sistema deve estar pronto para ser utilizado no final do semestre. |

# **A3: Arquitetura da Informação**

## 1. _Sitemap_

Como podemos ver na imagem seguinte, "<span dir="">O Ardina" está organizado em 5 áreas: autenticação, utilizador, administrador, notícias e informações.</span> Através da página inicial (UI01) o utilizador consegue ter acesso diretamente a 4 das 5 áreas totais.

<span dir="">Para que o utilizador possa contribuir na criação de notícias, comentários e votos, através da área de autenticação, temos da a página para iniciar sessão (UI02) ou caso seja novo, criar conta (UI03).</span>

<span dir="">Caso o utilizador inicie sessão na página UI02, é redirecionado para o seu perfil no Ardina. Nesta página (UI04) contém outras opções de redirecionamento que ajudam o utilizador a organizar a sua informação (UI05, UI08 e UI09) e contributos que tenha realizado no jornal (UI06 e UI07).</span>

<span dir="">Para o controlo de todo o sistema, tenho a área do administrador que através de uma página inicial (UI10) consegue ter acesso a outras páginas que permitem fazer a organização das notícias e de toda a informação restante (notícias-UI11, comentários- UI12, _tags_-UI13 e utilizadores-UI14).</span>

<span dir="">A principal parte deste site é a área das Notícias, esta área destina-se a organizar todas as páginas que de algum modo fazem consultas (UI15 e UI16) ou criação de notícias (UI17) ou _tags_ (UI18).</span>

<span dir="">A área das informações contém páginas estáticas que fornecem informações sobre o Ardina (UI19), os seus contatos (UI20), FAQs (UI21) e informações sobre a aplicação web(UI22).</span>

<div>

![Sitemap_OArdina](uploads/42aadbf208af0ee4101d6ce39b5cb313/Sitemap_OArdina.png)

## 2. _Wireframe_

</div>Para apresentar as ideias do _layout_ da nossa página "O Ardina", escolhemos apresentar a página incial do jornal (UI01) e a página com a notícia detalhada (UI16).

### Rodapé e Cabeçalho

Como temos dois tipos de utilizadores, o não autenticado e o autenticado, os cabeçalhos e os rodapés (_headers_ e _footers_) têm diferenças, uma com a opção de entrar na área de autenticação e a outra com a opção da área do utilizador.
| ![RodapeCabe%C3%A7alho_SUtilizador](uploads/5c649bbacb39da786c2e94cb3768edfc/RodapeCabe%C3%A7alho_SUtilizador.png) | ![RodapeCabe%C3%A7alho_CUtilizador](uploads/8ec0fe1b4c578cfa161cd6b86ee2cfec/RodapeCabe%C3%A7alho_CUtilizador.png) |
|--------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------|
| Cabeçalho e rodapé do utilizador não autenticado | Cabeçalho e rodapé do utilizador autenticado |

**1-** Acesso direto a página de pesquisa (UI15)

**2-** Entra na área de autenticação, Iniciar Sessão(UI02)

**3-** Barra de organização de _tags_ das notícias

**4-** Botão "Mais Secções" escolher outra _tags_ que não esteja no menu

**5-** Menu relativo as informações do jornal "O Ardina", área de informação

**6-** Utilizador autenticado, dá acesso ao seu perfil (UI04)

### Página Inicial

Na página principal podemos encontrar as notícias mais recentes, cada retângulo corresponde a uma notícia diferente (exceto os que correspondem a publicidade).

Ao clicar em qualquer notícia é redirecionado para a página com os detalhes sobre ela, como por exemplo mais informação, imagens, comentários e autor (UI16).
| ![PaginaInicial_SUtilizador](uploads/86ddad07b178a05a3a9ff384fb1548ca/PaginaInicial_SUtilizador.png) | ![PaginaInicial_CUtilizador](uploads/0baa87bd14f616218e8f62e5a7eb5c11/PaginaInicial_CUtilizador.png) |
|------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------|
| Utilizador não autenticado | Utilizador autenticado |

### Página Destalhada da Notícia

<span dir="">Devido ao tipo de utilizador diferente, os detalhes da informação mudam. Esta diferença nos utilizadores reflete-se nas imagens seguintes, que correspondem aos _layouts_ da página referente às notícias.</span>
| ![Noticia_SUtilizador](uploads/a1ea31a21ba18ba951a5226026c33881/Noticia_SUtilizador.png) | ![Noticia_CUtilizador](uploads/036700ee4644aa94aa72179b1b8bb82c/Noticia_CUtilizador.png) |
|------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------|
| Utilizador não autenticado | Utilizador autenticado |

<span dir="">Um utilizador autenticado para além de conseguir ver quem é o autor da notícia e as _tags_ secundárias atribuídas,  consegue também votar na notícia, adicionar a notícia aos seus favoritos, reportar algum probema, deixar comentários, votar em algum comentário ou até mesmo reportar um comentário</span>, como podemos ver melhor na imagem abaixo.

<div>

</div>![Noticia_CIndica%C3%A7oes](uploads/bdf29799a809f09fbea7144fe0ac2393/Noticia_CIndica%C3%A7oes.png)

**7-** Menu referente as _tags_, com a tag principal da notícia selecionada (igual no utilizador não autenticado)

**8-** Espaço para que o utilizador deixe o seu comentário

**9-** Botões referentes a votação (positiva ou negativa), adicionar aos seus favoritos e reportar a notícia

**10-** Em cada comentário o utilizador é capaz de colocar um "gosto" ou reportar caso ache que alguma coisa não está correta

**11-** _Tags_ secundárias correspondentes à notícia

---
# Histórico de Revisão
Alterações feitas no primeiro envio:
* Acrescentamos a informação inicial relativa ao projeto;
* Modificamos a representação do Administrador no esquema de atores, devido à evolução do projeto achamos mais correto;
* Acrescentamos a descrição do Administrador que faltava;
* Corrigimos um erro numa ligação no Sitemap.

<br></br>
**_Grupo 63, Data :_** 09/11/2021

* <span dir="">António Ferreira Cabral de Barbosa Campelo</span>, [<span dir="">up201704987@fc.up.pt</span>](mailto:up201704987@fc.up.pt)
* <span dir="">Edgar Miguel Pinto Lourenço</span>, [<span dir="">up201604910@fc.up.pt</span>](mailto:up201604910@fc.up.pt)
* <span dir="">Manuel da Silva Sá</span>, [<span dir="">up201805273@fc.up.pt</span>](mailto:up201805273@fc.up.pt)
* <span dir="">Patrícia Daniela Tavares Vieira</span>, [up201805238@fc.up.pt](mailto:up201805238@fc.up.pt)