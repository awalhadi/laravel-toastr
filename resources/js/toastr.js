// resources/js/toastr.js
(function () {
  window.LaravelToastr = {
    options: {},

    notify: function (type, message, title, options) {
      this.options = Object.assign({}, this.options, options);

      // Here you can customize how the notification is displayed
      // For this example, we'll use the browser's built-in alert function
      let alertMessage = title ? `${title}\n${message}` : message;
      alert(`${type.toUpperCase()}: ${alertMessage}`);

      // You could also use a more sophisticated notification library here
    },

    success: function (message, title, options) {
      this.notify('success', message, title, options);
    },

    info: function (message, title, options) {
      this.notify('info', message, title, options);
    },

    warning: function (message, title, options) {
      this.notify('warning', message, title, options);
    },

    error: function (message, title, options) {
      this.notify('error', message, title, options);
    },
  };
})();
