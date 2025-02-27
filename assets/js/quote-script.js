jQuery(document).ready(function ($) {
  // --------------------------------------------------------------------------
  // Form Submission
  // --------------------------------------------------------------------------
  $("#shutter-quote-form").submit(function (event) {
    event.preventDefault();

    // Collect form data
    var formData = $(this).serialize();

    // Add action and nonce to form data
    formData += "&action=process_shutter_form";
    formData += "&nonce=" + shutter_ajax_params.nonce;

    // Send data to server
    $.ajax({
      url: shutter_ajax_params.ajax_url,
      type: "POST",
      data: formData,
      success: function (response) {
        if (response.success) {
          alert(response.data.message);
          window.location.reload();
        } else {
          alert("Error: " + response.data.message);
        }
      },
      error: function (error) {
        console.error("AJAX error:", error);
        alert("Terjadi kesalahan saat mengirim formulir.");
      },
    });
  });

  // --------------------------------------------------------------------------
  // Summary
  // --------------------------------------------------------------------------

  function updateSummary() {
    var windowName = $("#quote_window_name").val();
    var price = $("#quote_price").val();

    $("#summary-window-name").text(windowName ? windowName : "");
    $("#summary-price").text(price ? price : "");
  }

  // Event listener untuk perubahan input window name
  $("#quote_window_name").on("input", function () {
    updateSummary();
  });

  // --------------------------------------------------------------------------
  // Calculations & Dynamic Updates
  // --------------------------------------------------------------------------
  function calculateAndUpdate() {
    var width = parseFloat($("#quote_width").val());
    var height = parseFloat($("#quote_height").val());
    var framePrice =
      parseFloat($('input[name="quote_frame"]:checked').data("price")) || 0;

    if (isNaN(width) || isNaN(height) || width <= 0 || height <= 0) {
      $("#quote_total_area").val("0.00");
      $("#quote_price").val("$0.00");
      return;
    }

    var area = (width * height) / 1000000;
    area = area.toFixed(2);

    var pricePerSqM = 100;
    var totalPrice = area * pricePerSqM + framePrice;
    totalPrice = totalPrice.toFixed(2);

    $("#quote_total_area").val(area);
    $("#quote_price").val("$" + totalPrice);
  }

  // Sidebar Tab Click
  $(".sidebar .step").click(function () {
    var stepNumber = $(this).data("step");

    // Hide all form steps first
    $(".form-step").addClass("hidden");

    // Show only the clicked step
    $('.form-step[data-step="' + stepNumber + '"]').removeClass("hidden");

    // Update sidebar active state
    $(".sidebar .step.active").removeClass("active bg-[#F1EBE6]");
    $(this).addClass("active bg-[#F1EBE6]");

    // Calculate and update
    calculateAndUpdate();
  });

  // --------------------------------------------------------------------------
  // Multi-Step Form Logic
  // --------------------------------------------------------------------------

  // Marks the step as complete in the sidebar.
  function markStepAsCompleted(stepNumber) {
    $('.sidebar .step[data-step="' + stepNumber + '"] .step-check').addClass(
      "inline"
    );
  }

  function markStepAsIncomplete(stepNumber) {
    $('.sidebar .step[data-step="' + stepNumber + '"] .step-check').removeClass(
      "inline"
    );
  }

  // Validates a single form-step
  function validateStep(step) {
    var isValid = true;

    // Validate text and select inputs
    step.find("input[required], select[required]").each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).closest(".form-row").addClass("error");
      } else {
        $(this).closest(".form-row").removeClass("error");
      }
    });

    // Validate radio buttons and checkboxes
    step
      .find('input[type="radio"][required], input[type="checkbox"][required]')
      .each(function () {
        var name = $(this).attr("name");
        if ($('input[name="' + name + '"]:checked').length === 0) {
          isValid = false;
          $(this).closest(".form-row").addClass("error");
        } else {
          $(this).closest(".form-row").removeClass("error");
        }
      });

    if (!isValid) {
      markStepAsIncomplete(step.data("step"));
    }

    return isValid;
  }

  // Next button Click Handle
  $(".next-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var nextStep = currentStep.next(".form-step");
    var stepNumber = currentStep.data("step");

    console.log("Next button clicked, validating step:", stepNumber);

    if (validateStep(currentStep)) {
      console.log("Step", stepNumber, "is valid");
      markStepAsCompleted(stepNumber);
      currentStep.addClass("hidden");
      nextStep.removeClass("hidden");

      $(".sidebar .step.active").removeClass("active bg-[#F1EBE6]");
      $('.sidebar .step[data-step="' + nextStep.data("step") + '"]').addClass(
        "active bg-[#F1EBE6]"
      );

      calculateAndUpdate();
      updateSummary();
    } else {
      console.log("Step", stepNumber, "is NOT valid");
      alert("Please fill in all required fields.");
    }
  });

  $(".prev-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var prevStep = currentStep.prev(".form-step");

    currentStep.addClass("hidden");
    prevStep.removeClass("hidden");

    let stepNumber = prevStep.data("step");

    $(".sidebar .step.active").removeClass("active bg-[#F1EBE6]");
    $('.sidebar .step[data-step="' + stepNumber + '"]').addClass(
      "active bg-[#F1EBE6]"
    );

    calculateAndUpdate();
  });

  // --------------------------------------------------------------------------
  // Initial Setup / Load Time
  // --------------------------------------------------------------------------
  $(".form-step").each(function () {
    var currentStep = $(this);

    if (validateStep(currentStep)) {
      markStepAsCompleted(currentStep.data("step"));
    }

    // Add background color to active step
    $(".step.active").addClass("bg-[#F1EBE6]");

    $("#quote_width, #quote_height").on("input", function () {
      calculateAndUpdate();
    });
  });

  // --------------------------------------------------------------------------
  // Sidebar Logic
  // --------------------------------------------------------------------------
  $(".sidebar .step").click(function () {
    var stepNumber = $(this).data("step");
    $(".form-step.active").removeClass("active");
    $('.form-step[data-step="' + stepNumber + '"]').addClass("active");

    $(".sidebar .step.active").removeClass("active");
    $(this).addClass("active");

    calculateAndUpdate();
  });

  // --------------------------------------------------------------------------
  // Conditional Form Fields
  // --------------------------------------------------------------------------
  $('input[name="quote_recess"]').change(function () {
    if ($(this).val() === "yes") {
      $(".conditional-recess-depth").slideDown();
    } else {
      $(".conditional-recess-depth").slideUp();
    }
  });

  // --------------------------------------------------------------------------
  // Color Options
  // --------------------------------------------------------------------------
  $(".color-option").on("click", function () {
    // Get the color value from the data attribute
    var colorValue = $(this).data("value");

    // Update the quote_color input field
    $("#quote_color").val(colorValue);

    // Remove outline-primary class from all color-option-preview elements
    $(".color-option-preview").removeClass("outline-primary outline-2");

    // Add outline-primary class to the clicked color option's preview
    $(this).find(".color-option-preview").addClass("outline-primary outline-2");
  });

  // --------------------------------------------------------------------------
  // Layout Options
  // --------------------------------------------------------------------------
  $('input[name="quote_layout"]').click(function () {
    $(".layout-option").removeClass("outline-primary outline-2");
    $(this).closest(".layout-option").addClass("outline-primary outline-2");
  });

  // --------------------------------------------------------------------------
  // Frame Options
  // --------------------------------------------------------------------------
  $(".frame-option").on("click", function () {
    $(".frame-option").removeClass("outline-primary outline-2");
    $(this).addClass("outline-primary outline-2");
  });

  // --------------------------------------------------------------------------
  // Initial Calculations
  // --------------------------------------------------------------------------
  calculateAndUpdate();
});
