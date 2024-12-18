<?php    
if(!isset($_SESSION)){     
    session_start();       
}   
include("../config.php");   
$con=connect();   
if(isset($_SESSION["username"])){     
    $services=$con->query("SELECT * FROM `memorial_services`");       
    // New query to fetch service requests with additional details 
    $service_requests = $con->query(" SELECT    sr.request_id,    sr.request_date,    sr.status,   c.family_name,    c.first_name,    c.middle_name,   ms.service_name,   lo.site_id,   lo.block_id,   lo.lot_id FROM    service_requests sr JOIN    lot_owners lo ON sr.lot_owner_id = lo.lot_owner_id JOIN    customers c ON lo.customer_id = c.customer_id JOIN    memorial_services ms ON sr.service_id = ms.service_id ORDER BY    sr.request_date DESC ");  
    // Check for query errors 
    if (!$service_requests) {   
        die("Query failed: " . $con->error); 
    }   
}else{     
    header("Location: index.php");   
}   

// Update Service Function 
if(isset($_POST['btn-edit-service'])) {     
    $service_id = $_POST['service-id'];     
    $service_name = $_POST['service-name'];     
    $service_price = $_POST['service-price'];     
    $service_description = $_POST['service-description'];      
    
    // Prepare the SQL statement to prevent SQL injection     
    $update_stmt = $con->prepare("UPDATE memorial_services                                     SET service_name = ?,                                         service_description = ?,                                         service_price = ?                                     WHERE service_id = ?");          
    
    // Bind parameters     
    $update_stmt->bind_param("ssdi",          
        $service_name,          
        $service_description,          
        $service_price,          
        $service_id     
    );      
    
    // Execute the update     
    if($update_stmt->execute()) {         
        $_SESSION['message'] = "Service updated successfully!";         
        $_SESSION['message_type'] = "success";     
    } else {         
        $_SESSION['message'] = "Error updating service: " . $con->error;         
        $_SESSION['message_type'] = "error";     
    }      
    
    // Close the statement     
    $update_stmt->close();      
    
    // Redirect back to services page     
    header("Location: services.php");     
    exit(); 
}  

// Delete Service Function 
if(isset($_POST['btn-delete-service'])) {     
    $service_id = $_POST['service-id'];      
    
    // Prepare the SQL statement to prevent SQL injection     
    $delete_stmt = $con->prepare("DELETE FROM memorial_services WHERE service_id = ?");          
    
    // Bind parameter     
    $delete_stmt->bind_param("i", $service_id);      
    
    // Execute the delete     
    if($delete_stmt->execute()) {         
        $_SESSION['message'] = "Service deleted successfully!";         
        $_SESSION['message_type'] = "success";     
    } else {         
        $_SESSION['message'] = "Error deleting service: " . $con->error;         
        $_SESSION['message_type'] = "error";     
    }      
    
    // Close the statement     
    $delete_stmt->close();      
    
    // Redirect back to services page     
    header("Location: services.php");     
    exit(); 
}

// Update Service Request Status Function 
if(isset($_POST['btn-update-service-status'])) {     
    $request_id = $_POST['request_id'];     
    $service_status = $_POST['service_status'];      
    
    // First, check the current status
    $check_status_query = "SELECT status FROM service_requests WHERE request_id = $request_id";
    $result = $con->query($check_status_query);
    
    if ($result) {
        $current_status = $result->fetch_assoc()['status'];
        
        // Prevent updating if already Completed or Cancelled
        if (in_array($current_status, ['Completed', 'Cancelled'])) {
            $_SESSION['message'] = "Cannot modify a $current_status request.";
            $_SESSION['message_type'] = "error";
            header("Location: services.php");
            exit();
        }
    }
    
    // Proceed with update if not Completed or Cancelled
    $update_query = "UPDATE service_requests SET status = '$service_status' WHERE request_id = $request_id";
    
    if ($con->query($update_query)) {
        if ($con->affected_rows > 0) {
            $_SESSION['message'] = "Service request status updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "No matching record found to update.";
            $_SESSION['message_type'] = "warning";
        }
    } else {
        $_SESSION['message'] = "Error updating status: " . $con->error;
        $_SESSION['message_type'] = "error";
    }
    
    header("Location: services.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../Assets/image/logopngplain1.png" type="image/x-icon">
    <title>Services | Holy Gardens Matutum Memorial Park</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../Assets/DataTables/datatables.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="../Assets/css/index_admin.css">
    
    <script src="../Assets/js/sweetalert.js"></script>

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>

   <style>
    :root{
        --Poppins: 'Poppins', sans-serif;
        --Font2: 'Roboto', sans-serif;
        --Font3: 'Inter', sans-serif;
        --color1: #00563B;
        --color2: white;
        --color3: #00432E;
    }
    .sidebar {
      background-color: var(--color1);
    }
    .sidebar .nav-links li:hover {
      background-color: var(--color3);
    }
    .sidebar .nav-links li.active {
      background-color: var(--color3);
    }
    .admin-content .admin {
      background-color: var(--color3);
    }
    .sidebar .logo-details img {
      width: 50px;
    }
    </style>
  <body>
  <?php
if(isset($_SESSION['message'])) {
    $message_type = $_SESSION['message_type'] ?? 'info';
    echo "<script>
        Swal.fire({
            icon: '$message_type',
            title: '$_SESSION[message]',
            showConfirmButton: false,
            timer: 3000
        });
    </script>";
    
    // Clear the message after displaying
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
  <?php include("queries/application.php");?>
  <div class="sidebar close">

    <div class="logo-details">
      <img src="../Assets/image/logo1.png" alt="">
    </div>

    <ul class="nav-links">
      
      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
        <a href="dashboard.php">
          <i class='bx bx-grid-alt bx-rotate-180' ></i>
          <span class="link_name">Dashboard</span>
        </a>
      </li>

      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Customer">
        <a href="customer.php">
          <i class='bx bx-user' ></i>
          <span class="link_name">Customer</span>
        </a>
      </li>

      <li class="tabs active" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Services">
        <a href="services.php">
          <i class='bx bx-book-heart fs-4' ></i>
          <span class="link_name">Services</span>
        </a>
      </li>

      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Block & Lot Setup">
        <a href="block-and-lot.php">
          <i class='bx bx-layer'></i>
          <span class="link_name">Block & Lot Setup</span>
        </a>
      </li>

      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Interment Setup">
        <a href="interment_Setup.php">
          <i class='bx bxs-user-rectangle' ></i>
          <span class="link_name">Interment Setup</span>
        </a>
      </li>

      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Grave Map">
        <a href="grave-map.php">
          <i class='bx bx-map-alt' ></i>
          <span class="link_name">Grave Map</span>
        </a>
      </li>

      <!-- <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Slideshow">
        <a href="slideshow.php">
          <i class='bx bx-carousel' ></i>
          <span class="link_name">Slideshow</span>
        </a>
      </li> -->

      <li class="tabs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="News & Events">
        <a href="news-events.php">
          <i class='bx bx-news'></i>
          <span class="link_name">News & Events</span>
        </a>
      </li>
      
    </ul>

    <button id="logout" data-username="<?php echo  $_SESSION["username"] ?>">
    <div class="admin-content">
      <div class="admin d-flex align-items-center">
        <div class="admin-details ">
          <i class='bx bx-log-out-circle' style="cursor: pointer"></i>
          <div class="admin-label">
            Logout
          </div>
        </div>
      </div>
    </div>
    </button>
  </div>
  <div class="notif"></div>

    <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
    </div>
      <div class="main-container">
        <div class="content active">
          <div class="div-content">
            <h2 class="title-head d-flex align-items-center">
              <i class='bx bx-book-heart fs-1'></i>
              &nbsp;MEMORIAL SERVICES
            </h2>
            <hr>
            <div class="row p-0">
              <div class="col-sm-12 col-md-12">
                <div class="bg-white p-4 h-100 rounded">
                  <div class="title-header bg-white sticky-top p-3 d-flex justify-content-between align-items-center">
                    <h4 class="d-flex align-items-center">
                      <i class='bx bx-list-ul fs-2'></i>
                      &nbsp;Services List
                    </h4>
                    <button class="btn btn-success add-service d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-service">
                      <i class='bx bxs-plus-circle fs-4'></i>
                      &nbsp;Add Service
                    </button>
                  </div>

                  <br>
                  
                  <table class="table table-striped table-bordered w-100" id="tbl-services">
                    <thead class="tbl-header text-light">
                      <tr>
                        <th>#</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while($row=$services->fetch_array()){?>
                      <tr>
                        <td><?php echo $row["service_id"]?></td>
                        <td><?php echo $row["service_name"]?></td>
                        <td><?php echo $row["service_description"]?></td>
                        <td>₱<?php echo number_format($row["service_price"], 2)?></td>
                        <td class="text-center">
                          <button class="btn btn-success btn-edit-service" data-bs-toggle="modal" data-bs-target="#edit-service<?php echo $row["service_id"]?>">
                            <i class='bx bxs-edit'></i>
                          </button>
                          <button class="btn btn-danger btn-delete-service">
                            <i class='bx bxs-trash'></i>
                          </button>
                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

                        <!-- New Section for Service Requests -->
            <div class="row p-0 mt-4">
              <div class="col-sm-12 col-md-12">
                <div class="bg-white p-4 h-100 rounded">
                  <div class="title-header bg-white sticky-top p-3 d-flex justify-content-between align-items-center">
                    <h4 class="d-flex align-items-center">
                      <i class='bx bx-list-ul fs-2'></i>
                      &nbsp;Service Requests
                    </h4>
                  </div>

                  <br>

                  <!-- Modify the Service Requests table -->
<table class="table table-striped table-bordered w-100" id="tbl-service-requests">
  <thead class="tbl-header text-light">
    <tr>
      <th>Request ID</th>
      <th>Full Name</th>
      <th>Site</th>
      <th>Block</th>
      <th>Lot</th>
      <th>Service Type</th>
      <th>Request Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row=$service_requests->fetch_array()){?>
    <tr>
      <td><?php echo $row["request_id"]?></td>
      <td><?php echo $row["family_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]?></td>
      <td><?php echo $row["site_id"]?></td>
      <td><?php echo $row["block_id"]?></td>
      <td><?php echo $row["lot_id"]?></td>
      <td><?php echo $row["service_name"]?></td>
      <td><?php echo $row["request_date"]?></td>
      <td><?php echo $row["status"]?></td>
      <td class="text-center">
        <button class="btn btn-info btn-view-request" 
                data-bs-toggle="modal" 
                data-bs-target="#view-service-request<?php echo $row["request_id"]?>">
          <i class='bx bx-show'></i>
        </button>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php 
// Reset the service_requests query to create view modals
$service_requests = $con->query("
  SELECT 
    sr.request_id, 
    sr.request_date, 
    sr.status,
    sr.additional_notes,
    sr.created_at,
    c.family_name, 
    c.first_name, 
    c.middle_name,
    c.contact,
    c.email,
    ms.service_name,
    lo.site_id,
    lo.block_id,
    lo.lot_id
  FROM 
    service_requests sr
  JOIN 
    lot_owners lo ON sr.lot_owner_id = lo.lot_owner_id
  JOIN 
    customers c ON lo.customer_id = c.customer_id
  JOIN 
    memorial_services ms ON sr.service_id = ms.service_id
  ORDER BY 
    sr.request_date DESC
");

// Check for query errors
if (!$service_requests) {
    die("Query failed: " . $con->error);
}

while($row = $service_requests->fetch_array()){
?>
<!-- View Service Request Modal -->
<div class="modal fade" id="view-service-request<?php echo $row["request_id"]?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class='bx bx-show'></i> Service Request Details
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Request ID</label>
            <p><?php echo $row["request_id"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Service Type</label>
            <p><?php echo $row["service_name"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Full Name</label>
            <p><?php echo $row["family_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Contact Number</label>
            <p><?php echo $row["contact"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Email</label>
            <p><?php echo $row["email"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Location</label>
            <p>Site: <?php echo $row["site_id"]?>, Block: <?php echo $row["block_id"]?>, Lot: <?php echo $row["lot_id"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Request Date</label>
            <p><?php echo $row["request_date"]?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="fw-bold">Created At</label>
            <p><?php echo $row["created_at"]?></p>
          </div>
          <div class="col-md-12 mb-3">
            <label class="fw-bold">Status</label>
            <p><?php echo $row["status"]?></p>
          </div>
          <div class="col-md-12 mb-3">
            <label class="fw-bold">Additional Notes</label>
            <p><?php echo $row["additional_notes"] ?? 'No additional notes'?></p>
          </div>
        </div>
        <div class="col-md-12 mb-3">
    <label class="fw-bold">Update Status</label>
    <form action="" method="post" id="update-status-form<?php echo $row["request_id"]?>">
        <input type="hidden" name="request_id" value="<?php echo $row["request_id"]?>">
        <div class="input-group">
            <select name="service_status" class="form-control" 
                <?php 
                // Disable the select if status is already Completed or Cancelled
                if (in_array($row["status"], ['Completed', 'Cancelled'])) {
                    echo 'disabled';
                }
                ?>>
                <option value="Pending" <?php echo ($row["status"] == "Pending") ? "selected" : ""; ?>>Pending</option>
                <option value="Completed" <?php echo ($row["status"] == "Completed") ? "selected" : ""; ?>>Completed</option>
                <option value="Cancelled" <?php echo ($row["status"] == "Cancelled") ? "selected" : ""; ?>>Cancelled</option>
            </select>
            <button type="submit" name="btn-update-service-status" class="btn btn-success"
                <?php 
                // Disable the button if status is already Completed or Cancelled
                if (in_array($row["status"], ['Completed', 'Cancelled'])) {
                    echo 'disabled';
                }
                ?>>
                Update Status
            </button>
        </div>
        <?php 
        // Add a message if the status can't be changed
        if (in_array($row["status"], ['Completed', 'Cancelled'])) {
            echo '<small class="text-danger mt-2 d-block">Status cannot be modified after being set to ' . $row["status"] . '.</small>';
        }
        ?>
    </form>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      
    </div>
    
  </div>
  
</div>
<?php } ?>
                </div>
                
              </div>
              
            </div>

            <?php 
// Reset the services query to loop through again for edit modals
$services = $con->query("SELECT * FROM `memorial_services`");
while($row = $services->fetch_array()){
?>
<!-- Edit Service Modal -->
<div class="modal fade" id="edit-service<?php echo $row["service_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class='bx bxs-edit'></i> Edit Memorial Service
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="post">
                <input type="hidden" name="service-id" value="<?php echo $row["service_id"]?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Service Name</label>
                            <input type="text" name="service-name" class="form-control" 
                                   value="<?php echo htmlspecialchars($row["service_name"])?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Service Price</label>
                            <input type="number" name="service-price" class="form-control" 
                                   value="<?php echo $row["service_price"]?>" step="0.01" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Service Description</label>
                            <textarea name="service-description" class="form-control" rows="4"><?php echo htmlspecialchars($row["service_description"])?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn-edit-service" class="btn btn-success">Update Service</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>

            <!-- Add Service Modal -->
            <div class="modal fade" id="add-service" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">
                      <i class='bx bxs-plus-circle'></i> Add Memorial Service
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <form action="" method="post">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Service Name</label>
                          <input type="text" name="service-name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Service Price</label>
                          <input type="number" name="service-price" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label>Service Description</label>
                          <textarea name="service-description" class="form-control" rows="4"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="btn-add-service" class="btn btn-success">Add Service</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
  <script src="https://kit.fontawesome.com/ec4303cca5.js" crossorigin="anonymous"></script>
  <script src="../Assets/js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../Assets/DataTables/datatables.min.js"></script>
  <script src="../Assets/js/index_admin.js" defer></script>
  <script>
    // Initialize DataTable for service requests
    $(document).ready(function() {
      $('#tbl-service-requests').DataTable({
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      });
    });
    // Initialize DataTable for services
    $(document).ready(function() {
    $('#tbl-services').DataTable({
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
    });

    $(document).ready(function() {
    // Delete Service Button Click Handler
    $('.btn-delete-service').on('click', function() {
        var serviceId = $(this).closest('tr').find('td:first').text();
        
        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this service?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form dynamically to submit deletion
                var form = $('<form>', {
                    'action': '',
                    'method': 'post'
                }).append($('<input>', {
                    'type': 'hidden',
                    'name': 'service-id',
                    'value': serviceId
                })).append($('<input>', {
                    'type': 'hidden',
                    'name': 'btn-delete-service',
                    'value': 'Delete'
                }));

                // Append form to body and submit
                $('body').append(form);
                form.submit();
            }
        });
    });
});

$(document).ready(function() {
    // Attach submit event to all update status forms
    $('form[id^="update-status-form"]').on('submit', function(e) {
        // Check if the form is disabled
        if ($(this).find('select[name="service_status"]').is(':disabled')) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Status Cannot Be Modified',
                text: 'This request has already been finalized and cannot be updated.'
            });
            return false;
        }
        
        // Optional: Add confirmation dialog
        var status = $(this).find('select[name="service_status"]').val();
        var confirmSubmit = confirm('Are you sure you want to update the status to ' + status + '?');
        if (!confirmSubmit) {
            e.preventDefault();
        }
    });
});
  </script>
  </body>
</html>