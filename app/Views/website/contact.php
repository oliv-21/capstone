<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <!-- Favicon -->
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- bootstrap link -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Customized Bootstrap Stylesheet -->
  <link rel="stylesheet" href="assets/css/website.css">

<style>
  #chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Nunito', sans-serif;
  }

  #chatbot-button {
    background-color: #ff6b6b; /* red tone */
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 26px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }

  #chatbot-button:hover {
    transform: scale(1.1);
  }

  /* Chat box positioned above the button */
  #chatbot-box {
    position: absolute;
    bottom: 75px; /* sits above the button */
    right: 0;
    width: 320px;
    background: white;
    border-radius: 12px;
    display: none;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    overflow: hidden;
  }

  #chatbot-header {
    background-color: #ff6b6b;
    color: white;
    font-weight: bold;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
  }

  #chatbot-messages {
    height: 280px;
    overflow-y: auto;
    font-size: 14px;
    padding: 10px;
  }

  .bot-message, .user-message {
    padding: 10px 14px;
    border-radius: 15px;
    max-width: 80%;
    word-wrap: break-word;
  }

  .bot-message {
    background-color: #f1f1f1;
    align-self: flex-start;
  }

  .user-message {
    background-color: #ff6b6b;
    color: white;
    align-self: flex-end;
    margin-left: auto;
  }

  .choice-btn {
    font-size: 12px;
    border-radius: 20px;
    border: 1px solid #ff6b6b;
    color: #ff6b6b;
    background: white;
    transition: 0.3s;
  }

  .choice-btn:hover {
    background: #ff6b6b;
    color: white;
  }

  #chatbot-input {
    border-top: 1px solid #eee;
  }

  #user-input {
    border-radius: 20px;
  }

  #send-btn {
    background: #ff6b6b;
    border-radius: 50%;
    width: 40px;
    height: 40px;
  }

  #close-chatbot {
    cursor: pointer;
}
</style>
</head>

<body>
  <!-- Navbar Start -->
  <div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
      <a href="<?= base_url('/') ?>" class="navbar-brand">
        <img class="logo" src="assets/img/logo.png" alt="" style="width: 230px;">
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav fw-bold fs-5 mx-auto py-0">
          <a href="<?= base_url('/') ?>" class="nav-item nav-link">Home</a>
          <a class="nav-link" href="<?= base_url(); ?>about">About</a>
          <a href="<?= base_url(); ?>classes" class="nav-item nav-link">Classes</a>
          <!-- <a href="<?= base_url(); ?>teacher" class="nav-item nav-link">Teachers</a> -->
          <a href="<?= base_url(); ?>contact" class="nav-item nav-link active">Contact</a>
        </div>
        <a href="<?= base_url(); ?>login" class="btn btn-primary px-5 fw-bold text-white">Login</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->

  <!-- Header Start -->
  <div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
      <h3 class="display-3 fw-bold text-white">Contact Us</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0"><a class="text-white" href="<?= base_url('/') ?>">Home</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">Contact Us</p>
      </div>
    </div>
  </div>
  <!-- Header End -->

  <!-- Contact Start -->
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Get In Touch</span>
        </p>
        <h1 class="mb-5 text-secondary">Contact Us For Any Query</h1>
      </div>
      <div class="row">
        <div class="col-lg-7 mb-5">
          <div class="contact-form">
            <div id="success"></div>
            <form name="sentMessage" id="contactForm" novalidate="novalidate" method="post" action="<?= base_url('send-contact-message') ?>">
              <div class="control-group">
                <input type="text" class="form-control" name='name' id="name" placeholder="Your Name" required="required"
                  data-validation-required-message="please enter your name" />
                <p class="help-block text-danger"></p>
              </div>
              <div class="control-group">
                <input type="email" class="form-control" id="email" placeholder="Your Email" name='email' required="required"
                  data-validation-required-message="please enter your email" />
                <p class="help-block text-danger"></p>
              </div>
              <div class="control-group">
                <input type="text" class="form-control" id="subject" placeholder="Subject" name='subject' required="required"
                  data-validation-required-message="please enter a subject" />
                <p class="help-block text-danger"></p>
              </div>
              <div class="control-group">
                <textarea class="form-control" rows="6" id="message" placeholder="Message" required="required" name='message'
                  data-validation-required-message="please enter your message"></textarea>
                <p class="help-block text-danger"></p>
              </div>
              <div>
                <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">
                  Send Message
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-5 mb-5">
          <div class="d-flex">
            <i class="fa fa-map-marker-alt d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
              style="width: 45px; height: 45px"></i>
            <div class="ps-3">
              <h5>Address</h5>
              <p>Barangay, Bagumbayan, Santa Cruz, Laguna</p>
            </div>
          </div>
          <div class="d-flex">
            <i class="fa fa-envelope d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
              style="width: 45px; height: 45px"></i>
            <div class="ps-3">
              <h5>Email</h5>
              <p>Brightside@gmail.com</p>
            </div>
          </div>
          <div class="d-flex">
            <i class="fa fa-phone-alt d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
              style="width: 45px; height: 45px"></i>
            <div class="ps-3">
              <h5>Phone</h5>
              <p>0912 123 1234</p>
            </div>
          </div>
          <div class="d-flex">
            <i class="far fa-clock d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
              style="width: 45px; height: 45px"></i>
            <div class="ps-3">
              <h5>Opening Hours</h5>
              <strong>Monday - Friday:</strong>
              <p class="m-0">08:00 AM - 05:00 PM</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contact End -->

  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <!-- Footer Start -->
  <div class="container-fluid bg-tertiary text-white mt-5 py-5 px-sm-3 px-md-5">
    <div class="row pt-5">
      <div class="col-lg-5 col-md-6 mb-5">
        <a href="" class="navbar-brand m-0 mb-4 p-0" style="font-size: 40px; line-height: 40px">
          <img class="w-75" src="assets/img/logo.png" alt="">
        </a>
      </div>

      <div class="col-lg-4 col-md-6 mb-5">
        <h3 class="text-primary mb-4">Get In Touch</h3>
        <div class="d-flex">
          <h4 class="fa fa-map-marker-alt text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Address</h5>
            <p>Barangay, Bagumbayan, Santa Cruz, Laguna</p>
          </div>
        </div>
        <div class="d-flex">
          <h4 class="fa fa-envelope text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Email</h5>
            <p>brightside@gmail.com</p>
          </div>
        </div>
        <div class="d-flex">
          <h4 class="fa fa-phone-alt text-primary"></h4>
          <div class="ps-3">
            <h5 class="text-white">Phone</h5>
            <p>+012 345 67890</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-5">
        <h3 class="text-primary mb-4">Quick Links</h3>
        <div class="d-flex flex-column justify-content-start">
          <a class="text-white mb-2" href="<?= base_url('/') ?>"><i class="fa fa-angle-right mr-2"></i>Home</a>
          <a class="text-white mb-2" href="<?= base_url(); ?>about"><i class="fa fa-angle-right mr-2"></i>About Us</a>
          <a class="text-white mb-2" href="<?=base_url(); ?>classes"><i class="fa fa-angle-right mr-2"></i>Our Classes</a>
          <!-- <a class="text-white mb-2" href="<?=base_url(); ?>teacher"><i class="fa fa-angle-right mr-2"></i>Our Teachers</a> -->
          <a class="text-white" href="<?=base_url(); ?>contact"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
        </div>
      </div>
    </div>

    <div class="container-fluid pt-5" style="border-top: 1px solid #ff6b6b;">
      <p class="m-0 text-center text-white">
        &copy;
        <a class="text-primary fw-bold" href="#">Brightside Global Learning Center</a>.
        All Rights Reserved.
      </p>
    </div>
  </div>

  <!-- Back to Top -->
  <!-- <a href="#" class="btn btn-primary p-3 back-to-top text-white" id="backToTopBtn">
    <i class="fa fa-angle-double-up"></i>
  </a> -->

  <!-- === FAQ Chatbot === -->
  <!-- Brightside FAQ Chatbot -->

  <div id="chatbot-container">
    <div id="chatbot-button">
      <i class="fa fa-comments"></i>
    </div>

    <div id="chatbot-box" class="shadow-lg">
      <div id="chatbot-header" class="bg-primary text-white d-flex justify-content-between align-items-center px-3 py-2">
        <span><i class="fa fa-robot me-2"></i>Brightside Assistant</span>
        <i id="close-chatbot" class="fa fa-times cursor-pointer"></i>
      </div>

      <div id="chatbot-messages" class="p-3">
        <div class="bot-message mb-2">👋 Hi there! I’m your Brightside Assistant. How can I help you today?</div>
      </div>

      <div id="chatbot-choices" class="p-2 border-top">
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Tuition Fee</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Class Schedule</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Age Requirement</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Enrollment Requirements</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Contact Info</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">School Address</button>
        <button class="choice-btn btn btn-outline-primary btn-sm m-1">Available Class</button>
      </div>

      <div id="chatbot-input" class="d-flex p-2 border-top">
        <input type="text" id="user-input" class="form-control me-2" placeholder="Type your question...">
        <button id="send-btn" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
      </div>
    </div>
  </div>

  <!-- Template Javascript -->
  <script src="assets/js/main.js"></script>
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const chatbotToggleBtn = document.getElementById('chatbot-button');
    const chatbotPanel = document.getElementById('chatbot-box');
    const chatbotClose = document.getElementById('close-chatbot');

    chatbotToggleBtn.onclick = () => {
      chatbotPanel.style.display = chatbotPanel.style.display === 'flex' ? 'none' : 'flex';
    };

    chatbotClose.onclick = () => chatbotPanel.style.display = 'none';
  </script>
  <!-- FAQ Chatbot Script -->
 <script>
const faqAnswers = {
  "tuition": `💰 Sure! Here’s the breakdown of our tuition fees per class:  

🏫 **Nursery** – ₱2,000 per month  
🎨 **Pre-Kinder** – ₱2,500 per month  
📚 **Kinder 1** – ₱2,500 per month  
✏️ **Kinder 2** – ₱2,500 per month  

Each plan already includes learning materials and activity kits, so you don’t have to worry about extra costs.  
You can settle payments monthly or per term directly at the admin office. 😊`,

  "schedule": `🕒 Of course! Here’s our class schedule for the week (Monday to Friday):  

🧸 **Toddler Class:** 10:00 AM – 12:00 PM  
🎨 **Pre-Kindergarten Class:** 8:00 AM – 10:00 AM  
📘 **Junior Kindergarten:** 10:00 AM – 12:00 PM  
✏️ **Senior Kindergarten:** 1:00 PM – 3:00 PM  

We keep sessions short and engaging to match each child’s learning pace. ❤️`,

  "age": `👶 Here’s the age requirement for each class:  

🧸 **Toddler Class:** 2 to 3 years old  
🎨 **Pre-Kindergarten Class:** 3 to 4 years old  
📘 **Junior Kindergarten:** 4 years old  
✏️ **Senior Kindergarten:** 5 years old  

If your child is right on the age border, we can help you find the best placement—just let us know! 😊`,

  "requirements": `📋 You’ll just need a few documents to enroll:  

✅ Photocopy of Birth Certificate  
✅ Two (2) pieces of 1x1 ID picture  
✅ Completed Registration Form (you can get this at our office)  

Once you have these ready, visit us anytime during office hours and we’ll assist you with the rest! 💖`,

  "contact": `📞 You can reach us through any of these:  

📧 **Email:** brightside@gmail.com  
📱 **Phone:** 0912 123 1234  
💬 **Facebook:** Brightside Learning Center  

Feel free to message us anytime — we’ll get back to you as soon as possible! ☀️`,

  "address": `📍 We’re located at:  

**Brightside Learning Center**  
Barangay Bagumbayan, Santa Cruz, Laguna  

We’re open **Monday to Friday, from 8:00 AM to 4:00 PM.**  
You’re always welcome to drop by and visit our classrooms! 🏫`,

  "class": `📋 Here’s a quick look at our available classes:  

🧸 **Toddler Class** – Fun and creative play-based learning for ages 2–3.  
🎨 **Pre-Kindergarten Class** – Early literacy and motor skills for ages 3–4.  
📘 **Junior Kindergarten** – Focused on foundational academics for 4-year-olds.  
✏️ **Senior Kindergarten** – Prepares 5-year-olds for elementary transition.  

Would you like me to tell you more about what each class offers? 😊`
};


const chatbotBtn = document.getElementById('chatbot-button');
const chatbotBox = document.getElementById('chatbot-box');
const closeChatbot = document.getElementById('close-chatbot');
const sendBtn = document.getElementById('send-btn');
const userInput = document.getElementById('user-input');
const messages = document.getElementById('chatbot-messages');
const choiceButtons = document.querySelectorAll('.choice-btn');

chatbotBtn.onclick = () => chatbotBox.style.display = 'flex';
closeChatbot.onclick = () => chatbotBox.style.display = 'none';
sendBtn.onclick = () => handleUserMessage();
userInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') handleUserMessage();
});

choiceButtons.forEach(btn => {
  btn.onclick = () => {
    const question = btn.textContent;
    addMessage(question, 'user-message');
    handleBotResponse(question.toLowerCase());
  };
});

function handleUserMessage() {
  const message = userInput.value.trim().toLowerCase();
  if (!message) return;
  addMessage(userInput.value, 'user-message');
  userInput.value = '';
  handleBotResponse(message);
}

function handleBotResponse(input) {
  setTimeout(() => {
    const response = getBotResponse(input);
    addMessage(response, 'bot-message');
  }, 500);
}

function addMessage(text, type) {
  const msg = document.createElement('div');
  msg.classList.add(type, 'mb-2');
  msg.innerHTML = text.replace(/\n/g, '<br>');
  messages.appendChild(msg);
  messages.scrollTop = messages.scrollHeight;
}

function getBotResponse(input) {
  for (let key in faqAnswers) {
    if (input.includes(key)) return faqAnswers[key];
  }
  return "Sorry, I didn’t understand that. Try asking about tuition, schedule, or requirements.";
}
</script>
</body>

</html>
