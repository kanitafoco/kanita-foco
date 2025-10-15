var app = $.spapp({
    defaultView: "home",
    templateDir: "views/"

});

app.route({
    view:"home",
    load:"home.html"
});

app.route({
    view:"categories",
    load:"categories.html"
});

app.route({
    view:"contact",
    load:"contact.html"
});

app.route({
    view:"dashboard",
    load:"dashboard.html"
});

app.route({
    view:"login",
    load:"login.html"
});

app.route({
    view:"orders",
    load:"orders.html"
});

app.route({
    view:"products",
    load:"products.html"
});

app.route({
    view:"profile",
    load:"profile.html"
});

app.route({
    view:"register",
    load:"register.html"
});

app.run();