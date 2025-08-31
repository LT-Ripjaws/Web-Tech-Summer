<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Management</title>

        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/team.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    </head>
    <body>
        <div class="full-container">
            <?php include("../../includes/sidebar.php"); ?>
             <main>
                <div class="topbar">
                    <h1>Car Management</h1>
                    <button class="btn-main">+ Add Car</button>
                </div>

                <!-- Search & Filter -->
                <div class="search">
                    <input type="text" placeholder="Search by Model, Brand...">
                    <select>
                        <option value="">All Brands</option>
                        <option value="toyota">Toyota</option>
                        <option value="honda">Honda</option>
                        <option value="bmw">BMW</option>
                    </select>
                    <select>
                        <option value="">Status</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <button class="btn-main">Search</button>
                </div>


                <!-- Car Table -->
                <div class="employee-table">
                    <table>
                        <thead>
                            <tr>
                                <th>VIN</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1HGCM82633A123456</td>
                                <td>Mercedes-Benz</td>
                                <td>a test name</td>
                                <td>1990</td>
                                <td>$5,500</td>
                                <td><span class="status available">Available</span></td>
                                <td>
                                    <button class="btn-main small">Edit</button>
                                    <button class="btn-main danger small">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
             </main>
        </div>