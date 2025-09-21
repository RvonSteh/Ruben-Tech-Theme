jQuery(document).ready(function ($) {
  function customQuantityButtons() {
    const cartItems = document.querySelectorAll(".cart_item");

    cartItems.forEach((cartItem) => {
      const quantityItem = cartItem.querySelector(".cart_quantity");
      if (!quantityItem) return;

      const plus = quantityItem.querySelector(".plus");
      const minus = quantityItem.querySelector(".minus");
      const qtyInput = quantityItem.querySelector("input.qty");

      if (plus && minus && qtyInput) {
        plus.replaceWith(plus.cloneNode(true));
        minus.replaceWith(minus.cloneNode(true));

        const newPlus = quantityItem.querySelector(".plus");
        const newMinus = quantityItem.querySelector(".minus");

        newPlus.addEventListener("click", function (e) {
          e.preventDefault();
          qtyInput.value = parseInt(qtyInput.value) + 1;
          $(qtyInput).trigger("change");
        });

        // Minus-Button
        newMinus.addEventListener("click", function (e) {
          e.preventDefault();
          if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            $(qtyInput).trigger("change");
          }
        });
      }
    });
  }

  customQuantityButtons();

  $(document.body).on("updated_cart_totals", function () {
    customQuantityButtons();
  });
});
