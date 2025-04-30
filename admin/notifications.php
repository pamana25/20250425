<?php
include 'includes/security.php';
include 'includes/header.php';
include 'includes/navbar.php';


//page view
$page_id = 2;
$visitor_ip = $_SERVER['REMOTE_ADDR']; // stores IP address of visitor in variable
add_view($con, $visitor_ip, $page_id);

?>
<div class="container-fluid py-4">
    <div class="row min-vh-80 h-100">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card mt-4 pb-3">
                <div class="card-header p-3">
                    <h5 class="mb-0">Notification </h5>
                </div>
                <?php

                // Get the current week's start and end dates
                $startDate = date('Y-m-d', strtotime('this week'));
                $endDate = date('Y-m-d', strtotime('this week +6 days'));

                // Query to fetch new users created within the current week
                $query = "SELECT users.userid, notifications.id, users.email, users.datecreated, notifications.status FROM users INNER JOIN notifications ON users.userid=notifications.userid ORDER BY id DESC";
                $result = mysqli_query($con, $query);

                // Check if there are any new users
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each new user and display their details
                    while ($row = mysqli_fetch_assoc($result)) {
                        $userId = $row['userid'];
                        $email = $row['email'];
                        $dateCreated = $row['datecreated'];
                        echo '<div class="div-parent d-flex justify-content-between align-items-center '. ($row['status'] != 1 ? 'bg-primary text-white': '') .' rounded shadow mx-5 my-2 ">
                                <div data-id="'. $row['id'] .'" class=" toggle-status w-100 cursor-pointer ms-3" role="alert">
                                    <span class="text-sm">New user created: ' . date('M d' . ',' . ' Y', strtotime($dateCreated)) . '</span>
                                    <br>
                                    <span>User ID:</span> ' . $userId . ' |
                                    <span>Email:</span> ' . $email . ' 
                                    
                                </div>
                                <button type="button" value="' . $row['id'] . '" class="btnDelete z-2 btn text-lg " >
                                    &times;
                                </button>
                            </div>';
                    }
                    echo '</div>
              </div>
          </div>
      </div>
  </div>';
                } else {
                    echo "<span class='ms-3'>No new users created.</span>";
                }
                ?>
            </div>
        </div>
    </div>
</div>







<?php

include 'includes/footer.php';
include 'includes/scripts.php';
?>
<script>
    document.querySelectorAll(".div-parent").forEach((parent) => {

        const deleteNotification = async (deleteNotif) => {
                try {
                    const response = await fetch(`../admin/functions.php?notif_id=${deleteNotif}`, {
                        method: "DELETE",
                    })
                    const data = await response.json()
                    if (data.status === "success") {
                        parent.remove()
                    }
                } catch (error) {
                    console.error("Something went wrong", error.message)
                }
        }
        const updateNotification = async (updateNotif)=>{
            try {
                const response = await fetch('../admin/functions.php', {
                    method: "PUT",
                    headers:{
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(updateNotif)
                })
                const data = await response.json()
            } catch (error) {
                console.error("Something went wrong", error.message)
            }

        }

        parent.addEventListener("click", async (e) => {
            if (e.target.classList.contains("toggle-status")) {
                // console.log(e.target.getAttribute("data-id"));
                const updateNotif = {
                    notification_id: e.target.getAttribute("data-id"),
                    update_notification: true
                }
                updateNotification(updateNotif)
                parent.classList.remove("bg-primary")
                parent.classList.remove("text-white")
            }
            if (e.target.classList.contains("btnDelete")) {
                deleteNotification(e.target.value)
            }
        });
    });
</script>

<script>
    const activePage = document.querySelector("a[href='notifications.php'")
    activePage.classList.add('active', 'bg-gradient-primary');
    const lssMenu = document.getElementById('lssMenu');
    const ncpMenu = document.getElementById('ncpMenu');
    ncpMenu.classList.add('d-none');
    lssMenu.classList.add('d-none');
</script>