/* Author: Will J. Kemmoe
*  Date: 2023-09-27

*  Protocol to migrate the database:
*  1. Create a new database named 'ToDoList'.
*  2. Execute the SQL code to create the 'tasks', 'users', and 'userTasks' tables within the 'ToDoList' database.
*  3. The database is now set up with the required tables and foreign key relationships.
*/

-- Create the 'ToDoList' database

CREATE DATABASE ToDoList;

-- Use the 'ToDoList' database
USE ToDoList;

-- Create the 'tasks' table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT DEFAULT NULL,
    status BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the 'users' table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    ip_address VARCHAR(50),
    device TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,  
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the 'userTasks' table
CREATE TABLE user_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_task INT,
    id_user INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,  
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_task) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id)
);
