<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
include '../config.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Register</h1>
</div>
<!-- Single Page Header End -->

<!--  Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h4 class="text-primary">Please tell us the reason for canceling this order.</h4>
                    </div>
                </div>

                <div class="">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        extract($_POST);

                        $message = array();
                        //Required validations-----------------------------------------------

                        if (empty($reason)) {
                            $message['reason'] = "Cancellation Reason is required...!";
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>
                        <div class="row">

                            <div class="form-group col-md-12">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM order_cancellation_customer";
                                $result = $db->query($sql);
                                ?>
                                 <label for="reason" class="form-label fw-bold">Cancellation Reason<span style = "color : red;"> * </span></label>
                               
                                <select name="reason" id="reason" class="form-select mb-4 border border-1" value="<?= @$reason ?>" aria-label="Large select example">
                                    <option value="">Select cancellation reason</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['CancelReasonId'] ?>"><?= $row['Reason'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['reason'] ?></span>
                            </div>
                        </div>

                        <button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Submit</button>


                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!--  Form End -->


<?php
include 'footer.php';
ob_end_flush();
?> 
