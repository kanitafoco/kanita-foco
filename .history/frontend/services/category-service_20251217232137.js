var CategoryService = {

    init: function () {
        if (UserService.isAdmin()) {
            console.log("User is admin - loading categories");
            $("#adminCategorySection").show();
            $("#notAdminMessage").hide();
            this.loadCategories();

            $("#addCategoryForm").validate({
                rules: {
                  name: { required: true, minlength: 2, maxlength: 50 },
                  description: { required: true, minlength: 5, maxlength: 255 }
                },
                messages: {
                  name: {
                    required: "Name is required",
                    minlength: "Minimum 2 characters",
                    maxlength: "Maximum 50 characters"
                  },
                  description: {
                    required: "Description is required",
                    minlength: "Minimum 5 characters",
                    maxlength: "Maximum 255 characters"
                  }
                },
                submitHandler: function (form) {
                  let data = Object.fromEntries(new FormData(form).entries());
                  CategoryService.addCategory(data);
                }
              });
              
              $("#editCategoryForm").validate({
                rules: {
                  name: { required: true, minlength: 2, maxlength: 50 },
                  description: { required: true, minlength: 5, maxlength: 255 }
                },
                messages: {
                  name: {
                    required: "Name is required",
                    minlength: "Minimum 2 characters",
                    maxlength: "Maximum 50 characters"
                  },
                  description: {
                    required: "Description is required",
                    minlength: "Minimum 5 characters",
                    maxlength: "Maximum 255 characters"
                  }
                },
                submitHandler: function (form) {
                  let data = Object.fromEntries(new FormData(form).entries());
                  CategoryService.updateCategory(data.category_id, data);
                }
              });
              

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
    
            Utils.datatable("categories-table", columns, response);
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
    RestClient.get("category/" + id, function (response) {
        console.log("openEditModal response:", response);

        const c = response.data || response;

        $("#edit_category_id").val(c.category_id);
        $("#edit_name").val(c.name);
        $("#edit_description").val(c.description);

        $("#editCategoryModal").modal("show");
    });
},


    updateCategory: function (id, data) {
        RestClient.patch("category/" + id, data, function () {
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

    RestClient.delete("category/" + id, {}, function () {
        toastr.success("Deleted!");
        CategoryService.loadCategories();
        CategoryService.closeModal();
    }, function (err) {
        console.log("Delete failed:", err);
        toastr.error("Delete failed!");
    });
},


    closeModal: function () {
        $(".modal").modal("hide");
    }
};