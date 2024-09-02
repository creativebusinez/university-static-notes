import axios from "axios"
// Import the axios library for making HTTP requests.

class Like {
  constructor() {
    // Check if there is an element with the class "like-box" on the page.
    if (document.querySelector(".like-box")) {
      // Set the default headers for axios, including the nonce for security.
      axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce
      // Initialize event listeners.
      this.events()
    }
  }

  events() {
    // Add a click event listener to the like box.
    document.querySelector(".like-box").addEventListener("click", e => this.ourClickDispatcher(e))
  }

  // methods
  ourClickDispatcher(e) {
    let currentLikeBox = e.target
    // Traverse up the DOM tree to find the parent element with the class "like-box".
    while (!currentLikeBox.classList.contains("like-box")) {
      currentLikeBox = currentLikeBox.parentElement
    }

    // Check if the like already exists, then either delete or create a like.
    if (currentLikeBox.getAttribute("data-exists") == "yes") {
      this.deleteLike(currentLikeBox)
    } else {
      this.createLike(currentLikeBox)
    }
  }

  async createLike(currentLikeBox) {
    // Method to create a new like.
    try {
      const response = await axios.post(universityData.root_url + "/wp-json/university/v1/manageLike", { "professorId": currentLikeBox.getAttribute("data-professor") })
      if (response.data != "Only logged in users can create a like.") {
        currentLikeBox.setAttribute("data-exists", "yes")
        var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
        likeCount++
        currentLikeBox.querySelector(".like-count").innerHTML = likeCount
        currentLikeBox.setAttribute("data-like", response.data)
      }
      console.log(response.data)
    } catch (e) {
      console.log("Sorry")
    }
  }

  async deleteLike(currentLikeBox) {
    // Method to delete an existing like.
    try {
      const response = await axios({
        url: universityData.root_url + "/wp-json/university/v1/manageLike",
        method: 'delete',
        data: { "like": currentLikeBox.getAttribute("data-like") },
      })
      currentLikeBox.setAttribute("data-exists", "no")
      var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
      likeCount--
      currentLikeBox.querySelector(".like-count").innerHTML = likeCount
      currentLikeBox.setAttribute("data-like", "")
      console.log(response.data)
    } catch (e) {
      console.log(e)
    }
  }
}

export default Like
// Export the Like class as the default export.
