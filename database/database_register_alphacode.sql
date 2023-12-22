create database register_alphacode;

use register_alphacode;

create table signup_user (
    id int auto_increment primary key,
    name varchar(255) not null,
    email varchar(255) not null,
    date_of_birth varchar(10) not null,
    contact_phone  varchar(25),
    occupation  varchar(100),
    contact_cellphone varchar(25) not null
);
