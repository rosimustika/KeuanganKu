// Toggle between Account and Notification pages
const menuLinks = document.querySelectorAll('.menu-link');

menuLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior

        // Remove 'active' class from all links
        menuLinks.forEach(link => link.classList.remove('active'));

        // Add 'active' class to the clicked link
        this.classList.add('active');

        // Toggle visibility of sections
        if (this.id === 'accountLink') {
            document.querySelector('.Account').style.display = 'block'; // Show Account page
            document.getElementById('Notification').style.display = 'none'; // Hide Notification page
        } else if (this.id === 'notificationLink') {
            document.querySelector('.Account').style.display = 'none'; // Hide Account page
            document.getElementById('Notification').style.display = 'block'; // Show Notification page
        }
    });
});

// Logout functionality
document.getElementById('logoutBtn').addEventListener('click', function() {
    alert('You have been logged out.');
    window.location.href = 'index.php'; // Redirect to login page
});

// --- Additional code for updating profile name when Save button is clicked ---

// Get elements related to the form and profile display
const saveButton = document.getElementById('btn-save'); // Tombol Save
const nameInput = document.getElementById('input-name'); // Input untuk nama pengguna
const profileName = document.getElementById('profile-name'); // Elemen untuk nama di samping gambar profil

// Update profile name when Save button is clicked
saveButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    // Update the profile name with the new input value
    if (nameInput.value.trim() !== "") {
        profileName.textContent = nameInput.value;
    }

    // Optional: Show a success message or notification
    alert('Profile updated successfully.');
});