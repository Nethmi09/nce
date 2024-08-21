<?php
ob_start();
session_start();
include_once 'init.php';
//checkUserType("employee");

$link = "Dashboard";
$breadcrumb_item = "Home";
$breadcrumb_item_active = "Dashboard";
?> 


<!--Role wise dashboard display start-->
<?php
$userrole = $_SESSION['ROLE'];

$dashboard = "users/dashboard/$userrole.php";
include $dashboard;
?>
<!--Role wise dashboard display end-->


<?php
$content = ob_get_clean();
include 'layouts.php';
?>

<!-- Sales by order chart code start-->
<?php
$db = dbConn();
$sql = "SELECT DATE_FORMAT(o.OrderDate, '%M') as month, SUM(p.UnitPrice * p.Quantity) as amt 
        FROM order_products p 
        INNER JOIN orders o ON o.OrderId = p.OrderId 
        GROUP BY month 
        ORDER BY MONTH(o.OrderDate)";
$result = $db->query($sql);

$months = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $amounts[] = $row['amt'];
}

// Encode data as JSON
$months_json = json_encode($months);
$amounts_json = json_encode($amounts);
?>
<!-- Sales by order chart code end -->

<!-- Customer orders by districts -->
<?php
$db = dbConn();
$sql_c_district = "SELECT Name as districts , COUNT(*) as count FROM districts d 
INNER JOIN customers c ON  c.DistrictId=d.Id 
GROUP by DistrictId
        ORDER BY Name";

$result_c_district = $db->query($sql_c_district);

$count = [];
$districts = [];

// array varables
while ($row_c_district = $result_c_district->fetch_assoc()) {
    $count[] = $row_c_district['count'];
    $districts[] = $row_c_district['districts'];
}

// Encode data as JSON (php varible->js varible)
$count_json = json_encode($count);
$district_json = json_encode($districts);
?>
<!-- Customer orders by districts -->


<!-- Sale Product by Categories -->
<?php
$db = dbConn();
$sql_category = "SELECT CategoryName as categories , COUNT(*) as count FROM categories c "
        . "INNER JOIN products p ON p.CategoryId=c.CategoryId GROUP by c.CategoryId ORDER BY c.CategoryName";

$result_category = $db->query($sql_category);

$count = [];
$categories = [];

// array varables
while ($row_category = $result_category->fetch_assoc()) {
    $count[] = $row_category['count'];
    $categories[] = $row_category['categories'];
}

// Encode data as JSON (php varible->js varible)
$count_json = json_encode($count);
$categories_json = json_encode($categories);
?>
<!-- Sale Product by Categories -->

<!-- Sale Product by Brands -->
<?php
$db = dbConn();
$sql_brand = "SELECT BrandName as brands , COUNT(*) as count FROM brands b "
        . "INNER JOIN products p ON p.BrandId=b.BrandId GROUP by b.BrandId ORDER BY b.BrandName";

$result_brand = $db->query($sql_brand);

$count = [];
$brands = [];

// array varables
while ($row_brand = $result_brand->fetch_assoc()) {
    $count[] = $row_brand['count'];
    $brands[] = $row_brand['brands'];
}

// Encode data as JSON (php varible->js varible)
$count_json = json_encode($count);
$brands_json = json_encode($brands);
?>
<!-- Sale Product by Brands -->



<!-- Sale Product by Brands chart script start-->
<script>
    $(document).ready(function () {
        var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
        var count = <?php echo $count_json; ?>;
        var brands = <?php echo $brands_json; ?>;

        function getRandomColor() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return 'rgba(' + r + ',' + g + ',' + b + ',0.9)';
        }

        // Generate dynamic colors for each segment
        var pieColors = brands.map(() => getRandomColor());

        var pieChartData = {
            labels: brands,
            datasets: [
                {
                    label: 'Sales Amount',
                    backgroundColor: pieColors, // Array of dynamically generated colors
                    borderColor: 'rgba(255,255,255,1)', // White border color
                    data: count
                }
            ]
        };

        var pieChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            }
        };

        // Create the chart
        new Chart(pieChartCanvas2, {
            type: 'pie',
            data: pieChartData,
            options: pieChartOptions
        });
    });
</script>
<!-- Sale Product by Brands chart script end-->

<!-- Sale Product by Categories chart script start-->
<script>
    $(document).ready(function () {
        var pieChartCanvas = $('#piechart').get(0).getContext('2d');
        var count = <?php echo $count_json; ?>;
        var categories = <?php echo $categories_json; ?>;

        function getRandomColor() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return 'rgba(' + r + ',' + g + ',' + b + ',0.9)';
        }

        // Generate dynamic colors for each segment
        var pieColors = categories.map(() => getRandomColor());

        var pieChartData = {
            labels: categories,
            datasets: [
                {
                    label: 'Sales Amount',
                    backgroundColor: pieColors, // Array of dynamically generated colors
                    borderColor: 'rgba(255,255,255,1)', // White border color
                    data: count
                }
            ]
        };

        var pieChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            }
        };

        // Create the chart
        new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieChartData,
            options: pieChartOptions
        });
    });
</script>
<!-- Sale Product by Categories chart script end-->


<!-- Customer orders by districts chart script start-->
<script>
    $(document).ready(function () {
        var barChartCanvas1 = $('#disChart').get(0).getContext('2d'); // canvas id
        var count = <?php echo $count_json; ?>;
        var disc = <?php echo $district_json; ?>;

        var barChartData = {
            labels: disc,
            datasets: [{
                    label: 'Customer Count',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: count,
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
                            display: true
                        }
                    }],
                yAxes: [{
                        ticks: {
                            beginAtZero: true, // Ensure the y-axis starts at zero
                            callback: function (value) {
                                return Number(value.toFixed(0));
                            } // Optional formatting for y-axis labels
                        },
                        gridLines: {
                            display: true
                        }
                    }]
            }
        };

        // Create the chart 
        new Chart(barChartCanvas1, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions,
            beginAtZero: true
        });
    });
</script>
<!-- Customer orders by districts chart script end-->



<!-- Sales by order chart script start -->
<script>
    $(document).ready(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var months = <?php echo $months_json; ?>;
        var amounts = <?php echo $amounts_json; ?>;

        var barChartData = {
            labels: months,
            datasets: [
                {
                    label: 'Sales Amount',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: amounts,
                    fill: false  // Ensure the area under the line is not filled
                }
            ]
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
            type: 'line',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>
<!-- Sales by order chart script end -->

<script>
    $(document).ready(function () {

// getNumberOfOrders();
        getNumberOfOrders();

        function getNumberOfOrders() {

            $.ajax({
                url: 'orders/getNumberOfOrders.php',
                type: 'GET',
                success: function (data) {
                    $("#NumberOfOrders").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
        // end function


// start play sound
        function playSound(url) {
            var audio = new Audio(url);//use to play js inbuilt function
            audio.play();
        }
        // end

        // start
        function checkForNewOrder() {
            $.ajax({
                url: 'orders/check_for_new_order.php', // Path to PHP file that checks for new orders
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // check new_order_flag==true
                    if (response.new_order_flag) {
                        // Play sound when a new order is detected
                        playSound('assets/mixkit-access-allowed-tone-2869.wav');
                    }
                    $("#NumberOfOrders").html(response.nooforders);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });
        }
        // end


// dynamicaly update the orders

        setInterval(checkForNewOrder, 5000);


    });


// get employee count
    function getNumberOfEmployees() {

        $.ajax({
            url: 'employees/getNumberOfEmployees.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfEmployee").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfEmployees();
// end function



// get customer count
    function getNumberOfCustomers() {

        $.ajax({
            url: 'customers/getNumberOfCustomers.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfCustomers").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfCustomers();
// end function


// Get products count
    function getTotalNumberOfProducts() {

        $.ajax({
            url: 'products/getNumberOfProducts.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfProducts").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getTotalNumberOfProducts();
// end function

// Get messages count
    function getTotalNumberOfMessages() {

        $.ajax({
            url: 'messages/getNumberOfMessages.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfMessages").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getTotalNumberOfMessages();
// end function


// get user count
    function getNumberOfUsers() {

        $.ajax({
            url: 'users/getNumberOfUsers.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfUsers").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfUsers();
// end function


// get user count
    function getNumberOfRoles() {

        $.ajax({
            url: 'users/getNumberOfRoles.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfRoles").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfRoles();
// end function


 //Number of accepted orders
function getNumberOfAcceptedOrders() {

        $.ajax({
            url: 'orderIssue/getNumberOfAcceptedOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfAcceptedOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfAcceptedOrders();
    
     //Number of processing orders
    function getNumberOfProcessingOrders() {

        $.ajax({
            url: 'orderIssue/getNumberOfProcessingOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfProcessingOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfProcessingOrders();

 //Number of packed orders
    function getNumberOfPackedOrders() {

        $.ajax({
            url: 'orderIssue/getNumberOfPackedOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfPackedOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfPackedOrders();
    
    //Number of ready to delivery orders
    function getNumberOfReadytoDeliveryOrders() {

        $.ajax({
            url: 'delivery/getNumberOfReadytoDeliveryOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfReadytoDeliveryOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfReadytoDeliveryOrders();
    
    
    //Number of shipping orders
    function getNumberOfShippingOrders() {

        $.ajax({
            url: 'delivery/getNumberOfShippingOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfShippingOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfShippingOrders();
    
    //Number of delivered orders
    function getNumberOfDeliveredOrders() {

        $.ajax({
            url: 'delivery/getNumberOfDeliveredOrders.php',
            type: 'GET',
            success: function (data) {
                $("#NumberOfDeliveredOrders").html(data);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    getNumberOfDeliveredOrders();


</script>