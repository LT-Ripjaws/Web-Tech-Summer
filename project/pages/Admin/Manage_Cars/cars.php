<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Management</title>

        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/cars.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    </head>
    <body>
        <div class="full-container">
            <?php include("../../../includes/sidebar.php"); ?>
             <main>
                <header class="topbar">
                    <h1>Car Management</h1>
                    <button class="btn-main">+ Add Car</button>
                </header>

                <!-- Search & Filter -->
                <section class="search">
                <input type="text" id="searchBar" placeholder="Search by Model, Brand...">

                <select id="brandFilter">
                    <option value="">All Brands</option>
                    <option value="mercedes-benz">Mercedes</option>
                    <option value="ford">Ford</option>
                    <option value="bmw">BMW</option>
                </select>

                <select id="statusFilter">
                    <option value="">Status</option>
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                    <option value="maintenance">Maintenance</option>
                </select>

                <button class="btn-main" id="searchBtn">Search</button>
                </section>


                <!-- Car Table -->
                <section class="car-table">
                    <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>VIN</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include("../../../includes/db/config.php");
                            $result = $conn->query("SELECT * from cars ORDER BY year ASC"); ?>
                            <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?> 
                                <tr>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                    <img src="/Web-Tech-Summer/project/assets/images/uploads/<?php echo $row['image']; ?>" width="80" height="60" style="object-fit:contain;">
                                    <?php else: ?>
                                    No Image
                                    <?php endif; ?>
                                </td>
                                <td class="vin"><?php echo $row['vin']?></td>
                                <td class="brand"><?php echo $row['brand']?></td>
                                <td class="model"><?php echo $row['model']?></td>
                                <td class="year"><?php echo $row['year']?></td>
                                <td class="price"><?php echo '$'.$row['price']?></td>
                                <td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo $row['status']?></span></td>
                                <td class="description" title="<?php echo $row['description']; ?>">
                                    <?php echo substr($row['description'], 0, 50) . (strlen($row['description']) > 50 ? '...' : ''); ?>
                                </td>
                                <td>
                                    <button class="btn-main small">Edit</button> <!-- will add it later -->
                                    <a href="actions/delete_car.php?car_id=<?php echo $row['car_id'];?>">
                                    <button class="btn-main danger small" onclick="return confirm('Are you sure you want to delete this car?')";>Delete</button>
                                    </a>
                                </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr><td colspan="9">No Cars yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
                  </section>
             </main>
        </div>

        <!-- Add Car function-->
        <div class="modal" id="addCarfunc">
        <div class="form-content">
            <h2 id="modalTitle">Add New Car</h2>
            <form id="carForm" action="actions/add_car.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="car_id" id="car_id">

            <label>Car Image</label>
            <input type="file" name="image" id="image" accept="image/*">
            
            <label>VIN</label>
            <input type="text" name="vin" id="vin" required>

            <label>Brand</label>
            <input type="text" name="brand" id="brand" required>
            
            <label>Model</label>
            <input type="text" name="model" id="model" required>
            
            <label>Year</label>
            <input type="number" name="year" id="year">

            <label>Price</label>
            <input type="number" name="price" id="price">

            <label>Status</label>
            <select name="status" id="status">
                <option value="available">Available</option>
                <option value="sold">Sold</option>
                <option value="maintenance">Maintenance</option>
            </select>

            <label>Description</label>
            <textarea name="desc" id="desc" rows="4" cols="50"></textarea>
            
            
            <div class="form-actions">
                <button type="submit" class="btn-main">Save</button>
                <button type="button" class="btn-main">Cancel</button>
            </div>
            </form>
        </div>
        </div>
        <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
        <script src="/Web-Tech-Summer/project/assets/js/Admin/cars.js"></script>
        </body>
</html>