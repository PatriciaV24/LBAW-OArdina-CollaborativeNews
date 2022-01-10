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


/*
CREATE OR REPLACE FUNCTION notificacao_seguidor(followed_id, infos_id) RETURNS TRIGGER AS
   $BODY$
   BEGIN
       INSERT INTO n_seguidor
       VALUES (followed_id, infos_id);

       RETURN n_seguidor;
   END  
   $BODY$
LANGUAGE plpgsql;
CREATE TRIGGER notificacao_seguidor
   AFTER INSERT ON info_seguidor
   FOR EACH ROW
   EXECUTE PROCEDURE notificacao_seguidor();


CREATE OR REPLACE FUNCTION notificacao_comentario(u_id,c_id) RETURNS TRIGGER AS
   $BODY$
   BEGIN
       INSERT INTO n_comentario 
        VALUES(u_id, c_id);
        
        RETURN n_comentario;
   END  
   $BODY$
LANGUAGE plpgsql;
CREATE TRIGGER notificacao_comentario
   AFTER INSERT ON comentario
   FOR EACH ROW
   EXECUTE PROCEDURE notificacao_comentario(); 


CREATE OR REPLACE FUNCTION notificacao_voto(voto) RETURNS TRIGGER AS
   $BODY$
   BEGIN
       INSERT INTO n_vot_not
       SELECT v.autor_id, v.id
       FROM vot_not v
       WHERE v.id=voto;
       RETURN n_vot_not;
   END  
   $BODY$
LANGUAGE plpgsql;
CREATE TRIGGER notificacao_voto
   AFTER INSERT ON vot_not
   FOR EACH ROW
   EXECUTE PROCEDURE notificacao_voto();

*/

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
            IF EXISTS(SELECT * FROM banido WHERE ban.id --ACABAR-- );