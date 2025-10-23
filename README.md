## 🎬 Movie Catalog Manager (CRUD Application)

## ✨ Project Overview

This project is a simple, full-stack web application designed to manage a Movie Catalog. It demonstrates a core understanding of database interaction by implementing the six key SQL operations: **CREATE TABLE**, **INSERT**,**SELECT**, **UPDATE**, **DELETE**, and **TRUNCATE**.

The primary goal was to build a functional, secure, and user-friendly system for handling data records, showcasing the essential flow between the client interface and a persistent database.

## 🚀 Key Features Implemented

- **C**reate (INSERT): Add new movie records (Title, Director, Year, Rating) to the database.

- **R**ead (SELECT) & Search Option 🔍: View the complete movie catalog and efficiently search for records by title or director. This feature uses the LIKE operator to provide fuzzy matching and filtering.

- **U**pdate (UPDATE): Edit existing movie details via a dedicated form.

- **D**elete (DELETE): Permanently remove movie records from the catalog.

- Catalog Reset Switch (TRUNCATE) ♻️: A dedicated utility to reset the entire catalog. This feature uses the efficient TRUNCATE TABLE command to delete all data and simultaneously reset the database's auto-increment counter to 1, ensuring clean ID sequencing for new entries.

## 🛠️ Tech Stack

- Server Environment: XAMPP (Local Development Environment for running PHP and MySQL.)

- Frontend/Scripting: PHP (Server-side logic, data processing, and HTML templating.)

- Database: MySQL (Persistent storage and data management.)

- Styling: Custom CSS (Dark-themed, responsive interface design.)

- Interaction: MySQLi (Secure database connectivity.)


## ⚙️ Setup and Installation

# Prerequisites

You must have XAMPP (or a similar stack like MAMP/WAMP) installed to run the Apache server and MySQL database locally.

# 1. Database Setup

1. Start the Apache and MySQL services in your XAMPP control panel.

2. Open your web browser and navigate to http://localhost/phpmyadmin.

3. Create a new database named movie_catalog.

4. Execute the following SQL command in the movie_catalog database to create the required table structure:

CREATE TABLE movies (
    movie_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    director VARCHAR(255) NOT NULL,
    release_year YEAR(4),
    rating DECIMAL(3, 1)
);


# 2. File Placement

Place all project files (index.php, edit.php, delete.php, reset.php, and db.php) inside a new folder (e.g., movie-app) within your XAMPP installation's root web directory (htdocs).

# 3. Running the Application

1. Ensure Apache and MySQL are running.

2. Open your browser and navigate to the project's URL: http://localhost/movie-app/index.php.

## ✅ Core Takeaways

This project solidified my experience in writing and executing reliable SQL queries (CREATE TABLE, INSERT, SELECT, UPDATE, DELETE, TRUNCATE) and demonstrated strong competency in building secure, transactional PHP logic for web applications.
