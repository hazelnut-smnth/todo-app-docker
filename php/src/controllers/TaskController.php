<?php
require_once __DIR__ . '/../models/Task.php';

/**
 * Task Controller
 * Handles all task-related requests
 */
class TaskController {
    private $taskModel;

    /**
     * Constructor
     * Initializes the task model
     */
    public function __construct() {
        $this->taskModel = new Task();
    }

    /**
     * Display all tasks (homepage)
     * 
     * @return void
     */
    public function index(): void {
        try {
            $tasks = $this->taskModel->getAllTasks();
            require __DIR__ . '/../views/tasks/index.view.php';
        } catch(Exception $e) {
            error_log("Error in TaskController::index: " . $e->getMessage());
            exit("Failed to load tasks. Please try again later.");
        }
    }

    /**
     * Create a new task
     * 
     * @return void
     */
    public function create(): void {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: /index.php");
            exit;
        }

        $task = $_POST['task'] ?? '';
        if (trim($task) === '') {
            exit("Error: Task cannot be empty");
        }

        $due_date = (isset($_POST['due_date']) && $_POST['due_date'] !== '') 
                    ? $_POST['due_date'] 
                    : null;

        try {
            $this->taskModel->createTask(trim($task), $due_date);
            header("Location: /index.php");
            exit;
        } catch(Exception $e) {
            error_log("Error in TaskController::create: " . $e->getMessage());
            exit("Failed to create task. Please try again later.");
        }
    }

    /**
     * Update an existing task
     * 
     * @return void
     */
    public function update(): void {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: /index.php");
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            exit("Error: Invalid task ID");
        }

        $task = $_POST['task'] ?? '';
        if (trim($task) === '') {
            exit("Error: Task cannot be empty");
        }

        $due_date = (isset($_POST['due_date']) && $_POST['due_date'] !== '') 
                    ? $_POST['due_date'] 
                    : null;

        try {
            $this->taskModel->updateTask($id, trim($task), $due_date);
            header("Location: /index.php");
            exit;
        } catch(Exception $e) {
            error_log("Error in TaskController::update: " . $e->getMessage());
            exit("Failed to update task. Please try again later.");
        }
    }

    /**
     * Delete a task
     * 
     * @return void
     */
    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            exit("Error: Invalid task ID");
        }

        try {
            $this->taskModel->deleteTask($id);
            header("Location: /index.php");
            exit;
        } catch(Exception $e) {
            error_log("Error in TaskController::delete: " . $e->getMessage());
            exit("Failed to delete task. Please try again later.");
        }
    }

    /**
     * Toggle task completion status
     * 
     * @return void
     */
    public function toggle(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            exit("Error: Invalid task ID");
        }

        try {
            $this->taskModel->toggleTask($id);
            header("Location: /index.php");
            exit;
        } catch(Exception $e) {
            error_log("Error in TaskController::toggle: " . $e->getMessage());
            exit("Failed to toggle task. Please try again later.");
        }
    }
}