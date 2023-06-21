;(function ($) {
  "use strict"

  $(function () {
    // Place your public-facing JavaScript here

    $("#bkb_woo_accordion").bwlAccordion({
      search: bkb_search_box_status, // true/false
      placeholder: bkb_acc_search_text, // You can write any thing as a placeholder text
      theme: bkb_woo_theme, // theme-red/theme-blue/theme-green/theme-orange/theme-yellow
      animation: bkb_woo_animation, // flash/shake/tada/swing/wobble/pulse/flipx/faderight/fadeleft/slide/slideup/bounce/lightspeed/roll/rotate/fade/none,
      rtl: bkb_rtl_mode,
      msg_item_found: bkb_acc_msg_item_found,
      msg_no_result: bkb_acc_msg_no_result,
      toggle: true, //
      highlight_bg: bkb_highlighter_bg, // founded item background color
      highlight_color: bkb_highlighter_text_color, // founded item text color.
      pagination: bkb_pagination_status, // pagination status.
      limit: bkb_items_per_page, // item per page..,
      text_singular_page: string_singular_page,
      text_plural_page: string_plural_page,
      text_total: string_total,
    })

    /*------------------------------  Count Total No of KBs---------------------------------*/

    if ($(".kbtfw_tab_tab").length && bkb_display_counter == 1) {
      var $bkb_woo_counter = $(".bkb_woo_counter"),
        $bkb_woo_parent_container = $("#bkb_woo_accordion"),
        $bkb_woo_total_items = $bkb_woo_parent_container.find("section").length,
        $bkb_woo_tab_title_text = $(".kbtfw_tab_tab").find("a").text()

      if ($bkb_woo_total_items > 0) {
        $(".kbtfw_tab_tab")
          .find("a")
          .html($bkb_woo_tab_title_text + " (" + $bkb_woo_total_items + ")")
      } else {
        $bkb_woo_counter.remove()
      }
    }
  })
})(jQuery)
