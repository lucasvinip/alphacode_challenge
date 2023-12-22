show databases;

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

insert into signup_user (
	 name,
	 email,
	 date_of_birth,
	 contact_phone,
	 occupation,
	 contact_cellphone
 )
values (
		'Daniella Dias',
		 'daniellapereira207@gmail.com',
		 '1990-05-01',
		 '',
		 'TSB',
		 '11975936195'
 );
insert into signup_user (
	 name,
	 email,
	 date_of_birth,
	 contact_phone,
	 occupation,
	 contact_cellphone
 )
values (
		'Lucas Pereira',
		 'l.vinicius1577@gmail.com',
		 '2004-02-19',
		 '',
		 'Dev',
		 '11987654321'
 );

DROP TABLE signup_user;

select * from signup_user where id = 5;

select * from signup_user;

delete from signup_user where id = 1;

update signup_user
set
    occupation = 'ASB'
WHERE
    id = 3;