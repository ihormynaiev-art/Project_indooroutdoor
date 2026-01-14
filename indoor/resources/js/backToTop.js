document.addEventListener("DOMContentLoaded", function () {
    const switchElement = document.querySelector(".switch");
    const body = document.body;
  
    if (switchElement) {
      switchElement.addEventListener("click", function () {
        if (body.classList.contains("light")) {
          body.classList.remove("light");
          switchElement.classList.remove("switched");
        } else {
          body.classList.add("light");
          switchElement.classList.add("switched");
        }
      });
    }
  
    const progressWrap = document.querySelector(".progress-wrap");
  
    if (progressWrap) {
      const path = progressWrap.querySelector("path");
      const totalLength = path.getTotalLength();
  
      path.style.transition = path.style.WebkitTransition = "none";
      path.style.strokeDasharray = `${totalLength} ${totalLength}`;
      path.style.strokeDashoffset = totalLength;
      path.getBoundingClientRect();
      path.style.transition = path.style.WebkitTransition = "stroke-dashoffset 10ms linear";
  
      const updateProgress = function () {
        const scrollOffset = window.scrollY;
        const windowHeight = window.innerHeight;
        const documentHeight = document.body.scrollHeight;
        const newOffset = totalLength - (scrollOffset * totalLength) / (documentHeight - windowHeight);
        path.style.strokeDashoffset = newOffset;
      };
  
      updateProgress();
      window.addEventListener("scroll", updateProgress);
  
      window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
          progressWrap.classList.add("active-progress");
        } else {
          progressWrap.classList.remove("active-progress");
        }
      });
  
      progressWrap.addEventListener("click", function (event) {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
        return false;
      });
    }
  });
  