<?php
session_start();
include("../config.php");
$con = connect();

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        // Get all sites
        case 'getSites':
            try {
                $query = "SELECT * FROM tbl_sites";
                $result = mysqli_query($con, $query);
                
                if (!$result) {
                    throw new Exception("Error fetching sites: " . mysqli_error($con));
                }

                $sites = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $sites[] = $row;
                }
                echo json_encode($sites);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        // Get sectors for a specific site
        case 'getSectors':
            try {
                if (!isset($_POST['site_id'])) {
                    throw new Exception("Site ID is required");
                }

                $site_id = mysqli_real_escape_string($con, $_POST['site_id']);
                $query = "SELECT DISTINCT sector FROM tbl_blocks WHERE site_id = ?";
                
                $stmt = $con->prepare($query);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $con->error);
                }

                $stmt->bind_param("i", $site_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $sectors = array();
                while ($row = $result->fetch_assoc()) {
                    $sectors[] = $row;
                }
                echo json_encode($sectors);
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        // Get blocks for a specific site and sector
        case 'getBlocks':
            try {
                if (!isset($_POST['site_id']) || !isset($_POST['sector'])) {
                    throw new Exception("Site ID and Sector are required");
                }

                $site_id = mysqli_real_escape_string($con, $_POST['site_id']);
                $sector = mysqli_real_escape_string($con, $_POST['sector']);
                
                $query = "SELECT * FROM tbl_blocks WHERE site_id = ? AND sector = ?";
                
                $stmt = $con->prepare($query);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $con->error);
                }

                $stmt->bind_param("is", $site_id, $sector);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $blocks = array();
                while ($row = $result->fetch_assoc()) {
                    $blocks[] = $row;
                }
                echo json_encode($blocks);
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        // Get lots for a specific block
        case 'getLots':
            try {
                if (!isset($_POST['block_id'])) {
                    throw new Exception("Block ID is required");
                }

                $block_id = mysqli_real_escape_string($con, $_POST['block_id']);
                $query = "SELECT * FROM tbl_lots WHERE block_id = ?";
                
                $stmt = $con->prepare($query);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $con->error);
                }

                $stmt->bind_param("i", $block_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $lots = array();
                while ($row = $result->fetch_assoc()) {
                    $lots[] = $row;
                }
                echo json_encode($lots);
                $stmt->close();
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}

// Close the database connection
mysqli_close($con);
?>