CREATE DATABASE IF NOT EXISTS marketplace_pi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE marketplace_pi;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','vendedor','comprador') NOT NULL DEFAULT 'comprador',
    blink_galaxy TINYINT(1) NOT NULL DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_original DECIMAL(10,2) DEFAULT NULL,
    descuento INT NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    vendedor VARCHAR(120) NOT NULL DEFAULT 'MercaShop',
    imagen VARCHAR(255) DEFAULT NULL,
    badge VARCHAR(50) DEFAULT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(128) NOT NULL,
    usuario_id INT DEFAULT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    agregado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY session_producto (session_id, producto_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ordenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado ENUM('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
    direccion TEXT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orden_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orden_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT IGNORE INTO usuarios (nombre, email, password, rol, blink_galaxy) VALUES
('Admin Local', 'admin@mercashop.local', '$2y$10$KwiFO30Mdh1zAlCbB6xPLuHysNMkMCBZg3atf5lIrnugpNBFzJ3EW', 'admin', 1),
('Usuario Demo', 'cliente@mercashop.local', '$2y$10$KwiFO30Mdh1zAlCbB6xPLuHysNMkMCBZg3atf5lIrnugpNBFzJ3EW', 'comprador', 0);

INSERT IGNORE INTO categorias (nombre, slug) VALUES
('Tecnología', 'tech'),
('Moda', 'moda'),
('Hogar', 'hogar'),
('Deporte', 'deporte'),
('Gaming', 'gaming');

INSERT IGNORE INTO productos (categoria_id, nombre, descripcion, precio, precio_original, descuento, stock, vendedor, imagen, badge) VALUES
(1, 'Teléfono Pocket Pro', 'Celular ligero para la red local con excelente batería.', 11999.00, 13999.00, 14, 12, 'PiStore', NULL, 'Hot'),
(1, 'Auriculares Inalámbricos', 'Sonido claro y cancelación de ruido para reuniones remotas.', 2999.00, 3999.00, 25, 18, 'AudioLab', NULL, 'Sale'),
(2, 'Zapatillas Urbanas', 'Calzado deportivo con amortiguación extra.', 2499.00, 2999.00, 16, 24, 'DeporteMax', NULL, 'Nuevo'),
(3, 'Lámpara LED Smart', 'Luz inteligente ideal para estudio y oficina.', 899.00, 1099.00, 18, 30, 'HogarPlus', NULL, ''),
(4, 'Bicicleta Estática', 'Ejercita en casa con pantalla de entrenamiento.', 7599.00, 8999.00, 15, 10, 'FitHome', NULL, 'Hot');
