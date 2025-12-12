var CategoryService = {

    init: function () {
        this.loadCategories();

        $("#addCategoryForm").validate({
            submitHandler: function (form) {
                let data = Object.fromEntries(new FormData(form).entries());
                CategoryService.addCategory(data);
            }
        });

        $("#editCategoryForm").validate({
            submitHandler: function (form) {
                let data = Object.fromEntries(new FormData(form).entries());
                CategoryService.updateCategory(data.category_id, data);
            }
        });
    },

    loadCategories: function () {
        RestClient.get("categories", function (response) {
    
            console.log("categories response:", response); 
    
            let columns = [
                { data: "name", title: "Name" },
                { data: "description", title: "Description" },
                {
                    data: null,
                    title: "Actions",
                    render: function (row) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="CategoryService.openEditModal(${row.category_id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="CategoryService.openDeleteModal(${row.category_id})">Delete</button>
                        `;
                    }
                }
            ];
    
            Utils.datatable("categories-table", columns, response.data);
        });
    },

    openAddModal: function () {
        $("#addCategoryModal").modal("show");
    },

    addCategory: function (data) {
        RestClient.post("categories", data, function () {
            toastr.success("Category added!");
            CategoryService.loadCategories();
            CategoryService.closeModal();
        });
    },

    openEditModal: function (id) {
        RestClient.get("categories/" + id, function (response) {
            let c = response.data;

            $("#edit_category_id").val(c.category_id);
            $("#edit_name").val(c.name);
            $("#edit_description").val(c.description);

            $("#editCategoryModal").modal("show");
        });
    },

    updateCategory: function (id, data) {
        RestClient.put("categories/" + id, data, function () {
            toastr.success("Updated!");
            CategoryService.loadCategories();
            CategoryService.closeModal();
        });
    },

    openDeleteModal: function (id) {
        $("#delete_category_id").val(id);
        $("#deleteCategoryModal").modal("show");
    },

    deleteCategory: function () {
        let id = $("#delete_category_id").val();

        RestClient.delete("categories/" + id, {}, function () {
            toastr.success("Deleted!");
            CategoryService.loadCategories();
            CategoryService.closeModal();
        });
    },

    closeModal: function () {
        $(".modal").modal("hide");
    }
};
