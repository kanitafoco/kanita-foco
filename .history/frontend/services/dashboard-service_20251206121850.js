var DashboardService = {

    init: function () {
        this.loadStats();
    },

    loadStats: function () {
        RestClient.get("dashboard/stats", function (response) {

            $("#dashboard-root").html(`
                <h2 class="text-center mb-4">Dashboard</h2>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow p-3">
                            <h4>Total Products</h4>
                            <p class="fw-bold fs-3 text-primary">${response.data.total_products}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow p-3">
                            <h4>Total Orders</h4>
                            <p class="fw-bold fs-3 text-success">${response.data.total_orders}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow p-3">
                            <h4>Total Users</h4>
                            <p class="fw-bold fs-3 text-danger">${response.data.total_users}</p>
                        </div>
                    </div>
                </div>
            `);
        });
    }
};
