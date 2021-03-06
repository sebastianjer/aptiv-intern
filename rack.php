<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>APTIV Warehouse System - Rack Status</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">APTIV Warehouse</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form> -->
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="upload-goods.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                                Upload Goods
                            </a>
                            <a class="nav-link" href="track-goods.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Track Goods
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                                Stock Material
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly"></i></div>
                                Material In
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck-loading"></i></div>
                                Material Out
                            </a>
                            <a class="nav-link" href="rack.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                                Rack Status
                            </a>


                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Rack Status</h1>
                        
                        
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- <i class="fas fa-table mr-1"></i> -->
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Input Material
                                </button>
                                <a href="export-barang.php" class="btn btn-info">Export Table</a>
                            </div>
                            <div class="card-body">

                                <?php
                                    $get_material_habis = mysqli_query($conn, "SELECT * FROM material WHERE total_box < 1");
                                    while ($data = mysqli_fetch_array($get_material_habis)) {
                                        $desc_material_habis = $data['description'];
                                    
                                ?>

                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stock <strong><?=$desc_material_habis;?></strong> telah habis.
                                </div>
                                    
                                <?php
                                    }
                                ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID Material</th>
                                                <th>Deskripsi</th>
                                                <th>Nama Vendor</th>
                                                <th>SNP</th>
                                                <th>Total Box</th>
                                                <!-- <th>Actions</th> -->
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
                                                <!-- <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$material_id;?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="id_material_dihapus" value="<?=$material_id;?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$material_id;?>">
                                                        Delete
                                                    </button>
                                                </td> -->
                                            </tr>
                                                
                                            <!-- Edit Modal -->
                                            <!-- <div class="modal fade" id="edit<?=$material_id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content"> -->
                                                
                                                        <!-- Modal Header -->
                                                        <!-- <div class="modal-header">
                                                            <h4 class="modal-title">Edit Material</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div> -->
                                                    
                                                        <!-- Modal body -->
                                                        <!-- <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="material_id" value="<?=$material_id?>">
                                                                <input type="hidden" name="vendor_id" value="<?=$vendor_id?>">
                                                                <label class="small mb-1">Description</label>
                                                                <input type="text" name="description" value="<?=$description?>" class="form-control" required>
                                                                <br>
                                                                <label class="small mb-1">SNP</label>
                                                                <input type="number" name="snp" value="<?=$snp?>" class="form-control" required>
                                                                <br>
                                                                <label class="small mb-1">Total Box</label>
                                                                <input type="number" name="total_box" value="<?=$total_box?>" class="form-control" required>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary" name="edit_material">Submit</button>
                                                            </div>
                                                        </form>
                                                    
                                                    </div>
                                                </div>
                                            </div> -->
                                            
                                            <!-- Delete Modal -->
                                            <!-- <div class="modal fade" id="delete<?=$material_id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content"> -->
                                                
                                                        <!-- Modal Header -->
                                                        <!-- <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Material</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div> -->
                                                    
                                                        <!-- Modal body -->
                                                        <!-- <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?=$material_id?> - <?=$description?>?
                                                                <input type="hidden" name="material_id" value="<?=$material_id?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="delete_material">Hapus</button>
                                                            </div>
                                                        </form>
                                                    
                                                    </div>
                                                </div>
                                            </div> -->
                                            
                                            <?php
                                                }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Input Material Baru</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="number" name="material_id" placeholder="Material ID" class="form-control" required>
                        <br>
                        <input type="text" name="description" placeholder="Description" class="form-control" required>
                        <br>
                        <input type="number" name="vendor_id" placeholder="Vendor ID" class="form-control" required>
                        <br>
                        <input type="number" name="snp" placeholder="SNP" class="form-control" required>
                        <br>
                        <input type="number" name="total_box" placeholder="Total Box" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="add_material">Submit</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

</html>