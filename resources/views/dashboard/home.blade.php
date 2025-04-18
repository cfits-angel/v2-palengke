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
                            <h1 class="mb-0">Home</h1>
                            <div class="small">
                                <span id="currentDay" class="fw-500 text-primary"></span>
                                &middot; <span id="currentDate"></span> &middot; <span id="currentTime"></span>
                            </div>
                        </div>
                        <!-- Date range picker example-->
                        {{-- <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">
                            <span class="input-group-text"><i data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                        </div> --}}
                    </div>
                    <!-- Illustration dashboard card example-->
                    <div class="card card-waves mb-4 mt-5">
                        <div class="card-body p-5">
                            <div class="row align-items-center justify-content-between">
                                <div class="col">
                                    <h2 class="text-primary" id="welcomeMessage">Welcome back, 👋</h2>
                                    <p class="text-gray-700">We’re glad to have you with us again! Whether you’re managing your store, exploring new products, or tracking your orders, everything you need is just a click away. 
                                        Let’s make today productive!</p>
                                </div>
                                <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-4 mt-xxl-n5" src="img/illustration-bg.svg" /></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section-->
                    <section class="py-5 role-customer">
                        <div class="mx-5">
                            <label for="categoryDropdown" class="form-label">Select a Category:</label>
                            <select id="categoryDropdown" class="form-select">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="container px-4 px-lg-5 mt-5">
                            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="productContainer">
                                
                            </div>
                        </div>
                    </section>
            </main>
            @include('layout.footer')
        </div>
    </div>
    
    @include('layout.scripts')

    

    <script>
        $(document).ready(function () {
            function checkUserRole() {
                const user = JSON.parse(localStorage.getItem('user'));

                if (user && user.role !== 'customer') {
                    $('.role-customer').addClass('d-none');
                }
            }

            // Initial role check for elements already present in the DOM
            checkUserRole();

            // Example: Re-run the check after dynamic content is loaded
            $(document).ajaxComplete(function () {
                checkUserRole();
            });
        });
    </script>
    
    <script>
        $(document).ready(function () {
            const categoryDropdown = $('#categoryDropdown');
            const productContainer = $('#productContainer');
            
            // Fetch category for the dropdown

            $.ajax({
                url: '/api/categories',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    // Check if response contains categories
                    if (response.categories && Array.isArray(response.categories)) {
                        response.categories.forEach(category => {
                            const option = `<option value="${category.id}">${category.name}</option>`;
                            categoryDropdown.append(option);
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching categories:', error);
                }
            });

            // Fetch and display products based on the selected location
            function fetchProducts(categoryId) {
                const apiEndpoint = categoryId ? `/api/catalog?category_id=${categoryId}` : '/api/catalog';

                $.ajax({
                    url: apiEndpoint,
                    method: 'GET',
                    dataType: 'json',
                    headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`, // Include token if required
                            },
                    success: function (products) {
                        // Clear existing products
                        productContainer.empty();

                        // Create product cards
                        products.forEach(product => {
                            const productCard = `
                                <div class="col mb-5">
                                    <div class="card h-100">
                                        <!-- Product image -->
                                        <img class="card-img-top border" 
                                            src="${product.image ? 'storage/' + product.image : 'no-image.jpg'}" 
                                            alt="${product.name}" />
                                        <!-- Product details -->
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <h5 class="fw-bolder text-primary">${product.name}</h5>
                                                <small>Stocks: ${product.quantity}</small>
                                                <h4 class="pt-3">₱<span class="product-price" id="product-price-${product.id}">${parseFloat(product.price).toFixed(2)}</span></h4>
                                                <small class="text-primary">Store: ${product.store.store_name}</small><br>
                                                <small>${product?.store?.street}, ${product?.store?.location?.barangay}, 
                                                ${product?.store?.location?.city}, ${product?.store?.location?.province} | 
                                                ${product?.store?.contact_number}</small>
                                            </div>
                                        </div>
                                        <!-- Product actions -->
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center">
                                                <button class="btn btn-outline-primary mt-auto add-to-cart role-customer" data-product-id="${product.id}">View Product</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            productContainer.append(productCard);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching products:', error);
                    }
                });
            }

            // Fetch products when a location is selected
            categoryDropdown.change(function () {
                const categoryId = $(this).val();
                fetchProducts(categoryId);
            });

            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('add-to-cart')) {
                    event.preventDefault();

                    const token = localStorage.getItem('token');

                    if (!token) {
                        alert('You need to login first to view product.');
                        window.location.href = '/login';
                    } else {
                        const productId = event.target.getAttribute('data-product-id');

                        localStorage.setItem('product_id', JSON.stringify(productId));

                        window.location.href = '/view-product';
                    }
                }
            });


            // Initial load of all products
            fetchProducts();
        });
    </script>

    <script>
        function updateDateTime() {
            // Create a new Date object and set the timezone to Asia/Manila
            let options = { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
            let now = new Date().toLocaleString('en-US', options);
    
            // Split the formatted date and time
            let dateTimeParts = now.split(', ');
            let currentDay = dateTimeParts[0];
            let currentDate = dateTimeParts[1];
            let currentTime = dateTimeParts[2];
    
            // Update the HTML elements
            document.getElementById('currentDay').textContent = currentDay;
            document.getElementById('currentDate').textContent = currentDate;
            document.getElementById('currentTime').textContent = currentTime;
        }
    
        // Update date and time immediately
        updateDateTime();
        // Optionally, keep it updated every minute
        setInterval(updateDateTime, 60000);

        // Retrieve user data from localStorage
        const user = JSON.parse(localStorage.getItem('user'));

        // Display user name if available
        if (user && user.first_name) {
            document.getElementById('welcomeMessage').textContent = `Welcome back, ${user.first_name} 👋`;
        }
    </script>

</body>
</html>