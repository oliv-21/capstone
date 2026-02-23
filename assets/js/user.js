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

  // document.addEventListener("DOMContentLoaded", function () {
  //   const notifMenu = document.querySelector('#notifDropdown + .dropdown-menu');

  //   if (notifMenu) {
  //     notifMenu.innerHTML = `
  //       <li class="dropdown-header fw-bold">Notifications</li>
  //       <li><hr class="dropdown-divider"></li>
  //       <li class="px-3 py-2 small">New admission request received</li>
  //       <li class="px-3 py-2 small">Server maintenance scheduled</li>
  //     `;
  //   }

  // });
function sendChatMessage(e) {
  e.preventDefault();
  const input = document.getElementById('chatInput');
  const message = input.value.trim();
  if (!message) return;

  const chatBox = document.getElementById('chatBox');
  const messageContainer = document.createElement('div');
  messageContainer.className = 'd-flex flex-column mb-3';

  messageContainer.innerHTML = `
    <div class="align-self-end bg-primary text-white p-2 rounded shadow-sm" style="max-width: 75%;">
      ${message}
    </div>
    <small class="align-self-end text-muted">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>
  `;

  chatBox.appendChild(messageContainer);
  input.value = '';
  chatBox.scrollTop = chatBox.scrollHeight;
}



window.addEventListener('DOMContentLoaded', () => {
  const savedTheme = JSON.parse(localStorage.getItem('themeColors'));
  if (savedTheme) {
    document.documentElement.style.setProperty('--brandcolor', savedTheme.brand);
    document.documentElement.style.setProperty('--accentcolor', savedTheme.accent);
    document.documentElement.style.setProperty('--tertiarycolor', savedTheme.tertiary);

    // Optional: Apply logo and name if elements exist on the page
    const logo = document.getElementById('schoolLogo');
    const name = document.getElementById('schoolName');
    if (logo && savedTheme.logo) logo.src = savedTheme.logo;
    if (name && savedTheme.schoolName) name.innerText = savedTheme.schoolName;
  }
});

// Other admin-specific JS below...


function downloadCard(cardId) {
  const card = document.getElementById(cardId);
  if (!card) return;

  // Hide all elements with the "no-capture" class
  const hiddenItems = card.querySelectorAll('.no-capture');
  hiddenItems.forEach(el => el.style.display = 'none');

  html2canvas(card).then(canvas => {
    // Restore hidden elements
    hiddenItems.forEach(el => el.style.display = '');

    const link = document.createElement('a');
    link.download = cardId + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
  });
}

