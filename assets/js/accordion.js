document.addEventListener("DOMContentLoaded", function () {
  const accordions = document.querySelectorAll(".accordion .question");

  accordions.forEach(question => {
      question.addEventListener("click", function () {
          const parent = this.parentElement;
          parent.classList.toggle("active");
      });
  });
});