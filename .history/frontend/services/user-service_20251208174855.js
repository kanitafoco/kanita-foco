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

  <section>
  <div class="form-card card p-4">
    <h3>Create Account</h3>
    <form id="registerForm">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input class="form-control" name="name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-success">Register</button>
      </div>
    </form>
    <div class="text-center mt-3 small text-muted">
      Already have an account? <a href="#login" data-route="login">Login</a>
    </div>
  </div>
</section>




  