class GMap {
    constructor() {
      // When a new instance of GMap is created, find all elements with the class "acf-map"
      // and initialize a new map for each one.
      document.querySelectorAll(".acf-map").forEach(el => {
        this.new_map(el)
      })
    }
  
    new_map($el) {
      // Get all markers within the map element.
      var $markers = $el.querySelectorAll(".marker")
  
      // Set up map options.
      var args = {
        zoom: 16,
        center: new google.maps.LatLng(0, 0), // Initial center position (0, 0) until markers are added.
        mapTypeId: google.maps.MapTypeId.ROADMAP // Use the standard roadmap view.
      }
  
      // Create a new map within the specified element.
      var map = new google.maps.Map($el, args)
      map.markers = []
      var that = this
  
      // Add markers to the map.
      $markers.forEach(function (x) {
        that.add_marker(x, map)
      })
  
      // Adjust the map to fit all markers.
      this.center_map(map)
    } // end new_map
  
    add_marker($marker, map) {
      // Get the latitude and longitude from the marker's data attributes.
      var latlng = new google.maps.LatLng($marker.getAttribute("data-lat"), $marker.getAttribute("data-lng"))
  
      // Create a new marker and add it to the map.
      var marker = new google.maps.Marker({
        position: latlng,
        map: map
      })
  
      // Add the marker to the map's marker array.
      map.markers.push(marker)
  
      // If the marker contains HTML content, add it to an info window.
      if ($marker.innerHTML) {
        var infowindow = new google.maps.InfoWindow({
          content: $marker.innerHTML
        })
  
        // Show the info window when the marker is clicked.
        google.maps.event.addListener(marker, "click", function () {
          infowindow.open(map, marker)
        })
      }
    } // end add_marker
  
    center_map(map) {
      var bounds = new google.maps.LatLngBounds()
  
      // Loop through all markers and extend the bounds to include each one.
      map.markers.forEach(function (marker) {
        var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng())
        bounds.extend(latlng)
      })
  
      // If there is only one marker, center the map on it and set a zoom level.
      if (map.markers.length == 1) {
        map.setCenter(bounds.getCenter())
        map.setZoom(16)
      } else {
        // Fit the map bounds to include all markers.
        map.fitBounds(bounds)
      }
    } // end center_map
  }
  
  export default GMap
  