function updateInfoCategory(title, content = '') {
  const infoCategory = document.querySelector('.info-category');
  infoCategory.innerHTML = `
      <h2>${title}</h2>
      ${content}
  `;
}

function showLoading() {
  updateInfoCategory('Loading...', '<p>Please wait while the data is being loaded.</p>');
}

function showError(error) {
  updateInfoCategory('Error', `<p>An error occurred: ${error.message}</p>`);
}

function displayUsers() {
    showLoading();
  
    fetch('getUser.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(users => {
            const tableContent = `
                <table id="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${users.map(user => `
                            <tr>
                                <td>${user.user_id}</td>
                                <td>${user.username}</td>
                                <td>${user.email}</td>
                                <td>${user.phone_number}</td>
                                <td>${user.role}</td>
                                <td>${user.created_at}</td>
                                <td>${user.updated_at}</td>
                                <td>
                                    <a href="editUser.php?user_id=${user.user_id}"><button>Edit</button></a>
                                    <a href="deleteUser.php?user_id=${user.user_id}"><button>Delete</button></a>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
                <a href="addUser.php" class="add-btn"><button>Add User</button></a>
            `;
            updateInfoCategory('Users', tableContent);
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            showError(error);
        });
}  

function displayServices() {
    showLoading();
  
    fetch('getService.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(services => {
            let content = '';
            
            if (services.length === 0) {
                content = `
                    <p>No services available.</p>
                    <a href="addService.php"><button>Add Service</button></a>
                `;
            } else {
                content = `
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${services.map(service => {
                                // Ensure price is a valid number
                                const price = parseFloat(service.price);
                                const formattedPrice = isNaN(price) ? 'N/A' : price.toFixed(2);
                                
                                return `
                                    <tr>
                                        <td>${service.service_name}</td>
                                        <td>${service.description}</td>
                                        <td>${service.duration}<p>Minutes</p></td>
                                        <td>₱${formattedPrice}</td>
                                        <td>
                                            <a href="editService.php?service_id=${service.service_id}"><button>Edit</button></a>
                                            <a href="deleteService.php?service_id=${service.service_id}"><button>Delete</button></a>
                                        </td>
                                    </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                    <a href="addService.php" class="add-btn"><button>Add Service</button></a>
                `;
            }
  
            updateInfoCategory('Services', content);
        })
        .catch(error => {
            console.error('Error fetching services data:', error);
            showError(error);
        });
}
  

function displayAppointments() {
    showLoading(); // Show loading message while fetching data

    fetch('getAppointments.php')  // Make sure 'getAppointments.php' returns the appointment data in JSON format
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(appointments => {
            const tableContent = `
                <table id="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Therapist</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${appointments.map(appointment => `
                            <tr>
                                <td>${appointment.client}</td>
                                <td>${appointment.therapist}</td>
                                <td>${appointment.service}</td>
                                <td>${appointment.date}</td>
                                <td>${appointment.start_time}</td>
                                <td>${appointment.end_time}</td>
                                <td>${appointment.status}</td>
                                <td>
                                    <form action="update-appointment-status.php" method="POST">
                                        <input type="hidden" name="appointment_id" value="${appointment.appointment_id}">
                                        <select name="status" required>
                                            <option value="pending" ${appointment.status === 'pending' ? 'selected' : ''}>Pending</option>
                                            <option value="confirmed" ${appointment.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                            <option value="completed" ${appointment.status === 'completed' ? 'selected' : ''}>Completed</option>
                                            <option value="canceled" ${appointment.status === 'canceled' ? 'selected' : ''}>Canceled</option>
                                        </select>
                                        <button type="submit">Update Status</button>
                                    </form>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            updateInfoCategory('Appointments', tableContent);
        })
        .catch(error => {
            console.error('Error fetching appointment data:', error);
            showError(error);
        });
}

function displayPayments() {
  updateInfoCategory('Payments', '<p>Feature not implemented yet.</p>');
}

function displayAvailability() {
    showLoading(); // Show loading message while fetching data

    fetch('getAvailability.php')  // Fetch availability data from the server
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(availability => {
            const tableContent = `
                <table id="table">
                    <thead>
                        <tr>
                            <th>Therapist</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${availability.map(avail => `
                            <tr>
                                <td>${avail.therapist_name}</td>
                                <td>${avail.date}</td>
                                <td>${avail.start_time}</td>
                                <td>${avail.end_time}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            updateInfoCategory('Availability', tableContent);
        })
        .catch(error => {
            console.error('Error fetching availability data:', error);
            showError(error);
        });
}

function displayReviews() {
  updateInfoCategory('Reviews', '<p>Feature not implemented yet.</p>');
}

// Example of initializing default content
document.addEventListener('DOMContentLoaded', () => {
  updateInfoCategory('Welcome Admin!', '<p>Select a category to view or manage.</p>');
});
