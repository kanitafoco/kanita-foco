var ContactService = {

    init: function () {
        $("#contactForm").validate({
            submitHandler: function (form) {
                let message = Object.fromEntries(new FormData(form).entries());
                ContactService.sendMessage(message);
            }
        });
    },

    sendMessage: function (data) {
        RestClient.post("contact", data, function () {
            toastr.success("Message sent!");
            $("#contactForm")[0].reset();
        });
    }
};
