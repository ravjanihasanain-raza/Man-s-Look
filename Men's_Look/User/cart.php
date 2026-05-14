<?php include "Layouts/_Header.php"; ?>
<?php include "Layouts/navbar.php"; ?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content" id="content">
  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">🛍️ Your Shopping Cart</h2>

    <div class="table-responsive shadow-sm rounded bg-white p-3">
      <table class="table align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="cartItemss">
          <tr>
            <td colspan="6" class="text-center text-muted">Loading your cart...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-4">
      <h4 class="fw-bold">Grand Total: ₹<span id="grandTotal">0</span></h4>
      <a href="checkout.php" class="btn btn-success mt-3 px-4">Proceed to Checkout</a>
    </div>
  </div>
</div>

<?php include "Layouts/_footer.php"; ?>

<script>
$(document).ready(function () {
  loadCart();
});

// =========================
// LOAD CART ITEMS
// =========================
function loadCart() {
  $.ajax({
    url: "../Controllers/CartController.php?UserId=" + localStorage.getItem("UserId"),
    method: "GET",
    success: function (res) {
      try {
        res = JSON.parse(res);
      } catch (e) {
        Swal.fire("Error!", "Failed to load cart data!", "error");
        return;
      }

      if (!res.Result || res.Result.length === 0) {
        $("#cartItemss").html(`
          <tr><td colspan="6" class="text-center text-muted">Your cart is empty.</td></tr>
        `);
        $("#grandTotal").text("0");
        return;
      }

      let total = 0;
      $("#cartItemss").empty();

      res.Result.forEach(item => {
        let price = item.discount_price > 0 ? item.discount_price : item.price;
        let subtotal = price * item.quantity;
        total += subtotal;

        let img = item.image_url 
          ? `../Content/Photo/${item.image_url}`
          : `../Content/no-image.png`;

        $("#cartItemss").append(`
          <tr>
            <td><img src="${img}" class="rounded" style="width:60px;height:60px;object-fit:cover;"></td>
            <td>${item.product_name}</td>
            <td>₹${price}</td>
            <td>
              <input type="number" class="form-control text-center" 
                     style="width:80px;" value="${item.quantity}" min="1"
                     onchange="updateQuantity(${item.product_id}, this.value)">
            </td>
            <td>₹${subtotal}</td>
            <td>
              <button class="btn btn-danger btn-sm" onclick="removeItem(${item.product_id})">
                Remove
              </button>
            </td>
          </tr>
        `);
      });

      $("#grandTotal").text(total);
    },
    error: function () {
      Swal.fire("Error!", "Unable to load cart items!", "error");
    }
  });
}

// =========================
// UPDATE QUANTITY
// =========================
function updateQuantity(id, qty) {
  if (qty <= 0) {
    Swal.fire("Invalid Quantity", "Quantity must be at least 1.", "warning");
    return;
  }

  $.ajax({
    url: "../Controllers/CartController.php",
    method: "PUT",
    contentType: "application/json",
    data: JSON.stringify({
      product_id: id,
      quantity: qty,
      UserId: localStorage.getItem("UserId")
    }),
    success: function (res) {
      try { res = JSON.parse(res); } catch (e) {
        Swal.fire("Error!", "Failed to update quantity!", "error");
        return;
      }

      if (res.Status === "Ok" || res.Status === "OK") {
        Swal.fire({
          icon: "success",
          title: "Updated!",
          text: "Quantity updated successfully.",
          timer: 1200,
          showConfirmButton: false
        });

        loadCart();
      } else {
        Swal.fire("Error!", res.Message || "Update failed!", "error");
      }
    },
    error: function () {
      Swal.fire("Error!", "Unable to update quantity!", "error");
    }
  });
}

// =========================
// REMOVE ITEM
// =========================
function removeItem(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "This item will be removed from your cart.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, remove it"
  }).then((result) => {

    if (result.isConfirmed) {

      $.ajax({
        url: `../Controllers/CartController.php?ID=${id}&UserId=${localStorage.getItem("UserId")}`,
        method: "DELETE",
        success: function (res) {
          try { res = JSON.parse(res); } catch (e) {
            Swal.fire("Error!", "Unable to remove item!", "error");
            return;
          }

          Swal.fire({
            icon: "success",
            title: "Removed!",
            text: res.Message || "Item removed successfully.",
            timer: 1500,
            showConfirmButton: false
          });

          loadCart();
        },
        error: function () {
          Swal.fire("Error!", "Unable to remove item!", "error");
        }
      });

    }

  });
}
</script>
