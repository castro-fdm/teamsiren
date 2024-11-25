function displayUsers() {
  const infoCategory = document.querySelector('.info-category');
  infoCategory.innerHTML = `
    <h2>Users</h2>
    <table id="usersTable">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Role</th>
          <th>Created At</th>
          <th>Updated At</th>
        </tr>
      </thead>
      <tbody id="usersTableBody">
        <!-- User rows will go here -->
      </tbody>
    </table>
  `;

  fetch('/res/php/getUser.php')
  .then(response => {
      if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
  })
  .then(users => {
      console.log(users); // Add this line to log the data
      const tableBody = document.getElementById('usersTableBody');
      tableBody.innerHTML = ''; // Clear any existing data

      // Populate the table with users
      users.forEach(user => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td>${user.user_id}</td>
              <td>${user.full_name}</td>
              <td>${user.email}</td>
              <td>${user.phone_number}</td>
              <td>${user.role}</td>
              <td>${user.created_at}</td>
              <td>${user.updated_at}</td>
          `;
          tableBody.appendChild(row);
      });
  })
  .catch(error => {
      console.error('Error fetching user data:', error);
  });
}
  
  function displayServices() {
    const infoCategory = document.querySelector('.info-category');
    infoCategory.innerHTML = `
      <h2>Services</h2>
    `;
  }

  function displayAppointments() {
    const infoCategory = document.querySelector('.info-category');
    infoCategory.innerHTML = `
      <h2>Appointments</h2>
    `;
  }

  function displayPayments() {
    const infoCategory = document.querySelector('.info-category');
    infoCategory.innerHTML = `
      <h2>Payments</h2>
    `;
  }

  function displayAvailability() {
    const infoCategory = document.querySelector('.info-category');
    infoCategory.innerHTML = `
      <h2>Availability</h2>
    `;
  }

  function displayReviews() {
    const infoCategory = document.querySelector('.info-category');
    infoCategory.innerHTML = `
      <h2>Reviews</h2>
    `;
  }