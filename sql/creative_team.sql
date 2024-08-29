CREATE TABLE creative_team (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    comic_book_id INT,
    FOREIGN KEY (comic_book_id) REFERENCES comic_books(id)
);
