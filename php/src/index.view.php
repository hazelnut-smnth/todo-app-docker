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
            <form action="add.php" method="POST" class="form">
                <input type="text" name="task" class="content" placeholder="What needs to be done?" required>
                <label for="due_date" class="due_date_label">Due Date: </label>
                <input type="datetime-local" name="due_date" class="due_date" id="due_date">
                <input type="submit" value="Add" class="add-btn">
            </form>
        </div>      
        <?php foreach($tasks as $task): ?>
            <div class="main">
                <a href="toggle.php?id=<?php echo $task['id'];?>">
                    <input type="checkbox" class="checkbox" <?php echo $task['completed']?'checked':'';?>>
                </a>
                <div class="task_info" id="display-<?php echo $task['id']; ?>">
                    <p class="<?php echo $task['completed']?'completed':'';?>"><?php echo htmlspecialchars($task['task']);?></p>
                    <?php if($task['due_date']): ?>
                    <p class="due-date-display">Due: <?php echo date('Y-m-d H:i', strtotime($task['due_date'])); ?></p>
                    <?php endif; ?>
                </div>
                <form class="edit_form" id="edit-form-<?php echo $task['id']; ?>" style="display:none;" action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                    <input type="text" name="task" class="edit_input" value="<?php echo htmlspecialchars($task['task']); ?>">
                    <div class="date-input-wrapper">
                        <input type="datetime-local" name="due_date" class="edit_due_date" id="due-date-<?php echo $task['id']; ?>" value="<?php echo $task['due_date'] ? date('Y-m-d\TH:i', strtotime($task['due_date'])) : ''; ?>">
                        <button type="button" class="clear_date_btn" onclick="clearDate(<?php echo $task['id']; ?>)" title="Clear Date">✖</button>
                    </div>
                    <button type="submit" class="save_btn">Save</button>
                    <button type="button" class="cancel_btn" onclick="cancelEdit(<?php echo $task['id']; ?>)">Cancel</button>
                </form>
                <div class="edit" id="edit-button-<?php echo $task['id']; ?>">
                    <a href="delete.php?id=<?php echo $task['id'];?>">Delete</a>
                    <a href="#" onclick="startEdit(<?php echo $task['id']; ?>); return false;">Edit</a>
                </div>
            </div>
        <?php endforeach; ?>
        <script src="script.js"></script>
    </body>
</html>