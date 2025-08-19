-- =========================================================
-- VIBRA_URBANA 
-- =========================================================

-- 1) Crear BD y usarla
CREATE DATABASE IF NOT EXISTS vibra_urbana
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_0900_ai_ci;
USE vibra_urbana;

-- 2) Limpiar si ya existía (orden correcto de dependencias)
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS carrito_detalle;
DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS producto_talla;
DROP TABLE IF EXISTS talla;
DROP TABLE IF EXISTS producto;
DROP TABLE IF EXISTS subcategoria_producto;
DROP TABLE IF EXISTS categoria_producto;
DROP TABLE IF EXISTS cliente;

SET FOREIGN_KEY_CHECKS = 1;

-- 3) Crear tablas
-- Tabla cliente
CREATE TABLE cliente (
    id_cliente     INT AUTO_INCREMENT PRIMARY KEY,
    nombre         VARCHAR(50)  NOT NULL,
    apellido       VARCHAR(50)  NOT NULL,
    usuario        VARCHAR(100) NOT NULL UNIQUE,
    contrasenia    VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla categoria_producto
CREATE TABLE categoria_producto (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla subcategoria_producto
CREATE TABLE subcategoria_producto (
    id_subcategoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(50) NOT NULL,
    id_categoria    INT NOT NULL,
    CONSTRAINT fk_subcat_cat
      FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla producto
CREATE TABLE producto (
    id_producto   INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(100) NOT NULL,
    descripcion   TEXT,
    precio        DECIMAL(10,2) NOT NULL,
    id_categoria  INT NOT NULL,
    id_subcategoria INT NOT NULL,
    sexo          CHAR(1) NOT NULL,
    imagen        VARCHAR(2048),
    CONSTRAINT chk_producto_sexo CHECK (sexo IN ('M','F','U')),
    CONSTRAINT fk_prod_cat
      FOREIGN KEY (id_categoria) REFERENCES categoria_producto(id_categoria)
      ON UPDATE CASCADE,
    CONSTRAINT fk_prod_subcat
      FOREIGN KEY (id_subcategoria) REFERENCES subcategoria_producto(id_subcategoria)
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Índices útiles para consultas por categoría/subcategoría
CREATE INDEX idx_producto_cat ON producto(id_categoria);
CREATE INDEX idx_producto_subcat ON producto(id_subcategoria);

-- Tabla talla
CREATE TABLE talla (
    id_talla INT AUTO_INCREMENT PRIMARY KEY,
    talla    VARCHAR(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla producto_talla (stock por talla)
CREATE TABLE producto_talla (
    id_producto         INT NOT NULL,
    id_talla            INT NOT NULL,
    cantidad_disponible INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id_producto, id_talla),
    CONSTRAINT fk_pt_producto
      FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
      ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pt_talla
      FOREIGN KEY (id_talla) REFERENCES talla(id_talla)
      ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla carrito (cabecera)
CREATE TABLE carrito (
    id_carrito     INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente     INT NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_carrito_cliente
      FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
      ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla carrito_detalle (líneas)
CREATE TABLE carrito_detalle (
    id_carrito  INT NOT NULL,
    id_producto INT NOT NULL,
    id_talla    INT NOT NULL,
    cantidad    INT NOT NULL,
    PRIMARY KEY (id_carrito, id_producto, id_talla),
    CONSTRAINT fk_cd_carrito
      FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito)
      ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_cd_producto
      FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
      ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_cd_talla
      FOREIGN KEY (id_talla) REFERENCES talla(id_talla)
      ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de mensajes de contacto
CREATE TABLE mensajes_contacto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  correo VARCHAR(100),
  mensaje TEXT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Cargar datos (en transacción)
START TRANSACTION;

-- Clientes
INSERT INTO cliente (nombre, apellido, usuario, contrasenia) VALUES
('Juan',   'Pérez',     'user1@mail.com', '$2y$10$pDKmQVIgLjR9AxyZd4aQmu0MKLo2lRn4284L4gRxwk754eMYLAHwK'),
('María',  'Gómez',     'user2@mail.com', '$2y$10$pDKmQVIgLjR9AxyZd4aQmu0MKLo2lRn4284L4gRxwk754eMYLAHwK'),
('Carlos', 'Rodríguez', 'user3@mail.com', '$2y$10$pDKmQVIgLjR9AxyZd4aQmu0MKLo2lRn4284L4gRxwk754eMYLAHwK'),
('Ana',    'Martínez',  'user4@mail.com', '$2y$10$pDKmQVIgLjR9AxyZd4aQmu0MKLo2lRn4284L4gRxwk754eMYLAHwK'),
('Luis',   'Hernández', 'user5@mail.com', '$2y$10$pDKmQVIgLjR9AxyZd4aQmu0MKLo2lRn4284L4gRxwk754eMYLAHwK');

-- Categorías
INSERT INTO categoria_producto (nombre) VALUES
('ropa'),
('accesorios'),
('trajes de baño');

-- Subcategorías
-- Ropa
INSERT INTO subcategoria_producto (nombre, id_categoria) VALUES
('camisetas', 1),
('shorts', 1),
('enterizos', 1),
('conjuntos', 1),
('crop tops', 1),
('vestidos', 1);
-- Accesorios
INSERT INTO subcategoria_producto (nombre, id_categoria) VALUES
('bolsos', 2),
('billeteras', 2),
('carteras', 2);
-- Trajes de baño
INSERT INTO subcategoria_producto (nombre, id_categoria) VALUES
('Bikinis', 3);

-- Tallas
INSERT INTO talla (talla) VALUES
('XS'), ('S'), ('M'), ('L'), ('unitalla');

-- Productos
-- Ropa - camisetas
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Camiseta Oversize Básica', 'Camiseta de algodón 100% oversize, corte unisex', 12990.00, 1, 1, 'U', 'https://dynamobrand.co/cdn/shop/files/DSC09323.jpg?v=1689611668'),
('Camiseta Crop Estampada', 'Camiseta ajustada con estampado urbano, corte femenino', 14990.00, 1, 1, 'F', 'https://i.pinimg.com/736x/ec/0f/d3/ec0fd32afdb9491609d9b18aa031f717.jpg');

-- Ropa - shorts
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Short Denim Destroyed', 'Short de jean con roturas y diseño desgastado', 19990.00, 1, 2, 'U', 'https://lrsa-media.lojasrenner.com.br/uri/medium_928140828_001_12_afd4af5e78.jpg'),
('Short Deportivo Running', 'Short ligero para deporte con bolsillos laterales', 17990.00, 1, 2, 'M', 'https://www.distritomoda.com.ar/sites/default/files/styles/producto_interior/public/imagenes/2512_short_con_bolsillo_england_002_1686063452.jpg?itok=g8C_qRiv');

-- Ropa - enterizos
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Enterizo Elegante', 'Enterizo de tirantes elegante', 29990.00, 1, 3, 'F', 'https://img.kwcdn.com/product/fancy/e2665ead-0de4-4dd3-805e-e1ebc09aa8e3.jpg?imageMogr2/auto-orient|imageView2/2/w/800/q/70/format/webp');

-- Ropa - conjuntos
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Conjunto 2 piezas blanco', 'Conjunto de 2 piezas blanco, la tela es súper rica y suavecita', 10000.00, 1, 4, 'F', 'https://img.ltwebstatic.com/images3_pi/2025/02/20/94/174004732215c4b53be417e756af2ccbed59229125_thumbnail_720x.jpg');

-- Ropa - crop tops
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Crop Top Básico Blanco croché', '1 pieza blanca, la tela es súper rica y suavecita', 15990.00, 1, 5, 'F', 'https://images-na.ssl-images-amazon.com/images/I/71Q6bXNo0aL._AC_UL600_SR600,600_.jpg');

-- Ropa - vestidos
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Vestido Strapless Floral', 'Vestido largo con estampado floral',  8990.00, 1, 6, 'F', 'https://m.media-amazon.com/images/I/51kC8kbLe4L._UY350_.jpg'),
('Vestido Casual Negro',   'Vestido corto flojo para ocasiones especiales', 31990.00, 1, 6, 'F', 'https://image.hm.com/assets/hm/3f/32/3f3230e62b85f886dc8b3cb367ca2e06e3aced53.jpg?imwidth=1260');

-- Accesorios - bolsos
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Bolso Turtle Minimalista', 'Bolso grande de tela resistente', 39990.00, 2, 7, 'F', 'https://ae01.alicdn.com/kf/S9fe5bfc73bc748fba44a0de416f279d8O.jpg_640x640q90.jpg'),
('Bolso negro playa', 'Bolso negro playa espacioso', 45990.00, 2, 7, 'U', 'https://img.ltwebstatic.com/images3_spmp/2024/05/05/ed/171489640629c0875bb156827b1304dbddfc36bc22_thumbnail_720x.jpg');

-- Accesorios - billeteras
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Billetera Slim Cuero', 'Billetera delgada de cuero genuino con ranuras para tarjetas', 24990.00, 2, 8, 'U', 'https://m.media-amazon.com/images/I/7158DKjQ6-L._AC_SL1500_.jpg'),
('Billetera RFID Segura', 'Billetera con protección contra clonación de tarjetas', 27990.00, 2, 8, 'U', 'https://oechsle.vteximg.com.br/arquivos/ids/16658393/image-bce0ce2ea2fd4fa49f5d7bb28cca391a.jpg?v=638346454740570000');

-- Accesorios - carteras (URLs de ejemplo)
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Cartera Bandolera Pequeña', 'Cartera cruzada con correa ajustable', 32990.00, 2, 9, 'F', 'https://cdn.gacel.cl/42520-superlarge_default/cartera-bandolera-pequena-negro-1709697.jpg'),
('Clutch Noche Dorado', 'Cartera de mano elegante para eventos formales', 28990.00, 2, 9, 'F', 'https://m.media-amazon.com/images/I/71hYPNC08OL._UY900_.jpg');

-- Trajes de baño
INSERT INTO producto (nombre, descripcion, precio, id_categoria, id_subcategoria, sexo, imagen) VALUES
('Bikini Floral Print', 'Bikini con estampado de flor de 2 piezas', 22990.00, 3, 10, 'F', 'https://img.ltwebstatic.com/v4/j/spmp/2025/03/20/22/1742471980f32ff1b0f143130db6f42380dc550fed_wk_1742472250_thumbnail_405x552.jpg'),
('Bikini Naranja Fluorescente', 'Bikini llamativo con diseño favorecedor', 24990.00, 3, 10, 'F', 'https://img.ltwebstatic.com/images3_pi/2022/03/03/1646280155fddbdb3c991584f19b2db0dcfeb25438_thumbnail_336x.jpg');

-- Stock por talla (producto_talla)
-- Camisetas (id_producto 1, 2)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(1, 5, 20), -- Camiseta Oversize Básica - unitalla
(2, 1,  8), -- Camiseta Crop Estampada - XS
(2, 2, 12); -- Camiseta Crop Estampada - S

-- Shorts (id_producto 3, 4)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(3, 2, 10), -- Short Denim Destroyed - S
(3, 3, 15), -- Short Denim Destroyed - M
(3, 4,  8), -- Short Denim Destroyed - L
(4, 2, 12), -- Short Deportivo Running - S
(4, 3, 18); -- Short Deportivo Running - M

-- Enterizos (id_producto 5)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(5, 2,  7), -- Enterizo Elegante - S
(5, 3, 10); -- Enterizo Elegante - M

-- Conjuntos (id_producto 6)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(6, 2,  5), -- Conjunto 2 piezas blanco - S
(6, 3,  8); -- Conjunto 2 piezas blanco - M

-- Crop tops (id_producto 7)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(7, 1,  6), -- Crop Top - XS
(7, 2, 10); -- Crop Top - S

-- Vestidos (id_producto 8, 9)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(8, 2,  8), -- Vestido Strapless Floral - S
(8, 3, 12), -- Vestido Strapless Floral - M
(9, 2,  6), -- Vestido Casual Negro - S
(9, 3,  9); -- Vestido Casual Negro - M

-- Accesorios unitalla (id_talla 5)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(10, 5, 20), -- Bolso Turtle Minimalista
(11, 5, 15), -- Bolso negro playa
(12, 5, 30), -- Billetera Slim Cuero
(13, 5, 25), -- Billetera RFID Segura
(14, 5, 12), -- Cartera Bandolera Pequeña
(15, 5,  8); -- Clutch Noche Dorado

-- Trajes de baño (id_producto 16, 17)
INSERT INTO producto_talla (id_producto, id_talla, cantidad_disponible) VALUES
(16, 2, 10), -- Bikini Floral Print - S
(16, 3, 15), -- Bikini Floral Print - M
(17, 2,  8), -- Bikini Naranja - S
(17, 3, 12); -- Bikini Naranja - M

-- Carritos y sus detalles
-- Usuario 1
INSERT INTO carrito (id_cliente) VALUES (1);
INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES
(1,  1, 5, 1),  -- Camiseta Oversize Básica (U)
(1,  2, 2, 1),  -- Camiseta Crop (S)
(1,  3, 3, 1),  -- Short Denim (M)
(1,  5, 3, 1),  -- Enterizo (M)
(1,  6, 3, 1),  -- Conjunto (M)
(1,  7, 2, 1),  -- Crop Top (S)
(1,  8, 3, 1),  -- Vestido Floral (M)
(1, 10, 5, 1),  -- Bolso Turtle (U)
(1, 12, 5, 1),  -- Billetera Slim (U)
(1, 16, 3, 1);  -- Bikini Floral (M)

-- Usuario 2
INSERT INTO carrito (id_cliente) VALUES (2);
INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES
(2, 4, 3, 1);   -- Short Deportivo Running (M)

-- Usuario 3
INSERT INTO carrito (id_cliente) VALUES (3);
INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES
(3, 9, 2, 1);   -- Vestido Casual Negro (S)

-- Usuario 4
INSERT INTO carrito (id_cliente) VALUES (4);
INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES
(4, 11, 5, 1);  -- Bolso negro playa (U)

-- Usuario 5
INSERT INTO carrito (id_cliente) VALUES (5);
INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES
(5, 17, 2, 1);  -- Bikini Naranja (S)

COMMIT;
