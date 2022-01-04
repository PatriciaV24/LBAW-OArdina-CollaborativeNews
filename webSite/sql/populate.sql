INSERT INTO utilizador (nome,email,password,foto,contacto)
VALUES
  ('Ricardo Gomes','rgomes@hotmail.com','legionario','/src/photos/test.jpg',935978945),
  ('Nuno Gaspar','gaspa2000.nuno@icloud.edu','password123','/src/photos/test1.jpg',963390475),
  ('Sara Cardoso','sc5298@aol.org','ricardo','/src/photos/test2.jpg',915684578),
  ('Francisco Ribero','ribs.chics@outlook.net','19990502','/src/photos/test3.jpg',925567441),
  ('Carolina Antunes','carolina.antunes.official@protonmail.org','superstar','/src/photos/test4.jpg',911156632);

/*Criar um administrador*/
UPDATE utilizador 
SET permissao = 'a' 
WHERE id = 2;

/*Criar um user banido*/
UPDATE utilizador 
SET permissao = 'b'
WHERE id = 5;

INSERT INTO noticia(autor_id,titulo,descricao)
VALUES
  (3,'Mulher perde cão em Lisboa','Luía Ferreira, separa-se de Bolinhas em pleno Rossio, na manhã desta quarta feira. A policia já tomou conta do caso.'),
  (3,'Joaquim Messias vai treinar o Oliveirense','O treinador Alentejano assina por dois anos com o atual décimo classificado'),
  (2,'Os preços dos combustíveis sobem mais uma vez','É já o quinto aumento desde o início do ano. Espera-se uma redução da gasolina no próximo trimestre. '),
  (4,'Faculdade de Ciências considerada a melhor de Portugal','Pelo quarto ano consecutivo, a Faculdade de Ciências é eleita a facudade de maior sucesso no país.'),
  (2,'Ataques Russos em Miami','João Bidão condena a destruição massiva e promete retaliação muito brevemente.');

UPDATE noticia 
SET titulo = 'Porto é campeão nacional!'
WHERE id = 3;

INSERT INTO tag(nome)
VALUES
    ('Desporto'),
    ('Nacional'),
    ('Local'),
    ('Mundo');

UPDATE tag 
SET prioridade=1
WHERE nome = 'Nacional'; 

DELETE FROM tag
WHERE id = 2;

INSERT INTO comentario(autor_id,not_id,texto)
VALUES
  (3,3,'Isto está uma vergonha. Mas eu como meto sempre 20€ não me faz muita diferença.'),
  (3,4,'Cá para mim isso foi minado...'),
  (1,4,'Parabéns aos nossos cientistas portugueses!!!'),
  (1,1,'Espero que o encontrem depressa.'),
  (4,5,'Ouvi dizer que els estão a prepar 4 bombas atómicas.');

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA comentario*/
/*autor_id -> é o autor da noticia da not_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_comentario(autor_id,com_id)
VALUES
    (3,1),
    (3,2),
    (1,3),
    (1,4),
    (4,5);


INSERT INTO categoria(not_id, tag_id)
VALUES
    (1,3),
    (2,1),
    (3,3),
    (4,3),
    (5,4);

INSERT INTO faq(autor_id, questao, resposta)
VALUES 
    (2, 'Como inserir uma notícia ?', 'Na pagina inicial clique no botão + e de seguida escreva o titulo e a noticia nas caixas que vao aparecer. De seguida selecione a categoria da noticia e clique publicar.');


INSERT INTO imagem(legenda,imag_path,not_id)
VALUES
    ('Bolinhas com a dona','/src/photos/test5.jpg',1),
    ('Joaquim Messias com o Presidente do Oliveirense','/src/photos/test6.jpg',2),
    ('Fila de carros na bomba para abastecer antes da subida de preços','/src/photos/test7.jpg',3),
    ('Departamento de ciências dos computadores da Faculdade de Ciências da UP','/src/photos/test8.jpg',4),
    ('Exibição de equipamento bélico americano','/src/photos/test9.jpg',5);
    

INSERT INTO vot_com(com_id,autor_id,tipo)
VALUES 
    (1,1,'dislike'),
    (1,2,'dislike'),
    (3,2,'like'),
    (3,4,'like'),
    (2,1,'dislike'),
    (5,3,'like');

        
/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA vot_com*/
/*autor_id -> é o autor do comentário da com_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_vot_com(autor_id,voto_id)
VALUES 
    (3,1),
    (3,2),
    (1,3),
    (1,4),
    (3,5),
    (4,6);

INSERT INTO vot_not(not_id,autor_id,tipo)
VALUES
    (3,3,'dislike'),
    (4,3,'dislike'),
    (2,4,'like'),
    (4,5,'like'),
    (2,1,'dislike'),
    (5,3,'like');


/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA vot_not*/
/*autor_id -> é o autor da noticia da not_id (QUE RECEBE A NOTIFICAÇAO)*/
INSERT INTO n_vot_not(autor_id,voto_id)
VALUES
    (2,1),
    (4,2),
    (3,3),
    (4,4),
    (3,5),
    (2,6);

INSERT INTO fav_not(autor_id,not_id)
VALUES  
    (5,4),
    (3,4);
     

INSERT INTO fav_com(autor_id,comentario_id)
VALUES
    (3,4),
    (5,3);


INSERT INTO fav_tag(autor_id,tag_id)
VALUES
    (1,1),
    (3,4);
INSERT INTO info_seguidor(followed_id, infos_id)
VALUES
    (1,3),
    (3,2),
    (4,1),
    (3,1);

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA info_seguidor*/
INSERT INTO n_seguidor(followed_id,infos_id)
VALUES 
    (1,3),
    (3,2),
    (4,1),
    (3,1);
    
INSERT INTO texto_report(report)
VALUES
    ('O utilizador foi agressivo com outro e além de ser agressivo tentou ameaçar diversos utilizadores');

INSERT INTO report_u(autor_id, uti_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO report_u(autor_id, uti_id, tiporesp_id, resolvido)
VALUES
    (3,2,1,TRUE);

/*VALUES TEM DE SER IGUAIS AOS VALUES DA TABELA report_u MAS com resolvido a TRUE*/
INSERT INTO n_uti_bloq (bloq_id, motivo)
VALUES (2,'Agressividade nos comentarios.');

INSERT INTO report_n(autor_id, not_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO report_c(autor_id, comentario_id, tiporesp_id)
VALUES
    (3,2,1);

INSERT INTO publicidade(imagem)
VALUES 
    ('/src/photos/test10.jpg'),
    ('/src/photos/test11.jpg'),
    ('/src/photos/test12.jpg');

