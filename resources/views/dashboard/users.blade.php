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
                            <h1 class="mb-0">Users</h1>
                        </div>
                        <!-- Date range picker example-->
                        <div class="">
                            <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#createUserModal">Create New User</button>
                        </div>
                    </div>
                    <!-- Illustration dashboard card example-->
                    <div class="card mb-4 mt-5">
                        <div class="card-body p-5">
                            <div class="table-responsive">
                                <table id="usersTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Plate Number</th>
                                            <th>Role</th>
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
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Form for creating a new user -->
                    <div class="modal-body">
                        <form id="createUserForm">
                        <div class="mb-3">
                            <label for="createUserName" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="createUserName" placeholder="Enter full name" required />
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
                            <label for="createUserPlateNumber" class="form-label">Plate Number</label>
                            <input type="text" class="form-control" id="createUserPlateNumber" placeholder="Enter plate number if rider (optional)" />
                        </div>
                        <div class="mb-3">
                            <label for="createUserRole" class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-select" id="createUserRole">
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                                <option value="vendor">Vendor</option>
                                <option value="rider">Rider</option>
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
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="editContact" class="form-label">Contact<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editContact" name="contact">
                        </div>
                        <div class="mb-3">
                            <label for="editPlateNumber" class="form-label">Plate Number</label>
                            <input type="text" class="form-control" id="editPlateNumber" name="plate_number" placeholder="Enter plate number if rider (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role<span class="text-danger">*</span></label>
                            <select class="form-control" id="editUserRole">
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                                <option value="vendor">Vendor</option>
                                <option value="rider">Rider</option>
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
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'contact' },
                        { data: 'plate_number' },
                        { data: 'role' },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return `
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser(${row.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})">Delete</button>
                                `;
                            }
                        }
                    ],
                    dom: 'lBfrtip', // Enable buttons for export functionality
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
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
                    document.getElementById('editName').value = user.name;
                    document.getElementById('editEmail').value = user.email;
                    document.getElementById('editContact').value = user.contact || '';
                    document.getElementById('editPlateNumber').value = user.plate_number || '';
                    document.getElementById('editUserRole').value = user.role;

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
    </script>

    <script>
        //CREATE USER
        document.getElementById("createUserForm").addEventListener("submit", async function (event) {
                event.preventDefault(); // Prevent default form submission behavior

                // Get form input values
                const name = document.getElementById("createUserName").value.trim();
                const email = document.getElementById("createUserEmail").value.trim();
                const contact = document.getElementById("createUserContact").value.trim();
                const plate_number = document.getElementById("createUserPlateNumber").value.trim();
                const role = document.getElementById("createUserRole").value;

                // Basic validation
                if (!name || !email || !contact || !role) {
                    alert("Please fill in all required fields.");
                    return;
                }

                try {
                    // Send POST request to create user
                    const response = await axios.post('/api/users', {
                        name: name,
                        email: email,
                        contact: contact,
                        plate_number: plate_number || null, // Optional field
                        role: role,
                        password: 'password'
                    }, );

                    // Show success message
                    alert("User created successfully!");

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
            const name = document.getElementById('editName').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const contact = document.getElementById('editContact').value.trim();
            const plate_number = document.getElementById('editPlateNumber').value.trim();
            const role = document.getElementById('editUserRole').value;

            // Basic validation
            if (!name || !email || !contact || !role) {
                alert("Please fill in all required fields.");
                return;
            }

            try {
                // Send PUT request to update the user
                const response = await axios.put(`/api/users/${userId}`, {
                    name: name,
                    email: email,
                    contact: contact,
                    plate_number: plate_number || null, // Optional field
                    role: role
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                    },
                });

                // Show success message
                alert("User updated successfully!");

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