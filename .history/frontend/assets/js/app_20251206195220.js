// Only footer year
const yearEl = document.getElementById("year");
if (yearEl) yearEl.textContent = new Date().getFullYear();

console.warn("Custom router disabled — SPApp is handling routing.");
