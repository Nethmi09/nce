
<?php
ob_start();
include_once '../init.php'; 
$breadcrumb_item = "Report";
$breadcrumb_item_active = "Sales";
?>


<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h3 class="text-bold">Namarathna Cellular and Electronics</h3>

    </div>

    <div class="col-md-4"></div>

</div>

<div class="row">
    <div class="col-md-4" style="color:rgb(8, 8, 41)">
        358/A,<br>
        Henegama road,<br>
        Radawana.<br>
    </div>
    <div class="col-md-4"></div>
    <!-- <div class="col-md-4"></div> -->
    <div class="col-md-4  text-right" style="color:rgb(8, 8, 41)">
        Tel : 0712056162<br>
        E-mail : namarathnagroup@gmail.com <br>
    </div>
</div>
<br>

<div class="card">
    <div class="card-header" style='color:white;'>
        Sales Report
    </div>
    <div class="card-body">
        <?php
        $db = dbConn();
        // Prepare the dynamic SQL query
        $sql = "SELECT DATE_FORMAT(o.OrderDate, '%M') as month, SUM(p.UnitPrice * p.Quantity) as amount
       FROM order_products p  
       INNER JOIN orders o ON o.OrderId = p.OrderId  
       GROUP BY month  
       ORDER BY MONTH(o.OrderDate)";

        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            echo "<table class='table table-hover text-nowrap'>

       <thead style='color:blue; background_color=red'>
       <tr>
                   <th>Month</th>
                   <th>Amount</th>
                   
       </tr>
       </thead>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                   <td>{$row['month']}</td>
                   <td>{$row['amount']}</td>

                   
                 </tr>";
            }

            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>

    </div>
</div>







<?php
$content = ob_get_clean();
include '../layouts.php';
?>
