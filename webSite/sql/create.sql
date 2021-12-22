DROP TABLE IF EXISTS publicidade CASCADE;
DROP TABLE IF EXISTS reportC CASCADE;
DROP TABLE IF EXISTS reportN CASCADE;
DROP TABLE IF EXISTS reportU CASCADE;
DROP TABLE IF EXISTS textoReport CASCADE;
DROP TABLE IF EXISTS nUtiBloq CASCADE;
DROP TABLE IF EXISTS nVotCom CASCADE;
DROP TABLE IF EXISTS nVotNot CASCADE;
DROP TABLE IF EXISTS nComentario CASCADE;
DROP TABLE IF EXISTS nSeguidor CASCADE;
DROP TABLE IF EXISTS infoSeguidor CASCADE;
DROP TABLE IF EXISTS favTag CASCADE;
DROP TABLE IF EXISTS favCom CASCADE;
DROP TABLE IF EXISTS favNot CASCADE;
DROP TABLE IF EXISTS votNot CASCADE;
DROP TABLE IF EXISTS votCom CASCADE;
DROP TABLE IF EXISTS imagem CASCADE;
DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS categoria CASCADE;
DROP TABLE IF EXISTS comentario CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS noticia CASCADE;
DROP TABLE IF EXISTS utilizador CASCADE;

DROP TYPE IF EXISTS USER_TYPE;
DROP TYPE IF EXISTS PRIORIDADE;
DROP TYPE IF EXISTS GOSTO;

DROP INDEX IF EXISTS nome_uti_idx;
DROP INDEX IF EXISTS noticia_date_idx;
DROP INDEX IF EXISTS autor_not_idx;
DROP INDEX IF EXISTS comentario_idx;
DROP INDEX IF EXISTS search_not_idx;
DROP INDEX IF EXISTS search_uti_idx;

-------------------------------------------

/* TIPOS */
CREATE TYPE USER_TYPE AS ENUM('a','u','b'); /* a - Administrador, u - User Autenticado, b - User Banido*/
CREATE TYPE PRIORIDADE AS ENUM('0', '1', '2');
CREATE TYPE GOSTO AS ENUM('like', 'dislike');

-------------------------------------------

/* TABELAS */

/* T: dos Utilizadores*/
CREATE TABLE utilizador(
    id SERIAL PRIMARY KEY,
    nome VARCHAR(20) NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    foto TEXT, /*url to text*/
    permissao USER_TYPE NOT NULL,
    contacto INTEGER NOT NULL,
    CONSTRAINT contacto_limites CHECK (contacto > 99999999 AND contacto < 1000000000)
);
/* T: das Noticias*/
CREATE TABLE noticia (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    titulo VARCHAR(90) NOT NULL,
    descricao TEXT NOT NULL,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: das Tags*/
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(40) NOT NULL UNIQUE,
    prioridade PRIORIDADE NOT NULL    
);
/* T: dos Comentários (Utilizador <-> Noticia)*/
CREATE TABLE comentario (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    texto TEXT NOT NULL,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);
/* T: dos Categoria (Noticia <-> Tag)*/
CREATE TABLE categoria (
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    tag_id INTEGER NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
    PRIMARY KEY (not_id, tag_id)
);
/* T: dos FAQ (-> Utilizador)*/
CREATE TABLE faq (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL, /*O administrador que realizou ou alterou o faq*/
    questao TEXT NOT NULL UNIQUE,
    resposta TEXT NOT NULL
);
/* T: das Imagens (-> Noticia)*/
CREATE TABLE imagem (
    id SERIAL PRIMARY KEY,
    legenda VARCHAR(30) NOT NULL,
    path TEXT NOT NULL,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE
);

/* T: Votaçao nos Comentários (Utilizador <-> Comentario)*/
CREATE TABLE votCom (
    id SERIAL PRIMARY KEY,
    com_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    tipo GOSTO NOT NULL
);

/* T: Votaçao nas Noticias (Utilizador <-> Noticia)*/
CREATE TABLE votNot (
    id SERIAL PRIMARY KEY,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    tipo GOSTO NOT NULL
);

/* T: Favoritos Noticias (Utilizador <-> Noticia)*/
CREATE TABLE favNot (
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, not_id)
);

/* T: Favoritos Comentários (Utilizador <-> Comentario)*/
CREATE TABLE favCom (
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    com_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, com_id)
);

/* T: Favoritos Tags (Utilizador <-> Tag)*/
CREATE TABLE favTag (
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    tag_id INTEGER NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, tag_id)
);

/* T: Seguidores (Utilizador <-> Utilizador)*/
CREATE TABLE infoSeguidor (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    followed_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL
);

/* T: Notificações Novos Seguidores (-> infoSeguidor)*/
CREATE TABLE nSeguidor (
    id SERIAL PRIMARY KEY,
    followed_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    infos_id INTEGER REFERENCES infoSeguidor(id)  ON DELETE SET NULL,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Notificações Novos Comentários (-> Comentario)*/
CREATE TABLE nComentario (
    id SERIAL PRIMARY KEY,
    authornot_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    com_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Notificações Votos Noticia (-> votNot)*/
CREATE TABLE nVotNot (
    id SERIAL PRIMARY KEY,
    uti_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    voto_id INTEGER NOT NULL REFERENCES vot_not(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Notificações Votos Comentario (-> votCom)*/
CREATE TABLE nVotCom (
    id SERIAL PRIMARY KEY,
    uti_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    votoc_id INTEGER NOT NULL REFERENCES vot_com(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
);

/* T: Notificações Utilizador Bloqueado (UreportU)*/
CREATE TABLE nUtiBloq (
    id SERIAL PRIMARY KEY,
    bloq_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    motivo TEXT NOT NULL,
    lido BOOLEAN NOT NULL DEFAULT FALSE
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Possiveis Reports */
CREATE TABLE textoReport (
    id SERIAL PRIMARY KEY,
    report TEXT NOT NULL
);
/* T: Report Utilizador (Utilizador-> textoReport)*/
CREATE TABLE reportU (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL, 
    uti_id INTEGER REFERENCES utilizador(id)  ON DELETE SET NULL,
    tiporesp_id INTEGER NOT NULL REFERENCES textoReport(id)  ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);

/* T: Report Noticia (Utilizador-> textoReport <-> Noticia)*/
CREATE TABLE reportN (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    tiporesp_id INTEGER NOT NULL REFERENCES textoReport(id) ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);
/* T: Report Comentario (Utilizador-> textoReport <-> Comentario)*/
CREATE TABLE reportC (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER REFERENCES utilizador(id) ON DELETE SET NULL,
    comentario_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    tiporesp_id INTEGER NOT NULL REFERENCES textoReport(id) ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);

/* T: Publicidade*/
CREATE TABLE publicidade (
    id SERIAL PRIMARY KEY,
    imagem TEXT NOT NULL
);

-------------------------------------------

/* Índices */

CREATE INDEX nome_uti_idx ON utilizador USING hash (nome);

CREATE INDEX noticia_date_idx ON noticia USING btree(data);

CREATE INDEX autor_not_idx ON noticia USING hash(autor_id);

CREATE INDEX comentario_idx ON comentario USING hash(not_id);

ALTER TABLE noticia ADD COLUMN search TSVECTOR;
CREATE INDEX search_not_idx ON noticia USING GIST (search);

ALTER TABLE utilizador ADD COLUMN search TSVECTOR;
CREATE INDEX search_uti_idx ON utilizador USING GIST (search);

-----------------------------------------------------------
