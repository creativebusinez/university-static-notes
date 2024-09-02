import Glide from "@glidejs/glide"
// Import the Glide.js library for creating a slider.

class HeroSlider {
  constructor() {
    // Check if the element with the class "hero-slider" exists on the page.
    if (document.querySelector(".hero-slider")) {
      
      // Count how many slides there are within the hero slider.
      const dotCount = document.querySelectorAll(".hero-slider__slide").length

      // Generate the HTML for the navigation dots based on the number of slides.
      let dotHTML = ""
      for (let i = 0; i < dotCount; i++) {
        dotHTML += `<button class="slider__bullet glide__bullet" data-glide-dir="=${i}"></button>`
      }

      // Insert the generated dots HTML into the DOM within the element with the class "glide__bullets".
      document.querySelector(".glide__bullets").insertAdjacentHTML("beforeend", dotHTML)

      // Initialize the Glide slider with the specified options.
      var glide = new Glide(".hero-slider", {
        type: "carousel",  // Set the slider type to "carousel".
        perView: 1,        // Display one slide at a time.
        autoplay: 3000     // Autoplay the slides every 3 seconds.
      })

      // Mount the Glide slider to make it functional.
      glide.mount()
    }
  }
}

export default HeroSlider
// Export the HeroSlider class as the default export.
