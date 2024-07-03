document.addEventListener("DOMContentLoaded", function() {

    var eventSlider = document.getElementById("event-slider");

    var events = eventSlider.querySelectorAll(".event");

    var currentSlide = 0;

    // Function to show the current slide
    function showSlide(index) {
        for (var i = 0; i < events.length; i++) {
            events[i].style.display = "none";
        }

        events[index].style.display = "block";
    }
    showSlide(currentSlide);

    // Function to show the next slide
    function showNextSlide() {
        currentSlide++;
        if (currentSlide >= events.length) {
            currentSlide = 0; 
        }
        showSlide(currentSlide);
    }

    // Function to show the previous slide
    function showPrevSlide() {
        currentSlide--;
        if (currentSlide < 0) {
            currentSlide = events.length - 1;
        }
        showSlide(currentSlide);
    }

    // Event listeners for next and previous buttons
    document.getElementById("next-btn").addEventListener("click", showNextSlide);
    document.getElementById("prev-btn").addEventListener("click", showPrevSlide);
});
