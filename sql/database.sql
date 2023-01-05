DROP DATABASE IF EXISTS pdv;
CREATE DATABASE pdv DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE pdv;

CREATE TABLE mainlevel(
    id int not null auto_increment primary key,
    alias varchar(255)
);

CREATE TABLE generaluser(
    id int not null auto_increment primary key,
    mainlevel int not null,
    fullname varchar(255),
    document varchar(255),
    email varchar(255),
    pass varchar(255),
    birthdate date,
    country varchar(255),
    state varchar(255),
    city varchar(255),
    street varchar(255),
    numberstreet varchar(255),
    postalcode varchar(255)
);

CREATE TABLE user_mainlevel(
    generaluser int,
    mainlevel int,
    foreign key (generaluser) references generaluser(id),
    foreign key (mainlevel) references mainlevel(id)
);

INSERT INTO mainlevel(id, alias) VALUES (4, "client"),
                                        (3, "balcony"),
                                        (2, "kitchen"),
                                        (1, "adm");

insert into generaluser(id, mainlevel, fullname) values(default, 1, "Matiolli");

insert into user_mainlevel(generaluser, mainlevel) values(1, 1);

select generaluser.id as "User ID", generaluser.fullname as "User Name", mainlevel.id as "Level ID", mainlevel.alias as "Level" from generaluser inner join user_mainlevel on generaluser.id = user_mainlevel.generaluser inner join mainlevel on mainlevel.id = user_mainlevel.mainlevel;

select * from generaluser;