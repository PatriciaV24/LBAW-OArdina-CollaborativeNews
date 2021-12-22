/*Transactions*/

/*Insert new News Post*/

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
 
INSERT INTO noticias (author_id, titulo, descricao, date)
VALUES ($author_id, $titulo, $descricao, $date);
 
COMMIT;
-------------------------------

/*Insert new Comment*/

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;


INSERT INTO noticias (author_id, titulo, descricao, date)
VALUES ($author_id, $titulo, $descricao, $date);

INSERT INTO comentario (author_id, noticia_id, comentario)
VALUES ($author_id, currval('noticia_id_seq'), $comentario);

COMMIT;

-------------------------------------

/*Insert Report User*/

BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_u (author_id, users_id, tipo_rep, resolucao)
VALUES($author_id, $titulo, $descricao, $date);

COMMIT;
-------------------------------------------

/*Insert Report Comment*/
BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_c (author_id, comentario_id, tipo_rep, resolucao)
VALUES($author_id, $comentario_id, $descricao, $date);

COMMIT;
-------------------------------------------

/*Insert Report News*/

BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_n (author_id, noticia_id, tipo_rep, resolucao)
VALUES($author_id, $noticia_id, $descricao, $date);

COMMIT;
-------------------------------------------