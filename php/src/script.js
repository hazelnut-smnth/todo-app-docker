"use strict";

function startEdit(taskId) {
  const display = document.querySelector(`#display-${taskId}`);
  const form = document.querySelector(`#edit-form-${taskId}`);
  const editButton = document.querySelector(`#edit-button-${taskId}`);
  const input = document.querySelector(
    `#edit-form-${taskId} input[type="text"]`,
  );

  // Error checking: ensure all required elements exist
  if (!display || !form || !editButton || !input) {
    console.error("Required elements not found for task ID:", taskId);
    return;
  }

  display.style.display = "none";
  form.style.display = "flex";
  editButton.style.display = "none";
  input.focus();
}

function cancelEdit(taskId) {
  const form = document.querySelector(`#edit-form-${taskId}`);
  const display = document.querySelector(`#display-${taskId}`);
  const editButton = document.querySelector(`#edit-button-${taskId}`);

  // Error checking: ensure all required elements exist
  if (!form || !display || !editButton) {
    console.error("Required elements not found for task ID:", taskId);
    return;
  }

  form.reset();
  display.style.display = "flex";
  form.style.display = "none";
  editButton.style.display = "block";
}

function clearDate(taskId) {
  const dateInput = document.querySelector(`#due-date-${taskId}`);

  // Error checking: ensure date input exists
  if (!dateInput) {
    console.error("Date input not found for task ID:", taskId);
    return;
  }

  dateInput.value = "";
}
