/* ==========================================================
    SPAPP ROUTER – JEDINI ROUTER U APLIKACIJI
========================================================== */
$(document).ready(function () {

  var app = $.spapp({
    defaultView: "home",
    templateDir: "views/"
  });

  // ROUTES
  app.route({ view: "home",       load: "home.html" });
  app.route({ view: "products",   load: "products.html" });
  app.route({ view: "categories", load: "categories.html" });
  app.route({ view: "reviews",    load: "reviews.html" });
  app.route({ view: "contact",    load: "contact.html" });
  app.route({ view: "login",      load: "login.html" });
  app.route({ view: "register",   load: "register.html" });
  app.route({ view: "profile",    load: "profile.html" });
  app.route({ view: "dashboard",  load: "dashboard.html" });
  app.route({ view: "orders",     load: "orders.html" });

  app.run();
});


/* ==========================================================
   VIEWCHANGE – UČITAVANJE SERVISA PO STRANICI
========================================================== */
$(document).on("viewchange", function (e, page) {

  console.log("Loaded view:", page);

  if (page === "categories") CategoryService.init();
  if (page === "products")   ProductService.init();
  if (page === "orders")     OrderService.init();   // ⬅️ BITNO: OrderService
  if (page === "reviews")    ReviewService.init();
  if (page === "dashboard")  DashboardService.init();
  if (page === "profile")    ProfileService.init();

});
