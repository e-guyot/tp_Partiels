create table user (
  id int primary key, 
  name varchar(255),
  username varchar(255),
  mail varchar(255),
  pwd varchar(255),
  id_role int,
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
  libelle varchar(255)
 );
  
