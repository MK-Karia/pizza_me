CREATE DATABASE pizza_me;
USE pizza_me;

CREATE TABLE user
(
    `user_id`     INT NOT NULL AUTO_INCREMENT,
	`first_name`  VARCHAR(255) NOT NULL,
    `last_name`   VARCHAR(255) NOT NULL,
    `email`       VARCHAR(255) NOT NULL,
	`phone`       VARCHAR(255) DEFAULT NULL,
	`avatar_path` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `email_idx` (`email`),
    UNIQUE INDEX `phone_idx` (`phone`)
)
