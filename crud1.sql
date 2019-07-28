create database tienda;
use tienda;

create table orders(
	id int not null auto_increment primary key,
	customer_name varchar(80) not null,
	customer_email varchar(120) not null,
	customer_movil varchar(40) not null,
	status varchar(20) not null,
	created_at datetime not null,
	updated_at datetime not null
);