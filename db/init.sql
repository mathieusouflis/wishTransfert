-- Database for WeTransfer application
CREATE DATABASE IF NOT EXISTS wishtransfert;
USE wishtransfert;

-- utilisateurs
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(35) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- fichiers
CREATE TABLE IF NOT EXISTS files (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    file_data LONGBLOB NOT NULL,
    status VARCHAR(255) DEFAULT 'Stored',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- liens de téléchargement
CREATE TABLE IF NOT EXISTS links (
    link_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    download_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- liens entre les liens et les fichiers
CREATE TABLE IF NOT EXISTS files_links (
    file_link_id INT AUTO_INCREMENT PRIMARY KEY,
    link_id INT NOT NULL,
    file_id INT NOT NULL,
    FOREIGN KEY (file_id) REFERENCES files(file_id) ON DELETE CASCADE,
    FOREIGN KEY (link_id) REFERENCES links(link_id) ON DELETE CASCADE
);

-- liens entre les emails et les liens
CREATE TABLE IF NOT EXISTS emails_links (
    email_link_id INT AUTO_INCREMENT PRIMARY KEY,
    link_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    FOREIGN KEY (link_id) REFERENCES links(link_id) ON DELETE CASCADE
);

-- commentaires sur les fichiers
CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    file_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (file_id) REFERENCES files(file_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

SET GLOBAL max_allowed_packet = 16 * 1024 * 1024 * 1024;
