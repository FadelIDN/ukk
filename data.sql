CREATE TABLE kantin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100)
);

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kantin INT,
    nama VARCHAR(100),
    harga INT,
    stok INT,
    FOREIGN KEY (id_kantin) REFERENCES kantin(id)
);

-- Contoh data
INSERT INTO kantin (nama) VALUES 
('Ayam Geprek Bang Romi'),
('Dapur Mak Ujang'),
('Batagor Mas Riki'),
('Kantin Masakan Rumah bu Eka');

INSERT INTO menu (id_kantin, nama, harga, stok) VALUES
(1, 'Ayam Geprek Sambel ijo', 15000, 10),
(1, 'Curry Udon', 1500, 15),
(1, 'Jamur Goreng', 5000, 20),
(1, 'Telor Goreng', 3000, 8),
(2, 'Bakso', 15000, 8),
(2, 'Teh Manis', 5000, 10),
(2, 'Mie Ayam', 13000, 12),
(2, 'Es Jeruk', 6000, 10),
(3, 'Batagor', 13000, 7),
(3, 'Siomay', 12000, 10),
(3, 'Es Campur', 9000, 8),
(3, 'Tahu Gejrot', 7000, 15),
(4, 'Ayam Goreng', 17000, 12),
(4, 'Jus Alpukat', 9000, 10),
(4, 'Sayur Asem', 8000, 10),
(4, 'Tempe Orek', 5000, 20);
