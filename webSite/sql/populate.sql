INSERT INTO utilizador (nome,email,password,foto,contacto)
VALUES
  ('nec,','diam.nunc@hotmail.couk','semper','/src/photos/test.jpg','722325481'),
  ('Nunc','lacinia@icloud.edu','Lorem','/src/photos/test.jpg','303987142'),
  ('tortor,','lacus.ut.nec@aol.org','Nullam','/src/photos/test.jpg','550016487'),
  ('fringilla','aptent.taciti@outlook.net','senectus','/src/photos/test.jpg','817282354'),
  ('mauris','ligula@protonmail.org','nunc','/src/photos/test.jpg','667894517');

/*Criar um administrador*/
UPDATE utilizador 
SET permissao = 'a' 
WHERE id = 2;

/*Criar um user banido*/
UPDATE utilizador 
SET permissao = 'b'; 
WHERE id = 5;

INSERT INTO noticia(autor_id,titulo,descricao)
VALUES
  (3,'a felis','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis'),
  (3,'pretium neque. Morbi','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar'),
  (2,'egestas blandit. Nam nulla','Lorem ipsum dolor sit'),
  (4,'Class aptent taciti sociosqu','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque'),
  (2,'massa. Mauris','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed');

UPDATE noticia 
SET titulo = 'Porto é campeão nacional!'
WHERE noticia_id = 3;

INSERT INTO tag(nome)
VALUES
    ('Desporto'),
    ('Nacional'),
    ('Local'),
    ('Mundo');

UPDATE tag 
SET prioridade=1;
WHERE nome = 'Nacional'; 

DELETE FROM tags
WHERE tag_id = 2;

INSERT INTO comentario(autor_id,not_id,texto)
VALUES
  (3,3,'mi felis, adipiscing fringilla, porttitor'),
  (3,4,'Nulla tempor augue ac ipsum. Phasellus vitae mauris'),
  (1,4,'nibh. Phasellus nulla. Integer vulputate,'),
  (1,1,'Morbi non sapien molestie orci'),
  (1,3,'turpis vitae');

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA comentario*/
/*autor_id -> é o autor da noticia da not_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_comentario(autor_id,com_id)
VALUES


INSERT INTO categoria(not_id, tag_id)
VALUES
    (1,2),
    (2,1),
    (3,1),
    (4,3),
    (5,4);

INSERT INTO faq(autor_id, questao, resposta)
VALUES 
    (2, 'Como inserir uma notícia ?', 'Nulla tempor augue ac ipsum. Phasellus vitae mauris');


INSERT INTO imagem(legenda,imag_path,not_id)
VALUES

INSERT INTO vot_com(com_id,autor_id,tipo)
VALUES

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA vot_com*/
/*autor_id -> é o autor do comentário da com_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_vot_com(autor_id,voto_id)
VALUES

INSERT INTO vot_not(not_id,autor_id,tipo)
VALUES


/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA vot_not*/
/*autor_id -> é o autor da noticia da not_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_vot_not(autor_id,voto_id)
VALUES

INSERT INTO fav_not(autor_id,not_id)
VALUES

INSERT INTO fav_com(autor_id,comentario_id)
VALUES

INSERT INTO fav_tag(autor_id,tag_id)
VALUES

INSERT INTO info_seguidor(followed_id, infos_id)
VALUES
    (1,3),
    (3,2),
    (4,1),
    (3,1);

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA info_seguidor*/
INSERT INTO n_seguidor(followed_id,infos_id)
VALUES 

INSERT INTO texto_report(report)
VALUES
    ('O utilizador foi agressivo com outro e além de ser agressivo tentou ameaçar diversos utilizadores');

INSERT INTO report_u(autor_id, uti_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO report_u(autor_id, uti_id, tiporesp_id, resolvido)
VALUES
    (,,,TRUE);

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA report_u MAS com resolvido a TRUE*/
INSERT INTO n_uti_bloq (bloq_id, motivo)
VALUES 

INSERT INTO report_n(autor_id, not_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO report_c(autor_id, comentario_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO publicidade(imagem)
VALUES 


