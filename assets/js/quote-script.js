jQuery(document).ready(function ($) {
  // Fungsi untuk kalkulasi dan update tampilan (diubah agar tidak langsung dieksekusi)
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

  // Multi-Step Form Navigation
  $(".next-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var nextStep = currentStep.next(".form-step");

    // Validasi input di step saat ini (contoh sederhana)
    var isValid = true;
    currentStep.find("input[required], select[required]").each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass("error"); // Tambahkan kelas error untuk styling
      } else {
        $(this).removeClass("error"); // Hapus kelas error jika valid
      }
    });

    if (isValid) {
      currentStep.removeClass("active");
      nextStep.addClass("active");

      // Update sidebar tab
      var stepNumber = nextStep.data("step");
      $(".sidebar .step.active").removeClass("active");
      $('.sidebar .step[data-step="' + stepNumber + '"]').addClass("active");

      // Update kalkulasi (jika ada)
      calculateAndUpdate();
    } else {
      alert("Please fill in all required fields.");
    }
  });

  $(".prev-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var prevStep = currentStep.prev(".form-step");

    currentStep.removeClass("active");
    prevStep.addClass("active");

    // Update sidebar tab
    var stepNumber = prevStep.data("step");
    $(".sidebar .step.active").removeClass("active");
    $('.sidebar .step[data-step="' + stepNumber + '"]').addClass("active");

    // Update kalkulasi (jika ada)
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

  // Kondisional Field (Contoh Recess Depth)
  $('input[name="quote_recess"]').change(function () {
    if ($(this).val() === "yes") {
      $(".conditional-recess-depth").slideDown();
    } else {
      $(".conditional-recess-depth").slideUp();
    }
  });

  // Inisialisasi Kalkulasi
  calculateAndUpdate();
});
