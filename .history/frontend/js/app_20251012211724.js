// UrbanStep Shoe Shop SPA Routing
const routes = {
  home: 'views/home.html',
  products: 'views/products.html',
  categories: 'views/categories.html',
  reviews: 'views/reviews.html',
  contact: 'views/contact.html',
  login: 'views/login.html',
  register: 'views/register.html',
  profile: 'views/profile.html',
  dashboard: 'views/dashboard.html',
  orders: 'views/orders.html'
};

const appEl = document.getElementById('app');
const yearEl = document.getElementById('year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

async function navigate(route) {
  if (!routes[route]) route = 'home';
  const res = await fetch(routes[route]);
  const html = await res.text();
  appEl.innerHTML = html;

  // Active link update
  document.querySelectorAll('[data-route]').forEach(el => {
    if (el.dataset.route === route) el.classList.add('nav-active');
    else el.classList.remove('nav-active');
  });

  // View-specific handlers
  if (route === 'login') attachAuthForms();
  if (route === 'register') attachAuthForms();
  if (route === 'dashboard') attachDashboard();
}

// Handle link clicks
document.addEventListener('click', e => {
  const a = e.target.closest('[data-route]');
  if (!a) return;
  e.preventDefault();
  const r = a.dataset.route;
  window.history.pushState({ route: r }, '', '#' + r);
  navigate(r);
});

// Handle browser back/forward
window.addEventListener('popstate', e => {
  const r = location.hash.replace('#', '') || 'home';
  navigate(r);
});

function attachAuthForms() {
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', e => {
      e.preventDefault();
      const data = Object.fromEntries(new FormData(loginForm));
      const user = data.email || 'guest@urbanstep.shop';
      localStorage.setItem('urban_user', user);
      localStorage.setItem('urban_role', 'customer');
      window.history.pushState({ route: 'dashboard' }, '', '#dashboard');
      navigate('dashboard');
    });
  }

  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', e => {
      e.preventDefault();
      const data = Object.fromEntries(new FormData(registerForm));
      const user = data.email || 'new@urbanstep.shop';
      localStorage.setItem('urban_user', user);
      localStorage.setItem('urban_role', 'customer');
      window.history.pushState({ route: 'dashboard' }, '', '#dashboard');
      navigate('dashboard');
    });
  }
}

function attachDashboard() {
  const user = localStorage.getItem('urban_user') || 'Guest';
  const role = localStorage.getItem('urban_role') || 'customer';
  const el = document.getElementById('dashboard-root');
  if (!el) return;

  if (role === 'customer') {
    el.innerHTML = `
      <h2>Welcome to your Dashboard</h2>
      <p class="text-muted">Hello, ${user}.</p>
      <div class="d-flex gap-3 mb-3">
        <a class="btn btn-primary" href="#" data-route="products">Shop Now</a>
        <a class="btn btn-secondary" href="#" data-route="orders">My Orders</a>
        <a class="btn btn-outline-primary" href="#" data-route="profile">My Profile</a>
      </div>
      <div>
        <h5>Recent Orders</h5>
        <ul>
          <li>Order #1234 — UrbanStep Sneakers — Shipped</li>
        </ul>
      </div>
    `;
  } else {
    el.innerHTML = `<h2>Welcome, ${user}</h2>`;
  }
}

// Initialize
const initialRoute = location.hash.replace('#', '') || 'home';
navigate(initialRoute);

// Handle "Add to Cart" buttons
document.addEventListener("DOMContentLoaded", () => {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach(button => {
    button.addEventListener("click", (e) => {
      e.preventDefault();

      // Get product info
      const card = e.target.closest(".card");
      const productName = card.querySelector("h5").textContent.trim();
      const productPrice = card.querySelector("p").textContent.trim();

      // Store in localStorage (simulate cart)
      const orders = JSON.parse(localStorage.getItem("orders")) || [];
      const newOrder = {
        id: `ORD${1000 + orders.length + 1}`,
        name: productName,
        price: productPrice,
        date: new Date().toISOString().split("T")[0],
        status: "Pending"
      };
      orders.push(newOrder);
      localStorage.setItem("orders", JSON.stringify(orders));

      // Redirect to Orders page
      window.location.href = "index.html#orders";
    });
  });
});

