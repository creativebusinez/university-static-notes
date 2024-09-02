class MobileMenu {
    constructor() {
      // Select the menu and the button that triggers the menu.
      this.menu = document.querySelector(".site-header__menu")
      this.openButton = document.querySelector(".site-header__menu-trigger")
      // Initialize event listeners.
      this.events()
    }
  
    events() {
      // Add a click event listener to the open button.
      this.openButton.addEventListener("click", () => this.openMenu())
    }
  
    openMenu() {
      // Toggle the icon from bars to close (and vice versa).
      this.openButton.classList.toggle("fa-bars")
      this.openButton.classList.toggle("fa-window-close")
      // Toggle the active state of the menu.
      this.menu.classList.toggle("site-header__menu--active")
    }
  }
  
  export default MobileMenu
  // Export the MobileMenu class as the default export.
  