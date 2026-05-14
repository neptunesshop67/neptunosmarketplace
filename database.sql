CREATE DATABASE IF NOT EXISTS hackathon_shop;
USE hackathon_shop;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cliente') DEFAULT 'cliente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    precio_original DECIMAL(10,2),
    descuento INT DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255),
    emoji VARCHAR(10),
    badge VARCHAR(50),
    categoria_id INT,
    vendedor VARCHAR(100) DEFAULT 'MercaShop',
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    metodo_envio VARCHAR(100) NOT NULL,
    estado ENUM('pendiente', 'pagado', 'enviado', 'entregado', 'cancelado') DEFAULT 'pendiente',
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS detalles_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Insertar usuario admin por defecto (pass: admin123)
INSERT IGNORE INTO usuarios (nombre, email, password, rol) VALUES 
('Admin', 'admin@mercashop.com', '$2y$10$wN9X.Z6hGk0OQeG5Jm/N/ee3j5eI9g15J4n2Yh4P5n6Q4X4eY3Tly', 'admin');

-- Insertar categorías
INSERT IGNORE INTO categorias (nombre, slug) VALUES 
('Tecnología', 'tech'), ('Moda', 'moda'), ('Hogar', 'hogar'), ('Deporte', 'deporte'), ('Gaming', 'gaming');

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, precio, precio_original, descuento, stock, emoji, badge, vendedor, categoria_id) VALUES
('iPhone 15 Pro Max 256GB Titanio', 1199.99, 1399.99, 14, 10, '📱', 'Hot', 'Apple Official', 1),
('MacBook Air M3 13" 8GB RAM', 1599.00, 1899.00, 16, 5, '💻', 'Nuevo', 'Apple Store AR', 1),
('Nike Air Max 270 React Blanco/Negro', 149.99, 199.99, 25, 20, '👟', 'Sale', 'Nike Argentina', 2),
('Smart TV Samsung 55" QLED 4K 2024', 799.00, 999.00, 20, 8, '📺', NULL, 'Samsung Oficial', 1),
('Silla Gamer RGB Ergonómica Pro X', 289.00, 389.00, 26, 15, '🪑', 'Sale', 'Gaming Zone', 5);
