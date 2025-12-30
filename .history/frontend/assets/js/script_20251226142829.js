/* ==========================================================
   UI / NAVBAR LOGIKA
========================================================== */

var App = {

    generateMenuItems: function () {
      const token = localStorage.getItem("user_token");
      const nav = $("#nav-menu");
  
      if (!nav.length) return;
  
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
  
      if (user.role === "admin") {
        nav.append(`
          <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="#orders">Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
        `);
      }
  
      if (user.role === "customer") {
        nav.append(`
          <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        `);
      }
  
      nav.append(`
        <li class="nav-item">
          <button class="btn btn-danger ms-3" onclick="UserService.logout()">Logout</button>
        </li>
      `);
    }
  };
  
  
  // Refresh navbar kad se promijeni stranica ili login stanje
  $(window).on("hashchange", function () {
    App.generateMenuItems();
  });
  
  $(document).ready(function () {
    App.generateMenuItems();
  });
  