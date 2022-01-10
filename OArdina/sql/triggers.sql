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






