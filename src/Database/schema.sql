drop database if exists antimage;
CREATE DATABASE antimage DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
use antimage;
create table carrera(
  id integer not null auto_increment,
  nombre varchar(127),
  urlLogo varchar(255),
  primary key(id)
);
create table nroReferencia(
  id integer not null auto_increment,
  carrera_id integer not null,
  nro varchar(127),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table carousel(
  id integer not null auto_increment,
  carrera_id integer not null,
  titulo varchar(127),
  descripcion varchar(255),
  urlImg varchar(255),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table enlacesExternos(
  id integer not null auto_increment,
  carrera_id integer not null,
  urlEnlace varchar(127),
  descripcion varchar(255),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table menu(
  id integer not null auto_increment,
  carrera_id integer not null,
  nombre varchar(127),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table submenu(
  id integer not null auto_increment,
  menu_id integer not null,
  nombre varchar(127),
  primary key(id),
  foreign key(menu_id)
  references menu(id)
  on delete cascade
);
create table post(
  id integer not null auto_increment,
  submenu_id integer,
  titulo varchar(127),
  cuerpo LONGTEXT,
  publicado boolean,
  fecha date,
  hora time,
  tipo ENUM('post', 'page'),
  primary key(id)
);
create table comentario(
  id integer not null,
  post_id integer not null,
  comentario_id integer,
  texto text,
  fecha date,
  hora time,
  primary key(id),
  foreign key(post_id)
  references post(id)
  on delete cascade
);
create table admin(
  id integer not null auto_increment,
  nombres varchar(127),
  apellidos varchar(127),
  psswrd varchar(255),
  correo varchar(127),
  tipo enum('admin', 'writer'),
  primary key(id)
);
