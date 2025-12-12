var ProductService = {

    

    init: function () {
        this.loadProducts();

        $("#addProductForm").validate({
            submitHandler: function (form) {
                let data = Object.fromEntries(new FormData(form).entries());
                ProductService.addProduct(data);
            }
        });

        $("#editProductForm").validate({
            submitHandler: function (form) {
                let data = Object.fromEntries(new FormData(form).entries());
                ProductService.updateProduct(data.product_id, data);
            }
        });
    },

    

    loadProducts: function () {
        RestClient.get("products", function (response) {

            let columns = [
                { data: "name", title: "Name" },
                { data: "price", title: "Price" },
                { data: "category_name", title: "Category" },
                {
                    data: null,
                    title: "Actions",
                    render: function (row) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="ProductService.openEditModal(${row.product_id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="ProductService.openDeleteModal(${row.product_id})">Delete</button>
                        `;
                    }
                }
            ];

            Utils.datatable("products-table", columns, response.data);
        });
    },

    

    openAddModal: function () {
        $("#addProductModal").modal("show");
    },

    addProduct: function (data) {
        RestClient.post("products", data, function () {
            toastr.success("Product added!");
            ProductService.loadProducts();
            ProductService.closeModal();
        });
    },

    openEditModal: function (id) {
        RestClient.get("products/" + id, function (response) {
            let p = response.data;
            $("#edit_product_id").val(p.product_id);
            $("#edit_name").val(p.name);
            $("#edit_price").val(p.price);
            $("#edit_category").val(p.category_id);

            $("#editProductModal").modal("show");
        });
    },

    updateProduct: function (id, data) {
        RestClient.put("products/" + id, data, function () {
            toastr.success("Updated successfully");
            ProductService.loadProducts();
            ProductService.closeModal();
        });
    },

    openDeleteModal: function (id) {
        $("#delete_product_id").val(id);
        $("#deleteProductModal").modal("show");
    },

    deleteProduct: function () {
        let id = $("#delete_product_id").val();

        RestClient.delete("products/" + id, {}, function () {
            toastr.success("Deleted!");
            ProductService.loadProducts();
            ProductService.closeModal();
        });
    },

    loadShopProducts: function () {
        RestClient.get("products", function (response) {

            let html = "";

            response.data.forEach(p => {
                html += `
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/images/${p.image || 'placeholder.jpg'}" class="card-img-top" alt="${p.name}">
                        <div class="card-body">
                            <h5>${p.name}</h5>
                            <p class="text-muted">$${p.price}</p>
                            <button class="btn btn-primary add-to-cart"
                                onclick="ProductService.addToCart(${p.product_id})">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>`;
            });

            $("#product-list").html(html);
        });
    },

    addToCart: function (productId) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart.push(productId);
        localStorage.setItem("cart", JSON.stringify(cart));
        toastr.success("Product added to cart!");
    }


    closeModal: function () {
        $(".modal").modal("hide");
    }
};

