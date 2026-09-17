CREATE TABLE painelhigor (
  idpainelhigor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nome VARCHAR(50)  NULL  ,
  datainicio DATETIME  NULL  ,
  datafim DATETIME  NULL    ,
PRIMARY KEY(idpainelhigor));



CREATE TABLE machigor (
  idmachigor VARCHAR(17)  NOT NULL  ,
  nome VARCHAR(50)  NULL  ,
  ativo BOOL  NULL    ,
PRIMARY KEY(idmachigor));



CREATE TABLE ledhigor (
  idledhigor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  pinor INTEGER UNSIGNED  NULL  ,
  pinog INTEGER UNSIGNED  NULL  ,
  pinob INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(idledhigor));



CREATE TABLE painelhigor_has_machigor (
  painelhigor_idpainelhigor INTEGER UNSIGNED  NOT NULL  ,
  machigor_idmachigor VARCHAR(17)  NOT NULL  ,
  ledhigor_idledhigor INTEGER UNSIGNED  NOT NULL  ,
  ledr INTEGER UNSIGNED  NULL  ,
  ledg INTEGER UNSIGNED  NULL  ,
  ledb INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(painelhigor_idpainelhigor, machigor_idmachigor)  ,
INDEX painelhigor_has_machigor_FKIndex1(painelhigor_idpainelhigor)  ,
INDEX painelhigor_has_machigor_FKIndex2(machigor_idmachigor)  ,
INDEX painelhigor_has_machigor_FKIndex3(ledhigor_idledhigor),
  FOREIGN KEY(painelhigor_idpainelhigor)
    REFERENCES painelhigor(idpainelhigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(machigor_idmachigor)
    REFERENCES machigor(idmachigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(ledhigor_idledhigor)
    REFERENCES ledhigor(idledhigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




