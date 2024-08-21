<?php 
ob_start(); 
include_once '../init.php';  
$breadcrumb_item = "Reports"; 
$breadcrumb_item_active = "Order Chart"; 
?>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Order Chart</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <!-- canvas use to draw chart -->
                            <canvas id="orderChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>


<?php 
$content = ob_get_clean(); 
include '../layouts.php'; 
?>


<?php 
$db = dbConn(); 
$sql = "SELECT DATE_FORMAT(o.OrderDate, '%M') as month, SUM(p.UnitPrice * p.Quantity) as amount  
        FROM order_products p  
        INNER JOIN orders o ON o.OrderId = p.OrderId  
        GROUP BY month  
        ORDER BY MONTH(o.OrderDate)"; 
$result = $db->query($sql); 
 
$months = []; 
$amounts = []; 
 
// array varables
while ($row = $result->fetch_assoc()) { 
    $months[] = $row['month']; 
    $amounts[] = $row['amount']; 
} 
 
// Encode data as JSON (php varible->js varible)
$months_json = json_encode($months); 
$amounts_json = json_encode($amounts); 
?>

<script>
$(document).ready(function() {
    var barChartCanvas = $('#orderChart').get(0).getContext('2d');//canvas id
    var months = <?php echo $months_json; ?>;
    var amounts = <?php echo $amounts_json; ?>;

    var barChartData = {
        labels: months,
        datasets: [{
            label: 'Sales Amount',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: amounts,
            fill: false // Ensure the area under the line is not filled 
        }]
    };

    var barChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: true,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: true,
                }
            }]
        }
    };

    // Create the chart 
    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });
});
</script>