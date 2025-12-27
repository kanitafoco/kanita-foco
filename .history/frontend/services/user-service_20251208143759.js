var UserService = {

  init: function () {
    // Ako je već logovan, šaljemo ga na home
    var token = localStorage.getItem("user_token");
    if (token && window.location.hash === "#login") {
        window.location.replace("index.html#home");
        return;
    }

    // Validacija i submit login forme
    $("#loginForm").validate({
      submitHandler: function (form) {
        const entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      }
    });
  },

  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",

      success: function (result) {
        // Spasi token
        localStorage.setItem("user_token", result.data.token);
        // Redirect na početnu
        window.location.replace("index.html#home");
      },

      error: function (xhr) {
        toastr.error(
          xhr?.responseJSON?.error ? xhr.responseJSON.error : "Login error"
        );
      }
    });
  },

  logout: function () {
    localStorage.clear();
    window.location.replace("login.html");
  },

  generateMenuItems: function () {
    const token = localStorage.getItem("user_token");
    const decoded = Utils.parseJwt(token);

    if (!decoded || !decoded.user) {
      window.location.replace("login.html");
      return;
    }

    const user = decoded.user;
    let nav = "";
    let main = "";

    // Role iz BACKENDA → customer / admin
    switch (user.role) {

      case Constants.USER_ROLE: // ← ovo je "customer"
        nav =
          '<li class="nav-item"><a class="nav-link" href="#products">Products</a></li>' +
          '<li class="nav-item"><a class="nav-link" href="#orders">My Orders</a></li>' +
          '<li class="nav-item"><button class="btn btn-sm btn-danger ms-3" onclick="UserService.logout()">Logout</button></li>';

        main =
          '<section id="products" data-load="views/products.html"></section>' +
          '<section id="orders" data-load="views/orders.html"></section>';

        break;

      case Constants.ADMIN_ROLE:
        nav =
          '<li class="nav-item"><a class="nav-link" href="#dashboard">Dashboard</a></li>' +
          '<li class="nav-item"><a class="nav-link" href="#products">Products</a></li>' +
          '<li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>' +
          '<li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>' +
          '<li class="nav-item"><button class="btn btn-sm btn-danger ms-3" onclick="UserService.logout()">Logout</button></li>';

        main =
          '<section id="dashboard" data-load="views/dashboard.html"></section>' +
          '<section id="products" data-load="views/products.html"></section>' +
          '<section id="categories" data-load="views/categories.html"></section>' +
          '<section id="reviews" data-load="views/reviews.html"></section>';

        break;
    }

    // Ubacivanje HTML-a
    $("#tabs").html(nav);
    $("#spapp").html(main);
  }
};

// auto start kao u labu
// ali SAMO na login stranici
if (window.location.href.includes("login")) {
  UserService.init();
}
