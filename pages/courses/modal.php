<!-- modal.php -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modalMessage"></p>
    </div>
</div>

<style>
    /* Style for the modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 300px;
        text-align: center;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    function showModal(message) {
        const modal = document.getElementById("myModal");
        const modalMessage = document.getElementById("modalMessage");

        modalMessage.textContent = message;
        modal.style.display = "block";

        // Close the modal when the user clicks on <span> (x)
        const span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks outside of the modal
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    }

    // Check the echo value from PHP
    <?php if (isset($echo_value)): ?>
        if (<?php echo json_encode($echo_value); ?> === 1) {
            showModal("สำเร็จ!");
        } else if (<?php echo json_encode($echo_value); ?> === 0) {
            showModal("ลองใหม่อีกครั้ง.");
        }
    <?php endif; ?>
</script>