import axios from "axios"

class Search {
  // 1. describe and create/initiate our object
  // Defining the constructor function of our class
constructor() {

    // Calling the addSearchHTML method when an instance is created.
    this.addSearchHTML()

    // Getting the element where search results would be displayed from HTML DOM
    this.resultsDiv = document.querySelector("#search-overlay__results")

    // Getting all elements that trigger the search overlay functionality
    this.openButton = document.querySelectorAll(".js-search-trigger")

    // Getting the close button for the search overlay from the HTML DOM
    this.closeButton = document.querySelector(".search-overlay__close")

    // Getting the search overlay element from the HTML DOM
    this.searchOverlay = document.querySelector(".search-overlay")

    // Getting the input field for the search from the HTML DOM
    this.searchField = document.querySelector("#search-term")

    // Variable to hold the state of the overlay, initially set as not open.
    this.isOverlayOpen = false

    // Variable to hold the state of the spinner (loading indicator), initially set as not visible.
    this.isSpinnerVisible = false

    // Variable to store the previous value
    this.previousValue

    // Variable to act as a timer for typing delay functionality
    this.typingTimer

    // Calling the events method that listens to certain user events
    this.events()
}


  // 2. events
  // Defining the events function of our class
events() {

    // Loop through each element in openButton (which contains all elements that trigger the search overlay)
    this.openButton.forEach(el => {

        // Add event listener 'click' to each element
        el.addEventListener("click", e => {

            // Prevent click event's default behavior
            e.preventDefault()

            // Call the openOverlay method when the element is clicked
            this.openOverlay()
        })
    })

    // Add a "click" event listener to closeButton. On clicking it calls closeOverlay method that hides the overlay
    this.closeButton.addEventListener("click", () => this.closeOverlay())

    // Add an event listener for the "keydown" event on the whole document. This calls keyPressDispatcher which might be used to handle various keypress events
    document.addEventListener("keydown", e => this.keyPressDispatcher(e))

    // Add an "keyup" event listener to searchField. As the user types into the field, typingLogic method is called which may implement live or delayed search functionality
    this.searchField.addEventListener("keyup", () => this.typingLogic())
}


  // 3. methods (function, action...)
  // Defining the typingLogic function of our class
typingLogic() {

    // Check if the current value of searchField is different from the previous value
    if (this.searchField.value != this.previousValue) {

        // If they are not equal, clear any existing timing events which might have been due to previous key presses
        clearTimeout(this.typingTimer)

        // If searchField contains some text
        if (this.searchField.value) {

            // And if spinner is not already visible, show it by changing the innerHTML of resultsDiv
            if (!this.isSpinnerVisible) {
                this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>'
                this.isSpinnerVisible = true
            }

            // Set a timer for 750ms which calls getResults method after waiting for this time. This delay can be used to prevent unnecessary server requests while user is still typing
            this.typingTimer = setTimeout(this.getResults.bind(this), 750)
        } else {

            // If searchField is empty, clear resultsDiv and hide the spinner
            this.resultsDiv.innerHTML = ""
            this.isSpinnerVisible = false
        }
    }

    // Update previousValue with the current value of searchField for the next cycle
    this.previousValue = this.searchField.value
}


async getResults() {
    try {
      // Make an asynchronous GET request to the university's search API endpoint with the search term from the input field.
    const response = await axios.get(universityData.root_url + "/wp-json/university/v1/search?term=" + this.searchField.value)

      // Store the results from the API response.
    const results = response.data

    // Update the inner HTML of the resultsDiv with the search results.
    this.resultsDiv.innerHTML = `
        <div class="row">
        <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${results.generalInfo.length 
            ? '<ul class="link-list min-list">' 
            : "<p>No general information matches that search.</p>"}
            ${results.generalInfo.map(item => 
                `<li><a href="${item.permalink}">${item.title}</a> 
                ${item.postType == "post" ? `by ${item.authorName}` : ""}</li>`
            ).join("")}
            ${results.generalInfo.length ? "</ul>" : ""}
        </div>

        <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${results.programs.length 
            ? '<ul class="link-list min-list">' 
            : `<p>No programs match that search. <a href="${universityData.root_url}/programs">View all programs</a></p>`}
            ${results.programs.map(item => 
                `<li><a href="${item.permalink}">${item.title}</a></li>`
            ).join("")}
            ${results.programs.length ? "</ul>" : ""}

            <h2 class="search-overlay__section-title">Professors</h2>
            ${results.professors.length 
            ? '<ul class="professor-cards">' 
            : `<p>No professors match that search.</p>`}
            ${results.professors.map(item => 
                `
                <li class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                    <img class="professor-card__image" src="${item.image}">
                    <span class="professor-card__name">${item.title}</span>
                </a>
                </li>
                `
            ).join("")}
            ${results.professors.length ? "</ul>" : ""}
        </div>

        <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${results.campuses.length 
            ? '<ul class="link-list min-list">' 
            : `<p>No campuses match that search. <a href="${universityData.root_url}/campuses">View all campuses</a></p>`}
            ${results.campuses.map(item => 
                `<li><a href="${item.permalink}">${item.title}</a></li>`
            ).join("")}
            ${results.campuses.length ? "</ul>" : ""}

            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length 
            ? ""
            : `<p>No events match that search. <a href="${universityData.root_url}/events">View all events</a></p>`}
            ${results.events.map(item => 
                `
                <div class="event-summary">
                <a class="event-summary__date t-center" href="${item.permalink}">
                    <span class="event-summary__month">${item.month}</span>
                    <span class="event-summary__day">${item.day}</span>  
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny">
                    <a href="${item.permalink}">${item.title}</a>
                    </h5>
                    <p>${item.description} 
                    <a href="${item.permalink}" class="nu gray">Learn more</a>
                    </p>
                </div>
                </div>
                `
            ).join("")}
        </div>
        </div>
    `

    // Hide the spinner after the results have been loaded and displayed.
    this.isSpinnerVisible = false
    } catch (e) {
    // Log any errors that occur during the API request or the rendering process.
    console.log(e)
    }
}

  // Method to handle keyboard events
keyPressDispatcher(e) {
    // If the pressed key is 's' (keyCode == 83), the search overlay is not currently open, 
    // and the active element isn't an input or textarea,
    // then open the search overlay.
    if (
    e.keyCode == 83 && !this.isOverlayOpen && 
    document.activeElement.tagName != "INPUT" && 
    document.activeElement.tagName != "TEXTAREA"
    ) {
    this.openOverlay()
    }

    // If the pressed key is 'esc' (keyCode == 27) and the search overlay is currently open, 
    // then close the search overlay.
    if (e.keyCode == 27 && this.isOverlayOpen) {
    this.closeOverlay()
    }
}


  // Method to open the search overlay
openOverlay() {
    // Add "search-overlay--active" class to the search overlay element.
    // This typically helps in displaying the search overlay by applying some CSS rules.
    this.searchOverlay.classList.add("search-overlay--active")

    // Add "body-no-scroll" class to the body of our document.
    // This typically prevents scrolling on the document when the search overlay is active.
    document.body.classList.add("body-no-scroll")

    // Clear the value (text) in our search field
    this.searchField.value = ""

    // Set the focus to our search field after a slight delay approx. 301ms.
    // This allows the transition animation to complete (if any), ensuring that 
    // our search field is focused when ready for user input.
    setTimeout(() => this.searchField.focus(), 301)

    // Display a console message indicating that our method has ran. Useful for debugging.
    console.log("our open method just ran!")

    // Update our flag to indicate that the search overlay is now open
    this.isOverlayOpen = true

    // Return false - this could have specific use-cases, such as preventing default action for an event.
    return false
}


// Method to close the search overlay
closeOverlay() {
// Remove "search-overlay--active" class from the search overlay element.
// This typically helps in hiding the search overlay by removing the associated CSS rules.
this.searchOverlay.classList.remove("search-overlay--active")

// Remove "body-no-scroll" class from the body of our document.
// This allows scrolling on the document to resume once the search overlay is closed.
document.body.classList.remove("body-no-scroll")

// Display a console message indicating that our method has ran. Useful for debugging.
console.log("our close method just ran!")

// Update our flag to indicate that the search overlay is now closed
this.isOverlayOpen = false
}


addSearchHTML() {
    document.body.insertAdjacentHTML(
    "beforeend",
    `
    <div class="search-overlay">
        <div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
        </div>

        <div class="container">
        <div id="search-overlay__results"></div>
        </div>

    </div>
    `
    )
}
}

export default Search

