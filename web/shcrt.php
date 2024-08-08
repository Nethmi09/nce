<!--Profit-->

<div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Profit</h5>
                            <div class="">
                                <p class="mb-0"> LKR 
                                    <?php
                                    echo $profitt = number_format($profit, 2);
                                    $_SESSION['profit'] = $profit;

                                    $_SESSION['quantity'] = $noproducts;
                                    ?>
                                </p>
                            </div>
                        </div>


<!--Checkhout page display details-->
 <?php
        echo $grandTotal = $_SESSION['grand_total'];
        echo '<br>';
        echo $disCount = $_SESSION['discount'];
        echo '<br>';
        echo $proFit = $_SESSION['profit'];
        echo '<br>';
        echo $quanTity = $_SESSION['quantity'];
        ?>