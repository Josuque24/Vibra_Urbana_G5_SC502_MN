
-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS vibra_urbana;
USE vibra_urbana;

-- Tabla cliente
CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    usuario VARCHAR(50) UNIQUE,
    contrasenia VARCHAR(255)
);

-- Tabla categoria_producto
CREATE TABLE categoria_producto (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

-- Tabla subcategoria_producto
CREATE TABLE subcategoria_producto (
    id_subcategoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria)
);

-- Tabla producto
CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10,2),   
    id_categoria INT,
    id_subcategoria INT,
    sexo char(1),
    imagen VARCHAR(255), 
    FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria),
    FOREIGN KEY (id_subcategoria) REFERENCES subcategoria_producto(id_subcategoria)
);

-- Tabla talla
CREATE TABLE talla (
    id_talla INT AUTO_INCREMENT PRIMARY KEY,
    talla VARCHAR(10)
);

-- Tabla producto_talla
CREATE TABLE producto_talla (
    id_producto INT,
    id_talla INT,
    cantidad_disponible INT,
    PRIMARY KEY (id_producto, id_talla),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (id_talla) REFERENCES talla(id_talla)
);

-- Tabla carrito
CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

-- Tabla carrito_detalle
CREATE TABLE carrito_detalle (
    id_carrito INT,
    id_producto INT,
    id_talla INT,
    cantidad INT,
    PRIMARY KEY (id_carrito, id_producto, id_talla),
    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (id_talla) REFERENCES talla(id_talla)
);
