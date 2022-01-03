/*  SCHEMA - Elimina tudo dentro do SCHEMA
DROP SCHEMA IF EXISTS lbaw2163 CASCADE;
CREATE SCHEMA lbaw2163;
SET search_path TO "lbaw2163";
*/

/*------------------------------------------------------------*/
/*Caso nao esteja dentro do lbaw2163*/
DROP TABLE IF EXISTS publicidade CASCADE;
DROP TABLE IF EXISTS report_c CASCADE;
DROP TABLE IF EXISTS report_n CASCADE;
DROP TABLE IF EXISTS report_u CASCADE;
DROP TABLE IF EXISTS texto_report CASCADE;
DROP TABLE IF EXISTS n_uti_bloq CASCADE;
DROP TABLE IF EXISTS n_vot_com CASCADE;
DROP TABLE IF EXISTS n_vot_not CASCADE;
DROP TABLE IF EXISTS n_comentario CASCADE;
DROP TABLE IF EXISTS n_seguidor CASCADE;
DROP TABLE IF EXISTS info_seguidor CASCADE;
DROP TABLE IF EXISTS fav_tag CASCADE;
DROP TABLE IF EXISTS fav_com CASCADE;
DROP TABLE IF EXISTS fav_not CASCADE;
DROP TABLE IF EXISTS vot_not CASCADE;
DROP TABLE IF EXISTS vot_com CASCADE;
DROP TABLE IF EXISTS imagem CASCADE;
DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS categoria CASCADE;
DROP TABLE IF EXISTS comentario CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS noticia CASCADE;
DROP TABLE IF EXISTS utilizador CASCADE;

DROP TYPE IF EXISTS USER_TYPE;
DROP TYPE IF EXISTS GOSTO;

DROP INDEX IF EXISTS nome_uti_idx;
DROP INDEX IF EXISTS noticia_date_idx;
DROP INDEX IF EXISTS autor_not_idx;
DROP INDEX IF EXISTS comentario_idx;
DROP INDEX IF EXISTS search_not_idx;
DROP INDEX IF EXISTS search_uti_idx;

----------------------------------------------------

/* TIPOS */
CREATE TYPE USER_TYPE AS ENUM('a','u','b'); /* a - Administrador, u - User Autenticado, b - User Banido*/
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
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    titulo VARCHAR(90) NOT NULL,
    descricao TEXT NOT NULL,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: das Tags*/
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(40) NOT NULL UNIQUE,
    prioridade INTEGER NOT NULL DEFAULT 0   
);
/* T: dos Comentários (Utilizador <-> Noticia)*/
CREATE TABLE comentario (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
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
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE, /*O administrador que realizou ou alterou o faq*/
    questao TEXT NOT NULL,
    resposta TEXT NOT NULL
);
/* T: das Imagens (-> Noticia)*/
CREATE TABLE imagem (
    id SERIAL PRIMARY KEY,
    legenda VARCHAR(30) NOT NULL,
    imag_path TEXT NOT NULL UNIQUE,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE
);

/* T: Votaçao nos Comentários (Utilizador <-> Comentario)*/
CREATE TABLE vot_com (
    id SERIAL PRIMARY KEY,
    com_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    tipo GOSTO NOT NULL
);

/* T: Votaçao nas Noticias (Utilizador <-> Noticia)*/
CREATE TABLE vot_not (
    id SERIAL PRIMARY KEY,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    tipo GOSTO NOT NULL
);

/* T: Favoritos Noticias (Utilizador <-> Noticia)*/
CREATE TABLE fav_not (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, not_id)
);

/* T: Favoritos Comentários (Utilizador <-> Comentario)*/
CREATE TABLE fav_com (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    comentario_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, comentario_id)
);

/* T: Favoritos Tags (Utilizador <-> Tag)*/
CREATE TABLE fav_tag (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    tag_id INTEGER NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
    PRIMARY KEY(autor_id, tag_id)
);

/* T: Seguidores (Utilizador <-> Utilizador)*/
CREATE TABLE info_seguidor (
    followed_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    infos_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    PRIMARY KEY(followed_id, infos_id)
);

/* T: Notificações Novos Seguidores (-> info_seguidor)*/
CREATE TABLE n_seguidor (
    followed_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    infos_id INTEGER NOT NULL REFERENCES utilizador(id)  ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(followed_id, infos_id)
);

/* T: Notificações Novos Comentários (-> Comentario)*/
CREATE TABLE n_comentario (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    com_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(autor_id, com_id)

);

/* T: Notificações Votos Noticia (-> vot_not)*/
CREATE TABLE n_vot_not (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    voto_id INTEGER NOT NULL REFERENCES vot_not(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(autor_id, voto_id)
);

/* T: Notificações Votos Comentario (-> vot_com)*/
CREATE TABLE n_vot_com (
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    voto_id INTEGER NOT NULL REFERENCES vot_com(id) ON DELETE CASCADE,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(autor_id, voto_id)
);

/* T: Notificações Utilizador Bloqueado (UreportU)*/
CREATE TABLE n_uti_bloq (
    id SERIAL PRIMARY KEY,
    bloq_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    motivo TEXT NOT NULL,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Possiveis Reports */
CREATE TABLE texto_report (
    id SERIAL PRIMARY KEY,
    report TEXT NOT NULL
);
/* T: Report Utilizador (Utilizador-> texto_report)*/
CREATE TABLE report_u (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE, 
    uti_id INTEGER NOT NULL REFERENCES utilizador(id)  ON DELETE CASCADE,
    tiporesp_id INTEGER NOT NULL REFERENCES texto_report(id)  ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);

/* T: Report Noticia (Utilizador-> texto_report <-> Noticia)*/
CREATE TABLE report_n (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    not_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE,
    tiporesp_id INTEGER NOT NULL REFERENCES texto_report(id) ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);
/* T: Report Comentario (Utilizador-> texto_report <-> Comentario)*/
CREATE TABLE report_c (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    comentario_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE,
    tiporesp_id INTEGER NOT NULL REFERENCES texto_report(id) ON DELETE CASCADE,
    resolvido BOOLEAN NOT NULL DEFAULT FALSE
);

/* T: Publicidade*/
CREATE TABLE publicidade (
    id SERIAL PRIMARY KEY,
    imagem TEXT NOT NULL UNIQUE
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
