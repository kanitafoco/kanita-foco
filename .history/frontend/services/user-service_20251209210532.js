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
  

success: function (result) {

    // 1. Spremi token
    localStorage.setItem("user_token", result.data.token);

    // 2. Decode JWT token
    const decoded = Utils.parseJwt(result.data.token);
    const u = decoded?.user;

    // 3. Spremi user_info u localStorage (role, email itd.)
    if (u) {
        const userInfo = {
            user_id: u.user_id,
            role: u.role,       // OVDJE JE ROLE KOJI TREBA updateRoleUI!
            email: u.email,
            full_name: u.full_name
        };

        localStorage.setItem("user_info", JSON.stringify(userInfo));
    }

    // 4. Sakrij/prikaži navbar based on role
    UserService.updateRoleUI();

    // 5. Redirect na home
    window.location.replace("index.html");
}

