
create database sampleCode;
CREATE TABLE Customer (
    id int primary key auto_increment,
    name varchar(255),
    phone varchar(255),
	email varchar(255),
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL
);
