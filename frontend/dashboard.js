const apiBaseUrl = "http://localhost:8000/api";
const token = localStorage.getItem("token");

if (!token) {
  window.location.href = "index.html"; // redirect to login if not authenticated
}

const headers = {
  "Content-Type": "application/json",
  Authorization: `Bearer ${token}`,
};

const taskList = document.getElementById("taskList");
const createForm = document.getElementById("createTaskForm");
const logoutBtn = document.getElementById("logoutBtn");

// Load tasks on page load
window.onload = fetchTasks;

// Create Task
createForm.onsubmit = async (e) => {
  e.preventDefault();
  const title = document.getElementById("taskTitle").value;
  const description = document.getElementById("taskDescription").value;

  const res = await fetch(`${apiBaseUrl}/tasks`, {
    method: "POST",
    headers,
    body: JSON.stringify({ title, description }),
  });

  if (res.ok) {
    fetchTasks();
    createForm.reset();
  }
};

// Fetch Tasks
async function fetchTasks() {
  const res = await fetch(`${apiBaseUrl}/tasks`, { headers });
  const data = await res.json();
  taskList.innerHTML = "";
  data.forEach((task) => {
    const li = document.createElement("li");
    li.innerHTML = `
      <strong>${task.title}</strong><br/>
      <small>${task.description}</small><br/>
      <button onclick="editTask(${task.id}, '${task.title}', '${task.description}')">Edit</button>
      <button onclick="deleteTask(${task.id})">Delete</button>
    `;
    taskList.appendChild(li);
  });
}

// Delete Task
async function deleteTask(id) {
  await fetch(`${apiBaseUrl}/tasks/${id}`, {
    method: "DELETE",
    headers,
  });
  fetchTasks();
}

// Edit Task
async function editTask(id, title, description) {
  const newTitle = prompt("Edit title:", title);
  const newDescription = prompt("Edit description:", description);

  if (newTitle !== null && newDescription !== null) {
    await fetch(`${apiBaseUrl}/tasks/${id}`, {
      method: "PUT",
      headers,
      body: JSON.stringify({
        title: newTitle,
        description: newDescription,
      }),
    });
    fetchTasks();
  }
}

// Logout
logoutBtn.onclick = () => {
  localStorage.removeItem("token");
  window.location.href = "index.html";
};
