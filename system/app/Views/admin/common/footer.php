</div>
<!-- script -->
<script src="<?= base_url() ?>/adminassets/js/popper.js"></script>
<script src="<?= base_url() ?>/adminassets/js/bootstrap.js"></script>
<script src="<?= base_url() ?>/adminassets/js/datatables.js"></script>
<script src="<?= base_url() ?>/adminassets/js/toastr.js"></script>
<!-- end script -->
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
<script>
    /* Set the width of the side navigation to 250px */

    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    function myFunction(x) {
        if (x.matches) { // If media query matches

            document.getElementById('webmain').addEventListener('click', closeNav)
        } else {

        }
    }

    var x = window.matchMedia("(max-width: 992px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction)

    // side drop down 
    const hasCollapsible = document.querySelectorAll(".has-collapsible");
    hasCollapsible.forEach(function (collapsible) {
        collapsible.addEventListener("click", function () {
            collapsible.classList.toggle("active");

            // Close Other Collapsible
            hasCollapsible.forEach(function (otherCollapsible) {
                if (otherCollapsible !== collapsible) {
                    otherCollapsible.classList.remove("active");
                }
            });
        });
    });
</script>
<?php if (session('toastr')): ?>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        <?php foreach (session('toastr') as $key => $value): ?>
            toastr['<?= $key ?>']("<?= $value ?>");
        <?php endforeach; ?>
    </script>
<?php endif; ?>
</body>

</html>