<!DOCTYPE html>
<html lang="en">
    @include('layout.head')
<body class="nav-fixed">
    @include('layout.topnav')
    <div id="layoutSidenav">
        @include('layout.sidenav')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-xl px-4 mt-5">
                    <!-- Custom page header alternative example-->
                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="me-4 mb-3 mb-sm-0">
                            <h1 class="mb-0">Vendors</h1>
                        </div>
                        <!-- Date range picker example-->
                        <div class="">
                            <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#createUserModal">Create New Vendor</button>
                        </div>
                    </div>
                    <!-- Illustration dashboard card example-->
                    <div class="card mb-4 mt-5">
                        <div class="card-body p-5">
                            <div class="table-responsive">
                                <table id="usersTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be populated here by DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
            </main>
            @include('layout.footer')
        </div>
    </div>

    {{-- modals --}}

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Form for creating a new user -->
                    <div class="modal-body">
                        <form id="createUserForm">
                            <div class="mb-3">
                                <label for="createUserName" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="createUserFirstName" placeholder="Enter first name" required />
                            </div>
                            <div class="mb-3">
                                <label for="createUserName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="createUserMiddleName" placeholder="Enter middle name" />
                            </div>
                            <div class="mb-3">
                                <label for="createUserName" class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="createUserLastName" placeholder="Enter last name" required />
                            </div>
                            <div class="mb-3">
                                <label for="createUserEmail" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="createUserEmail" placeholder="Enter email address" required />
                            </div>
                            <div class="mb-3">
                                <label for="createUserContact" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="createUserContact" placeholder="Enter contact number" required />
                            </div>
                            <div class="mb-3">
                                <label for="locationDropdown" class="form-label">Choose a Location<span class="text-danger">*</span></label>
                                <select id="locationDropdown" class="form-select" required>
                                    <option value="">Select Location</option>
                                </select>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="createUserName" class="form-label">First Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editFirstName" placeholder="Enter first name" required />
                        </div>
                        <div class="mb-3">
                            <label for="createUserName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="editMiddleName" placeholder="Enter middle name" />
                        </div>
                        <div class="mb-3">
                            <label for="createUserName" class="form-label">Last Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editLastName" placeholder="Enter last name" required />
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editContact" class="form-label">Contact<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editContact" name="contact" required>
                        </div>
                        <div class="mb-3">
                            <label for="locationDropdown" class="form-label">Choose a Location<span class="text-danger">*</span></label>
                            <select id="locationDropdown2" class="form-select" required>
                                <option value="">Select Location</option>
                            </select>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('layout.scripts')

    <script>
        $(document).ready(function () {
                // Initialize DataTable
                $('#usersTable').DataTable({
                    ajax: {
                        url: '/api/users', // Your API endpoint for fetching users
                        type: 'GET',
                        headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                            },
                        dataSrc: '' // Adjust based on the response structure ('' if data is a direct array)
                    },
                    columns: [
                        { 
                            data: null, 
                            render: function (data, type, row) {
                                return `${row.first_name} ${row.middle_name ? row.middle_name + ' ' : ''}${row.last_name}`;
                            } 
                        },
                        { data: 'email' },
                        { data: 'contact' },
                        {
                            data: 'email_verified_at',
                            render: function (data, type, row) {
                                return data ? 'Approved' : 'Pending';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let buttons = '';
                                
                                // Display "Approve" button only if email_verified_at is null
                                if (!row.email_verified_at) {
                                    buttons += `<button class="btn btn-secondary btn-sm" onclick="approveUser(${row.id})">Approve</button> `;
                                }

                                // Always display "Edit" and "Delete" buttons
                                buttons += `
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser(${row.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})">Delete</button>
                                `;

                                return buttons;
                            },
                        }
                    ],
                    dom: 'lBfrtip', // Enable buttons for export functionality
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    order: [[0, 'desc']]
                });
            });

            // Function to populate the edit form with existing user data
            async function editUser(userId) {
                try {
                    // Fetch user details using the user ID
                    const response = await axios.get(`/api/users/${userId}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                        },
                    });

                    const user = response.data;

                    // Populate form fields with user data
                    document.getElementById('editFirstName').value = user.first_name;
                    document.getElementById('editMiddleName').value = user.middle_name;
                    document.getElementById('editLastName').value = user.last_name;
                    document.getElementById('editEmail').value = user.email;
                    document.getElementById('editContact').value = user.contact || '';
                    document.getElementById('locationDropdown2').value = user.location_id || '';

                    // Attach user ID to the form for submission
                    document.getElementById('editUserForm').dataset.userId = userId;
                } catch (error) {
                    alert('Failed to fetch user details. Please try again.');
                }
            }

            // Function to delete a user
            async function deleteUser(userId) {
                if (confirm("Are you sure you want to delete this user?")) {
                    try {
                        // Send DELETE request to the API
                        await axios.delete(`/api/users/${userId}`, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                            },
                        });

                        // Show success message
                        alert("User deleted successfully!");

                        // Reload the DataTable to reflect changes
                        $('#usersTable').DataTable().ajax.reload();
                    } catch (error) {
                        // Handle error response
                        if (error.response) {
                            alert(error.response.data.message || "Failed to delete user. Please try again.");
                        } else {
                            alert("An error occurred. Please check your connection and try again.");
                        }
                    }
                }
            }

            async function approveUser(userId) {
                if (confirm("Are you sure you want to approve this user?")) {
                    $.ajax({
                        url: `/api/users/vendor-verify/${userId}/`,
                        type: 'POST',
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`,
                        },
                        success: function(response) {
                            alert('The user has been approved successfully.');
                            $('#usersTable').DataTable().ajax.reload();
                        },
                        error: function() {
                            alert('Failed to process approval.');
                        }
                    });
                }
            }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", async function () {
            const locationDropdown = $('#locationDropdown');
            const locationDropdown2 = $('#locationDropdown2');

            $.ajax({
                    url: '/api/locations',
                    method: 'GET',
                    dataType: 'json',
                    success: function (locations) {
                        // Populate the dropdown with locations
                        locations.forEach(location => {
                            const option = `<option value="${location.id}">${location.barangay}, ${location.city}, ${location.province}</option>`;
                            locationDropdown.append(option);
                            locationDropdown2.append(option);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching locations:', error);
                    }
                });
            });
    </script>

    <script>
        //CREATE USER
        document.getElementById("createUserForm").addEventListener("submit", async function (event) {
                event.preventDefault(); // Prevent default form submission behavior

                // Get form input values
                const first_name = document.getElementById("createUserFirstName").value.trim();
                const middle_name = document.getElementById("createUserMiddleName").value.trim();
                const last_name = document.getElementById("createUserLastName").value.trim();
                const email = document.getElementById("createUserEmail").value.trim();
                const contact = document.getElementById("createUserContact").value.trim();
                const location_id = document.getElementById("locationDropdown").value.trim();

                // Basic validation
                if (!first_name || !last_name || !email || !contact || !location_id) {
                    alert("Please fill in all required fields.");
                    return;
                }

                try {
                    // Send POST request to create user
                    const response = await axios.post('/api/users', {
                        first_name: first_name,
                        middle_name: middle_name,
                        last_name: last_name,
                        email: email,
                        contact: contact,
                        role: "vendor",
                        password: 'password',
                        location_id: location_id
                    }, );

                    // Show success message
                    alert("Vendor created successfully!");

                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById("createUserModal"));
                    modal.hide();

                    // Reset form
                    event.target.reset();

                    // Reload the DataTable
                    $('#usersTable').DataTable().ajax.reload();
                } catch (error) {
                    // Handle error response
                    if (error.response) {
                        alert(error.response.data.message || "Failed to create user. Please try again.");
                    } else {
                        alert("An error occurred. Please check your connection and try again.");
                    }
                }
            });
    </script>
    
    <script>
        // Submit handler for updating the user
        document.getElementById('editUserForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent default form submission behavior

            const userId = this.dataset.userId; // Retrieve user ID from the form's dataset

            // Get updated data from form inputs
            const first_name = document.getElementById("editFirstName").value.trim();
            const middle_name = document.getElementById("editMiddleName").value.trim();
            const last_name = document.getElementById("editLastName").value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const contact = document.getElementById('editContact').value.trim();
            const location_id = document.getElementById("locationDropdown2").value.trim();

            // Basic validation
            if (!first_name || !last_name || !email || !contact || !location_id) {
                alert("Please fill in all required fields.");
                return;
            }

            try {
                // Send PUT request to update the user
                const response = await axios.put(`/api/users/${userId}`, {
                    first_name: first_name,
                    middle_name: middle_name,
                    last_name: last_name,
                    email: email,
                    contact: contact,
                    role: "vendor",
                    location_id: location_id
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                    },
                });

                // Show success message
                alert("Vendor updated successfully!");

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                modal.hide();

                // Reload the DataTable
                $('#usersTable').DataTable().ajax.reload();
            } catch (error) {
                // Handle error response
                if (error.response) {
                    alert(error.response.data.message || "Failed to update user. Please try again.");
                } else {
                    alert("An error occurred. Please check your connection and try again.");
                }
            }
        });
    </script>
    
</body>
</html>