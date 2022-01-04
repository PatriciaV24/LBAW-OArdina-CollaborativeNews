CREATE OR REPLACE FUNCTION acao_de_admin() RETURNS TRIGGER AS
   $BODY$
       BEGIN
           IF NOT (SELECT permissao FROM utilizador WHERE USER_TYPE = 'u' ) THEN 
               RAISE EXCEPTION 'Apenas administradores podem realizar esta operação.';
           END IF;
           RETURN utilizador;
       END
   $BODY$
LANGUAGE plpgsql;
CREATE TRIGGER acao_de_admin
   BEFORE UPDATE ON utilizador
   FOR EACH ROW
   EXECUTE PROCEDURE acao_de_admin();




CREATE OR REPLACE FUNCTION seguir_proprio() RETURNS TRIGGER AS
   $BODY$
   BEGIN
       IF info_seguidor.autor_id = info_seguidor.followed_id THEN
           RAISE EXCEPTION 'Nao se pode seguir a si próprio.';
       END IF;
       RETURN info_seguidor;
   END
   $BODY$
LANGUAGE plpgsql;
CREATE TRIGGER  seguir_proprio
   BEFORE INSERT ON info_seguidor
   FOR EACH ROW
   EXECUTE PROCEDURE  seguir_proprio();


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
