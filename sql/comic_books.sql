CREATE TABLE comic_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    issue_number INT NOT NULL,
    release_date DATE NOT NULL,
    publisher_id INT,
    FOREIGN KEY (publisher_id) REFERENCES publishers(id)
);
