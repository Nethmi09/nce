

                    <div class="col md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Payment History</h3>
                            </div>

                            <div class="card-body">

                                <?php
                                extract($_POST);
                                extract($_GET);
                                $db = dbConn();
                                
                                $sql_orders = "SELECT o.OrderNumber,o.GrandTOTAL, o.Discount,o.NetTotal,o.DeliveryCost,o.TotalAmount, c.PaidAmount FROM orders o INNER JOIN customer_payments c ON c.OrderId=o.OrderId WHERE o.OrderId='$order_id'";
                                $result_orders = $db->query($sql_orders);
                                $roworders = $result_orders->fetch_assoc();
                                
                                $order_number = $roworders['OrderNumber'];
                                $product_total = $roworders['GrandTOTAL'];
                                $discount = $roworders['Discount'];
                                $net_amount = $roworders['NetTotal'];
                                $delivery_charge = $roworders['DeliveryCost'];
                                $total_amount = $roworders['TotalAmount'];
                                
                                
                                $pay_amount = $roworders['PaidAmount'];
                                ?>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Order Number</th>
                                                <td><?= $order_number ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Products Total</th>
                                                <td><?= $product_total ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Discount</th>
                                                <td>Rs. <?= number_format($discount, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Net Amount</th>
                                                <td>Rs. <?= number_format($net_amount, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery Charge</th>
                                                <td>Rs. <?= number_format($delivery_charge, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total Amount</th>
                                                <td>Rs. <?= number_format($total_amount, 2) ?></td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Paid Amount</th>
                                                <td>Rs. <?= number_format($pay_amount, 2) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="submit" action="submit" value="Confirm Payment" class="btn btn-success">
                                </form>

                            </div>

                        </div>
                    </div>