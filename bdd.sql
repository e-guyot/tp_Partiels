create table user (
  id int primary key, 
  name varchar(255) NOT NULL,
  username varchar(255),
  mail varchar(255),
  pwd varchar(255) NOT NULL,
  id_role int NOT NULL,
  FOREIGN KEY (id_role) REFERENCES role(id)
);
// pwd ==> password doit être protégé par password_hash

create table contenu(
  id int primary key,
  libelle varchar(255),
  id_user int,
  FOREIGN KEY (id_user) REFERENCES user(id)
 );
 
 create table role (
  id int primary key,
  libelle varchar(255),
  desc varchar(255)
 );
  
insert into role(libelle, desc)  values 
('ROLE_ADMIN', 'admin, tous les droits'),
('ROLE_COM', 'communication'),
('ROLE_REVIEW', 'reviewer'),
('ROLE_USER', 'membre');
