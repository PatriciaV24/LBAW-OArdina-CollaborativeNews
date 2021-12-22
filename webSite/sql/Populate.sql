INSERT INTO users (username,email,password,foto,contacto)
VALUES
  ('nec,','diam.nunc@hotmail.couk','semper','/src/photos/test.jpg','722325481'),
  ('Nunc','lacinia@icloud.edu','Lorem','/src/photos/test.jpg','303987142'),
  ('tortor,','lacus.ut.nec@aol.org','Nullam','/src/photos/test.jpg','550016487'),
  ('fringilla','aptent.taciti@outlook.net','senectus','/src/photos/test.jpg','817282354'),
  ('mauris','ligula@protonmail.org','nunc','/src/photos/test.jpg','667894517');


UPDATE users /*Criar um administrador*/
SET usertype = 'a'
WHERE users_id = 2;

UPDATE users /*Criar um user banido*/
SET usertype = 'b';
WHERE users_id = 5;

INSERT INTO noticias(author_id,titulo,descricao)
VALUES
  (3,'a felis','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis'),
  (3,'pretium neque. Morbi','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar'),
  (2,'egestas blandit. Nam nulla','Lorem ipsum dolor sit'),
  (4,'Class aptent taciti sociosqu','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque'),
  (2,'massa. Mauris','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed');

UPDATE noticias
SET titulo = 'Ola Pessoa'
WHERE noticia_id = 3;

INSERT INTO tags(nome)
VALUES
    ('Desporto'),
    ('Nacional'),
    ('Local'),
    ('Mundo');

DELETE FROM tags
WHERE tag_id = 2;

INSERT INTO comentarios (author_id,noticias_id,comentario)
VALUES
  (3,3,'mi felis, adipiscing fringilla, porttitor'),
  (3,4,'Nulla tempor augue ac ipsum. Phasellus vitae mauris'),
  (1,4,'nibh. Phasellus nulla. Integer vulputate,'),
  (1,1,'Morbi non sapien molestie orci'),
  (1,3,'turpis vitae');

INSERT INTO noti_tags(noticias_id, tag_id)
VALUES
    (1,2),
    (2,1),
    (3,1),
    (4,3),
    (5,4);

INSERT INTO seguir(users_id, follow_id)
VALUES
    (1,3),
    (3,2),
    (4,1),
    (3,1);

INSERT INTO texto_report(report)
VALUES
    ('O utilizador foi agressivo com outro e além de ser agressivo tentou ameaçar diversos utilizadores');

INSERT INTO report_u(author_id, users_id, tipo_rep)
VALUES
    (3,2,1);


INSERT INTO faq(author_id, question, answer)
VALUES 
    (2, 'Como inserir uma notícia ?', 'Nulla tempor augue ac ipsum. Phasellus vitae mauris');
s