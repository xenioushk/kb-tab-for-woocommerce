;(function ($) {
  function bkbm_kbtfw_installation_counter() {
    return $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "bkbm_kbtfw_installation_counter", // this is the name of our WP AJAX function that we'll set up next
        product_id: BkbmKbtfwAdminData.product_id, // change the localization variable.
      },
      dataType: "JSON",
    })
  }

  if (typeof BkbmKbtfwAdminData.installation != "undefined" && BkbmKbtfwAdminData.installation != 1) {
    $.when(bkbm_kbtfw_installation_counter()).done(function (response_data) {
      // console.log(response_data)
    })
  }
})(jQuery)
