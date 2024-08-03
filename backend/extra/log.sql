    use futbollibre;

    CREATE TABLE IF NOT EXISTS pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        status BOOLEAN DEFAULT false,
        url VARCHAR(255) NOT NULL
    );
