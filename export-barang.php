<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
?>
<html>
    <head>
        <title>Stock Material</title>
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
			<h2>Stock Material</h2>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">
					
					<!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table class="table table-bordered" id="export_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Material</th>
                                <th>Deskripsi</th>
                                <th>Nama Vendor</th>
                                <th>SNP</th>
                                <th>Total Box</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php
                                $get_material = mysqli_query($conn, "SELECT * FROM material, vendor WHERE vendor.vendor_id = material.vendor_id");
                                while ($data = mysqli_fetch_array($get_material)) {
                                    $material_id = $data['material_id'];
                                    $description = $data['description'];
                                    $vendor_id = $data['vendor_id'];
                                    $vendor_name = $data['vendor_name'];
                                    $snp = $data['snp'];
                                    $total_box = $data['total_box'];
                            ?>
                        
                            <tr>
                                <td><?=$material_id;?></td>
                                <td><?=$description;?></td>
                                <td><?=$vendor_name;?></td>
                                <td><?=$snp;?></td>
                                <td><?=$total_box;?></td>
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