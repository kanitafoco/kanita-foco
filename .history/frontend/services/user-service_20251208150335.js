var UserService = {

    init: function () {

        const token = localStorage.getItem("user_token");

        // Ako je logovan i pokušava otvoriti login → vrati ga na home
        if (token && window.location.hash === "#login") {
            window.location.replace("index.html#home");
            return;
        }

        // Aktiviraj login formu
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

        $("#tabs").html(nav);
        $("#spapp").html(main);
    }
};


// POKREĆE SE KADA GOD USER OTVORI LOGIN
if (window.location.hash === "#login") {
    UserService.init();
}

$(window).on("hashchange", function () {
    if (window.location.hash === "#login") {
        setTimeout(() => UserService.init(), 50);
    }
});

  