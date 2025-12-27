var UserService = {

    init: function () {
        var token = localStorage.getItem("user_token");

        // Ako vec logovan → idi na home
        if (token) {
            window.location.replace("index.html#home");
            return;
        }

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
                localStorage.setItem("user_token", result.data.token);

                // Redirect nakon login-a
                window.location.replace("index.html#home");
            },

            error: function (xhr) {
                toastr.error(xhr?.responseJSON?.error || "Login error");
            }
        });
    },

    logout: function () {
        localStorage.clear();
        window.location.replace("index.html#login");
    },

    generateMenuItems: function () {
        const token = localStorage.getItem("user_token");
        const decoded = Utils.parseJwt(token);

        if (!decoded || !decoded.user) {
            window.location.replace("index.html#login");
            return;
        }

        const user = decoded.user;
        let nav = "";
        let main = "";

        switch (user.role) {

            case Constants.USER_ROLE:
                nav += '<li class="nav-item"><a class="nav-link" href="#products">Products</a></li>';
                nav += '<li class="nav-item"><a class="nav-link" href="#orders">My Orders</a></li>';
                nav += '<li class="nav-item"><button class="btn btn-danger btn-sm ms-3" onclick="UserService.logout()">Logout</button></li>';

                main =
                    '<section id="products" data-load="views/products.html"></section>' +
                    '<section id="orders" data-load="views/orders.html"></section>';
                break;

            case Constants.ADMIN_ROLE:
                nav += '<li class="nav-item"><a class="nav-link" href="#dashboard">Dashboard</a></li>';
                nav += '<li class="nav-item"><a class="nav-link" href="#products">Products</a></li>';
                nav += '<li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>';
                nav += '<li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>';
                nav += '<li class="nav-item"><button class="btn btn-danger btn-sm ms-3" onclick="UserService.logout()">Logout</button></li>';

                main =
                    '<section id="dashboard" data-load="views/dashboard.html"></section>' +
                    '<section id="products" data-load="views/products.html"></section>' +
                    '<section id="categories" data-load="views/categories.html"></section>' +
                    '<section id="reviews" data-load="views/reviews.html"></section>';
                break;
        }

        $("#tabs").html(nav);
        $("#spapp").html(main);
    }
};

if (window.location.href.includes("login")) {
    UserService.init();
}
