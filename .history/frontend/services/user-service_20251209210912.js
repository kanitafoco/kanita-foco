var UserService = {
    // LOGIN FUNKCIJA
    login: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/login",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
  
        success: function (result) {
          // Spremi token
          localStorage.setItem("user_token", result.data.token);
  
          // Dekodiraj JWT
          const decoded = Utils.parseJwt(result.data.token);
          console.log("Decoded JWT:", decoded);
  
          // Ekstrakcija user podataka iz decoded.user
          const u = decoded?.user;
  
          if (u) {
            const userInfo = {
              id: u.user_id,
              role: u.role,             // "admin" ili "user"
              email: u.email,
              full_name: u.full_name
            };
  
            console.log("Saving userInfo:", userInfo);
            localStorage.setItem("user_info", JSON.stringify(userInfo));
  
          } else {
            console.error("ERROR: Token does not contain user object!");
          }
  
          toastr.success("Login successful!");
          UserService.updateNavbar();
  
          // Navigacija
          setTimeout(() => {
            window.location.hash = "#home";
          }, 400);
        },
  
        error: function (xhr) {
          toastr.error(
            xhr?.responseJSON?.error ??
            "Login error"
          );
        }
      });
    },
  
    // REGISTER FUNKCIJA
    register: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/register",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
  
        success: function () {
          toastr.success("Account created! You can now log in.");
          window.location.replace("index.html#login");
        },
  
        error: function (xhr) {
          toastr.error(
            xhr?.responseJSON?.message ??
            xhr?.responseJSON?.error ??
            "Registration error"
          );
        }
      });
    },
  
    // LOGOUT
    logout: function () {
      localStorage.clear();
      UserService.updateNavbar();
      window.location.replace("index.html#login");
    },
  
    // NAVBAR UPDATE
    updateNavbar: function () {
        const token = localStorage.getItem("user_token");
        const userInfo = localStorage.getItem("user_info");
      
        console.log("updateNavbar ->", { token, userInfo });
      
        if ($("#authButtonsContainer").length === 0) {
          setTimeout(() => UserService.updateNavbar(), 100);
          return;
        }
      
        if (token && userInfo) {
          // USER JE LOGINAN
          $("#authButtonsContainer")
            .addClass("d-none")
            .removeClass("d-flex");
      
          $("#logoutButtonContainer")
            .removeClass("d-none")
            .addClass("d-flex");
      
          const user = JSON.parse(userInfo);
          $("#userDisplay").text(user.email || "User");
      
          // 🔥 ROLE-BASED MENI
          if (user.role === "customer") {
              $("#navCategories").hide();
          } else if (user.role === "admin") {
              $("#navCategories").show();
          }
      
        } else {
          // USER NIJE LOGINAN
          $("#authButtonsContainer")
            .removeClass("d-none")
            .addClass("d-flex");
      
          $("#logoutButtonContainer")
            .addClass("d-none")
            .removeClass("d-flex");
      
          // Prije login-a: Categories treba biti vidljiv
          $("#navCategories").show();
        }
      },
      
  
  
    isLoggedIn: function () {
      return !!localStorage.getItem("user_token");
    },
  
    getUserRole: function () {
      const userInfo = localStorage.getItem("user_info");
      if (!userInfo) return null;
  
      const user = JSON.parse(userInfo);
      return user.role || null;
    },
  
    isAdmin: function () {
      const role = UserService.getUserRole();
      return role === "admin";
    }
  };
  
  // JQUERY INIT
  $(function () {
  
    UserService.updateNavbar();
    // LOGIN SUBMIT
    $(document).on("submit", "#loginForm", function (e) {
      e.preventDefault();
      const entity = Object.fromEntries(new FormData(this).entries());
      UserService.login(entity);
    });
  
    // REGISTER SUBMIT
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
  
    // Kad promijeni hash → update navbara
    $(window).on("hashchange", function () {
      UserService.updateNavbar();
    });
  });