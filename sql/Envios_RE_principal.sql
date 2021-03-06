drop database if exists Envios_RE_principal;
create database Envios_RE_principal;
use Envios_RE_principal;

drop table if exists usuarios;
drop table if exists cuentas_bancarias;
drop table if exists consultas_tasa_diaria;
drop table if exists transacciones_realizadas;
drop table if exists formularios;

create table usuarios(
    email VARCHAR(225) NOT NULL,
    passwrd VARCHAR(1000),
    nombre VARCHAR(225),
    apellidos VARCHAR(225),
    telefono INT(13),
    PRIMARY KEY (email) 

) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table cuentas_bancarias(
    cuentaBancaria VARCHAR(225),
    pais VARCHAR(225),
    banco VARCHAR(225),
    email VARCHAR(225) NOT NULL,
    PRIMARY KEY (cuentaBancaria, email),
    CONSTRAINT FK_usuarioscuentas FOREIGN KEY (email)
    REFERENCES usuarios(email)

) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table consultas_tasa_diaria(
    ID_consulta INT UNSIGNED AUTO_INCREMENT  NOT NULL,
    monedaOrigen VARCHAR(225),
    monedaDestino VARCHAR(225),
    horaConsulta VARCHAR(225),
    horaConsultaFinalizacion VARCHAR(225),
    cantidad FLOAT,
    cantidadTransformada FLOAT,
    email VARCHAR(225) NOT NULL,
    PRIMARY KEY (ID_consulta),
    CONSTRAINT FK_usuariosconsultas FOREIGN KEY (email)
    REFERENCES usuarios(email)

) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table transacciones_realizadas(
    ID_transaccion INT UNSIGNED AUTO_INCREMENT  NOT NULL,
    fechaTransaccion VARCHAR(225),
    cuentaBancariaDestino VARCHAR(225),
    lugarTransaccion VARCHAR(225),
    telefonoReceptor INT(13),
    cantidad FLOAT,
    PRIMARY KEY (ID_transaccion),
    email VARCHAR(225) NOT NULL,
    cuentaBancaria VARCHAR(225),
    CONSTRAINT FK_consultasusuario FOREIGN KEY (email)
    REFERENCES usuarios(email),
    CONSTRAINT FK_consultascuentabancaria FOREIGN KEY (cuentaBancaria)
    REFERENCES cuentas_bancarias(cuentaBancaria)

) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table formularios(
    ID_formulario INT UNSIGNED AUTO_INCREMENT  NOT NULL,
    nombreApellido VARCHAR(225),
    correo VARCHAR(225),
    telefono INT(13),
    mensaje VARCHAR(1500),
    fechaMensaje VARCHAR(225),
    PRIMARY KEY (ID_formulario)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;