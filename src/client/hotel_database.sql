CREATE TABLE payment_methods(
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_number VARCHAR(20) NOT NULL,
    card_name VARCHAR(50) NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(4) NOT NULL
    )