CREATE TABLE Users
(
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    phone      VARCHAR(20),
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Admins
(
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    email    VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Categories
(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL
);

CREATE TABLE Products
(
    product_id  INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)   NOT NULL,
    description TEXT,
    price       DECIMAL(10, 2) NOT NULL,
    quantity    INT            NOT NULL,
    category_id INT,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories (category_id)
);

CREATE TABLE ProductImages
(
    product_image_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id       INT          NOT NULL,
    image_url        VARCHAR(255) NOT NULL,
    alt_text         VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES Products (product_id)
);

CREATE TABLE Cart
(
    cart_id    INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (user_id),
    FOREIGN KEY (product_id) REFERENCES Products (product_id)
);

CREATE TABLE Wishlist
(
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    product_id  INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (user_id),
    FOREIGN KEY (product_id) REFERENCES Products (product_id)
);

CREATE TABLE Orders
(
    order_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    created_at DATETIME                                             DEFAULT CURRENT_TIMESTAMP,
    status     ENUM ('Pending', 'Shipped', 'Delivered', 'Canceled') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
);

CREATE TABLE OrderItems
(
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id      INT NOT NULL,
    product_id    INT NOT NULL,
    quantity      INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders (order_id),
    FOREIGN KEY (product_id) REFERENCES Products (product_id)
);

CREATE TABLE Payments
(
    payment_id     INT AUTO_INCREMENT PRIMARY KEY,
    order_id       INT NOT NULL,
    status         ENUM ('Success', 'Failed', 'Pending') DEFAULT 'Pending',
    method         VARCHAR(50),
    transaction_id VARCHAR(100),
    FOREIGN KEY (order_id) REFERENCES Orders (order_id)
);

CREATE TABLE Shipping
(
    shipping_id     INT AUTO_INCREMENT PRIMARY KEY,
    order_id        INT          NOT NULL,
    address         VARCHAR(255) NOT NULL,
    city            VARCHAR(100) NOT NULL,
    postal_code     VARCHAR(20)  NOT NULL,
    shipping_method VARCHAR(50),
    tracking_number VARCHAR(100),
    status          ENUM ('Shipped', 'Delivered', 'Returned') DEFAULT 'Shipped',
    FOREIGN KEY (order_id) REFERENCES Orders (order_id)
);

CREATE TABLE Reviews
(
    review_id  INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id    INT NOT NULL,
    rating     INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment    TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES Products (product_id),
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
);