<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    
    var modal_container = document.getElementById('modal-container');

    $(document).ready(function() {


        // time
        setInterval(function() {
            $("#clock").load("time.php");
        }, 1000);

    });

    // message box container function
    function close() {
        modal_container.style.display = "none";
    }

    // message box button
    document.getElementById("close").addEventListener("click", function() {
        close();
    });

    // modal-container


    // charts
</script>