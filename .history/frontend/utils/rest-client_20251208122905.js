let RestClient = {

    // GET metoda
    get: function (url, callback, error_callback) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: "GET",
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authentication",
            localStorage.getItem("user_token")
          );
        },
        success: function (response) {
          if (callback) callback(response);
        },
        error: function (jqXHR) {
          if (error_callback) error_callback(jqXHR);
        }
      });
    },
  
    // Generalna request metoda (POST, PUT, PATCH, DELETE)
    request: function (url, method, data, callback, error_callback) {
        $.ajax({
            url: url,
            type: method,
            data: data ? JSON.stringify(data) : null,
            contentType: "application/json",
            headers: {
                "Authentication": localStorage.getItem("token")
            },
            success: callback,
            error: function (xhr) {
                console.error(xhr);
                toastr.error(xhr.responseText);
            }
        });
    },
  
    // Helperi
    post: function (url, data, callback, error_callback) {
      RestClient.request(url, "POST", data, callback, error_callback);
    },
  
    delete: function (url, data, callback, error_callback) {
      RestClient.request(url, "DELETE", data, callback, error_callback);
    },
  
    patch: function (url, data, callback, error_callback) {
      RestClient.request(url, "PATCH", data, callback, error_callback);
    },
  
    put: function (url, data, callback, error_callback) {
      RestClient.request(url, "PUT", data, callback, error_callback);
    }
  };
  