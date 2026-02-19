<?php
include "db_connect.php";

$sql = "

CREATE TABLE donors (
    donor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    business VARCHAR(150),
    address VARCHAR(200),
    phone VARCHAR(25),
    email VARCHAR(150)
);

CREATE TABLE items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT,
    item_name VARCHAR(200),
    description TEXT,
    retail_value DECIMAL(8,2),
    FOREIGN KEY (donor_id) REFERENCES donors(donor_id)
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(150)
);

CREATE TABLE lots (
    lot_id INT AUTO_INCREMENT PRIMARY KEY,
    lot_name VARCHAR(200),
    description TEXT,
    category_id INT,
    photo_path VARCHAR(255),
    starting_bid DECIMAL(8,2),
    bid_increment DECIMAL(8,2),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE lot_items (
    lot_id INT,
    item_id INT,
    PRIMARY KEY (lot_id, item_id),
    FOREIGN KEY (lot_id) REFERENCES lots(lot_id),
    FOREIGN KEY (item_id) REFERENCES items(item_id)
);

CREATE TABLE bidders (
    bidder_id INT AUTO_INCREMENT PRIMARY KEY,
    bidder_number INT,
    name VARCHAR(150),
    address VARCHAR(200),
    cell VARCHAR(25),
    home VARCHAR(25),
    email VARCHAR(150),
    paid BOOLEAN DEFAULT 0
);

CREATE TABLE winning_bids (
    win_id INT AUTO_INCREMENT PRIMARY KEY,
    bidder_id INT,
    lot_id INT,
    amount DECIMAL(8,2),
    delivered BOOLEAN DEFAULT 0,
    FOREIGN KEY (bidder_id) REFERENCES bidders(bidder_id),
    FOREIGN KEY (lot_id) REFERENCES lots(lot_id)
);

";

if ($conn->multi_query($sql)) {
    echo "Auction tables created successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>
