// AuthHelper – global UI helpers
var AuthHelper = {
    isAuthenticated: function () {
        return $('meta[name="user-authenticated"]').attr("content") === "true";
    },

    getUserId: function () {
        return $('meta[name="user-id"]').attr("content");
    },

    showLoginPrompt: function (action) {
        action = action || "perform this action";

        $("#loginModalMessage").text("Please log in to " + action);

        var modal = new bootstrap.Modal(
            document.getElementById("loginRequiredModal"),
        );

        modal.show();
    },

    showToast: function (message, type) {
        type = type || "info";

        var container = $("#toastContainer");

        if (!container.length) {
            $("body").append(
                '<div id="toastContainer" style="position:fixed;top:20px;right:20px;z-index:9999;"></div>',
            );

            container = $("#toastContainer");
        }

        var toast = $(
            '<div class="alert alert-' +
                type +
                ' alert-dismissible fade show" role="alert" style="min-width:250px;margin-bottom:10px;">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
        );

        container.append(toast);

        setTimeout(function () {
            toast.remove();
        }, 5000);
    },

    updateCartCount: function (count) {
        $("#cartCount").text(count);

        $(".cart-count").each(function () {
            $(this).text("( " + count + " )");
        });
    },

    updateWishlistCount: function (count) {
        $("#wishlistCount").text(count);

        $(".wish-count").each(function () {
            $(this).text("( " + count + " )");
        });

        $(".wish-count-badge").text(count);
    },
};

// Wishlist AJAX – toggle and refresh offcanvas
function toggleWishlist(productId, element) {
    if (!AuthHelper.isAuthenticated()) {
        AuthHelper.showLoginPrompt("manage your wishlist");
        return;
    }

    var $icon = $(element).find("i");
    var originalClass = $icon.attr("class");

    $icon.removeClass("fa-solid fa-regular").addClass("fa-spinner fa-spin");

    $.ajax({
        url: "/user/wishlist/toggle",
        type: "POST",
        contentType: "application/json",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        data: JSON.stringify({
            productId: productId,
        }),

        success: function (data) {
            if (!data.success) {
                $icon
                    .removeClass("fa-regular fa-solid fa-spinner fa-spin")
                    .addClass(originalClass);

                AuthHelper.showToast(data.message || "Error", "danger");

                return;
            }

            if (data.inWishlist) {
                $icon
                    .removeClass("fa-regular fa-spinner fa-spin")
                    .addClass("fa-solid");

                $(element).attr("title", "Remove from Wishlist");
            } else {
                $icon
                    .removeClass("fa-solid fa-spinner fa-spin")
                    .addClass("fa-regular");

                $(element).attr("title", "Add to Wishlist");
            }

            $.get("/user/wishlist/offcanvas-items", function (html) {
                $("#wishlistOffcanvasList").html(html);
            });

            AuthHelper.updateWishlistCount(data.wishlistCount);

            AuthHelper.showToast(data.message, "success");
        },

        error: function (xhr) {
            $icon
                .removeClass("fa-regular fa-solid fa-spinner fa-spin")
                .addClass(originalClass);

            AuthHelper.showToast(
                xhr.responseJSON?.message || "Something went wrong",
                "danger",
            );
        },
    });
}

// Add to Cart AJAX
function addToCart(productId, qty) {
    qty = qty || 1;

    if (!AuthHelper.isAuthenticated()) {
        AuthHelper.showLoginPrompt("add items to cart");
        return;
    }

    $.ajax({
        url: "/user/add/cart",
        type: "POST",
        contentType: "application/json",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        data: JSON.stringify({
            userId: AuthHelper.getUserId(),
            productId: productId,
            qty: qty,
        }),

        success: function (data) {
            if (data.success) {
                AuthHelper.showToast("Added to cart!", "success");

                AuthHelper.updateCartCount(data.cartCount);
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                AuthHelper.showToast(data.message || "Error", "danger");
            }
        },

        error: function () {
            AuthHelper.showToast("Something went wrong", "danger");
        },
    });
}

// Submit Rating
function submitRating(productId, rating) {
    if (!AuthHelper.isAuthenticated()) {
        AuthHelper.showLoginPrompt("rate this product");
        return;
    }

    $.ajax({
        url: "/user/rating",
        type: "POST",
        contentType: "application/json",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        data: JSON.stringify({
            productId: productId,
            productRating: rating,
        }),

        success: function (data) {
            if (data.success) {
                AuthHelper.showToast("Thanks for rating!", "success");

                location.reload();
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                AuthHelper.showToast(data.message || "Error", "danger");
            }
        },

        error: function () {
            AuthHelper.showToast("Something went wrong", "danger");
        },
    });
}

// Submit Comment
function submitComment(form) {
    if (!AuthHelper.isAuthenticated()) {
        AuthHelper.showLoginPrompt("post a comment");
        return;
    }

    var formData = new FormData(form);

    $.ajax({
        url: "/user/create/comment",
        type: "POST",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        data: formData,
        processData: false,
        contentType: false,

        success: function (data) {
            if (data.success) {
                AuthHelper.showToast("Comment posted!", "success");

                location.reload();
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                AuthHelper.showToast(data.message || "Error", "danger");
            }
        },

        error: function () {
            AuthHelper.showToast("Something went wrong", "danger");
        },
    });
}

// Event delegation
$(document).ready(function () {
    // Helper: Update cart totals
    function updateCartTotals() {
        let total = 0;

        $("#productTable tbody tr").each(function () {
            let priceText = $(this)
                .find(".price")
                .text()
                .replace(/[^\d.]/g, "");

            let qty = parseInt($(this).find(".qty, .guest-qty").val()) || 0;

            let price = parseInt(priceText) || 0;

            let itemTotal = price * qty;

            $(this)
                .find(".total")
                .text(itemTotal.toLocaleString() + " MMK");

            total += itemTotal;
        });

        $("#subtotal").html(total.toLocaleString() + " MMK");

        $("#finaltotal").html((total + 5000).toLocaleString() + " MMK");
    }

    // Wishlist toggle
    $(document).on(
        "click",
        ".wishlist-toggle, .wishlist-toggle-detail",
        function (e) {
            e.preventDefault();

            var productId = $(this).data("product-id");

            if (AuthHelper.isAuthenticated()) {
                toggleWishlist(productId, this);
            } else {
                AuthHelper.showLoginPrompt("add to wishlist");
            }
        },
    );

    // Product detail quantity controls
    $(document).on("click", ".detail-minus, .detail-plus", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $input = $("#product-qty");

        if (!$input.length) {
            return;
        }

        var currentVal = parseInt($input.val()) || 1;

        var newVal;

        if ($(this).hasClass("detail-minus")) {
            newVal = currentVal > 1 ? currentVal - 1 : 1;
        } else {
            newVal = currentVal + 1;
        }

        $input.val(newVal);
    });

    // Add to Cart
    $(document).on(
        "click",
        ".add-to-cart-home, .add-to-cart-related, .add-to-cart-detail, .add-to-cart-btn",
        function (e) {
            e.preventDefault();

            var productId = $(this).data("product-id");

            var qty = $(this).data("qty") || 1;

            // If this is the product detail page,
            // use the currently selected quantity
            if ($(this).hasClass("add-to-cart-detail")) {
                qty = parseInt($("#product-qty").val()) || 1;
            }

            if (AuthHelper.isAuthenticated()) {
                addToCart(productId, qty);
            } else {
                AuthHelper.showLoginPrompt("add items to cart");
            }
        },
    );

    // Remove from offcanvas wishlist
    $(document).on("click", ".remove-offcanvas-wishlist", function (e) {
        e.preventDefault();

        var button = $(this);

        var productId = button.data("product-id");

        if (!productId) {
            return;
        }

        var icon = button.find("i");

        icon.removeClass("fa-solid fa-xmark").addClass("fa-spinner fa-spin");

        $.ajax({
            url: "/user/wishlist/toggle",
            type: "POST",
            contentType: "application/json",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            data: JSON.stringify({
                productId: productId,
            }),

            success: function (data) {
                if (data.success && !data.inWishlist) {
                    $.get("/user/wishlist/offcanvas-items", function (html) {
                        $("#wishlistOffcanvasList").html(html);
                    });

                    AuthHelper.updateWishlistCount(data.wishlistCount);

                    var heart = $(
                        '.wishlist-toggle[data-product-id="' + productId + '"]',
                    );

                    if (heart.length) {
                        heart
                            .find("i")
                            .removeClass("fa-solid")
                            .addClass("fa-regular");

                        heart.attr("title", "Add to Wishlist");
                    }

                    AuthHelper.showToast(data.message, "success");
                } else {
                    icon.removeClass("fa-spinner fa-spin").addClass(
                        "fa-solid fa-xmark",
                    );

                    AuthHelper.showToast(data.message || "Error", "danger");
                }
            },

            error: function () {
                icon.removeClass("fa-spinner fa-spin").addClass(
                    "fa-solid fa-xmark",
                );

                AuthHelper.showToast("Error", "danger");
            },
        });
    });

    // Offcanvas Add to Cart
    $(document).on("submit", ".offcanvas-add-to-cart", function (e) {
        e.preventDefault();

        var form = $(this);

        var productId = form.find('input[name="productId"]').val();

        var userId = form.find('input[name="userId"]').val();

        $.ajax({
            url: "/user/add/cart",
            type: "POST",
            contentType: "application/json",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            data: JSON.stringify({
                userId: userId,
                productId: productId,
                qty: 1,
            }),

            success: function (data) {
                if (!data.success) {
                    AuthHelper.showToast(data.message || "Error", "danger");

                    return;
                }

                // Add product to cart
                AuthHelper.showToast("Added to cart!", "success");

                // Update cart count only
                AuthHelper.updateCartCount(data.cartCount);

                // IMPORTANT:
                // Do not refresh or toggle the wishlist here.
                // The item should remain in the wishlist.
            },

            error: function () {
                AuthHelper.showToast("Something went wrong", "danger");
            },
        });
    });

    // Cart page: logged-in user quantity
    $(document).on("click", ".cart-qty-btn:not(.guest-qty-btn)", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $row = $(this).closest("tr");

        var $input = $row.find(".qty");

        var currentVal = parseInt($input.val()) || 1;

        var newVal;

        if ($(this).hasClass("btn-minus")) {
            newVal = currentVal > 1 ? currentVal - 1 : 1;
        } else {
            newVal = currentVal + 1;
        }

        $input.val(newVal);

        updateCartTotals();

        var cartId = $row.data("cart-id");

        if (cartId) {
            $.ajax({
                type: "PATCH",

                url: "/user/cart/update/" + cartId,

                data: {
                    quantity: newVal,
                },

                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),

                    Accept: "application/json",
                },

                success: function (res) {
                    if (res.success) {
                        AuthHelper.updateCartCount(res.cartCount);
                    }
                },

                error: function () {
                    AuthHelper.showToast("Error updating quantity", "danger");

                    // Revert quantity
                    $input.val(currentVal);

                    updateCartTotals();
                },
            });
        }
    });

    // Cart page: guest quantity
    $(document).on("click", ".guest-qty-btn", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $row = $(this).closest("tr");

        var $input = $row.find(".guest-qty");

        var currentVal = parseInt($input.val()) || 1;

        var newVal;

        if ($(this).hasClass("btn-minus")) {
            newVal = currentVal > 1 ? currentVal - 1 : 1;
        } else {
            newVal = currentVal + 1;
        }

        $input.val(newVal);

        updateCartTotals();

        var productId = $input.data("product-id");

        if (productId) {
            $.ajax({
                type: "PATCH",

                url: "/user/guest/cart/update",

                data: {
                    productId: productId,
                    quantity: newVal,
                },

                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),

                    Accept: "application/json",
                },

                success: function (res) {
                    if (res.success) {
                        AuthHelper.updateCartCount(res.cartCount);
                    }
                },

                error: function () {
                    AuthHelper.showToast("Error updating quantity", "danger");

                    $input.val(currentVal);

                    updateCartTotals();
                },
            });
        }
    });

    // Cart page: remove logged-in item
    $(document).on("click", ".btn-remove", function (e) {
        e.preventDefault();

        var $row = $(this).closest("tr");

        var cartId = $row.find(".cartId").val();

        if (!cartId) {
            return;
        }

        var btn = $(this);

        btn.prop("disabled", true).html(
            '<i class="fa fa-spinner fa-spin"></i>',
        );

        $.ajax({
            type: "GET",

            url: "/user/remove/cart",

            data: {
                cartId: cartId,
            },

            dataType: "json",

            success: function (res) {
                if (res.status === "success") {
                    $row.fadeOut(300, function () {
                        $(this).remove();

                        updateCartTotals();

                        AuthHelper.updateCartCount(res.cartCount || 0);

                        AuthHelper.showToast("Item removed", "success");

                        if ($("#productTable tbody tr").length === 0) {
                            location.reload();
                        }
                    });
                }
            },

            error: function () {
                btn.prop("disabled", false).html('<i class="fa fa-times"></i>');

                AuthHelper.showToast("Error removing item", "danger");
            },
        });
    });

    // Cart page: remove guest item
    $(document).on("click", ".guest-remove", function (e) {
        e.preventDefault();

        var productId = $(this).data("product-id");

        if (!productId) {
            return;
        }

        var btn = $(this);

        btn.prop("disabled", true).html(
            '<i class="fa fa-spinner fa-spin"></i>',
        );

        $.ajax({
            type: "DELETE",

            url: "/user/guest/cart/remove",

            data: {
                productId: productId,
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),

                Accept: "application/json",
            },

            success: function (res) {
                if (res.success) {
                    var $row = $('tr[data-product-id="' + productId + '"]');

                    $row.fadeOut(300, function () {
                        $(this).remove();

                        updateCartTotals();

                        AuthHelper.updateCartCount(res.cartCount);

                        AuthHelper.showToast("Item removed", "success");

                        if ($("#productTable tbody tr").length === 0) {
                            location.reload();
                        }
                    });
                }
            },

            error: function () {
                btn.prop("disabled", false).html('<i class="fa fa-times"></i>');

                AuthHelper.showToast("Error removing item", "danger");
            },
        });
    });

    // Checkout button
    $(document).on("click", "#btn-checkout", function () {
        let orderList = [];

        let userId = $(".userId").val();

        let orderCode = "COS-209-" + Math.floor(Math.random() * 10000000000);

        $("#productTable tbody tr").each(function () {
            let productId = $(this).find(".productId").val();

            let qty = $(this).find(".qty").val();

            let finalTotal = $("#finaltotal")
                .text()
                .replace(/[^\d.]/g, "");

            orderList.push({
                product_id: productId,

                user_id: userId,

                count: qty,

                status: 0,

                order_code: orderCode,

                totalAmt: finalTotal,
            });
        });

        $.ajax({
            type: "get",

            url: "/user/tempStorage",

            data: Object.assign({}, orderList),

            dataType: "json",

            success: function (res) {
                if (res.status === "success") {
                    location.href = "/user/checkOutPage";
                } else {
                    location.reload();
                }
            },
        });
    });

    // Rating form
    $(document).on("submit", "#ratingForm", function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        var productId = formData.get("productId");

        var rating = formData.get("productRating");

        submitRating(productId, rating);
    });

    // Comment form
    $(document).on("submit", "#commentForm", function (e) {
        e.preventDefault();

        submitComment(this);
    });

    // Initialize cart totals
    updateCartTotals();
});
