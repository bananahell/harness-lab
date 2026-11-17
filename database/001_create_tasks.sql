IF DB_ID('HarnessLab') IS NULL
BEGIN
    CREATE DATABASE HarnessLab;
END
GO

USE HarnessLab;
GO

IF OBJECT_ID('tasks', 'U') IS NULL
BEGIN
    CREATE TABLE tasks (
        id INT PRIMARY KEY,
        title NVARCHAR(255) NOT NULL,
        completed BIT NOT NULL
    );
END
GO

DELETE FROM tasks;
GO

INSERT INTO tasks (id, title, completed)
VALUES (1, 'Learn harness engineering', 0);
GO
