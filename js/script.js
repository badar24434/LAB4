document.addEventListener('DOMContentLoaded', function() {
  // Registration form validation
  const registrationForm = document.getElementById('registrationForm');
  if (registrationForm) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const emailError = document.getElementById('emailError');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordSuccess = document.getElementById('passwordSuccess');
    const passwordFailure = document.getElementById('passwordFailure');
    const confirmError = document.getElementById('confirmError');

    // Check if email exists
    emailInput.addEventListener('blur', function() {
      if (emailInput.value) {
        checkEmailExists(emailInput.value);
      }
    });

    // Remove password checking functionality
    passwordInput.addEventListener('input', function() {
      if (passwordInput.value) {
        // Basic client-side validation only
        if (passwordInput.value.length >= 12) {
          passwordStrength.style.display = 'block';
          passwordStrength.style.backgroundColor = '#4CAF50'; // Green
          passwordSuccess.style.display = 'block';
          passwordFailure.style.display = 'none';
        } else {
          passwordStrength.style.display = 'block';
          passwordStrength.style.backgroundColor = '#f44336'; // Red
          passwordSuccess.style.display = 'none';
          passwordFailure.textContent = 'Password must be at least 12 characters';
          passwordFailure.style.display = 'block';
        }
      } else {
        passwordStrength.style.display = 'none';
        passwordSuccess.style.display = 'none';
        passwordFailure.style.display = 'none';
      }
    });

    // Check if passwords match
    confirmPasswordInput.addEventListener('input', function() {
      if (passwordInput.value !== confirmPasswordInput.value) {
        confirmError.textContent = 'Passwords do not match';
        confirmError.style.display = 'block';
      } else {
        confirmError.style.display = 'none';
      }
    });

    // Handle form submission
    registrationForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const password = passwordInput.value;
      if (password.length < 12) {
        alert('Password must be at least 12 characters long');
        return;
      }
      
      // Only check if passwords match
      if (password !== confirmPasswordInput.value) {
        confirmError.textContent = 'Passwords do not match';
        confirmError.style.display = 'block';
        return;
      }
      
      // Submit the registration directly
      submitRegistration();
    });

    function submitRegistration() {
      // Send form data to server
      const formData = new FormData(registrationForm);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'register_user.php', true);
      
      // Add proper error handling
      xhr.onerror = function() {
        console.error('Network error occurred');
        alert('Network error occurred. Please check your connection and try again.');
      };
      
      xhr.onload = function() {
        try {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
              alert('Registration successful! Please login.');
              window.location.href = 'login.html';
            } else {
              alert('Registration failed: ' + response.message);
            }
          } else {
            console.error('Server returned status: ' + xhr.status);
            alert('Server error: ' + xhr.status + '. Please try again later.');
          }
        } catch (e) {
          console.error('Error parsing response:', e, 'Response text:', xhr.responseText);
          alert('Error processing server response. Please try again.');
        }
      };
      
      xhr.send(formData);
    }
  }

  // Login form handling
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const loginEmail = document.getElementById('loginEmail').value;
      const loginPassword = document.getElementById('loginPassword').value;
      const loginMessage = document.getElementById('loginMessage');
      
      console.log("Attempting login with:", loginEmail);
      
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'login.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            console.log("Server response:", response);
            loginMessage.textContent = response.message;
            loginMessage.className = response.success ? 'message success' : 'message error';
            // Redirect to index.html instead of dashboard
            if (response.success) {
              setTimeout(function() {
                window.location.href = 'index.html';
              }, 1500);
            }
          } catch (e) {
            console.error("Error parsing response:", e);
            loginMessage.textContent = "An error occurred during login. Please try again.";
            loginMessage.className = "message error";
          }
        }
      };
      xhr.send('loginEmail=' + encodeURIComponent(loginEmail) +
               '&loginPassword=' + encodeURIComponent(loginPassword));
    });
  }

  // Helper functions
  function checkEmailExists(email) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'check_user.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.exists) {
          emailError.textContent = 'Email already exists. Please use a different email.';
          emailError.style.display = 'block';
        } else {
          emailError.style.display = 'none';
        }
      }
    };
    xhr.send('email=' + encodeURIComponent(email));
  }
});
