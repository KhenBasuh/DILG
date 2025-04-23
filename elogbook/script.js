// Toggle between Signature and Photo
function selectMethod(method) {
    const sigSection = document.getElementById('signatureSection');
    const photoSection = document.getElementById('photoSection');
    const buttons = document.querySelectorAll('.toggle-btn');
  
    // Remove active class from both buttons
    buttons.forEach(btn => btn.classList.remove('active'));
  
    if (method === 'signature') {
      sigSection.classList.remove('hidden');
      photoSection.classList.add('hidden');
      buttons[0].classList.add('active');
    } else {
      sigSection.classList.add('hidden');
      photoSection.classList.remove('hidden');
      buttons[1].classList.add('active');
      startCamera();
    }
  }
  
  
  // Clear canvas
  function clearCanvas() {
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  }
  
  // Draw on canvas (mobile & desktop)
  const canvas = document.getElementById('signatureCanvas');
  const ctx = canvas.getContext('2d');
  let drawing = false;
  
  canvas.addEventListener('mousedown', () => drawing = true);
  canvas.addEventListener('mouseup', () => drawing = false);
  canvas.addEventListener('mousemove', draw);
  
  canvas.addEventListener('touchstart', function (e) {
    e.preventDefault();
    drawing = true;
    const touch = e.touches[0];
    ctx.beginPath();
    ctx.moveTo(touch.clientX - canvas.getBoundingClientRect().left, touch.clientY - canvas.getBoundingClientRect().top);
  }, { passive: false });
  
  canvas.addEventListener('touchend', function (e) {
    e.preventDefault();
    drawing = false;
  }, { passive: false });
  
  canvas.addEventListener('touchmove', function (e) {
    e.preventDefault();
    if (!drawing) return;
    const touch = e.touches[0];
    ctx.lineTo(touch.clientX - canvas.getBoundingClientRect().left, touch.clientY - canvas.getBoundingClientRect().top);
    ctx.stroke();
  }, { passive: false });
    
  function draw(e) {
    if (!drawing) return;
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
  }
  
  // Camera
  function startCamera() {
    const video = document.getElementById('video');
    if (!video.srcObject) {
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
          video.srcObject = stream;
        })
        .catch(err => {
          alert("Unable to access camera");
          console.error(err);
        });
    }
  }
  
  function captureImage() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('photoCanvas');
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  }

  // Language toggle
document.addEventListener("DOMContentLoaded", function () {
    const engBtn = document.getElementById("english-btn");
    const tagBtn = document.getElementById("tagalog-btn");
    const engContent = document.getElementById("english-content");
    const tagContent = document.getElementById("tagalog-content");
    const popup = document.getElementById("privacy-popup");
    const form = document.getElementById("elogbookForm");
  
    // Show popup on load
    popup.style.display = "flex";
    form.style.display = "none"; // hide form initially
  
    engBtn.addEventListener("click", () => {
      engContent.style.display = "block";
      tagContent.style.display = "none";
      engBtn.classList.add("active");
      tagBtn.classList.remove("active");
    });
  
    tagBtn.addEventListener("click", () => {
      engContent.style.display = "none";
      tagContent.style.display = "block";
      engBtn.classList.remove("active");
      tagBtn.classList.add("active");
    });
  
    // Accept buttons
    document.getElementById("accept-btn").addEventListener("click", acceptPrivacy);
    document.getElementById("accept-btn-tagalog").addEventListener("click", acceptPrivacy);
  
    function acceptPrivacy() {
      popup.style.display = "none";
      form.style.display = "block";
    }
  });
  
  