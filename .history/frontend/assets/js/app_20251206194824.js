console.warn("Custom router disabled — using SPAPP only");

const yearEl = document.getElementById("year");
if (yearEl) yearEl.textContent = new Date().getFullYear();
