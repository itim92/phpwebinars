CREATE TABLE `products`
(
    `id`          int unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) NOT NULL DEFAULT '',
    `article`     varchar(255) NOT NULL DEFAULT '',
    `price`       double unsigned       DEFAULT NULL,
    `amount`      int unsigned          DEFAULT NULL,
    `description` MEDIUMTEXT            DEFAULT NULL,
    `category_id` int unsigned          DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `categories`
(
    `id`   int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
);
CREATE TABLE `product_images`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `product_id` int(10) unsigned NOT NULL,
    `name`       varchar(255)     NOT NULL DEFAULT '',
    `path`       varchar(255)              DEFAULT NULL,
    `size`       int(1) unsigned  NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);
CREATE TABLE `tasks_queue`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) NOT NULL                       DEFAULT '',
    `task`       varchar(255) NOT NULL                       DEFAULT '',
    `params`     varchar(255) NOT NULL,
    `status`     ENUM ('new', 'in_process', 'done', 'error') DEFAULT 'new',
    `created_at` DATETIME     NOT NULL,
    `updated_at` DATETIME     NOT NULL                       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `users`
(
    `id`       int unsigned NOT NULL AUTO_INCREMENT,
    `name`     varchar(255) NOT NULL DEFAULT '',
    `email`    varchar(255) NOT NULL DEFAULT '',
    `password` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
);


CREATE TABLE `orders`
(
    `id`         int unsigned   NOT NULL AUTO_INCREMENT,
    `total_sum`   float unsigned NOT NULL DEFAULT 0,
    `user_id`    int unsigned,
    `created_at` datetime       NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE `order_items`
(
    `id`           int unsigned NOT NULL AUTO_INCREMENT,
    `order_id`     int unsigned,
    `product_id`   int unsigned,
    `product_data` text         NOT NULL DEFAULT '',
    `amount`       int          NOT NULL DEFAULT 0,
    `totalSum`     float        NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);
