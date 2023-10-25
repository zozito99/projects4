CREATE TABLE posts (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       year INT,
                       relased DATE,
                       runtime INT,
                       genre VARCHAR(255),
                       director VARCHAR(255),
                       country VARCHAR(255),
                       poster VARCHAR(255),
                       imdp FLOAT(2, 1),
                       type VARCHAR(255),
                        actors VARCHAR(500)
);