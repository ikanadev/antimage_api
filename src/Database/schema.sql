drop database if exists antimage;
CREATE DATABASE antimage DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
use antimage;
create table carrera(
  id integer not null auto_increment,
  nombre varchar(127),
  urlLogo varchar(255),
  descripcion varchar(255),
  primary key(id)
);
create table contacto(
  id integer not null auto_increment,
  carrera_id integer not null,
  valor varchar(127),
  tipo enum('correo', 'celular', 'correo'),
  nombre varchar(127),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table redSocial(
  id integer not null auto_increment,
  carrera_id integer not null,
  nombre enum('facebook', 'youtube', 'whatsapp', 'instagram', 'twitter', 'linkedin', 'twitch'),
  url varchar(127),
  texto varchar(127),
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
  nombre varchar(255),
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table menu(
  id integer not null auto_increment,
  carrera_id integer not null,
  nombre varchar(127),
  estado boolean,
  primary key(id),
  foreign key(carrera_id)
  references carrera(id)
  on delete cascade
);
create table submenu(
  id integer not null auto_increment,
  menu_id integer not null,
  nombre varchar(127),
  estado boolean,
  tipo enum('posts', 'page'),
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
  visible boolean,
  primary key(id),
  foreign key(post_id)
  references post(id)
  on delete cascade
);
create table admin(
  id integer not null auto_increment,
  nombres varchar(127),
  apellidos varchar(127),
  password varchar(255),
  correo varchar(127),
  tipo enum('admin', 'writer'),
  primary key(id)
);
insert into admin values (null, 'Admin', 'Administrator', '$2y$10$txZFHz7PqP1td1yeg.qYBuBtVy4CKvcGJfQQi2XNq/uMdKQjUCKxO', 'admin@admin.com', 'admin');
insert into carrera values (null,
  'Nombre Carrera',
  'https://img.clipartxtras.com/fe97cd12676ecc3e6f195f52cf6ff01c_building-logo-clipart-png-2-clipart-station-building-logo-clipart-png_389-346.png',
  'La Carrera de Ing. se especializa en formar los mejores profesionales en el area de LOREM IPSUM a nivel nacional');
