document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const requirementsBox = document.getElementById('password-requirements');

    // Toggle password visibility
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Show requirements on focus
    if (passwordInput) {
        passwordInput.addEventListener('focus', () => {
            requirementsBox.style.display = 'block';
        });
    }
    
    // You can add a blur event listener to hide it when the user clicks away
    // passwordInput.addEventListener('blur', () => {
    //     requirementsBox.style.display = 'none';
    // });
});

// Function to check password strength in real-time
function checkPassword() {
    const password = document.getElementById('password').value;
    const length = document.getElementById('length');
    const lowercase = document.getElementById('lowercase');
    const uppercase = document.getElementById('uppercase');
    const number = document.getElementById('number');
    const special = document.getElementById('special');

    // Check length
    if (password.length >= 12) {
        length.classList.add('valid');
        length.classList.remove('invalid');
    } else {
        length.classList.add('invalid');
        length.classList.remove('valid');
    }

    // Check for lowercase letter
    if (/[a-z]/.test(password)) {
        lowercase.classList.add('valid');
        lowercase.classList.remove('invalid');
    } else {
        lowercase.classList.add('invalid');
        lowercase.classList.remove('valid');
    }

    // Check for uppercase letter
    if (/[A-Z]/.test(password)) {
        uppercase.classList.add('valid');
        uppercase.classList.remove('invalid');
    } else {
        uppercase.classList.add('invalid');
        uppercase.classList.remove('valid');
    }

    // Check for number
    if (/[0-9]/.test(password)) {
        number.classList.add('valid');
        number.classList.remove('invalid');
    } else {
        number.classList.add('invalid');
        number.classList.remove('valid');
    }

    // Check for special character
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        special.classList.add('valid');
        special.classList.remove('invalid');
    } else {
        special.classList.add('invalid');
        special.classList.remove('valid');
    }
}
