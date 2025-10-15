var app = $.spapp({
    defaultView: "home",
    templateDir: "views/"

});

app.route({
    view:"home",
    load:""
})


app.run();