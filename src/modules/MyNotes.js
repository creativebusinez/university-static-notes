import axios from "axios"
// Import the axios library for making HTTP requests.

class MyNotes {
  constructor() {
    // Check if the element with the ID "my-notes" exists on the page.
    if (document.querySelector("#my-notes")) {
      // Set the default headers for axios, including the nonce for security.
      axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce
      // Store a reference to the "my-notes" element.
      this.myNotes = document.querySelector("#my-notes")
      // Initialize event listeners.
      this.events()
    }
  }

  events() {
    // Add a click event listener to the "my-notes" element.
    this.myNotes.addEventListener("click", e => this.clickHandler(e))
    // Add a click event listener to the "submit-note" button for creating a new note.
    document.querySelector(".submit-note").addEventListener("click", () => this.createNote())
  }

  clickHandler(e) {
    // Handle different actions based on the clicked element's class.
    if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) this.deleteNote(e)
    if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) this.editNote(e)
    if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) this.updateNote(e)
  }

  findNearestParentLi(el) {
    // Traverse up the DOM tree to find the nearest parent <li> element.
    let thisNote = el
    while (thisNote.tagName != "LI") {
      thisNote = thisNote.parentElement
    }
    return thisNote
  }

  // Methods will go here
  editNote(e) {
    // Toggle the note's editability based on its current state.
    const thisNote = this.findNearestParentLi(e.target)

    if (thisNote.getAttribute("data-state") == "editable") {
      this.makeNoteReadOnly(thisNote)
    } else {
      this.makeNoteEditable(thisNote)
    }
  }

  makeNoteEditable(thisNote) {
    // Make the note fields editable.
    thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel'
    thisNote.querySelector(".note-title-field").removeAttribute("readonly")
    thisNote.querySelector(".note-body-field").removeAttribute("readonly")
    thisNote.querySelector(".note-title-field").classList.add("note-active-field")
    thisNote.querySelector(".note-body-field").classList.add("note-active-field")
    thisNote.querySelector(".update-note").classList.add("update-note--visible")
    thisNote.setAttribute("data-state", "editable")
  }

  makeNoteReadOnly(thisNote) {
    // Make the note fields read-only.
    thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit'
    thisNote.querySelector(".note-title-field").setAttribute("readonly", "true")
    thisNote.querySelector(".note-body-field").setAttribute("readonly", "true")
    thisNote.querySelector(".note-title-field").classList.remove("note-active-field")
    thisNote.querySelector(".note-body-field").classList.remove("note-active-field")
    thisNote.querySelector(".update-note").classList.remove("update-note--visible")
    thisNote.setAttribute("data-state", "cancel")
  }

  async deleteNote(e) {
    // Delete the note by sending a DELETE request to the server.
    const thisNote = this.findNearestParentLi(e.target)

    try {
      const response = await axios.delete(universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.getAttribute("data-id"))
      thisNote.style.height = `${thisNote.offsetHeight}px`
      setTimeout(function () {
        thisNote.classList.add("fade-out")
      }, 20)
      setTimeout(function () {
        thisNote.remove()
      }, 401)
      if (response.data.userNoteCount < 5) {
        document.querySelector(".note-limit-message").classList.remove("active")
      }
    } catch (e) {
      console.log("Sorry")
    }
  }

  async updateNote(e) {
    // Update the note by sending a POST request with the updated content.
    const thisNote = this.findNearestParentLi(e.target)

    var ourUpdatedPost = {
      "title": thisNote.querySelector(".note-title-field").value,
      "content": thisNote.querySelector(".note-body-field").value
    }

    try {
      const response = await axios.post(universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.getAttribute("data-id"), ourUpdatedPost)
      this.makeNoteReadOnly(thisNote)
    } catch (e) {
      console.log("Sorry")
    }
  }

  async createNote() {
    // Create a new note by sending a POST request with the new note data.
    var ourNewPost = {
      "title": document.querySelector(".new-note-title").value,
      "content": document.querySelector(".new-note-body").value,
      "status": "publish"
    }

    try {
      const response = await axios.post(universityData.root_url + "/wp-json/wp/v2/note/", ourNewPost)

      if (response.data != "You have reached your note limit.") {
        document.querySelector(".new-note-title").value = ""
        document.querySelector(".new-note-body").value = ""
        document.querySelector("#my-notes").insertAdjacentHTML(
          "afterbegin",
          ` <li data-id="${response.data.id}" class="fade-in-calc">
            <input readonly class="note-title-field" value="${response.data.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${response.data.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>`
        )

        // Temporarily set the height to 0px for a smooth height transition.
        let finalHeight // browser needs a specific height to transition to, you can't transition to 'auto' height
        let newlyCreated = document.querySelector("#my-notes li")

        // Give the browser time to add the invisible element to the DOM before moving on.
        setTimeout(function () {
          finalHeight = `${newlyCreated.offsetHeight}px`
          newlyCreated.style.height = "0px"
        }, 30)

        // Allow the browser to calculate the height before transitioning.
        setTimeout(function () {
          newlyCreated.classList.remove("fade-in-calc")
          newlyCreated.style.height = finalHeight
        }, 50)

        // Remove the hardcoded height after the transition to make the design responsive again.
        setTimeout(function () {
          newlyCreated.style.removeProperty("height")
        }, 450)
      } else {
        document.querySelector(".note-limit-message").classList.add("active")
      }
    } catch (e) {
      console.error(e)
    }
  }
}

export default MyNotes
// Export the MyNotes class as the default export.
