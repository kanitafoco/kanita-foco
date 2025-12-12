var ReviewService = {

    init: function () {
        this.loadReviews();
    },

    loadReviews: function () {
        RestClient.get("reviews", function (response) {

            let columns = [
                { data: "product_name", title: "Product" },
                { data: "rating", title: "Rating" },
                { data: "comment", title: "Comment" },
                {
                    data: null,
                    title: "Actions",
                    render: function (row) {
                        return `<button class="btn btn-danger btn-sm" onclick="ReviewService.deleteReview(${row.review_id})">Delete</button>`;
                    }
                }
            ];

            Utils.datatable("reviews-table", columns, response.data);
        });
    },

    deleteReview: function (id) {
        RestClient.delete("reviews/" + id, {}, function () {
            toastr.success("Review deleted!");
            ReviewService.loadReviews();
        });
    }
};
