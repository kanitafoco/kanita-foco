let RestClient = {

    
    get: function (url, callback, error_callback) {
        $.blockUI({ message: "<h3>Processing...</h3>" });
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
        },
        complete: function () {
            $.unblockUI();
        }
      });
    },
  
    
    request: function (url, method, data, callback, error_callback) {
        $.blockUI({ message: "<h3>Processing...</h3>" });
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: method,
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authentication",
            localStorage.getItem("user_token")
          );
        },
        contentType: "application/json",   
        data: JSON.stringify(data)         
      })
      .done(function (response) {
        if (callback) callback(response);
      })
      .fail(function (jqXHR) {
        if (error_callback) {
          error_callback(jqXHR);
        } else {
          toastr.error(
            jqXHR.responseJSON?.message || "Server error"
          );
        }
      },
      complete: function () {
        $.unblockUI();
      }
    });
  },
    
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
  