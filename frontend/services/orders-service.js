var OrderService = {

    init: function () {
        this.loadOrders();
    },

    loadOrders: function () {
        RestClient.get("orders/my", function (response) {

            let columns = [
                { data: "order_id", title: "Order ID" },
                { data: "total", title: "Total (€)" },
                { data: "created_at", title: "Date" },
                {
                    data: "items",
                    title: "Items",
                    render: items => items.length
                }
            ];

            Utils.datatable("orders-table", columns, response.data);
        });
    }
};
