<?php

session_start();
include 'connection.php';


if (!$_SESSION['username']) {
    header('location: sign_in.php');
}



//website view count


function total_views($con, $page_id = null)
{
    if ($page_id === null) {
        // count total website views
        $query = "SELECT sum(total_views) as total_views FROM pages";
        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            // while ($row = $query_run->fetch_assoc()) {
            foreach ($query_run as $row) {
                if ($row['total_views'] === null) {
                    return 0;
                } else {
                    return $row['total_views'];
                }
            }
        } else {
            return "No records found!";
        }
    } else {
        // count specific page views
        $query = "SELECT total_views FROM pages WHERE id='$page_id'";
        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $row) {
                if ($row['total_views'] === null) {
                    return 0;
                } else {
                    return $row['total_views'];
                }
            }
        } else {
            return "No records found!";
        }
    }
}
function is_unique_view($con, $visitor_ip, $page_id)
{
    $query = "SELECT * FROM page_views WHERE visitor_ip='$visitor_ip' AND page_id='$page_id'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        return false;
    } else {
        return true;
    }
}
function add_view($con, $visitor_ip, $page_id)
{
    if (is_unique_view($con, $visitor_ip, $page_id) === true) {
        // insert unique visitor record for checking whether the visit is unique or not in future.
        $query = "INSERT INTO page_views (visitor_ip, page_id) VALUES ('$visitor_ip', '$page_id')";

        if (mysqli_query($con, $query)) {
            // At this point unique visitor record is created successfully. Now update total_views of specific page.
            $query = "UPDATE pages SET total_views = total_views + 1 WHERE id='$page_id'";

            if (!mysqli_query($con, $query)) {
                echo "Error updating record: " . mysqli_error($con);
            }
        } else {
            echo "Error inserting record: " . mysqli_error($con);
        }
    }
}
