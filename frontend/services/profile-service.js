var ProfileService = {

    init: function () {
        this.loadProfile();
        this.loadOrders();
    },

    loadProfile: function () {
        RestClient.get("users/me", function (response) {
            $("#profile-name").text(response.data.name);
            $("#profile-email").text(response.data.email);
        });
    },

    loadOrders: function () {
        RestClient.get("orders/my", function (response) {
            let html = "";
            response.data.forEach(o => {
                html += `<li class="list-group-item">${o.first_product_name} — ${o.created_at}</li>`;
            });

            $("#profile-orders").html(html);
        });
    }
};
