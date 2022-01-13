DROP SCHEMA IF EXISTS lbaw2163 CASCADE;
CREATE SCHEMA lbaw2163;
SET search_path TO "lbaw2163";

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
DROP TABLE IF EXISTS ban CASCADE;
DROP TABLE IF EXISTS gosto CASCADE;
DROP TABLE IF EXISTS unban_appeal CASCADE;
DROP TABLE IF EXISTS pedidos CASCADE;

DROP TYPE IF EXISTS USER_TYPE;
DROP TYPE IF EXISTS GOSTO;
DROP TYPE IF EXISTS ESTADO;

DROP INDEX IF EXISTS nome_uti_idx;
DROP INDEX IF EXISTS noticia_date_idx;
DROP INDEX IF EXISTS autor_not_idx;
DROP INDEX IF EXISTS comentario_idx;
DROP INDEX IF EXISTS search_not_idx;
DROP INDEX IF EXISTS search_uti_idx; 
DROP INDEX IF EXISTS banido_idx; 
DROP INDEX IF EXISTS admin_idx; 
DROP INDEX IF EXISTS nr_gostos_idx; 


----------------------------------------------------

/* TIPOS */
CREATE TYPE USER_TYPE AS ENUM('a','u','b'); /* a - Administrador, u - User Autenticado, b - User Banido*/
CREATE TYPE GOSTO AS ENUM('like', 'dislike');
CREATE TYPE ESTADO AS ENUM('aprovado', 'rejeitado');

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
    admin BOOLEAN NOT NULL DEFAULT FALSE,
    banido BOOLEAN NOT NULL DEFAULT FALSE,
    conta_apagada BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT contacto_limites CHECK (contacto > 99999999 AND contacto < 1000000000)
);

/* T: das Noticias*/
CREATE TABLE noticia (
    id SERIAL PRIMARY KEY,
    autor_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    titulo VARCHAR(90) NOT NULL,
    descricao TEXT NOT NULL,
    imagem TEXT NOT NULL,
    nr_gostos INTEGER NOT NULL DEFAULT 0,
    nr_comentarios INTEGER NOT NULL DEFAULT 0,
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

/* T: Notificações Novos Seguidores (-> Utilizador)*/
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

/* T: Notificações Utilizador Bloqueado (->report_u)*/
CREATE TABLE n_uti_bloq (
    id SERIAL PRIMARY KEY,
    bloq_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    motivo TEXT NOT NULL,
    lido BOOLEAN NOT NULL DEFAULT FALSE,
    data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

/* T: Report Utilizador (Utilizador-> texto_report)*/
CREATE TABLE report_u (
    pedido_id INTEGER NOT NULL REFERENCES pedidos(id) ON DELETE CASCADE,
    utilizador_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE
);

/* T: Report Noticia (Utilizador-> texto_report <-> Noticia)*/
CREATE TABLE report_n (
    pedido_id INTEGER NOT NULL REFERENCES pedidos(id) ON DELETE CASCADE,
    noticia_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE
);

/* T: Report Comentario (Utilizador-> texto_report <-> Comentario)*/
CREATE TABLE report_c (
    pedido_id INTEGER NOT NULL REFERENCES pedidos(id) ON DELETE CASCADE,
    comentario_id INTEGER NOT NULL REFERENCES comentario(id) ON DELETE CASCADE
);

/*T: do ban*/
CREATE TABLE ban (
    id SERIAL PRIMARY KEY,
    utilizador_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    admin_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE, /*Trigger para verificar se user.is_admin == true*/
    start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    end_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT CHECK (end_date > start_date),
    razao TEXT NOT NULL 
)

/*T: do gosto*/
CREATE TABLE gosto {
    utilizador_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    noticia_id INTEGER NOT NULL REFERENCES noticia(id) ON DELETE CASCADE /*Trigger para verificar que autor não vota na própria noticia*/
}

/*T: Apelar unban*/
CREATE TABLE unban_appeal (
    request_id INTEGER NOT NULL REFERENCES request(id) ON DELETE CASCADE,
    ban_id INTEGER NOT NULL REFERENCES ban(id) ON DELETE CASCADE
);

/* T: Publicidade*/
CREATE TABLE publicidade (
    id SERIAL PRIMARY KEY,
    imagem TEXT NOT NULL UNIQUE
);

CREATE TABLE pedidos (
    id SERIAL PRIMARY KEY;
    utilizador_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    admin_id INTEGER NOT NULL REFERENCES utilizador(id) ON DELETE CASCADE,
    razao TEXT NOT NULL,
    data_criacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    estado ESTADO,
    data_revisao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

-------------------------------------------

/* Índices */

CREATE INDEX nome_uti_idx ON utilizador USING hash (nome);

CREATE INDEX banido_idx ON utilizador USING hash(banido);

CREATE INDEX admin_idx ON utilizador USING hash(admin);

CREATE INDEX nr_gostos_idx ON noticia USING btree(nr_gostos);

CREATE INDEX noticia_date_idx ON noticia USING btree(data);

CREATE INDEX autor_not_idx ON noticia USING hash(autor_id);

CREATE INDEX comentario_idx ON comentario USING hash(not_id);

ALTER TABLE noticia ADD COLUMN search TSVECTOR;
CREATE INDEX search_not_idx ON noticia USING GIST (search);

ALTER TABLE utilizador ADD COLUMN search TSVECTOR;
CREATE INDEX search_uti_idx ON utilizador USING GIST (search);

-----------------------------------------------------------

/* Triggers */

--Trigger - Ação de admin-----

DROP FUNCTION IF EXISTS acao_de_admin() CASCADE;
DROP TRIGGER IF EXISTS acao_de_admin ON request;


CREATE OR REPLACE FUNCTION acao_de_admin() RETURNS TRIGGER AS
   $BODY$
       BEGIN
           IF NOT (SELECT admin FROM utilizador WHERE utilizador.id = new.admin_id ) THEN 
               RAISE EXCEPTION 'Apenas administradores podem realizar esta operação.';
           END IF;
           RETURN utilizador;
       END
   $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER acao_de_admin
   BEFORE UPDATE OF estado ON pedidos
   FOR EACH ROW
   EXECUTE PROCEDURE acao_de_admin();

---Trigger - Seguir_Proprio----

DROP FUNCTION IF EXISTS seguir_proprio() CASCADE;
DROP TRIGGER IF EXISTS seguir_proprio ON request;

CREATE OR REPLACE FUNCTION seguir_proprio() RETURNS TRIGGER AS
   $BODY$
   BEGIN
       IF NEW.followed_id = NEW.infos_id THEN
           RAISE EXCEPTION 'Nao se pode seguir a si próprio.';
       END IF;
       RETURN info_seguidor;
   END
   $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER seguir_proprio
   BEFORE INSERT ON info_seguidor
   FOR EACH ROW
   EXECUTE PROCEDURE seguir_proprio();
   
---Trigger - Atualizar Feed---

CREATE OR REPLACE FUNCTION atualizar_feed() RETURNS TRIGGER AS
   $BODY$
   BEGIN
     SELECT *
     FROM noticia
     ORDER BY data DESC;
   END  
   $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER atualizar_feed
   AFTER UPDATE ON noticia
   FOR EACH ROW
   EXECUTE PROCEDURE atualizar_feed();


 --Trigger - Update TSVector(Noticia)-----

 ----
DROP FUNCTION IF EXISTS noticias_search_update() CASCADE;
DROP TRIGGER IF EXISTS noticias_search_update ON noticia;

CREATE OR REPLACE FUNCTION noticias_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE not_texto TEXT = (SELECT n.descricao FROM noticia n where n.id = new.id);
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search = 
                setweight(to_tsvector(coalesce(NEW.titulo, '')), 'B') ||
                setweight(to_tsvector(coalesce(not_texto, '')), 'C');
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.titulo <> OLD.titulo THEN
                NEW.search =
                    setweight(to_tsvector(coalesce(NEW.titulo, '')), 'B') ||
                    setweight(to_tsvector(coalesce(not_texto, '')), 'C');
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER noticias_search_update
    BEFORE INSERT OR UPDATE ON noticias_search_update
    FOR EACH ROW
    EXECUTE PROCEDURE noticias_search_update();

-- Trigger - Update TSVector(Noticia) -----

DROP FUNCTION IF EXISTS noticias_descricao_search_update() CASCADE;
DROP TRIGGER IF EXISTS noticias_descricao_search_update ON noticia;

CREATE OR REPLACE FUNCTION noticias_descricao_search_update() RETURN TRIGGER AS 
    $BODY$
    DECLARE not_titulo TEXT = (SELECT titulo FROM noticia WHERE noticia.id = new.id);
    BEGIN
        IF not_titulo IS NOT NULL THEN
            IF NEW.descricao <> OLD.descricao THEN
                UPDATE noticia
                SET search = 
                    setweight(to_tsvector(coalesce(not_titulo, '')), 'B') ||
                    setweight(to_tsvector(coalesce(NEW.descricao, '')), 'C')
                WHERE noticia.id = new.id;
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER noticias_descricao_search_update
    BEFORE UPDATE ON noticia
    FOR EACH ROW
    EXECUTE PROCEDURE noticias_descricao_search_update();

-- Trigger - Update TSVector(utilizador)-----

DROP FUNCTION IF EXISTS utilizador_search_update() CASCADE;
DROP TRIGGER IF EXISTS utilizador_search_update ON utilizador;

CREATE OR REPLACE FUNCTION utilizador_search_update() RETURN TRIGGER AS
    $BODY$
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search = 
                setweight(to_tsvector(coalesce(NEW.nome, '')), 'A')
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.nome <> OLD.nome THEN
                NEW.search = 
                    setweight(to_tsvector(coalesce(NEW.nome, '')), 'A');
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER utilizador_search_update
    BEFORE INSERT OR UPDATE ON utilizador
    FOR EACH ROW
    EXECUTE PROCEDURE utilizador_search_update(); 

--Trigger - Utilizador não pode votar nas suas próprias publicações----

DROP FUNCTION IF EXISTS votar_proprio() CASCADE;
DROP FUNCTION IF EXISTS votar_proprio ON gosto;

CREATE OR REPLACE FUNCTION votar_proprio() RETURN TRIGGER AS
    $BODY$
    BEGIN
        IF new.utilizador_id = (SELECT autor_id FROM noticia WHERE new.noticia_id = noticia_id) THEN
            RAISE EXCEPTION 'O utilizador não pode votar nos seus próprios conteúdos';
        END IF;
        RETURN new;
    END;
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER votar_proprio
    BEFORE INSERT ON gosto
    FOR EACH ROW
    EXECUTE PROCEDURE votar_proprio();


-- Trigger - Lidar com Pedidos----
DROP FUNCTION IF EXISTS lidar_com_pedidos() CASCADE;
DROP TRIGGER IF EXISTS lidar_com_pedidos ON pedidos;

CREATE OR REPLACE FUNCTION lidar_com_pedidos RETURN TRIGGER AS 

    $BODY$
    BEGIN
        IF new.estado = 'aprovado' THEN
            IF EXISTS (SELECT * FROM unban_appeal, users WHERE new.id = request_id AND utilizador.id = new.utilizador_id) THEN
                UPDATE utilizador SET banido = false WHERE new.utilizador_id = utilizador.id;
                IF EXISTS(SELECT * FROM banido WHERE ban.id IN (SELECT ban_id FROM unban_appeal WHERE new.id = request_id)) THEN
                UPDATE ban SET end_date = NOW() WHERE ban.id IN (SELECT ban_id FROM unban_appeal WHERE new.id = request_id);
                END IF;
            END IF;
            new.data_revisao = NOW();
        END IF;
        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER lidar_com_pedidos
    AFTER UPDATE ON pedidos
    FOR EACH ROW
    EXECUTE PROCEDURE lidar_com_pedidos();

-- Trigger - Aumentar nr de comentarios ---
DROP FUNCTION IF EXISTS aumentar_comentarios() CASCADE;
DROP TRIGGER IF EXISTS aumentar_comentarios ON noticia;

CREATE OR REPLACE FUNCTION aumentar_comentarios() RETURN TRIGGER AS
    $BODY$
    BEGIN
        UPDATE noticia SET nr_comentarios = noticia.nr_comentarios + 1;
        WHERE new.id = noticia.id;

        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER aumentar_comentarios
    AFTER INSERT ON noticia
    FOR EACH ROW
    EXECUTE PROCEDURE aumentar_comentarios();

-- Trigger - Diminuir nr de comentarios ---
DROP FUNCTION IF EXISTS diminuir_comentarios() CASCADE:
DROP TRIGGER IF EXISTS diminuir_comentarios ON noticia;

CREATE OR REPLACE FUNCTION diminuir_comentarios() RETURN TRIGGER AS
    $BODY$
    BEGIN
        UPDATE noticia SET nr_comentarios = nr_comentarios - 1
        WHERE old.id = id;
        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER diminuir_comentarios
    AFTER DELETE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE diminuir_comentarios();

-- Trigger - Aumentar nr de gostos ---
DROP FUNCTION IF EXISTS aumentar_gostos() CASCADE;
DROP TRIGGER IF EXISTS aumentar_gostos ON gosto;

CREATE OR REPLACE FUNCTION aumentar_gostos() RETURN TRIGGER AS
    $BODY$
    BEGIN
        UPDATE noticia
        SET nr_gostos = nr_gostos + 1;
        WHERE new.noticia_id = noticia.id;

        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER aumentar_gostos
    AFTER INSERT ON gosto
    FOR EACH ROW
    EXECUTE PROCEDURE aumentar_gostos;

-- Trigger - Diminuir nr de gostos ---
DROP FUNCTION IF EXISTS diminuir_gostos() CASCADE;
DROP TRIGGER IF EXISTS diminuir_gostos ON gosto;

CREATE OR REPLACE FUNCTION diminuir_gostos() RETURN TRIGGER AS
    $BODY$
    BEGIN
        UPDATE noticia
        SET nr_gostos = nr_gostos - 1;
        WHERE new.noticia_id = noticia.id;

        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER diminuir_gostos
    AFTER DELETE ON gosto
    FOR EACH ROW
    EXECUTE PROCEDURE diminuir_gostos();

 --Trigger - Update TSVector(Noticia)-----
DROP FUNCTION IF EXISTS noticias_search_update() CASCADE;
DROP TRIGGER IF EXISTS noticias_search_update ON noticia;

CREATE OR REPLACE FUNCTION noticias_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE not_texto TEXT = (SELECT n.descricao FROM noticia n where n.id = new.id);
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search = 
                setweight(to_tsvector(coalesce(NEW.titulo, '')), 'B') ||
                setweight(to_tsvector(coalesce(not_texto, '')), 'C');
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.titulo <> OLD.titulo THEN
                NEW.search =
                    setweight(to_tsvector(coalesce(NEW.titulo, '')), 'B') ||
                    setweight(to_tsvector(coalesce(not_texto, '')), 'C');
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER noticias_search_update
    BEFORE INSERT OR UPDATE ON noticias_search_update
    FOR EACH ROW
    EXECUTE PROCEDURE noticias_search_update();

-- Trigger - Update TSVector(Noticia) -----

DROP FUNCTION IF EXISTS noticias_descricao_search_update() CASCADE;
DROP TRIGGER IF EXISTS noticias_descricao_search_update ON noticia;

CREATE OR REPLACE FUNCTION noticias_descricao_search_update() RETURN TRIGGER AS 
    $BODY$
    DECLARE not_titulo TEXT = (SELECT titulo FROM noticia WHERE noticia.id = new.id);
    BEGIN
        IF not_titulo IS NOT NULL THEN
            IF NEW.descricao <> OLD.descricao THEN
                UPDATE noticia
                SET search = 
                    setweight(to_tsvector(coalesce(not_titulo, '')), 'B') ||
                    setweight(to_tsvector(coalesce(NEW.descricao, '')), 'C')
                WHERE noticia.id = new.id;
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER noticias_descricao_search_update
    BEFORE UPDATE ON noticia
    FOR EACH ROW
    EXECUTE PROCEDURE noticias_descricao_search_update();

-- Trigger - Update TSVector(utilizador)-----

DROP FUNCTION IF EXISTS utilizador_search_update() CASCADE;
DROP TRIGGER IF EXISTS utilizador_search_update ON utilizador;

CREATE OR REPLACE FUNCTION utilizador_search_update() RETURN TRIGGER AS
    $BODY$
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search = 
                setweight(to_tsvector(coalesce(NEW.nome, '')), 'A')
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.nome <> OLD.nome THEN
                NEW.search = 
                    setweight(to_tsvector(coalesce(NEW.nome, '')), 'A');
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER utilizador_search_update
    BEFORE INSERT OR UPDATE ON utilizador
    FOR EACH ROW
    EXECUTE PROCEDURE utilizador_search_update(); 








            