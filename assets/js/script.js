jQuery(document).ready(function ($) {
  const form = $(".shutter-customizer-form");
  const widthInput = $("#shutter_width");
  const heightInput = $("#shutter_height");
  const totalAreaSpan = $("#total_area");
  const calculatedPriceSpan = $("#calculated_price");
  const windowNameInput = $("#window_name");
  const frameTypeInput = $("#frame_type");
  const framePriceInput = $("#frame_price");
  const colorInput = $("#shutter_color");

  $.ajax({
    url: shutterData.ajax_url,
    type: "POST",
    data: {
      action: "load_shutter_form",
    },
    success: function (response) {
      if (response.success) {
        $("#shutter-form-container").html(response.data);

        // Menangani submit formulir setelah template dimuat
        $("#shutter-form-container form").submit(function (event) {
          event.preventDefault();

          // ... (mengumpulkan data formulir)

          $.ajax({
            url: shutterData.ajax_url,
            type: "POST",
            data: {
              action: "process_shutter_form",
              // ... (data formulir)
              nonce: shutterData.nonce,
            },
            success: function (response) {
              // ... (menangani respon)
            },
            error: function (error) {
              // ... (menangani error)
            },
          });
        });
      }
    },
    error: function (error) {
      // ... (menangani error)
    },
  });

  // Get price per square meter from WooCommerce product
  const pricePerSqm = parseFloat(shutterData.price_per_sqm);

  function calculateArea() {
    const width = parseFloat(widthInput.val()) || 0;
    const height = parseFloat(heightInput.val()) || 0;

    // Convert mm to m² and round to 2 decimal places
    const area = ((width * height) / 1000000).toFixed(2);
    totalAreaSpan.text(area);
    return parseFloat(area);
  }

  const framePrices = {
    standard: 0, // Harga tambahan untuk standard frame
    premium: 50, // Harga tambahan untuk premium frame
  };

  // Set initial frame type
  frameTypeInput.val("standard");
  $(".frame-option[data-value='standard']").addClass("selected"); // Select default frame

  function calculatePrice() {
    const area = calculateArea();
    const frameType = frameTypeInput.val();
    const framePrice = framePrices[frameType] || 0;

    const isSale = shutterData.is_on_sale;
    let pricePerSqmToUse = pricePerSqm;

    if (isSale) {
      pricePerSqmToUse = parseFloat(shutterData.sale_price);
    } else {
      pricePerSqmToUse = parseFloat(shutterData.regular_price);
    }

    const totalPrice = (area * pricePerSqmToUse + framePrice).toFixed(2);
    calculatedPriceSpan.text("$" + totalPrice);
    framePriceInput.val(framePrice);
  }

  const minWidth = 250;
  const maxWidth = 4800;
  const minHeight = 400;
  const maxHeight = 4800;

  // Function to validate input values
  function validateInput(input, min, max, inputName) {
    let value = parseInt(input.val());

    // Jika input kosong, jangan tampilkan peringatan, anggap valid
    if (isNaN(value) || input.val() === "") {
      input.removeClass("is-invalid");
      input.next(".invalid-feedback").hide();
      return true; // Kembalikan true karena dianggap valid (kosong tidak masalah)
    }

    // Validasi nilai input
    if (value < min || value > max) {
      input.addClass("is-invalid");
      input.next(".invalid-feedback").show();
      return false; // Kembalikan false jika tidak valid
    }

    input.removeClass("is-invalid");
    input.next(".invalid-feedback").hide();
    return true; // Kembalikan true jika valid
  }

  // Event listener for width input
  widthInput.on("input", function () {
    validateInput(widthInput, minWidth, maxWidth, "width");
    calculateArea();
    calculatePrice();
  });

  // Event listener for height input
  heightInput.on("input", function () {
    validateInput(heightInput, minHeight, maxHeight, "height");
    calculateArea();
    calculatePrice();
  });

  // Initial validation when the page loads
  validateInput(widthInput, minWidth, maxWidth, "width");
  validateInput(heightInput, minHeight, maxHeight, "height");

  // Handle color option selection
  $(".color-option").on("click", function () {
    const $this = $(this);
    const isCurrentlySelected = $this.hasClass("selected");

    // Jika sudah terseleksi, hapus seleksi
    if (isCurrentlySelected) {
      $this.removeClass("selected");
      colorInput.val(""); // Kosongkan nilai warna
    } else {
      // Jika belum terseleksi, hapus seleksi yang lain dan pilih yang ini
      $(".color-option").removeClass("selected");
      $this.addClass("selected");
      colorInput.val($this.data("value"));
    }
  });

  // Form validation

  $("form.cart").on("submit", function (e) {
    if (!widthInput.val() || !heightInput.val()) {
      e.preventDefault();
      alert("Please specify shutter measurements");
      return false;
    }

    // validation for frame type
    if (!frameTypeInput.val()) {
      e.preventDefault();
      alert("Please select a frame type");
      return false;
    }

    // validation for shutter color
    if (!colorInput.val()) {
      e.preventDefault();
      alert("Please select a shutter color");
      return false;
    }
  });

  // Handle frame type selection

  $(".frame-option").on("click", function () {
    $(".frame-option").removeClass("selected");
    $(this).addClass("selected");
    frameTypeInput.val($(this).data("value"));
    calculatePrice(); // Recalculate price when frame type changes
  });

  //Trigger initial calculation on load
  calculateArea();
  calculatePrice();
});
