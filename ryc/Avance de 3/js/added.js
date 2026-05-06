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

// Carrusel de profesores con drag de mouse (desktop)
(function() {
    const container = document.querySelector('.prof-scroll');
    if (!container) return;

    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let velX = 0;
    let lastX = 0;
    let lastTime = 0;
    let momentumID = null;

    container.addEventListener('mousedown', (e) => {
        isDown = true;
        container.style.cursor = 'grabbing';
        container.style.scrollBehavior = 'auto';
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        lastX = startX;
        lastTime = Date.now();
        velX = 0;
        if (momentumID) cancelAnimationFrame(momentumID);
    });

    container.addEventListener('mouseleave', () => {
        isDown = false;
        container.style.cursor = 'grab';
        if (Math.abs(velX) > 1) applyMomentum();
    });

    container.addEventListener('mouseup', () => {
        isDown = false;
        container.style.cursor = 'grab';
        container.style.scrollBehavior = 'smooth';
        if (Math.abs(velX) > 1) applyMomentum();
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 1.5;
        container.scrollLeft = scrollLeft - walk;
        
        const now = Date.now();
        const dt = now - lastTime;
        if (dt > 0) {
            velX = (x - lastX) / dt * 10;
        }
        lastX = x;
        lastTime = now;
    });

    function applyMomentum() {
        if (Math.abs(velX) < 0.1) return;
        const decay = 0.95;
        const maxVel = 30;
        
        function step() {
            velX *= decay;
            container.scrollLeft -= velX;
            if (Math.abs(velX) > 0.5) {
                momentumID = requestAnimationFrame(step);
            }
        }
        momentumID = requestAnimationFrame(step);
    }
})();