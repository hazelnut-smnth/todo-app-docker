<?php
/**
 * Task Model
 * Responsible for all database operations related to tasks
 */
class Task {
    private $conn;

    /**
     * Constructor - gets database connection
     */
    public function __construct() {
        require_once __DIR__ . '/../config.php';
        $this->conn = getDBConnection();
    }

    /**
     * Get all tasks from database
     *
     * @return array List of all tasks
     */
    public function getAllTasks(): array {
        try {
            $sql = "SELECT * FROM todo ORDER BY completed, id DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in Task::getAllTasks: " . $e->getMessage());
            throw new Exception("Failed to fetch tasks");
        }
    }

    /**
     * Create a new task
     *
     * @param string $task Task description
     * @param string|null $due_date Due date
     * @return bool Success or failure
     */
    public function createTask(string $task, ?string $due_date): bool {
        try {
            $sql = "INSERT INTO todo (task, due_date) VALUES (:task, :due_date)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':task' => $task,
                ':due_date' => $due_date
            ]);
        } catch(PDOException $e) {
            error_log("Error in Task::createTask: " . $e->getMessage());
            throw new Exception("Failed to create task");
        }
    }

    /**
     * Update an existing task
     *
     * @param int $id Task ID
     * @param string $task Task description
     * @param string|null $due_date Due date
     * @return bool Success or failure
     */
    public function updateTask(int $id, string $task, ?string $due_date): bool {
        try {
            $sql = "UPDATE todo SET task = :task, due_date = :due_date WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':task' => $task,
                ':due_date' => $due_date,
                ':id' => $id
            ]);
        } catch(PDOException $e) {
            error_log("Error in Task::updateTask: " . $e->getMessage());
            throw new Exception("Failed to update task");
        }
    }

    /**
     * Delete a task
     *
     * @param int $id Task ID
     * @return bool Success or failure
     */
    public function deleteTask(int $id): bool {
        try {
            $sql = "DELETE FROM todo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch(PDOException $e) {
            error_log("Error in Task::deleteTask: " . $e->getMessage());
            throw new Exception("Failed to delete task");
        }
    }

    /**
     * Toggle task completion status
     *
     * @param int $id Task ID
     * @return bool Success or failure
     */
    public function toggleTask(int $id): bool {
        try {
            // Get current status
            $sql = "SELECT completed FROM todo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$task) {
                throw new Exception("Task not found");
            }

            // Calculate new status
            $new_completed = $task['completed'] ? 0 : 1;
            $completed_at = $new_completed ? date('Y-m-d H:i:s') : null;

            // Update
            $sql = "UPDATE todo SET completed = :completed, completed_at = :completed_at WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':completed' => $new_completed,
                ':completed_at' => $completed_at,
                ':id' => $id
            ]);
        } catch(PDOException $e) {
            error_log("Error in Task::toggleTask: " . $e->getMessage());
            throw new Exception("Failed to toggle task");
        }
    }
}