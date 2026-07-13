--base de datos mis autitos
CREATE DATABASE IF NOT EXISTS concesionario;
USE concesionario;

CREATE TABLE IF NOT EXISTS autos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    color VARCHAR(30) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

-- Algunos datos de ejemplo
INSERT INTO autos (marca, modelo, anio, precio, color, stock) VALUES
('Toyota', 'Corolla', 2023, 15990000, 'Blanco', 5),
('Chevrolet', 'Sail', 2022, 9990000, 'Rojo', 3),
('Nissan', 'Versa', 2023, 13500000, 'Gris', 4);


--Usuarios--
INSERT INTO usuarios (usuario, password) VALUES
('admin', '1234'),
('pedri', 'pedri10');