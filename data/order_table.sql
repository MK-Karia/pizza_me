USE pizza_me;

CREATE TABLE pizza_order
(
    `order_id`     INT NOT NULL AUTO_INCREMENT,
	`user_id`      INT NOT NULL,
    `pizza_id`     INT NOT NULL,
    `address`      VARCHAR(255) NOT NULL,
	`price`        INT NOT NULL,
	`order_date`   DATETIME NOT NULL,
    PRIMARY KEY (`order_id`)
)
