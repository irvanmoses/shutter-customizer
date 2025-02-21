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
          window.location.href = shutter_ajax_params.home_url;
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

  $("#quote_width, #quote_height").on("input", function () {
    calculateAndUpdate();
  });
  // Sidebar Tab Click
  $(".sidebar .step").click(function () {
    var stepNumber = $(this).data("step");
    $(".form-step.active").removeClass("active");
    $('.form-step[data-step="' + stepNumber + '"]').addClass("active");

    $(".sidebar .step.active").removeClass("active");
    $(this).addClass("active");

    // Update kalkulasi (jika ada)
    calculateAndUpdate();
  });

  // --------------------------------------------------------------------------
  // Multi-Step Form Logic
  // --------------------------------------------------------------------------

  // Marks the step as complete in the sidebar.
  function markStepAsCompleted(stepNumber) {
    $('.sidebar .step[data-step="' + stepNumber + '"]').addClass("completed");
  }

  // Validates a single form-step
  function validateStep(step) {
    var isValid = true;

    console.log("Validating step:", step.data("step"));

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

    console.log("Step", step.data("step"), "is valid:", isValid);
    return isValid;
  }

  // Next button Click Handle
  $(".next-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var nextStep = currentStep.next(".form-step");
    var stepNumber = currentStep.data("step");

    console.log("Next button clicked, validating step:", stepNumber); // Tambahkan ini

    if (validateStep(currentStep)) {
      console.log("Step", stepNumber, "is valid"); // Tambahkan ini
      markStepAsCompleted(stepNumber);
      currentStep.removeClass("active");
      nextStep.addClass("active");

      $(".sidebar .step.active").removeClass("active");
      $('.sidebar .step[data-step="' + nextStep.data("step") + '"]').addClass(
        "active"
      );

      calculateAndUpdate();
    } else {
      console.log("Step", stepNumber, "is NOT valid"); // Tambahkan ini
      alert("Please fill in all required fields.");
    }
  });

  $(".prev-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var prevStep = currentStep.prev(".form-step");

    currentStep.removeClass("active");
    prevStep.addClass("active");

    var stepNumber = prevStep.data("step");
    $(".sidebar .step.active").removeClass("active");
    $('.sidebar .step[data-step="' + stepNumber + '"]').addClass("active");

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
    const $this = $(this);
    const isCurrentlySelected = $this.hasClass("selected");

    if (isCurrentlySelected) {
      $this.removeClass("selected");
      $("#quote_color").val("");
    } else {
      $(".color-option").removeClass("selected");
      $this.addClass("selected");
      $("#quote_color").val($this.data("value"));
    }
  });

  // --------------------------------------------------------------------------
  // Initial Calculations
  // --------------------------------------------------------------------------
  calculateAndUpdate();
});
