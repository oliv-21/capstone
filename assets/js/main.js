// Get the button
let backToTopBtn = document.getElementById("backToTopBtn");

// When the user scrolls down 100px from the top of the document, show the button
window.onscroll = function () {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    backToTopBtn.style.display = "block"; // Show the button
  } else {
    backToTopBtn.style.display = "none"; // Hide the button
  }
};

// When the user clicks on the button, scroll to the top of the document
backToTopBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent default action of anchor tag
  window.scrollTo({
    top: 0,
    behavior: "smooth", // Smooth scrolling
  });
});


function computeAge() {
    const birthDate = new Date(document.getElementById('birthday').value);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    document.getElementById('age').value = age;
}

