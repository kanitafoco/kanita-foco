/* -------------------------
   SPAPP ROUTER
-------------------------- */
$(document).ready(function () {

    var app = $.spapp({
        defaultView: "home",
        templateDir: "views/"
    });

    // ROUTES
    app.route({ view: "home", load: "home.html" });
    app.route({ view: "categories", load: "categories.html" });
    app.route({ view: "contact", load: "contact.html" });
    app.route({ view: "dashboard", load: "dashboard.html" });
    app.route({ view: "login", load: "login.html" });
    app.route({ view: "orders", load: "orders.html" });
    app.route({ view: "products", load: "products.html" });
    app.route({ view: "profile", load: "profile.html" });
    app.route({ view: "register", load: "register.html" });
    app.route({ view: "reviews", load: "reviews.html" });

    app.run();
});

/* --------------------------------------------------------
   VIEWCHANGE EVENT → LOAD SERVICES WHEN PAGE IS LOADED
-------------------------------------------------------- */
$(document).on("viewchange", function (e, page) {
    console.log("Loaded view:", page);

    if (page === "categories") CategoryService.init();
    if (page === "products")   ProductService.init();
    if (page === "orders")     OrdersService.init();
    if (page === "reviews")    ReviewService.init();
    if (page === "dashboard")  DashboardService.init();
    if (page === "profile")    ProfileService.init();

    // Login / Register frontend only
    if (page === "login" || page === "register") attachAuthForms();
});

/* --------------------------------------------------------
   LOGIN & REGISTER HANDLING (FRONTEND ONLY)
-------------------------------------------------------- */
function attachAuthForms() {

    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const data = Object.fromEntries(new FormData(loginForm));
            localStorage.setItem("urban_user", data.email);
            localStorage.setItem("urban_role", "customer");

            window.location.hash = "#dashboard";
        });
    }

    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const data = Object.fromEntries(new FormData(registerForm));
            localStorage.setItem("urban_user", data.email);
            localStorage.setItem("urban_role", "customer");

            window.location.hash = "#dashboard";
        });
    }
}
