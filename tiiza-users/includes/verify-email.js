jQuery(document).ready(function($) {
    
    // Initialize phone input with intlTelInput
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
   
       // Real-time validation for name fields
       function validateNameFields() {
           $('#first_name, #middle_name, #last_name').on('input', function() {
               const namePattern = /^[a-zA-Z]+$/;
               const value = $(this).val();
               const errorField = $(this).closest('.input-container').next('.error-message');
   
               if (!namePattern.test(value)) {
                   errorField.text("Name must contain only alphabets.").css({ 'color': 'red', 'font-size': '11px' });
               } else if (value.length < 3) {
                   errorField.text("Name must be at least 3 characters long.").css({ 'color': 'red', 'font-size': '11px' });
               } else {
                   errorField.text("");
               }
           });
       }
       validateNameFields();
   
       // Real-time validation for password fields
       function validatePasswordFields() {
           $('#password, #confirm_password').on('input', function() {
               const password = $('#password').val();
               const confirmPassword = $('#confirm_password').val();
               const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
      
               if (!passwordPattern.test(password)) {
                   $('#password-error').text('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.')
                       .css({ 'color': 'red', 'font-size': '13px' });
               } else {
                   $('#password-error').text('');
               }
           
               if (password !== confirmPassword) {
                   $('#confirm-password-error').text('Passwords do not match.')
                       .css({ 'color': 'red', 'font-size': '13px' });
               } else {
                   $('#confirm-password-error').text('');
               }
           });        
       }
       validatePasswordFields();
   
       // Toggle password visibility
       function togglePasswordVisibility(toggleButton, passwordField) {
           $(toggleButton).on('click', function() {
               const icon = $(this);
               if ($(passwordField).attr('type') === 'password') {
                   $(passwordField).attr('type', 'text');
                   icon.removeClass('fa-eye').addClass('fa-eye-slash');
               } else {
                   $(passwordField).attr('type', 'password');
                   icon.removeClass('fa-eye-slash').addClass('fa-eye');
               }
           });
       }
       togglePasswordVisibility('#togglePassword', '#password');
       togglePasswordVisibility('#toggleConfirmPassword', '#confirm_password');
   
       
   // Form submission with AJAX
   function handleFormSubmission(formSelector, action, nonceField) {
       $(formSelector).on('submit', function(e) {
           e.preventDefault();
   
           // Show loading spinner
           $('#spinner').show();
           $(formSelector).addClass('form-blur');
   
           const formData = new FormData(this);
           formData.append('action', action);
           formData.append(nonceField, $(`#${nonceField}`).val());
   
           $.ajax({
               url: tiisa_users_ajax.ajax_url,
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               success: function(response) {
                   if (response.success) {
                       // Check if response data is a URL
                       if (response.data.startsWith('http')) {
                           window.location.href = response.data;
                       } else {
                           alert(response.data);
                           if (action === 'handle_registration') {
                               $(formSelector)[0].reset();
                           }
                       }
                   } else {
                       alert(response.data);
                   }
               },
               error: function(xhr, status, error) {
                   console.error('AJAX Error:', status, error);
                   alert('An error occurred. Please try again.');
               },
               complete: function() {
                   // Hide spinner
                   $('#spinner').hide();
                   $(formSelector).removeClass('form-blur');
               }
           });
       });
   }
   handleFormSubmission('#registration_form', 'handle_registration', 'registration_nonce');
   handleFormSubmission('#login_form', 'handle_login', 'login_nonce');
   handleFormSubmission('#reset_password_form', 'handle_reset_password', 'reset_password_nonce');
   
   $('#login_button').on('click', function() {
       window.location.href = 'login';
   });
   
   $('#register_button').on('click', function() {
       window.location.href = 'register';
   });
   
   
   // Handle KYC form stages
   $('#next_to_face_capture').on('click', function() {
       $('#spinner').show();
       $('#kyc_form-container').hide();
       $('#face_capture_form').show();
       $('#stage-1').removeClass('active');
       $('#stage-2').addClass('active');
       startCamera();
   });
   
   
   
   async function startCamera() {
       const constraints = { video: { width: { ideal: 1920 }, height: { ideal: 1080 }, facingMode: 'user' } };
       try {
           const stream = await navigator.mediaDevices.getUserMedia(constraints);
           const video = document.querySelector('video');
           video.srcObject = stream;
           video.play();
   
           video.addEventListener('canplay', function() {
               console.log('Camera is playing');
               setTimeout(captureFace, 7000); // Adjust this as needed
           });
       } catch (err) {
           console.error('Error accessing camera:', err);
           alert('Failed to access the camera. Please check your browser settings.');
       }
   }
   
   function captureFace() {
       const video = document.querySelector('video');
       const canvas = document.querySelector('#canvas');
       const faceImage = document.querySelector('#face_image');
   
       if (video && canvas) {
           canvas.width = video.videoWidth;
           canvas.height = video.videoHeight;
           const ctx = canvas.getContext('2d');
           ctx.clearRect(0, 0, canvas.width, canvas.height);
   
           // Draw circular face capture on the canvas
           ctx.save();
           ctx.beginPath();
           ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2, 0, Math.PI * 2, true);
           ctx.closePath();
           ctx.clip();
           ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
           ctx.restore();
   
           // Set the captured face as the source of the image element
           const dataURL = canvas.toDataURL('image/png');
           $('#face_capture').val(dataURL);
           $('#face_image').attr('src', dataURL);
           $('#countdown-timer').show();
           faceImage.style.display = 'block';
   
           // Stop the video stream, but keep the video element visible
           video.srcObject.getTracks().forEach(track => track.stop());
           video.srcObject = null;
       } else {
           console.error('Video or canvas element not found.');
       }
   }
   
   
   $('#face_capture_form').on('submit', function(e) {
       e.preventDefault();
   
       $('#spinner').show();
       $('#face_capture_form').hide();
       $('#submission-message').show();
       $('#stage-2').removeClass('active');
       $('#stage-3').addClass('active');
   
       const formData = new FormData(this);
       formData.append('action', 'user_profile_tracker_handle_kyc');
       formData.append('gender', $('input[name="gender"]:checked').val());
       formData.append('address', $('#address').val());
       formData.append('country', $('#country').val());
       formData.append('identity_card_type', $('input[name="identity_card_type"]:checked').val());
       formData.append('identity_card', $('#identity_card')[0].files[0]);
       formData.append('face_capture', $('#face_capture').val());
       formData.append('kyc_nonce', $('#kyc_nonce').val());
   
       $.ajax({
           url: tiisa_users_ajax.ajax_url,
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
           success: function(response) {
               if (response.success) {
                   $('#submission-message').show();
               } else {
                   alert(response.data);
               }
           },
           error: function(xhr, status, error) {
               console.error('AJAX Error:', error);
               alert('An error occurred while submitting the KYC form. Please try again.');
           },
           complete: function() {
               // Hide spinner when the request completes
               $('#spinner').hide();
           }
       });
   });
   
           
   $('#go-to-home').on('click', function() {
       $('#spinner').show();  // Show spinner
   
       // Simulate redirecting back to home (replace with actual navigation logic)
       setTimeout(function() {
           window.location.href = '/';
       }, 1000);  // Adjust delay as needed
   });
   
   // Function to resize and compress the image
   function resizeAndCompressImage(file, maxWidth, maxHeight, quality, callback) {
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
   
               // Convert the canvas to a data URL
               const dataURL = canvas.toDataURL('image/jpeg', quality);
   
               // Call the callback function with the resized image
               callback(dataURL);
           };
   
           img.src = event.target.result;
       };
       
       reader.readAsDataURL(file);
   }
   
   $('#upload_trigger_button').on('click', function() {
       $('#profile_picture_input').click();
   });
   
   $('#profile_picture_input').on('change', function() {
       const formData = new FormData();
       formData.append('action', 'profile_picture_upload');
       formData.append('profile_picture', $('#profile_picture_input')[0].files[0]);
       formData.append('profile_picture_nonce', $('input[name="profile_picture_nonce"]').val());
   
       $.ajax({
           url: tiisa_users_ajax.ajax_url,  // Change to your site's AJAX URL
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
           success: function(response) {
               if (response.success) {
                   // Display the uploaded picture
                   const profilePictureUrl = response.data.profile_picture_url;
                   $('#profile_picture_display').attr('src', profilePictureUrl);
               } else {
                   alert(response.data.message);
               }
           },
           error: function() {
               alert('An error occurred while uploading the file. Please try again.');
           }
       });
   });
       $('.clickable').on('click', function() {
           var action = $(this).attr('id').replace('_count', ''); // Extract action name from id
           console.log('Extracted action:', action);
           var displayElement = '#' + action + '_details_display'; // Determine the display element
   
           // Hide all details displays
           $('.details-display').hide();
   
           $.ajax({
               url: tiisa_users_ajax.ajax_url,
               type: 'POST',
               data: {
                   action: 'get_' + action + '_details',
                   profile_picture_nonce: $('input[name="profile_picture_nonce"]').val(),
                   activated_details_nonce: $('input[name="activated_details_nonce"]').val(),
                   found_report_nonce: $('input[name="found_report_nonce"]').val(),
                   lost_report_nonce: $('input[name="lost_report_nonce"]').val(),
                   device_registration_nonce: $('input[name="device_registration_nonce"]').val(),
               },
               success: function(response) {
                   console.log('AJAX response for ' + action + ':', response); // Debugging
   
                   if (response.success) {
                       var details = response.data.details;
                       var detailsHtml = '<table>';
   
                       if (action === 'activated_details') {
                           detailsHtml += '<tr><th>Tracker ID</th><th>Item Name</th><th>Color</th><th>Image</th></tr>';
                           $.each(details, function(index, detail) {
                               detailsHtml += '<tr>';
                               detailsHtml += '<td>' + detail.tracker_id + '</td>';
                               detailsHtml += '<td>' + detail.item_name + '</td>';
                               detailsHtml += '<td>' + detail.color + '</td>';
                               detailsHtml += '<td><img src="' + detail.image_url + '" alt="Item Image" style="width: 50px; height: 50px;"></td>';
                               detailsHtml += '</tr>';
                           });
                       } else if (action === 'found_report') {
                           detailsHtml += '<tr><th>Tracker ID</th><th>Image</th></tr>';
                           $.each(details, function(index, detail) {
                               detailsHtml += '<tr>';
                               detailsHtml += '<td>' + detail.tracker_id + '</td>';
                               detailsHtml += '<td><img src="' + detail.image_url + '" alt="Item Image" style="width: 50px; height: 50px;"></td>';
                               detailsHtml += '</tr>';
                           });
                       } else if (action === 'lost_report') {
                           detailsHtml += '<tr><th>Item Name</th><th>Tracker ID</th><th>Image</th><th>Reporter</th></tr>';
                           $.each(details, function(index, detail) {
                              detailsHtml += '<tr>';
                              detailsHtml += '<td>' + detail.item_name + '</td>';
                              detailsHtml += '<td>' + detail.tracker_id + '</td>';
                              detailsHtml += '<td><img src="' + detail.image_url + '" alt="Item Image" style="width: 50px; height: 50px;"></td>';
                              detailsHtml += '<td>' + detail.reporter + '</td>';
                              detailsHtml += '</tr>';
                           });
                       } else if (action === 'device_registration') {
                           detailsHtml += '<tr><th>Device Name</th><th>IMEI</th><th>Serial Number</th><th>Purchase Receipt</th></tr>';
                           $.each(details, function(index, detail) {
                               detailsHtml += '<tr>';
                               detailsHtml += '<td>' + detail.device_name + '</td>';
                               detailsHtml += '<td>' + detail.imei + '</td>';
                               detailsHtml += '<td>' + detail.serial_number + '</td>';
                               detailsHtml += '<td><img src="' + detail.purchase_receipt_url + '" alt="Item Image" style="width: 50px; height: 50px;"></td>';
                               detailsHtml += '</tr>';
                           });
                       }
   
                       detailsHtml += '</table>';
                       $(displayElement).html(detailsHtml).show();
                   } else {
                       // Handle nonce verification failure or no details case
                       if (response.data.message !== "Nonce verification failed") {
                           $(displayElement).html('<p>No details available.</p>').show();
                       }
                   }
               },
               error: function(response) {
                   alert('An error occurred. Please try again.');
               }
           });
       });
   
     // Logout button handler
   $('#logout_button').on('click', function(e) {
       e.preventDefault();
       $.ajax({
           url: tiisa_users_ajax.ajax_url,
           type: 'POST',
           data: {
               action: 'handle_logout'
           },
           success: function() {
               window.location.href = tiisa_users_ajax.redirect_url;
           },
           error: function(xhr, status, error) {
               console.error('AJAX Error:', error);
               alert('An error occurred while logging out. Please try again.');
           }
       });
   });
   
   (function() {
       var timeout;
       var logoutUrl = tiisa_users_ajax.redirect_url; // Updated URL to redirect after logout
   
       function resetTimer() {
           clearTimeout(timeout);
           timeout = setTimeout(function() {
               alert("Session has expired, logging out...");
   
               // Trigger logout on the server
               $.ajax({
                   url: tiisa_users_ajax.ajax_url, // Updated to match the logout button's AJAX URL
                   type: 'POST',
                   data: {
                       action: 'handle_logout'
                   },
                   success: function() {
                       window.location.href = logoutUrl; // Redirect to login page
                   },
                   error: function() {
                       window.location.href = logoutUrl; // Fallback to redirecting to login
                   }
               });
   
           }, 20 * 60 * 1000); // 20 minutes
       }
   
       // Reset timer on various user activities
       window.onload = resetTimer;
       document.onmousemove = resetTimer;
       document.onkeypress = resetTimer;
       document.onclick = resetTimer;
       document.onscroll = resetTimer;
   
   })();

   
   $('.verify-kyc').on('click', function() {
       var kycId = $(this).data('id');
   
       if (confirm('Are you sure you want to verify this KYC submission?')) {
           $.ajax({
               url: ajaxurl,
               type: 'POST',
               data: {
                   action: 'verify_kyc_submission',
                   kyc_id: kycId
               },
               success: function(response) {
                   if (response.success) {
                       location.reload(); // Reload page after verification
                   } else {
                       alert('Verification failed. Please try again.');
                   }
               }
           });
       }
   });
   
   });
   


   <div class="profile-header">
   <div class="profile-info">
    <!-- Display the uploaded picture -->
    <img id="profile_picture_display" src="<?php echo esc_url(get_user_meta(get_current_user_id(), $image_url, true)); ?>" alt="" style="width:100px; height:100px; object-fit:cover;">
    <div class="profile-text">
        <h2><?php echo esc_html($user_info->display_name); ?></h2>
        <form id="profile_picture_form" enctype="multipart/form-data">
            <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*" style="display:none;">
            <input type="button" id="upload_trigger_button" value="Upload">
            <input type="hidden" name="profile_picture_nonce" value="<?php echo esc_attr($nonce); ?>">
        </form>
    </div>
</div>
</div>