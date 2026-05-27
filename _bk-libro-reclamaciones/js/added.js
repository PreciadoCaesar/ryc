// Modal video
document.addEventListener("DOMContentLoaded", function () {
    let videoModal = document.getElementById("videoModal");
    let videoFrame = document.getElementById("videoFrame");

    videoModal.addEventListener("show.bs.modal", function (event) {
        let button = event.relatedTarget;
        let videoUrl = button.getAttribute("data-bs-video");
        videoFrame.src = videoUrl;
    });

    videoModal.addEventListener("hidden.bs.modal", function () {
        videoFrame.src = "";
    });
});