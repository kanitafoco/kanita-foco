var ProfileService = {

    init: function () {
        this.loadProfile();

        $("#profileForm").validate({
            submitHandler: function (form) {
                let data = Object.fromEntries(new FormData(form).entries());
                ProfileService.updateProfile(data);
            }
        });
    },

    loadProfile: function () {
        RestClient.get("users/me", function (response) {
            let u = response.data;

            $("#profile_name").val(u.full_name);
            $("#profile_email").val(u.email);
        });
    },

    updateProfile: function (data) {
        RestClient.put("users/me", data, function () {
            toastr.success("Profile updated!");
        });
    }
};
