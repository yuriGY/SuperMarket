CREATE TABLE products_types (
    id VARCHAR(8) PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL,
    product_tax FLOAT NOT NULL,
    removed BOOLEAN DEFAULT FALSE
);

CREATE TABLE products (
    id VARCHAR(8) PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL,
    product_type_id VARCHAR(8) NOT NULL,
    stock INT NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    removed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (product_type_id) REFERENCES products_types (id) ON DELETE CASCADE
);

CREATE TABLE products_images (
    id VARCHAR(8) PRIMARY KEY,
    product_id VARCHAR(8) NOT NULL,
    image BYTEA NOT NULL,
    content_type VARCHAR(50) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE payment_types (
    id VARCHAR(8) PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE sales (
    id VARCHAR(8) PRIMARY KEY NOT NULL,
    payment_type_id VARCHAR(8) NOT NULL,
    total_cost DECIMAL(10, 2),
    total_taxes DECIMAL(10, 2),
    date TIMESTAMP WITH TIME ZONE NOT NULL,
    FOREIGN KEY (payment_type_id) REFERENCES payment_types (id) ON DELETE CASCADE
);

CREATE TABLE products_sales (
    id VARCHAR(8) PRIMARY KEY NOT NULL,
    product_id VARCHAR(8) NOT NULL,
    quantity_sold INT NOT NULL,
    sale_id VARCHAR(8) NOT NULL,
    total_cost DECIMAL(10, 2) NOT NULL,
    taxes DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    FOREIGN KEY (sale_id) REFERENCES sales (id) ON DELETE CASCADE
);
