document.addEventListener('DOMContentLoaded', () => {

  function initPhoneInput() {
    const phoneInput = document.querySelector('#phone');
    if (phoneInput) {
        const iti = intlTelInput(phoneInput, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io/json', { cache: 'reload' })
                    .then(response => response.json())
                    .then(data => {
                        const countryCode = (data && data.country) ? data.country : 'us';
                        callback(countryCode);
                    })
                    .catch(() => callback('us'));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.js"
        });
        return iti;
    }
    return null;
}
const iti = initPhoneInput();

    const validateNameFields = () => {
        const nameFields = document.querySelectorAll('#first_name, #middle_name, #last_name');
        nameFields.forEach(field => {
            field.addEventListener('input', () => {
                const namePattern = /^[a-zA-Z]+$/;
                const value = field.value.trim();
                const errorField = field.closest('#form-row').querySelector('.error-message'); 

                if (!namePattern.test(value)) {
                    errorField.textContent = "Name must contain only alphabets.";
                } else if (value.length < 3) {
                    errorField.textContent = "Name must be at least 3 characters long.";
                } else {
                    errorField.textContent = "";
                }
                errorField.style.color = 'red';
                errorField.style.fontSize = '11px';
            });
        });
    };
    validateNameFields();

    //password validation
    function validatePasswords() {
        const passwordField = document.getElementById('password'); 
        const confirmPasswordField = document.getElementById('confirm_password'); 
        
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    
        const passwordError = document.querySelector('#password-error');
        const confirmPasswordError = document.querySelector('#confirm-password-error');
    
        if (passwordError && confirmPasswordError) {
            if (!passwordPattern.test(password)) {
                passwordError.textContent = 'Password must be at least 8 characters long and contain one uppercase letter, one lowercase letter, one number, and one special character.';
            } else {
                passwordError.textContent = '';
            }
    
            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
            } else {
                confirmPasswordError.textContent = '';
            }
    
            passwordError.style.color = 'red';
            confirmPasswordError.style.color = 'red';
            passwordError.style.fontSize = confirmPasswordError.style.fontSize = '13px';
        }
    }
    

       // Toggle password visibility
       const togglePasswordVisibility = (toggleButtonSelector, passwordFieldSelector) => {
        const toggleButton = document.querySelector(toggleButtonSelector);
        const passwordField = document.querySelector(passwordFieldSelector);

        if(toggleButton) {
        
        toggleButton.addEventListener('click', () => {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        });
    }
    };
    togglePasswordVisibility('#togglePassword', '#password');
    togglePasswordVisibility('#toggleConfirmPassword', '#confirm_password');
    

    //register form submission
    const registerFormContainer = document.getElementById('registration_form');

    if(registerFormContainer) {

    registerFormContainer.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Validate phone number
        if (!iti.isValidNumber()) {
            alert('Please enter a valid phone number.');
            return;
        }

        const action = 'handle_registration'; 

        document.getElementById('spinner').style.display = 'block';
        registerFormContainer.classList.add('form-blur');

             // Check if the nonce element exists
             const nonceElement = document.getElementById('registration_nonce');
             if (!nonceElement) {
                 alert('Registration nonce not found!');
                 return;
             }     

        const formData = new FormData(registerFormContainer);
        formData.append('action', action);
        formData.append('registration_nonce', document.getElementById('registration_nonce').value);

        try {
            const response = await fetch(usersoftiizaAjax.ajax_url, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            document.getElementById('spinner').style.display = 'none';
            registerFormContainer.classList.remove('form-blur');

            // Handle success
            if (result.success) {
                if (result.data.startsWith('http')) {
                    window.location.href = result.data;
                } else {
                    alert(result.data);
                    registerFormContainer.reset(); // Reset the form if success
                }
            } else {
                // Handle error message
                alert(result.data || 'An unknown error occurred.');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            alert('An error occurred. Please try again.');
        } finally {
            document.getElementById('spinner').style.display = 'none';
            registerFormContainer.classList.remove('form-blur');
        }
    });
   }

   const loginFormContainer = document.getElementById('login_form');

   if (loginFormContainer) {
       loginFormContainer.addEventListener('submit', async (e) => {
           e.preventDefault();
   
           const action = 'handle_login'; 
   
           // Show spinner and blur effect during the login process
           document.getElementById('spinner').style.display = 'block';
           loginFormContainer.classList.add('form-blur');
   
           // Check if the nonce element exists
           const nonceElement = document.getElementById('login_nonce');
           if (!nonceElement) {
               alert('Login nonce not found!');
               return;
           }
   
           const formData = new FormData(loginFormContainer);
           formData.append('action', action);
           formData.append('login_nonce', document.getElementById('login_nonce').value);
   
           try {
               const response = await fetch(usersoftiizaAjax.ajax_url, {
                   method: 'post',
                   body: formData
               });
               const result = await response.json();
   
               document.getElementById('spinner').style.display = 'none';
               loginFormContainer.classList.remove('form-blur');
   
               // Handle successful login
               if (result.success) {
                   window.location.href = result.data;
               } else {
                   // Check if 'error' exists and display it properly
                   const errorMessage = result.data || 'Invalid username or password.';
                   alert(errorMessage);
               }
           } catch (error) {
               console.error('Fetch error:', error);
               alert('An error occurred. Please try again.');
           } finally {
               document.getElementById('spinner').style.display = 'none';
               loginFormContainer.classList.remove('form-blur');
           }
       });
   }
   
   const registerButton = document.getElementById('regis');

   if (registerButton) {
    registerButton.addEventListener('click', () => {
        window.location.href = 'register'; 
    });
   };

const loginButton = document.getElementById('regisLog');

if (loginButton) {
 loginButton.addEventListener('click', () => {
     window.location.href = 'login'; 
 });
};

const forgotPassword = document.getElementById('forgot_password_link');

if (forgotPassword) {
    forgotPassword.addEventListener('click', (event) => {
        event.preventDefault(); 
        window.location.href = 'forgot-password'; 
    });
}


// Forget password
const forgotPasswordForm = document.getElementById('forgot_password_form');
if(forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();

         // Show spinner and blur effect during the login process
           document.getElementById('spinner').style.display = 'block';
           forgotPasswordForm.classList.add('form-blur');
        
        const formData = new FormData(forgotPasswordForm);
        formData.append('action', 'handle_forgot_password');
        formData.append('forget_pass_nonce', document.getElementById('forget_pass_nonce').value);
        
        fetch(usersoftiizaAjax.ajax_url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(response => {
            document.querySelector('.spinner').style.display = 'none';
            document.querySelector('#forgot_password_form').classList.remove('form-blur');
            if (response.success) {
                alert(response.data);
                forgotPasswordForm.reset();

                // Password reset expiration should be managed server-side, not client-side
            } else {
                alert(response.error || 'An unknown error occurred.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
}


// reset password
const resetPasswordForm = document.querySelector('#reset_password_form');

if (resetPasswordForm) {
    resetPasswordForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (newPassword.length < 8 || !/\d/.test(newPassword) || !/[A-Z]/.test(newPassword) || !/[!@#$%^&*]/.test(newPassword)) {
            alert('Password must be at least 8 characters long and contain at least one number, one uppercase letter, and one special character.');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'handle_reset_password');
        formData.append('reset_password_nonce', document.getElementById('reset_password_nonce').value);
        formData.append('rp_key', document.getElementById('rp_key').value);
        formData.append('rp_login', document.getElementById('rp_login').value);
        formData.append('new_password', newPassword);
        formData.append('confirm_password', confirmPassword);

        fetch(usersoftiizaAjax.ajax_url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert(response.data);
                window.location.href = 'login';
            } else {
                alert(response.data || 'An error occurred, please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
}


//kyc page
const nextToFaceCapture = document.getElementById('next_to_face_capture');

if(nextToFaceCapture) {

    nextToFaceCapture.addEventListener('click', function() {
    document.querySelector('#kyc_form-container').style.display ='none';
    document.querySelector('#face_capture_form').style.display = 'block';
    document.querySelector('.stage-1').classList.remove('active');
    document.querySelector('.stage-2').classList.add('active');
    startCamera();
});
}

 // Start camera for face capture
 const captureFace = () => {
    const video = document.querySelector('video');
    const canvas = document.querySelector('#canvas');
    const faceImage = document.querySelector('#face_image');
    const submitButton = document.querySelector('#submit-selfie'); 

    if (video && canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw circular clipping region
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = Math.min(canvas.width, canvas.height) / 2;

        ctx.save();
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, Math.PI * 2, true);
        ctx.closePath();
        ctx.clip();

        // Draw the video feed into the canvas
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        ctx.restore();

        // Convert the canvas to a data URL (base64 image)
        const dataURL = canvas.toDataURL('image/png');
        document.querySelector('#face_capture').value = dataURL;

        // Show the captured image and hide the video
        faceImage.src = dataURL;
        faceImage.style.display = 'block';
        video.style.display = 'none';
        document.querySelector('#countdown-timer').style.display = 'block';

        // Stop the camera stream
        video.srcObject.getTracks().forEach(track => track.stop());

        // Show the submit button now that the face image is captured
        submitButton.style.display = 'inline-block';
    } else {
        console.error('Video or canvas element not found.');
    }
};


const face_capture = document.getElementById('face_capture_form');

if(face_capture) {

face_capture.addEventListener('submit', async(e) => {
    e.preventDefault();

   
    const action = 'user_profile_tracker_handle_kyc';

    document.querySelector('.spinner').style.display = 'block';
    document.querySelector('#kyc_form').style.display = 'none';
    document.querySelector('#submission-message').style.display = 'block';
    document.querySelector('#stage-1').classList.remove('active');
    document.querySelector('#stage-2').classList.add('active');
    document.querySelector('#kyc_form').classList.add('form-blur');


    const formData = new FormData();
    formData.append('action', action);
    formData.append('gender', document.querySelector('input[name="gender"]:checked').value);
    formData.append('address', document.querySelector('#address').value);
    formData.append('country', document.querySelector('#country').value);
    formData.append('identity_card_type', document.querySelector('input[name="identity_card_type"]:checked').value);
    formData.append('identity_card', document.querySelector('#identity_card').files[0]);
    formData.append('face_capture', document.querySelector('#face_capture').value);
    formData.append('kyc_nonce', document.querySelector('#kyc_nonce').value);


    fetch(usersoftiizaAjax.ajax_url, {
        method: 'post',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(response => {
        document.querySelector('.spinner').style.display = 'none';
        document.querySelector('#kyc_form').classList.remove('form-blur');

            if (response.success) {
                document.getElementById('submission-message').style.display = 'block';
            } else {
                alert(response.data);
            }
    })
    .catch(error => {
        console.error('Error submitting KYC:', error);
        alert('An error occurred. Please try again.');
    });
  });

  //message submission
  const goToHome = document.getElementById('go-to-home');
  if (goToHome) {
    goToHome.addEventListener('click', () => {
        window.location.href = '/';
    });
  } else {
    console.error("Element with ID 'go-to-home' not found");
   }
  };
  
const resizeAndCompressImage = (file, maxWidth, maxHeight, quality, callback) => {
    const reader = new FileReader();
       
    reader.onload = function(event) {
        const img = new Image();
        
        img.onload = function() {
            let width = img.width;
            let height = img.height;

            // Calculate the scaling factor
            if (width > height) {
                if (width > maxWidth) {
                    height = Math.round((height * maxWidth) / width);
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width = Math.round((width * maxHeight) / height);
                    height = maxHeight;
                }
            }

            // Create a canvas element
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;

            // Draw the image on the canvas
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            const dataURL = canvas.toDataURL('image/jpeg', quality);

            callback(dataURL);
        };

        img.src = event.target.result;
    };
    
    reader.readAsDataURL(file);
}

//profile picture upload
const fileUploadInput = document.querySelector('.file-uploader');

if (fileUploadInput) {
  fileUploadInput.addEventListener('change', function () {
    const image = fileUploadInput.files[0];

    // Check if the file selected is not an image
    if (!image.type.includes('image/jpeg', 'image/png', 'image/gif')) {
      return alert('Only images are allowed!');
    }

    // Check if the file size exceeds 5MB
    if (image.size > 5_000_000) {
      return alert('Maximum upload size is 5MB!');
    }

    const fileReader = new FileReader();
    fileReader.readAsDataURL(image);

        const formData = new FormData();
        formData.append('profile_picture', image);
        formData.append('action', 'handle_picture_upload');
        formData.append('profile_nonce', document.querySelector('#profile_nonce').value);
    
        fetch(usersoftiizaAjax.ajax_url, {
          method: 'post',
         body: formData,
         headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
        })       
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the profile picture preview
                const profilePicture = document.querySelector('.profile-info');
                if (profilePicture) {
                  profilePicture.style.backgroundImage = `url(${data.data.image_url})`;
                } else {
                  console.error('Profile picture element not found!');
                }
              } else {
                console.error('Error: ', data.error);
              }
            })
            .catch(error => {
              console.error('Error uploading profile picture:', error);
            });
          });
        }

// Handle clickable actions
document.querySelectorAll('.clickable').forEach(button => {
    button.addEventListener('click', function() {
      const action = this.id.replace('_count', '');
      console.log('Extracted action:', action);
      const displayElement = document.querySelector(`#${action}_details_display`);

      document.querySelectorAll('.details-display').forEach(el => el.style.display = 'none');
  
      // Collect nonces
      const nonces = {
        activated_details_nonce: document.querySelector('input[name="activated_details_nonce"]').value,
        found_report_nonce: document.querySelector('input[name="found_report_nonce"]').value,
        lost_report_nonce: document.querySelector('input[name="lost_report_nonce"]').value,
        device_registration_nonce: document.querySelector('input[name="device_registration_nonce"]').value,
      };
  
      // Prepare AJAX request
      fetch(usersoftiizaAjax.ajax_url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
          action: 'get_' + action + '_details',
          ...nonces
        })
      })
      .then(response => response.json())
      .then(response => {
        console.log('AJAX response for ' + action + ':', response); 
  
        if (response.success) {
          let details = response.data.details;
          let detailsHtml = '<table>';
  
          if (action === 'activated_details') {
            detailsHtml += '<tr><th>Tracker ID</th><th>Item Name</th><th>Color</th><th>Image</th></tr>';
            details.forEach(detail => {
              detailsHtml += `<tr>
                                <td>${detail.tracker_id}</td>
                                <td>${detail.item_name}</td>
                                <td>${detail.color}</td>
                                <td><img src="${detail.image_url}" alt="Item Image" style="width: 50px; height: 50px;"></td>
                              </tr>`;
            });
          } else if (action === 'found_report') {
            detailsHtml += '<tr><th>Tracker ID</th><th>Image</th></tr>';
            details.forEach(detail => {
              detailsHtml += `<tr>
                                <td>${detail.tracker_id}</td>
                                <td><img src="${detail.image_url}" alt="Item Image" style="width: 50px; height: 50px;"></td>
                              </tr>`;
            });
          } else if (action === 'lost_report') {
            detailsHtml += '<tr><th>Item Name</th><th>Tracker ID</th><th>Image</th><th>Reporter</th></tr>';
            details.forEach(detail => {
              detailsHtml += `<tr>
                                <td>${detail.item_name}</td>
                                <td>${detail.tracker_id}</td>
                                <td><img src="${detail.image_url}" alt="Item Image" style="width: 50px; height: 50px;"></td>
                                <td>${detail.reporter}</td>
                              </tr>`;
            });
          } else if (action === 'device_registration') {
            detailsHtml += '<tr><th>Device Name</th><th>IMEI</th><th>Serial Number</th><th>Purchase Receipt</th></tr>';
            details.forEach(detail => {
              detailsHtml += `<tr>
                                <td>${detail.device_name}</td>
                                <td>${detail.imei}</td>
                                <td>${detail.serial_number}</td>
                                <td><img src="${detail.purchase_receipt_url}" alt="Item Image" style="width: 50px; height: 50px;"></td>
                              </tr>`;
            });
          }
  
          detailsHtml += '</table>';
          displayElement.innerHTML = detailsHtml;
          displayElement.style.display = 'block';
        } else {
          if (response.data.message !== "Nonce verification failed") {
            displayElement.innerHTML = '<p>No details available.</p>';
            displayElement.style.display = 'block';
          }
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred. Please try again.');
      });
    });
  });


  (() => {
    let timeout;

    // Function to reset the inactivity timer
    const resetTimer = () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            alert('Session has expired, logging out...');

            // Trigger logout on the server
            const formData = new FormData();
            formData.append('action', 'handle_logout');
            formData.append('logout_nonce', usersoftiizaAjaxlogout_nonce); 

            fetch(tiisa_users_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = usersoftiizaAjax.redirect_url; 
                } else {
                    window.location.href = usersoftiizaAjax.redirect_url;
                }
            })
            .catch(() => {
                window.location.href = usersoftiizaAjax.redirect_url;
            });

        }, 20 * 60 * 1000);
    };

    // Check if the user is logged in before setting up the inactivity timer
    if (usersoftiizaAjax.is_logged_in) { 
        ['load', 'mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
            window.addEventListener(event, resetTimer);
        });
    }
})();
 
});