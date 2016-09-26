// bootstrap-select-togglebutton

(function($) {
  // Define the togglebutton plugin.
  $.fn.togglebutton = function(opts) {
    // Apply the users options if exists.
    var settings = $.extend( {}, $.fn.togglebutton.defaults, opts);

    // For each select element.
    this.each(function() {
      var self = $(this);
      var multiple = this.multiple;

      // Retrieve data attributes
      var data = self.data()

      // Retrieve all options.
      var options = self.children('option');

      // Remove first option?
      if (settings.removeFirst) {
        options = options.slice(1);
      }

      // Create an array of buttons with the value of select options.
      var buttons = options.map(function(index, opt) {
        var button = $("<button type='button' class='swatch'></button>")
        .prop('value', opt.value)
        .text(opt.text);

        // Add an `active` class if the option has been selected.
        if (opt.selected)
          button.addClass("active");

        // Return the button.
        return button[0];
      });

      // For each button, implement the click button removing and adding
      // `active` class to simulate the toggle effect. And also change the
      // select selected option.
      buttons.each(function(index, btn) {
        self.change(function() {
          settings.onChange($(btn).val(), $(btn).text(), self);
        });

        $(btn).click(function() {
          // Retrieve all buttons siblings of the clicked one with an
          // `active` class !
          var activeBtn = $(btn).siblings(".active");
          var total = [];

          // Remove all selected property on options.
          self.children("option:selected").prop("selected", false);

          // Check if the clicked button has the class `active`.
          // Add or remove it according to the check.
          if ($(btn).hasClass("active"))  {
            $(btn).removeClass("active");
          }
          else {
            $(btn).addClass("active");
            options.val(btn.value).prop("selected", true);
            total.push(btn.value);
          }

          // If the select allow multiple values, remove all active
          // class to the other buttons (to keep only the last clicked
          // button).
          if (!multiple) {
            activeBtn.removeClass("active");
          }

          // Push all active buttons value in an array.
          activeBtn.each(function(index, btn) {
            total.push(btn.value);
          });

          // Change selected options of the select.
          self.val(total).change();
        });
      });

      // Group all the buttons in a `div` element.
      var btnGroup = $("<div class='swatch-group'>").append(buttons);

      // Include the buttons group after the select element.
      self.after(btnGroup);
      // Hide the display element.
      self.hide();

      // save the btnGroup and buttons so we can use it later
      self.data('group', btnGroup);
      self.data('buttons', buttons);
    });
  };

  // Set the defaults options of the plugin.
  $.fn.togglebutton.defaults = {
    removeFirst: false,
    onChange: $.noop
  };

}(jQuery));
