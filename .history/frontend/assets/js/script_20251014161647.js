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
    view:"home",
    load:"home.html"
});


app.run();