var UserService = {

    /* =========================
       SPA INIT (OBAVEZNO)
       ========================= */
    init: function () {
      // SPApp očekuje da ova funkcija postoji
      this.updateNavbar();
    },
  
    /* =========================
       LOGIN
       ========================= */
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
  
          const u = decoded?.user;
  
          if (u) {
            const userInfo = {
              id: u.user_id,
              role: u.role,
              email: u.email,
              full_name: u.full_name
            };
  
            localStorage.setItem("user_info", JSON.stringify(userInfo));
          } else {
            console.error("Token does not contain user object");
          }
  
          toastr.success("Login successful!");
          UserService.updateNavbar();
  
          setTimeout(() => {
            window.location.hash = "#home";
          }, 300);
        },
  
        error: function (xhr) {
          toastr.error(
            xhr?.responseJSON?.error ?? "Login error"
          );
        }
      });
    },
  
    /* =========================
       REGISTER
       ========================= */
    register: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/register",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
  
        success: function () {
          toastr.success("Account created! You can now log in.");
          window.location.hash = "#login";
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
  
    /* =========================
       LOGOUT
       ========================= */
    logout: function () {
      localStorage.removeItem("user_token");
      localStorage.removeItem("user_info");
      this.updateNavbar();
      window.location.hash = "#login";
    },
  
    /* =========================
       NAVBAR LOGIC
       ========================= */
    updateNavbar: function () {
      const token = localStorage.getItem("user_token");
      const userInfo = localStorage.getItem("user_info");
  
      if ($("#authButtonsContainer").length === 0) {
        setTimeout(() => this.updateNavbar(), 100);
        return;
      }
  
      if (token && userInfo) {
        $("#authButtonsContainer").addClass("d-none");
        $("#logoutButtonContainer").removeClass("d-none");
  
        const user = JSON.parse(userInfo);
        $("#userDisplay").text(user.email || "User");
  
        if (user.role === "customer") {
          $("#navCategories").hide();
        } else if (user.role === "admin") {
          $("#navCategories").show();
        }
  
      } else {
        $("#authButtonsContainer").removeClass("d-none");
        $("#logoutButtonContainer").addClass("d-none");
        $("#navCategories").show();
      }
    },
  
    /* =========================
       HELPERS
       ========================= */
    isLoggedIn: function () {
      return !!localStorage.getItem("user_token");
    },
  
    getUserRole: function () {
      const userInfo = localStorage.getItem("user_info");
      if (!userInfo) return null;
      return JSON.parse(userInfo).role;
    },
  
    isAdmin: function () {
      return this.getUserRole() === "admin";
    }
  };
  
  /* =========================
     GLOBAL EVENT BINDINGS
     ========================= */
  $(function () {
  
    UserService.updateNavbar();
  
    $(document).on("submit", "#loginForm", function (e) {
      e.preventDefault();
      const entity = Object.fromEntries(new FormData(this).entries());
      UserService.login(entity);
    });
  
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
  
    $(window).on("hashchange", function () {
      UserService.updateNavbar();
    });
  });
  