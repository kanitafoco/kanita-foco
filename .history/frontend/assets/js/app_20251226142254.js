/* ==========================================================
    SPAPP ROUTER – jedini router u tvojoj aplikaciji
========================================================== */
$(document).ready(function () {

  var app = $.spapp({
      defaultView: "home",
      templateDir: "views/"
  });

  // ROUTES
  app.route({ view: "home",       load: "home.html" });
  app.route({ view: "products",   load: "products.html" });
  app.route({ view: "categories", load: "categories.html" });
  app.route({ view: "reviews",    load: "reviews.html" });
  app.route({ view: "contact",    load: "contact.html" });
  app.route({ view: "login",      load: "login.html" });
  app.route({ view: "register",   load: "register.html" });
  app.route({ view: "profile",    load: "profile.html" });
  app.route({ view: "dashboard",  load: "dashboard.html" });
  app.route({ view: "orders",     load: "orders.html" });

  app.run();
});


/* ==========================================================
 VIEWCHANGE – kada se promijeni stranica, učitava se servis
========================================================== */
$(document).on("viewchange", function (e, page) {

  console.log("Loaded view:", page);

  if (page === "categories") CategoryService.init();
  if (page === "products")   ProductService.init();
  if (page === "orders")     OrdersService.init();
  if (page === "reviews")    ReviewService.init();
  if (page === "dashboard")  DashboardService.init();
  if (page === "profile")    ProfileService.init();

 
  if (page === "login" || page === "register") {
      attachAuthForms();
  }
});


/* ==========================================================
  LOGIN / REGISTER
========================================================== */
function attachAuthForms() {

  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
      loginForm.addEventListener("submit", function (e) {
          e.preventDefault();

          let data = Object.fromEntries(new FormData(loginForm));

          localStorage.setItem("urban_user", data.email);
          localStorage.setItem("urban_role", "customer");

          window.location.hash = "#dashboard";
      });
  }

  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
      registerForm.addEventListener("submit", function (e) {
          e.preventDefault();

          let data = Object.fromEntries(new FormData(registerForm));

          localStorage.setItem("urban_user", data.email);
          localStorage.setItem("urban_role", "customer");

          window.location.hash = "#dashboard";
      });
  }
}





var App = {

  generateMenuItems: function () {
      const token = localStorage.getItem("user_token");
      const nav = $("#nav-menu");

      nav.empty(); 

      
      nav.append(`
          <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
      `);

      
      if (!token) {
          nav.append(`
              <li class="nav-item"><a class="nav-link" href="#login">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="#register">Register</a></li>
          `);
          return;
      }

      const user = JSON.parse(localStorage.getItem("user_info"));

      if (!user) return;

      // --- ADMIN MENI ---
      if (user.role === "admin") {
          nav.append(`
              <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
              <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
              <li class="nav-item"><a class="nav-link" href="#orders">Orders</a></li>
              <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
          `);
      }

      // --- CUSTOMER MENI ---
      if (user.role === "customer") {
          nav.append(`
              <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
              <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
              <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          `);
      }

      // Logout
      nav.append(`
          <li class="nav-item">
              <button class="btn btn-danger ms-3" onclick="UserService.logout()">Logout</button>
          </li>
      `);
  }

};
