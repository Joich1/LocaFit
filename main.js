const toggleThemeBtn = document.getElementById('toggle-theme-btn');
const themeIcon = document.getElementById('theme-icon');
const root = document.documentElement;

function toggleTheme() {
  const currentTheme = root.getAttribute('data-bs-theme');
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';
  root.setAttribute('data-bs-theme', newTheme);
  if (themeIcon.classList.contains("bi-moon")) {
    themeIcon.classList.remove('bi-moon');
    themeIcon.classList.add('bi-sun');
  } else {
    themeIcon.classList.remove('bi-sun');
    themeIcon.classList.add('bi-moon');
  }

  localStorage.setItem('theme', newTheme);
}


function loadTheme() {
  const savedTheme = localStorage.getItem('theme') || 'light';
  root.setAttribute('data-bs-theme', savedTheme);
  if (savedTheme === 'dark') {
    themeIcon.classList.remove('bi-moon');
    themeIcon.classList.add('bi-sun');
  } else {
    themeIcon.classList.remove('bi-sun');
    themeIcon.classList.add('bi-moon');
  }
}


const input = document.getElementById('file-input');
const previewPhoto = () => {
    const file = input.files;
    if (file) {
        const fileReader = new FileReader();
        const preview = document.getElementById('file-preview');
fileReader.onload = function (event) {
            preview.setAttribute('src', event.target.result);
        }
        fileReader.readAsDataURL(file[0]);
    }
}
input.addEventListener("change", previewPhoto);

