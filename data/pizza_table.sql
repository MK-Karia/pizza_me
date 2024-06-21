USE pizza_me;
CREATE TABLE pizza
(
    `pizza_id`     INT NOT NULL AUTO_INCREMENT,
	`name`         VARCHAR(255) NOT NULL,
    `ingredients`  VARCHAR(255) DEFAULT NULL,
    `discription`  TEXT DEFAULT NULL,
	`price`        INT NOT NULL,
	`image_path`   VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`pizza_id`),
    UNIQUE INDEX `name_idx` (`name`)
)
