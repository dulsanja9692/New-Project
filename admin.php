
    <link rel="stylesheet" href="admincss.css"> 
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#manage-products">Manage Products</a></li>
            <li><a href="#manage-users">Manage Users</a></li>
            <li><a href="#logout">Logout</a></li>
        </ul>
    </div>
    
    <div class="content">
        <h1>Welcome, Admin </h1>

        <section id="dashboard">
            <h2>Dashboard Overview</h2>
            
            <!-- You can display stats such as number of users, orders, and revenue -->
        </section>

        <section id="manage-products">
            <h2>Manage Products</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <button type="submit">Add Product</button>
                    </tr>
                </thead>
                <tbody>
                    <!-- Products will be populated here dynamically using PHP -->
                </tbody>
            </table>
        </section>

    </div>
   
</body>