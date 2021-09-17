<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
?>
<html>
    <head>
        <title>Goods</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    </head>
    <body>
        <div class="container">
			<h2>Pengiriman Goods</h2>
			<h4>(Beserta Status)</h4>
				<div class="data-tables datatable-dark">
					
					<!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table class="table table-bordered" id="export_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Supplier (Vendor)</th>
                                <th>AWB Number</th>
                                <th>ASN</th>
                                <th>PL</th>
                                <th>AWB</th>
                                <th>Logistic Partner</th>
                                <th>ETA</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php
                                $get_goods = mysqli_query($conn, "SELECT * FROM goods, vendor WHERE vendor.vendor_id = goods.vendor_id");
                                while ($data = mysqli_fetch_array($get_goods)) {
                                    $goods_id = $data['goods_id'];
                                    $vendor_id = $data['vendor_id'];
                                    $vendor_name = $data['vendor_name'];
                                    $asn_name = $data['asn_name'];
                                    $pl_name = $data['pl_name'];
                                    $awb_name = $data['awb_name'];
                                    $log_partner = $data['log_partner'];
                                    $eta = $data['ETA'];
                                    $status = $data['status'];
                            ?>
                        
                            <tr>
                                <td><?=$vendor_name;?></td>
                                <td><?=$goods_id;?></td>
                                <td>
                                    <a href="download.php?path=<?=$asn_name;?>" download>
                                    <?=$asn_name;?>
                                </td>
                                <td>
                                    <a href="download.php?path=<?=$pl_name;?>" download>
                                    <?=$pl_name;?>
                                </td>
                                <td>
                                    <a href="download.php?path=<?=$awb_name;?>" download>
                                    <?=$awb_name;?>
                                </td>
                                <td><?=$log_partner;?></td>
                                <td><?=$eta;?></td>
                                <td><?=$status;?></td>
                            </tr>
                            
                            <?php
                                }
                            ?>

                        </tbody>
                    </table>
				</div>
        </div>
	
        <script>
            $(document).ready(function() {
                $('#export_table').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy','csv','excel', 'pdf', 'print'
                    ]
                });
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	</body>

</html>