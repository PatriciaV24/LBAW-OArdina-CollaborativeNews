/*Transactions*/

/*Insert new News Post*/

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
 
INSERT INTO noticia (autor_id, titulo, descricao, date)
VALUES ($autor_id, $titulo, $descricao, $date);
 
COMMIT;
-------------------------------

/*Insert new Comment*/

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;


INSERT INTO noticias (autor_id, titulo, descricao, date)
VALUES ($autor_id, $titulo, $descricao, $date);

INSERT INTO comentario (autor_id, noticia_id, comentario)
VALUES ($autor_id, currval('noticia_id_seq'), $comentario);

COMMIT;

-------------------------------------

/*Insert Report User*/

BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_u (autor_id, users_id, tipo_rep, resolucao)
VALUES($autor_id, $titulo, $descricao, $date);

COMMIT;
-------------------------------------------

/*Insert Report Comment*/
BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_c (autor_id, comentario_id, tipo_rep, resolucao)
VALUES($autor_id, $comentario_id, $descricao, $date);

COMMIT;
-------------------------------------------

/*Insert Report News*/

BEGIN TRANSACTION
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ:

INSERT INTO report_n (autor_id, noticia_id, tipo_rep, resolucao)
VALUES($autor_id, $noticia_id, $descricao, $date);

COMMIT;
-------------------------------------------