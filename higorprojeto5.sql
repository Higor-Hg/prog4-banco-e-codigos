CREATE TABLE machigor (
  idmachigor VARCHAR(17)  NOT NULL  ,
  nome VARCHAR(50)  NULL  ,
  ativo BOOL  NULL    ,
PRIMARY KEY(idmachigor));



CREATE TABLE painelhigor (
  idpainelhigor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  nome VARCHAR(50)  NULL  ,
  datainicio DATETIME  NULL  ,
  datafim DATETIME  NULL    ,
PRIMARY KEY(idpainelhigor));



CREATE TABLE ledhigor (
  idledhigor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  pinor INTEGER UNSIGNED  NULL  ,
  pinog INTEGER UNSIGNED  NULL  ,
  pinob INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(idledhigor));



CREATE TABLE combinahigor (
  idcombinahigor INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  painelhigor_idpainelhigor INTEGER UNSIGNED  NOT NULL  ,
  ledhigor_idledhigor INTEGER UNSIGNED  NOT NULL  ,
  machigor_idmachigor VARCHAR(17)  NOT NULL  ,
  ledr INTEGER UNSIGNED  NULL  ,
  ledg INTEGER UNSIGNED  NULL  ,
  ledb INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(idcombinahigor)  ,
INDEX combinahigor_FKIndex1(machigor_idmachigor)  ,
INDEX combinahigor_FKIndex2(ledhigor_idledhigor)  ,
INDEX combinahigor_FKIndex3(painelhigor_idpainelhigor),
  FOREIGN KEY(machigor_idmachigor)
    REFERENCES machigor(idmachigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(ledhigor_idledhigor)
    REFERENCES ledhigor(idledhigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(painelhigor_idpainelhigor)
    REFERENCES painelhigor(idpainelhigor)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




