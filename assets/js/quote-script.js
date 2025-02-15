jQuery(document).ready(function ($) {
  // Handle submit
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
          // Tampilkan pesan sukses
          alert(response.data.message); // Atau tampilkan di elemen HTML
          window.location.href = shutter_ajax_params.home_url;
        } else {
          // Tampilkan pesan error
          alert("Error: " + response.data.message); // Atau tampilkan di elemen HTML
        }
      },
      error: function (error) {
        // Tampilkan pesan error dan/atau log error ke console
        console.error("AJAX error:", error);
        alert("Terjadi kesalahan saat mengirim formulir.");
      },
    });
  });

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

  // Automatic update of price and total area when setting width and height
  $("#quote_width, #quote_height").on("input", function () {
    calculateAndUpdate();
  });

  function markStepAsCompleted(stepNumber) {
    $('.sidebar .step[data-step="' + stepNumber + '"]').addClass("completed");
  }

  // Multi-Step Form Navigation
  $(".next-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var nextStep = currentStep.next(".form-step");
    var stepNumber = currentStep.data("step");

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
      // Mark step as complete
      markStepAsCompleted(stepNumber);

      currentStep.removeClass("active");
      nextStep.addClass("active");

      // Update sidebar tab
      $(".sidebar .step.active").removeClass("active");
      $('.sidebar .step[data-step="' + nextStep.data("step") + '"]').addClass(
        "active"
      );

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

  // Fungsi untuk menyertakan checklist saat Load Halaman
  $(".form-step").each(function () {
    var currentStep = $(this);
    var stepNumber = currentStep.data("step");

    var isValid = true;
    currentStep.find("input[required], select[required]").each(function () {
      if (!$(this).val()) {
        isValid = false;
      }
    });

    if (isValid && stepNumber < 6) {
      markStepAsCompleted(stepNumber);
    }
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

  // Handle color option selection
  $(".color-option").on("click", function () {
    const $this = $(this);
    const isCurrentlySelected = $this.hasClass("selected");

    // Jika sudah terseleksi, hapus seleksi
    if (isCurrentlySelected) {
      $this.removeClass("selected");
      $("#quote_color").val(""); // Kosongkan nilai warna
    } else {
      // Jika belum terseleksi, hapus seleksi yang lain dan pilih yang ini
      $(".color-option").removeClass("selected");
      $this.addClass("selected");
      $("#quote_color").val($this.data("value"));
    }
  });

  // Inisialisasi Kalkulasi
  calculateAndUpdate();
});
