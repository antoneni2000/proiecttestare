CREATE TABLE programari{
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefon VARCHAR(20),
    data_programare DATE NOT NULL,
    ora TIME NOT NULL,
    mesaj TEXT,
    data_inregistrare TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    };