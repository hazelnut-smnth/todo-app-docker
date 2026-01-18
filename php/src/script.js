"use strict";
// document.querySelector('clear_date_btn').addEventListener('click',function clearDate(taskId));
function startEdit(taskId) {
  document.querySelector(`#display-${taskId}`).style.display = "none";
  document.querySelector(`#edit-form-${taskId}`).style.display = "flex";
  document.querySelector(`#edit-button-${taskId}`).style.display = "none";
  document.querySelector(`#edit-form-${taskId} input[type="text"]`).focus();
}
function cancelEdit(taskId) {
  const form = document.querySelector(`#edit-form-${taskId}`);
  form.reset();
  document.querySelector(`#display-${taskId}`).style.display = "flex";
  document.querySelector(`#edit-form-${taskId}`).style.display = "none";
  document.querySelector(`#edit-button-${taskId}`).style.display = "block";
}
function clearDate(taskId) {
  document.querySelector(`#due-date-${taskId}`).value = "";
}
