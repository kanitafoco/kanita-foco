let RestClient = {
    get: function (url, callback, error_callback) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: "GET",
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authentication", localStorage.getItem("user_token"));
        },
        success: callback,
        error: error_callback
      });
    },

    request: function (url, method, data, callback, error_callback) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: method,
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authentication", localStorage.getItem("user_token"));
        },
        contentType: "application/json",
        data: JSON.stringify(data)
      })
      .done(callback)
      .fail(error_callback);
    },

    post(url, data, callback, error_callback)  { this.request(url, "POST", data, callback, error_callback); },
    delete(url, data, callback, error_callback){ this.request(url, "DELETE", data, callback, error_callback); },
    patch(url, data, callback, error_callback) { this.request(url, "PATCH", data, callback, error_callback); },
    put(url, data, callback, error_callback)   { this.request(url, "PUT", data, callback, error_callback); },
};
