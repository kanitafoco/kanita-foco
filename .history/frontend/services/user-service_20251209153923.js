var UserService = {
    login: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/login",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
  
        success: function (result) {
          localStorage.setItem("user_token", result.data.token);
          window.location.replace("index.html");
        },
  
        error: function (xhr) {
          toastr.error(
            xhr?.responseJSON?.error ? xhr.responseJSON.error : "Login error"
          );
        }
      });
    },
  
    register: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/register",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
  
        success: function (result) {
          toastr.success("Account created! You can now log in.");
          window.location.replace("index.html#login");
        },
  
        error: function (xhr) {
          toastr.error(
            xhr?.responseJSON?.message ||
            xhr?.responseJSON?.error ||
            "Registration error"
          );
        }
      });
    },
  
    logout: function () {
      localStorage.clear();
      window.location.replace("index.html#login");
    }
  };
  
  // GLOBAL – radi i za login i za register, bez init() i hash provjere
  $(function () {
    // LOGIN submit
    $(document).on("submit", "#loginForm", function (e) {
      e.preventDefault();
  
      const entity = Object.fromEntries(new FormData(this).entries());
      UserService.login(entity);
    });
  
    // REGISTER submit
    $(document).on("submit", "#registerForm", function (e) {
      e.preventDefault();
  
      const raw = Object.fromEntries(new FormData(this).entries());
  
      const entity = {
        full_name: raw.name,
        email: raw.email,
        password: raw.password
      };
  
      UserService.register(entity);
    });
  });
  

  generateMenuItems: function () {
    const token = localStorage.getItem("user_token");
    if (!token) return window.location.replace("login.html");

    const user = Utils.parseJwt(token).user;
    const nav = document.getElementById("nav-menu");

    nav.innerHTML = ""; // clear old menu

    // HOME (everyone sees)
    nav.innerHTML += `
        <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#home">Home</a>
        </li>
    `;

    if (user.role === Constants.ADMIN_ROLE) {
        // ADMIN MENU
        nav.innerHTML += `
            <li class="nav-item mx-0 mx-lg-1">
                <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#students">Students</a>
            </li>
        `;
    }

    if (user.role === Constants.USER_ROLE) {
        // NORMAL USER MENU
        nav.innerHTML += `
            <li class="nav-item mx-0 mx-lg-1">
                <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a>
            </li>
            <li class="nav-item mx-0 mx-lg-1">
                <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a>
            </li>
        `;
    }

    // LOGOUT (everyone)
    nav.innerHTML += `
        <li class="nav-item mx-0 mx-lg-1">
            <button class="btn btn-danger ms-3" onclick="UserService.logout()">Logout</button>
        </li>
    `;
}

};