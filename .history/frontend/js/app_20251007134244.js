// Simple client-side router for SPA navigation (no page reloads)
const routes = {
  home: 'views/home.html',
  services: 'views/services.html',
  book: 'views/book.html',
  profile: 'views/profile.html',
  login: 'views/login.html',
  register: 'views/register.html',
  dashboard: 'views/dashboard.html',
  'manage-appointments': 'views/manage-appointments.html',
  barbers: 'views/barbers.html',
  reviews: 'views/reviews.html',
};

const appEl = document.getElementById('app');
const yearEl = document.getElementById('year');
if(yearEl) yearEl.textContent = new Date().getFullYear();

async function navigate(route){
  if(!routes[route]) route='home';
  const res = await fetch(routes[route]);
  const html = await res.text();
  appEl.innerHTML = html;
  // Update active nav link
  document.querySelectorAll('[data-route]').forEach(el=>{
    if(el.dataset.route===route) el.classList.add('nav-active'); else el.classList.remove('nav-active');
  });
  // Attach view-specific scripts
  if(route==='book') attachBooking();
  if(route==='dashboard') attachDashboard();
  if(route==='login') attachAuthForms();
  if(route==='register') attachAuthForms();
}

// Use event delegation to handle all `data-route` clicks from a single listener.
// This prevents attaching multiple handlers when views are re-rendered.
document.addEventListener('click', function(e){
  // only handle primary button clicks
  if(e.button && e.button !== 0) return;
  const a = e.target.closest('[data-route]');
  if(!a) return;
  // allow normal behavior for inputs, etc.
  e.preventDefault();
  const r = a.dataset.route;
  if(!r) return;
  window.history.pushState({route:r}, '', '#'+r);
  navigate(r);
});

window.addEventListener('popstate', (e)=>{
  const r = location.hash.replace('#','') || 'home';
  navigate(r);
});

function attachBooking(){
  const form = document.getElementById('bookingForm');
  if(!form) return;
  form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form));
    const alertBox = document.createElement('div');
    alertBox.className='alert alert-success';
    alertBox.textContent = `Thanks ${data.name}, your booking request for ${data.service} on ${data.date} at ${data.time} was received (demo).`;
    form.prepend(alertBox);
    form.reset();
  })
}

function attachAuthForms(){
  const loginForm = document.getElementById('loginForm');
  if(loginForm){
    loginForm.addEventListener('submit', (e)=>{
      e.preventDefault();
      const data = Object.fromEntries(new FormData(loginForm));
      // Demo: store role in localStorage for role-based dashboard
      const role = data.role || 'customer';
      localStorage.setItem('barber_role', role);
      localStorage.setItem('barber_user', data.email || 'demo@user');
      window.history.pushState({route:'dashboard'}, '', '#dashboard');
      navigate('dashboard');
    })
  }
  const registerForm = document.getElementById('registerForm');
  if(registerForm){
    registerForm.addEventListener('submit', (e)=>{
      e.preventDefault();
      const data = Object.fromEntries(new FormData(registerForm));
      const role = data.role || 'customer';
      localStorage.setItem('barber_role', role);
      localStorage.setItem('barber_user', data.email || data.name || 'demo@user');
      window.history.pushState({route:'dashboard'}, '', '#dashboard');
      navigate('dashboard');
    })
  }
}

function attachDashboard(){
  const role = localStorage.getItem('barber_role') || 'guest';
  const user = localStorage.getItem('barber_user') || 'Guest';
  const el = document.getElementById('dashboard-root');
  if(!el) return;
  if(role==='admin'){
    el.innerHTML = `
      <h2>Admin Dashboard</h2>
      <p class="text-muted">Welcome back, ${user} (admin).</p>
      <div class="d-flex gap-3 mb-3">
        <a class="btn btn-primary" href="#" data-route="manage-appointments">Manage Appointments</a>
        <a class="btn btn-primary" href="#" data-route="barbers">Manage Barbers</a>
        <a class="btn btn-primary" href="#" data-route="services">Manage Services</a>
        <a class="btn btn-primary" href="#" data-route="reviews">Manage Reviews</a>
      </div>
      <div>
        <h5>Quick stats (demo)</h5>
        <ul>
          <li>Users: 124</li>
          <li>Barbers: 8</li>
          <li>Appointments today: 12</li>
          <li>Pending reviews: 2</li>
        </ul>
      </div>
    `;
  } else if(role==='barber'){
    el.innerHTML = `
      <h2>Barber Dashboard</h2>
      <p class="text-muted">Welcome, ${user} (barber).</p>
      <div class="d-flex gap-3 mb-3">
        <a class="btn btn-primary" href="#" data-route="manage-appointments">My Appointments</a>
        <a class="btn btn-secondary" href="#" data-route="profile">My Profile</a>
      </div>
      <div>
        <h5>Today's schedule (demo)</h5>
        <ul>
          <li>09:30 — Classic Cut — John Doe</li>
          <li>11:00 — Fade — Mark R</li>
          <li>13:00 — Beard Trim — Tim L</li>
        </ul>
      </div>
    `;
  } else if(role==='customer'){
    el.innerHTML = `
      <h2>Customer Dashboard</h2>
      <p class="text-muted">Hello, ${user}.</p>
      <div class="d-flex gap-3 mb-3">
        <a class="btn btn-primary" href="#" data-route="book">Book a Service</a>
        <a class="btn btn-secondary" href="#" data-route="profile">My Profile</a>
        <a class="btn btn-outline-primary" href="#" data-route="reviews">My Reviews</a>
      </div>
      <div>
        <h5>Upcoming bookings</h5>
        <ul>
          <li>2025-10-15 — Classic Cut — 10:00</li>
        </ul>
      </div>
    `;
  } else {
    el.innerHTML = `
      <h2>Welcome</h2>
      <p class="text-muted">Please <a href="#" data-route="login">login</a> or <a href="#" data-route="register">register</a>.</p>
    `;
  }
  // event delegation handles link binding globally
}

// Initialize
const initialRoute = location.hash.replace('#','') || 'home';
navigate(initialRoute);
