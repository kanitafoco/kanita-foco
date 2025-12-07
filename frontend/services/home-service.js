var HomeService = {

    init: function () {
        this.loadFeatured();
    },

    loadFeatured: function () {
        RestClient.get("products/featured", function (response) {

            let html = "";
            response.data.forEach(p => {
                html += `
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <img src="${p.image}" class="card-img-top">
                            <div class="card-body">
                                <h5>${p.name}</h5>
                                <p>${p.price} €</p>
                            </div>
                        </div>
                    </div>`;
            });

            $("#home-featured").html(html);
        });
    }
};
