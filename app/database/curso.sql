BEGIN TRANSACTION;

CREATE TABLE categoria (
  id INTEGER PRIMARY KEY NOT NULL,
  nome VARCHAR(200)
);

INSERT INTO categoria VALUES(1,'Frequente');
INSERT INTO categoria VALUES(2,'Casual');
INSERT INTO categoria VALUES(3,'Varejista');

CREATE TABLE estado (
  id INTEGER PRIMARY KEY NOT NULL,
  nome VARCHAR(200)
);

INSERT INTO estado VALUES(1,'RS');
INSERT INTO estado VALUES(2,'SP');

CREATE TABLE cidade (
  id INTEGER PRIMARY KEY NOT NULL,
  nome VARCHAR(200),
  estado_id INTEGER NOT NULL,
  FOREIGN KEY(estado_id) REFERENCES estado(id)
);

INSERT INTO cidade VALUES(1,'Lajeado',1);
INSERT INTO cidade VALUES(2,'Porto Alegre',1);
INSERT INTO cidade VALUES(3,'Caxias do Sul',1);
INSERT INTO cidade VALUES(4,'São Paulo',2);
INSERT INTO cidade VALUES(5,'Osasco',2);

CREATE TABLE habilidade (
  id INTEGER PRIMARY KEY NOT NULL,
  nome VARCHAR(200)
);

INSERT INTO habilidade VALUES(1,'Leitura');
INSERT INTO habilidade VALUES(2,'Escrita');
INSERT INTO habilidade VALUES(3,'Comunicação');
INSERT INTO habilidade VALUES(4,'Criatividade');
INSERT INTO habilidade VALUES(5,'Relações');
INSERT INTO habilidade VALUES(6,'Organização');
INSERT INTO habilidade VALUES(7,'Liderança');

CREATE TABLE cliente (
  id INTEGER PRIMARY KEY NOT NULL, 
  nome VARCHAR(200), 
  endereco VARCHAR(200), 
  telefone VARCHAR(200), 
  nascimento DATE, 
  situacao CHAR(1), 
  email VARCHAR(200), 
  genero CHAR(1), 
  categoria_id INTEGER NOT NULL, 
  cidade_id INTEGER NOT NULL,
  created_at timestamp,
  updated_at timestamp, 
  FOREIGN KEY(cidade_id)    REFERENCES cidade(id), 
  FOREIGN KEY(categoria_id) REFERENCES categoria(id) 
);

INSERT INTO cliente VALUES(1,'Al Green','Rua do Al Green','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',2,3,NULL,'2019-05-19 16:30:06');
INSERT INTO cliente VALUES(2,'Amy Winehouse','Rua do Amy Winehouse','555 4444 8888','1990-01-01','Y','contato@gmail.com','F',1,4,NULL,NULL);
INSERT INTO cliente VALUES(3,'Aretha Franklin','Rua do Aretha Franklin','555 4444 8888','1990-01-01','Y','contato@gmail.com','F',1,4,NULL,NULL);
INSERT INTO cliente VALUES(4,'B B King','Rua do B B King','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,4,NULL,NULL);
INSERT INTO cliente VALUES(5,'Bob Dylan','Rua do Bob Dylan','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,4,NULL,NULL);
INSERT INTO cliente VALUES(6,'Bob Marley','Rua do Bob Marley','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,'2019-05-19 16:29:22');
INSERT INTO cliente VALUES(7,'Bono Vox','Rua do Bono Vox','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(8,'Bruce Springsteen','Rua do Bruce Springsteen','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(9,'Chuck Berry','Rua do Chuck Berry','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(10,'Dave Grohl','Rua do Dave Grohl','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(11,'Dave Hole','Rua do Dave Hole','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(12,'David Bowie','Rua do David Bowie','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(13,'Dionne warwick','Rua do Dionne warwick','555 4444 8888','1990-01-01','Y','contato@gmail.com','F',1,2,NULL,NULL);
INSERT INTO cliente VALUES(14,'Elton John','Rua do Elton John','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(15,'Elvis Presley','Rua do Elvis Presley','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(16,'Etta James','Rua do Etta James','555 4444 8888','1990-01-01','N','contato@gmail.com','F',1,3,NULL,NULL);
INSERT INTO cliente VALUES(17,'Fernando Noronha','Rua do Fernando Noronha','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(18,'Frank Sinatra','Rua do Frank Sinatra','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(19,'Freddie mercury','Rua do Freddie mercury','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(20,'George Thorogood','Rua do George Thorogood','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(21,'Buddy Guy','Rua do Buddy Guy','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(22,'Herbert Vianna','Rua do Herbert Vianna','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(23,'Humberto Gessinger','Rua do Humberto Gessinger','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(24,'Janis Joplin','Rua do Janis Joplin','555 4444 8888','1990-01-01','Y','contato@gmail.com','F',1,1,NULL,NULL);
INSERT INTO cliente VALUES(25,'John Fogerty','Rua do John Fogerty','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,3,NULL,NULL);
INSERT INTO cliente VALUES(26,'John Lennon','Rua do John Lennon','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(27,'Johnny Cash','Rua do Johnny Cash','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(28,'Kurt Cobain','Rua do Kurt Cobain','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(29,'Marvin Gaye','Rua do Marvin Gaye','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(30,'Neil Yuoung','Rua do Neil Yuoung','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(31,'Otis Redding','Rua do Otis Redding','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(32,'Paul McCartney','Rua do Paul McCartney','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(33,'Paul Simon','Rua do Paul Simon','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(34,'Raul Seixas','Rua do Raul Seixas','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(35,'Ray Charles','Rua do Ray Charles','555 4444 8888','1990-01-01','Y','contato@gmail.com','M',1,4,NULL,NULL);
INSERT INTO cliente VALUES(36,'Renato Russo','Rua do Renato Russo','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,2,NULL,NULL);
INSERT INTO cliente VALUES(37,'Roy Orbison','Rua do Roy Orbison','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,4,NULL,NULL);
INSERT INTO cliente VALUES(38,'Stevie Wonder','Rua do Stevie Wonder','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,NULL);
INSERT INTO cliente VALUES(39,'Willie Nelson','Rua do Willie Nelson','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,4,NULL,NULL);
INSERT INTO cliente VALUES(40,'Wilson Pickett','Rua do Wilson Pickett','555 4444 8888','1990-01-01','N','contato@gmail.com','M',1,1,NULL,'2019-05-19 16:19:18');

CREATE TABLE contato (
  id INTEGER PRIMARY KEY NOT NULL, 
  tipo VARCHAR(200), 
  valor VARCHAR(200), 
  cliente_id INTEGER NOT NULL, 
  FOREIGN KEY(cliente_id) REFERENCES cliente(id) 
);

INSERT INTO contato VALUES(1,'phone','78 2343-4545',4);
INSERT INTO contato VALUES(2,'phone','78 9494-0404',4);
INSERT INTO contato VALUES(3,'phone','78 2343-4545',4);
INSERT INTO contato VALUES(4,'phone','78 9494-0404',4);
INSERT INTO contato VALUES(5,'face','www.fb.com/john',1);
INSERT INTO contato VALUES(6,'twitter','twitter.com/mary',1);
INSERT INTO contato VALUES(7,'email','andrei@gmail.com',1);

CREATE TABLE cliente_habilidade (
  id INTEGER PRIMARY KEY NOT NULL, 
  cliente_id INTEGER NOT NULL, 
  habilidade_id INTEGER NOT NULL, 
  FOREIGN KEY(cliente_id) REFERENCES cliente(id), 
  FOREIGN KEY(habilidade_id)    REFERENCES habilidade(id) 
);

INSERT INTO cliente_habilidade VALUES(61,4,1);
INSERT INTO cliente_habilidade VALUES(62,4,2);
INSERT INTO cliente_habilidade VALUES(66,6,5);
INSERT INTO cliente_habilidade VALUES(67,6,7);
INSERT INTO cliente_habilidade VALUES(68,1,1);
INSERT INTO cliente_habilidade VALUES(69,1,2);
INSERT INTO cliente_habilidade VALUES(70,1,4);

CREATE TABLE produto(
  id INTEGER PRIMARY KEY NOT NULL,
  descricao VARCHAR(200),
  estoque float,
  preco_venda float,
  unidade VARCHAR(200),
  local_foto text
);

INSERT INTO produto VALUES(1,'Pendrive 512Mb',10.0,57.60000000000000142,'PC','files/imagems/1/pendrive.jpg');
INSERT INTO produto VALUES(2,'HD 120 GB',20.0,179.99999999999999999,'PC','files/imagems/2/hd.jpg');
INSERT INTO produto VALUES(3,'SD CARD  512MB',4.0,35.0,'PC','files/imagems/3/sdcard.jpg');
INSERT INTO produto VALUES(4,'SD CARD 1GB MINI',3.0,40.0,'PC','files/imagems/4/sdcard.jpg');
INSERT INTO produto VALUES(5,'CAM. PHOTO I70 Silver',5.0,900.0,'PC','files/imagems/5/camera.jpg');
INSERT INTO produto VALUES(6,'CAM. PHOTO DSC-W50 Silver',4.0,700.0,'PC','files/imagems/6/camera.jpg');
INSERT INTO produto VALUES(7,'WEBCAM INSTANT VF0040SP',4.0,80.0,'PC','files/imagems/7/webcam.jpg');
INSERT INTO produto VALUES(8,'CPU 775 CEL.D 360 3.46 533M',10.0,300.0,'PC',NULL);
INSERT INTO produto VALUES(9,'Recorder DCR-DVD108',2.0,1399.9999999999999999,'PC',NULL);
INSERT INTO produto VALUES(10,'HD IDE  80G 7.200',8.0,160.0,'PC','files/imagems/10/hd.jpg');
INSERT INTO produto VALUES(11,'Printer LASERJET 1018 USB 2.0',4.0,300.0,'PC','files/imagems/11/c05944349.png');
INSERT INTO produto VALUES(12,'DDR 512MB 400MHZ PC3200',10.0,100.0,'PC',NULL);
INSERT INTO produto VALUES(13,'DDR2 1024MB 533MHZ PC4200',5.0,170.0,'PC',NULL);
INSERT INTO produto VALUES(14,'MONITOR LCD 19',2.0,800.0,'PC','files/imagems/14/jpg.jpeg');
INSERT INTO produto VALUES(15,'MOUSE USB OMC90S OPT.',10.0,40.0,'PC','files/imagems/15/download.jpeg');
INSERT INTO produto VALUES(16,'NB DV6108 CS 1.86/512/80/DVD',2.0,2500.0,'PC',NULL);
INSERT INTO produto VALUES(17,'NB N220E/B DC 1.6/1/80/DVD',3.0,3400.0,'PC',NULL);
INSERT INTO produto VALUES(18,'CAM. PHOTO DSC-W90 Silver',5.0,1200.0,'PC',NULL);
INSERT INTO produto VALUES(19,'CART. 8767 black',20.0,50.0,'PC',NULL);
INSERT INTO produto VALUES(20,'CD-R TUBE DE 100 52X 700MB',20.0,60.0,'PC',NULL);
INSERT INTO produto VALUES(21,'DDR 1024MB 400MHZ PC3200',7.0,150.0,'PC',NULL);
INSERT INTO produto VALUES(22,'MOUSE PS2 A7 Blue',20.0,15.0,'PC','');
INSERT INTO produto VALUES(23,'SPEAKER AS-5100 White',5.0,179.99999999999999999,'PC',NULL);
INSERT INTO produto VALUES(24,'Keyb. USB AK-806',13.999999999999999999,40.0,'PC',NULL);

CREATE TABLE produto_imagem (
	id INTEGER PRIMARY KEY NOT NULL,
	produto_id integer references produto(id),
	imagem text
);

INSERT INTO produto_imagem VALUES(1,1,'files/imagems/1/libreoffice-oasis-text-template.png');
INSERT INTO produto_imagem VALUES(2,1,'files/imagems/1/libreoffice-oasis-web-template.png');

CREATE TABLE venda (
  id INTEGER PRIMARY KEY NOT NULL,
  dt_venda date,
  total float,
  cliente_id int,
  obs text,
  FOREIGN KEY(cliente_id) REFERENCES cliente(id)
);

INSERT INTO venda VALUES(1,'2015-03-14',505.00000000000000001,1,'');
INSERT INTO venda VALUES(2,'2015-03-14',1945.0,2,'');
INSERT INTO venda VALUES(3,'2015-03-14',4880.0000000000000001,3,'');
INSERT INTO venda VALUES(4,'2015-03-14',1059.9999999999999999,4,'');
INSERT INTO venda VALUES(5,'2015-03-14',1889.9999999999999999,5,'');
INSERT INTO venda VALUES(6,'2015-03-14',12899.999999999999999,6,'');
INSERT INTO venda VALUES(7,'2015-03-14',619.99999999999999998,7,'');
INSERT INTO venda VALUES(8,'2015-03-14',494.99999999999999998,8,'');
INSERT INTO venda VALUES(9,'2015-10-26',79.0,1,'');
INSERT INTO venda VALUES(10,'2015-10-26',40.0,4,'teste');

CREATE TABLE venda_item (
  id INTEGER PRIMARY KEY NOT NULL,
  preco_venda float,
  quantidade float,
  desconto float,
  total float,
  produto_id int,
  venda_id int,
  FOREIGN KEY(produto_id) REFERENCES produto(id),
  FOREIGN KEY(venda_id) REFERENCES venda(id)
);

INSERT INTO venda_item VALUES(1,40.0,1.0,0.0,40.0,1,1);
INSERT INTO venda_item VALUES(2,179.99999999999999999,2.0,0.0,359.99999999999999999,2,1);
INSERT INTO venda_item VALUES(3,35.0,3.0,0.0,104.99999999999999999,3,1);
INSERT INTO venda_item VALUES(4,40.0,1.0,0.0,40.0,4,2);
INSERT INTO venda_item VALUES(5,900.0,2.0,0.0,1799.9999999999999999,5,2);
INSERT INTO venda_item VALUES(6,35.0,3.0,0.0,104.99999999999999999,3,2);
INSERT INTO venda_item VALUES(7,80.0,1.0,0.0,80.0,7,3);
INSERT INTO venda_item VALUES(8,300.0,2.0,0.0,600.0,8,3);
INSERT INTO venda_item VALUES(9,1399.9999999999999999,3.0,0.0,4199.9999999999999998,9,3);
INSERT INTO venda_item VALUES(10,160.0,1.0,0.0,160.0,10,4);
INSERT INTO venda_item VALUES(11,300.0,2.0,0.0,600.0,11,4);
INSERT INTO venda_item VALUES(12,100.0,3.0,0.0,300.0,12,4);
INSERT INTO venda_item VALUES(13,170.0,1.0,0.0,170.0,13,5);
INSERT INTO venda_item VALUES(14,800.0,2.0,0.0,1600.0,14,5);
INSERT INTO venda_item VALUES(15,40.0,3.0,0.0,120.0,15,5);
INSERT INTO venda_item VALUES(16,2500.0,1.0,0.0,2500.0,16,6);
INSERT INTO venda_item VALUES(17,3400.0,2.0,0.0,6800.0000000000000001,17,6);
INSERT INTO venda_item VALUES(18,1200.0,3.0,0.0,3599.9999999999999999,18,6);
INSERT INTO venda_item VALUES(19,50.0,1.0,0.0,50.0,19,7);
INSERT INTO venda_item VALUES(20,60.0,2.0,0.0,120.0,20,7);
INSERT INTO venda_item VALUES(21,150.0,3.0,0.0,450.0,21,7);
INSERT INTO venda_item VALUES(22,15.0,1.0,0.0,15.0,22,8);
INSERT INTO venda_item VALUES(23,179.99999999999999999,2.0,0.0,359.99999999999999999,23,8);
INSERT INTO venda_item VALUES(24,40.0,3.0,0.0,120.0,24,8);
INSERT INTO venda_item VALUES(25,40.0,2.0,1.0,79.0,1,9);
INSERT INTO venda_item VALUES(26,40.0,1.0,0.0,39.0,4,10);

CREATE VIEW view_vendas as 
        select
           id,
           nome,
           endereco,
           telefone,
           nascimento,
           situacao,
           email,
           genero,
           cidade_id,
           categoria_id,
           (
              select
                 sum(total) 
              from
                 venda 
              where
                 cliente_id = cliente.id
           )
           as total,
           (
              select
                 max(dt_venda) 
              from
                 venda 
              where
                 cliente_id = cliente.id
           )
           as last_date 
        from
           cliente;
COMMIT;
