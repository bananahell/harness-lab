USE HarnessLab;
GO

DELETE FROM tasks;
GO

INSERT INTO tasks (id, title, completed)
VALUES (1, 'Learn harness engineering', 0);
GO
