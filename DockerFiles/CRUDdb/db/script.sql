CREATE DATABASE hospital;
USE hospital;

CREATE TABLE pacientes(
	id_paciente			int			auto_increment PRIMARY KEY,
    nombre				varchar(50)	NOT NULL,
    fecha				date		NULL,
    fecha_nac			date		NULL,
    edad				int			NULL,
    genero				char		NOT NULL,
    ocupacion			varchar(20)	NULL,
    lateralidad			char		NOT NULL,
    nacionalidad		varchar(20)	NULL,
    religion			varchar(20)	NULL,
    domicilio			varchar(20)	NULL,
    telefono			varchar(20)	NULL,
    email				varchar(40)	NULL,
    tel_emergencia		varchar(20)	NULL,
    con_emergencia		varchar(50)	NULL
);
