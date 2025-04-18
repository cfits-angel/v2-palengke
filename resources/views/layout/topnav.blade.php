<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2 text-primary" href="/home">
        <img src="/logo.png" alt="Logo" style="height: 32px; width: auto; margin-right: 8px;">
        Palengke</a>
    
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <li class="nav-item me-3 me-lg-4 fw-bold sy-name">
        </li>

        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" id="dropdownUserImg2" src="../assets/img/user.jpg" /></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" id="dropdownUserImg" src="../assets/img/user.jpg" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name" id="dropdownUserName"></div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/update-profile">
                    <div class="dropdown-item-icon"><i data-feather="user"></i></div>
                    Update Profile
                </a>
                <a class="dropdown-item" href="#!" id="logoutButton">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<script>
    document.getElementById('logoutButton').addEventListener('click', function () {
        // Clear all local storage
        localStorage.clear();

        // Redirect to home page
        window.location.href = '/';
    });
</script>

<script>
    $(document).ready(function () {
        const user = JSON.parse(localStorage.getItem("user"));

        if (user) {
            // Set user name
            $("#dropdownUserName").text(user.first_name + " " + user.last_name);

            // Set profile picture if it exists
            if (user.profile_picture) {
                $("#dropdownUserImg").attr("src", `/storage/${user.profile_picture}`);
            }

            if (user.profile_picture) {
                $("#dropdownUserImg2").attr("src", `/storage/${user.profile_picture}`);
            }
        }
    });
</script>