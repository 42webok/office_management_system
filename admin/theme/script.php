<!-- Script code here -->

</body>

<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
<script>
// timeLoading();
function loadNotifyData() {
    $.ajax({
        type: "POST",
        url: "fetch_notifecation.php",
        dataType: "json",
        success: function(data) {
            if (data.status !== 'false') {
                    let notif = data.length;
                    $("#notify_batch").html(notif);
                    $("#new_notify").html(notif);
                    // Notify list data 
                    let notify_list_data = $("#notify_list_data");
                    let contents = '';
                    $.each(data, function(index, value) {
                        contents += `
        <div class="notif-center" onclick='markRead(${value.id})'>
           <a href="javascript:void(0)">
                <div class="notif-icon notif-info"> <i class="la la-bell"></i> </div>
                       <div class="notif-content">
                            <span class="block">
                                 ${value.message}
                            </span>
                       <span class="time time-ago" data-time="${value.created_at}"></span>
                </div>
           </a>
         </div>
        `;
                    });
                    notify_list_data.html(contents);
                    // console.log(data);
            } else {
                console.log(data);
            }

        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed: " + status + ", " + error);
        }
    });
}
loadNotifyData();
try {
    loadNotifyData();
    window.markRead = function(notif_id) {
        $.post("mark_as_read.php", {
            id: notif_id
        }, function() {
            loadNotifyData();
        });
    };
} catch {
    console.log(data);
}
</script>
<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<!-- <script src="../assets/js/plugin/chartist/chartist.min.js"></script> -->
<!-- <script src="../assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script> -->
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<!-- <script src="../assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script> -->
<!-- <script src="../assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script> -->
<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../assets/js/ready.min.js"></script>
<!-- <script src="../assets/js/demo.js"></script> -->


<script>
document.addEventListener("DOMContentLoaded", function() {
    const sideNavLinks = document.querySelectorAll('.custom_nav a');

    const currentPage = window.location.pathname;
    const result = currentPage.replace('/office/admin/', '');

    sideNavLinks.forEach(function(item) {
        if (item.getAttribute('href') === result) {
            item.closest('.custom_nav').classList.add('active');
        } else {
            item.closest('.custom_nav').classList.remove('active');
        }
    });
});
</script>

<!-- Making a time format js code -->


<script>
function timeAgo(date) {
    const now = new Date();
    const past = new Date(date);
    const seconds = Math.floor((now - past) / 1000);

    if (seconds < 60) return `${seconds}s`; // Less than 1 minute
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}m`; // Less than 1 hour
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h`; // Less than 1 day
    const days = Math.floor(hours / 24);
    if (days < 7) return `${days}d`; // Less than 1 week
    const weeks = Math.floor(days / 7);
    if (weeks < 4) return `${weeks}w`; // Less than 1 month
    const months = Math.floor(days / 30);
    if (months < 12) return `${months}mo`; // Less than 1 year
    const years = Math.floor(months / 12);
    return `${years}y`; // More than 1 year
}

// Make sure the element with 'time-ago' class exists
window.onload = () => {
    document.querySelectorAll('.time-ago').forEach(element => {
        const createdAt = element.getAttribute('data-time'); // Get the timestamp
        if (createdAt) {
            const relativeTime = timeAgo(createdAt); // Format the time
            element.textContent = relativeTime; // Display formatted time
        }
    });
}
</script>


</html>