//import * as $ from 'jquery';

export default (function() {
  // Sidebar links
  $(".sidebar .sidebar-menu li a").on("click", function() {
      const $this = $(this);

      if ($this.parent().hasClass("open")) {
          $this
              .parent()
              .children(".dropdown-menu")
              .slideUp(200, () => {
                  $this.parent().removeClass("open");
              });
      } else {
          $this
              .parent()
              .parent()
              .children("li.open")
              .children(".dropdown-menu")
              .slideUp(200);

          $this
              .parent()
              .parent()
              .children("li.open")
              .children("a")
              .removeClass("open");

          $this
              .parent()
              .parent()
              .children("li.open")
              .removeClass("open");

          $this
              .parent()
              .children(".dropdown-menu")
              .slideDown(200, () => {
                  $this.parent().addClass("open");
              });
      }
  });

  // Sidebar Activity Class
  const sidebarLinks = $(".sidebar").find(".sidebar-link");

  sidebarLinks
      .each((index, el) => {
          $(el).removeClass("active");
      })
      .filter(function() {
          const href = $(this).attr("href");     
          const search = window.location.search;
          const pathname = window.location.pathname;
          const url = pathname + search;
          return href.includes(pathname);
      })
      .each((index, el) => {
          const parentIsDropdown = $(el).parents(".dropdown");

          if (parentIsDropdown.length > 0) {
              parentIsDropdown.addClass("open");
          }
          $(el).addClass("active");
      });

  // ٍSidebar Toggle
  $(".sidebar-toggle").on("click", e => {
      $("body").toggleClass("is-collapsed");
      e.preventDefault();
  });

  /**
   * Wait untill sidebar fully toggled (animated in/out)
   * then trigger window resize event in order to recalculate
   * masonry layout widths and gutters.
   */
  $("#sidebar-toggle").click(e => {
      e.preventDefault();
      setTimeout(() => {
          window.dispatchEvent(window.EVENT);
      }, 300);
  });
})();
