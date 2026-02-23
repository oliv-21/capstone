function setupSidebarToggle() {
  const sidebar = document.getElementById('adminSidebar');
  const toggle = document.getElementById('sidebarToggle');
  const backdrop = document.getElementById('sidebarBackdrop');

  if (toggle && sidebar && backdrop) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      backdrop.classList.toggle('show');
    });

    backdrop.addEventListener('click', () => {
      sidebar.classList.remove('active');
      backdrop.classList.remove('show');
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  setupSidebarToggle();
});

function updateDateTime() {
  const now = new Date();
  const date = now.toLocaleDateString();
  const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

  // Check if the elements exist before updating
  const dateElement = document.getElementById("date");
  const timeElement = document.getElementById("time");

  if (dateElement) {
    dateElement.textContent = `${date}`;
  }

  if (timeElement) {
    timeElement.textContent = `${time}`;
  }
}

// Start updating the time every 1 second (1000ms)
setInterval(updateDateTime, 1000);

// Immediately update time when the script loads
updateDateTime();



// TimeIn sweetalert2 for attendance
// function arrived() {
//   Swal.fire({
//     title: 'Child Arrived?',
//     text: "Are you sure you want to mark this child as arrived?",
//     icon: 'question',
//     showCancelButton: true,
//     confirmButtonText: 'Yes, Arrived',
//     cancelButtonText: 'Cancel',
//     confirmButtonColor: '#ff6b6b',
//     cancelButtonColor: '#5a1e1e'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire('Arrived!', 'Child has been marked as arrived.', 'success');
//       // You can add your actual arrival logic here
//       document.getElementById("pickedupEl").disabled = false;
//       document.getElementById("arrivedEl").disabled = true;
//       document.getElementById("statusEl").textContent = 'Present';
//     } else {
//       Swal.fire('Cancelled', 'Arrival not recorded.', 'info');
//     }
//   });
// }


// // TimeOut sweetalert2 for attendance
// function left() {
//   Swal.fire({
//     title: 'Time Out?',
//     text: "Are you sure you want to time in now?",
//     icon: 'question',
//     showCancelButton: true,
//     confirmButtonText: 'Yes, Time In',
//     cancelButtonText: 'Cancel',
//     confirmButtonColor: '#ff6b6b',
//     cancelButtonColor: '#5a1e1e'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire('Timed In!', 'Attendance recorded.', 'success');
//       // You can add your actual time-in logic here
//     } else {
//       Swal.fire('Cancelled', 'You did not time in.', 'info');
//     }
//   });
// }

// approved sweetalert2 for admision
// 

//save changes notif for account management
function saveChanges() {
  Swal.fire({
    title: 'Save Changes?',
    text: "Are you sure you want to save the changes made?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Save Changes',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#ff6b6b',
    cancelButtonColor: '#5a1e1e'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire('Saved!', 'Changes have been saved successfully.', 'success')
        .then(() => {
          // Submit the form manually
          document.getElementById('editGuardianForm').submit();

          // Optional: Hide modal after submission
          const modalEl = document.getElementById('guardianDetailsModal');

          let modal = bootstrap.Modal.getInstance(modalEl);
          if (modal) modal.hide();
        });
    }
  });
}
function saveChangesTeacher() {
  Swal.fire({
    title: 'Save Changes?',
    text: "Are you sure you want to save the changes made?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Save Changes',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#ff6b6b',
    cancelButtonColor: '#5a1e1e'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire('Saved!', 'Changes have been saved successfully.', 'success')
        .then(() => {
          // Submit the form manually
          document.getElementById('editTeacherForm').submit();

          // Optional: Hide modal after submission
          const modalEl = document.getElementById('detailsModal');
          let modal = bootstrap.Modal.getInstance(modalEl);
          if (modal) modal.hide();
        });
    }
  });
}


//chat at notif
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
  }
});

//pag apply ng theme color
const defaultTheme = {
  brand: "#ff6b6b",
  accent: "#c14444",
  tertiary: "#5a1e1e",
  schoolName: "Brightside",
  logo: "assets/img/logoicon.png"
};

function applyTheme() {
  const brandColor = document.getElementById('brandcolorPicker').value;
  const accentColor = document.getElementById('accentcolorPicker').value;
  const tertiaryColor = document.getElementById('tertiarycolorPicker').value;
  const schoolName = document.getElementById('schoolNameInput')?.value || defaultTheme.schoolName;
  const logoInput = document.getElementById('schoolLogoInput');
  const logoImg = document.getElementById('schoolLogo');

  const applyAndSaveTheme = (logoDataUrl) => {
    // Apply styles
    document.documentElement.style.setProperty('--brandcolor', brandColor);
    document.documentElement.style.setProperty('--accentcolor', accentColor);
    document.documentElement.style.setProperty('--tertiarycolor', tertiaryColor);

    document.getElementById('schoolName').innerText = schoolName;
    logoImg.src = logoDataUrl;

    // Save to localStorage
    localStorage.setItem('themeColors', JSON.stringify({
      brand: brandColor,
      accent: accentColor,
      tertiary: tertiaryColor,
      schoolName: schoolName,
      logo: logoDataUrl
    }));
  };

  // If a new file is selected, read it first
  if (logoInput.files.length > 0) {
    const reader = new FileReader();
    reader.onload = function(e) {
      applyAndSaveTheme(e.target.result); // base64
    };
    reader.readAsDataURL(logoInput.files[0]);
  } else {
    const currentLogo = logoImg.src || defaultTheme.logo;
    applyAndSaveTheme(currentLogo);
  }
}



function resetTheme() {
  document.getElementById('brandcolorPicker').value = defaultTheme.brand;
  document.getElementById('accentcolorPicker').value = defaultTheme.accent;
  document.getElementById('tertiarycolorPicker').value = defaultTheme.tertiary;
  document.getElementById('schoolLogo').src = defaultTheme.logo;

  if (document.getElementById('schoolNameInput')) {
    document.getElementById('schoolNameInput').value = defaultTheme.schoolName;
  }
  document.getElementById('schoolName').innerText = defaultTheme.schoolName;

  document.documentElement.style.setProperty('--brandcolor', defaultTheme.brand);
  document.documentElement.style.setProperty('--accentcolor', defaultTheme.accent);
  document.documentElement.style.setProperty('--tertiarycolor', defaultTheme.tertiary);

  localStorage.removeItem('themeColors');
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




// //admission controller
// document.addEventListener("DOMContentLoaded", function () {
//   let classIndex = 1;
//   const addClassBtn = document.getElementById('addClassBtn');
//   const classContainer = document.getElementById('classContainer');
//   const admissionForm = document.getElementById('admissionForm');

//   // Add new class row
//   if (addClassBtn && classContainer) {
//     addClassBtn.addEventListener('click', function () {
//       const newRow = document.createElement('div');
//       newRow.classList.add('row', 'g-3', 'align-items-end', 'class-row', 'mb-2');
//       newRow.innerHTML = `
//         <div class="col-md-5">
//           <input type="text" name="classes[${classIndex}][name]" class="form-control" placeholder="e.g., Grade ${classIndex + 1}" required>
//         </div>
//         <div class="col-md-5">
//           <input type="number" name="classes[${classIndex}][fee]" class="form-control" placeholder="e.g., 15000" required>
//         </div>
//         <div class="col-md-2">
//           <button type="button" class="btn btn-danger remove-class"><i class="fa-solid fa-minus"></i></button>
//         </div>
//       `;
//       classContainer.appendChild(newRow);
//       classIndex++;
//     });

//     // Remove class row
//     classContainer.addEventListener('click', function (e) {
//       if (e.target.closest('.remove-class')) {
//         e.target.closest('.class-row').remove();
//       }
//     });
//   }

//   // Form validation and submission
//   if (admissionForm) {
//     admissionForm.addEventListener("submit", function (e) {
//       const openingDateInput = document.getElementById("openingDate");
//       const closingDateInput = document.getElementById("closingDate");

//       const openingDate = new Date(openingDateInput.value);
//       const closingDate = new Date(closingDateInput.value);
//       const today = new Date();
//       today.setHours(0, 0, 0, 0); // Reset to midnight for accurate comparison

//       if (!openingDateInput.value || !closingDateInput.value) {
//         e.preventDefault();
//         alert("Please select both opening and closing dates.");
//         return;
//       }

//       if (openingDate <= today) {
//         e.preventDefault();
//         alert("Admission opening date must be in the future.");
//         return;
//       }

//       if (closingDate <= today) {
//         e.preventDefault();
//         alert("Admission closing date must be in the future.");
//         return;
//       }

//       if (openingDate >= closingDate) {
//         e.preventDefault();
//         alert("Opening date must be earlier than closing date.");
//         return;
//       }

//       // Disable button to prevent resubmit
//       const submitBtn = admissionForm.querySelector("button[type='submit']");
//       submitBtn.disabled = true;
//       submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i>Submitting...`;
//     });
//   }
// });

