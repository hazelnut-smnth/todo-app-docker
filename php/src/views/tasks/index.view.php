<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>To-Do List</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="heading">
            <h1>To Do List</h1>
            <form action="index.php?action=create" method="POST" class="form">
                <?php echo csrfField(); ?>
                <input type="text" name="task" class="content" placeholder="What needs to be done?" required>
                <label for="due-date" class="due-date-label">Due Date: </label>
                <input type="datetime-local" name="due_date" class="due-date" id="due-date">
                <input type="submit" value="Add" class="add-btn">
            </form>
        </div>      
        <?php foreach($tasks as $task): ?>
            <div class="main">
                <form method="POST" action="index.php?action=toggle" style="display: inline;">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                    <label onclick="this.closest('form').submit(); return false;" style="cursor: pointer; display: inline-block;">
                        <input type="checkbox" 
                            class="checkbox" 
                            <?php echo $task['completed']?'checked':'';?>
                            onclick="return false;">
                    </label>
                </form>
                <div class="task-info" id="display-<?php echo $task['id']; ?>">
                    <p class="<?php echo $task['completed']?'completed':'';?>"><?php echo htmlspecialchars($task['task']);?></p>
                    <?php if($task['due_date']): ?>
                    <p class="due-date-display">Due: <?php echo date('Y-m-d H:i', strtotime($task['due_date'])); ?></p>
                    <?php endif; ?>
                </div>
                <form class="edit-form" id="edit-form-<?php echo $task['id']; ?>" style="display:none;" action="index.php?action=update" method="POST">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                    <input type="text" name="task" class="edit-input" value="<?php echo htmlspecialchars($task['task']); ?>">
                    <div class="date-input-wrapper">
                        <input type="datetime-local" name="due_date" class="edit-due-date" id="due-date-<?php echo $task['id']; ?>" value="<?php echo $task['due_date'] ? date('Y-m-d\TH:i', strtotime($task['due_date'])) : ''; ?>">
                        <button type="button" class="clear-date-btn" onclick="clearDate(<?php echo $task['id']; ?>)" title="Clear Date">✖</button>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                    <button type="button" class="cancel-btn" onclick="cancelEdit(<?php echo $task['id']; ?>)">Cancel</button>
                </form>
                <div class="edit" id="edit-button-<?php echo $task['id']; ?>">
                    <form method="POST" action="index.php?action=delete" style="display: inline;">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <button type="submit" class="link-style-btn" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                    </form>
                    <button type="button" class="link-style-btn" onclick="startEdit(<?php echo (int)$task['id']; ?>)">Edit</button>
                </div>
            </div>
        <?php endforeach; ?>
        <script src="script.js"></script>
    </body>
</html>