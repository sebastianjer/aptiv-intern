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
        <title>APTIV Warehouse System - Material In</title>
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
                        <h1 class="mt-4">Material In</h1>
                        
                        
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- <i class="fas fa-table mr-1"></i> -->
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Material In
                                </button>
                                <a href="export-masuk.php" class="btn btn-info">Export Table</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID Masuk</th>
                                                <th>Nama Material</th>
                                                <th>Total Box (In)</th>
                                                <th>Week</th>
                                                <th>Timestamp</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                            <?php
                                                $get_masuk = mysqli_query($conn, "SELECT * FROM material_in, material WHERE material.material_id = material_in.material_id");
                                                while ($data = mysqli_fetch_array($get_masuk)) {
                                                    $masuk_id = $data['masuk_id'];
                                                    $material_id = $data['material_id'];
                                                    $description = $data['description'];
                                                    $total_box_in = $data['total_box_in'];
                                                    $week = $data['week'];
                                                    $timestamp = $data['timestamp'];
                                            ?>
                                        
                                            <tr>
                                                <td><?=$masuk_id;?></td>
                                                <td><?=$description;?></td>
                                                <td><?=$total_box_in;?></td>
                                                <td><?=$week;?></td>
                                                <td><?=$timestamp;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$masuk_id;?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="id_masuk_dihapus" value="<?=$masuk_id;?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$masuk_id;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$masuk_id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Material In</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="masuk_id" value="<?=$masuk_id?>">
                                                                <input type="hidden" name="material_id" value="<?=$material_id?>">
                                                                <label class="small mb-1">Description</label>
                                                                <input type="text" name="description" value="<?=$description?>" class="form-control" required>
                                                                <br>
                                                                <label class="small mb-1">Total Box (In)</label>
                                                                <input type="number" name="total_box_in" value="<?=$total_box_in?>" class="form-control" required>
                                                                <br>
                                                                <label class="small mb-1">Week</label>
                                                                <input type="number" name="week" value="<?=$week?>" class="form-control" required>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary" name="edit_material_in">Submit</button>
                                                            </div>
                                                        </form>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$masuk_id;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Material In</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?=$material_id?> - <?=$description?>?
                                                                <input type="hidden" name="masuk_id" value="<?=$masuk_id?>">
                                                                <input type="hidden" name="material_id" value="<?=$material_id?>">
                                                                <input type="hidden" name="total_box_in" value="<?=$total_box_in?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="delete_material_in">Hapus</button>
                                                            </div>
                                                        </form>
                                                    
                                                    </div>
                                                </div>
                                            </div>

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
                            <div class="text-muted">Copyright &copy; www.linkedin.com/in/sebastian-jeremiah</div>
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
                    <h4 class="modal-title">Input Material In</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        
                        <select name="material_id" class="form-control">
                            <?php
                                $data_material = mysqli_query($conn, "SELECT * FROM material");
                                while ($fetcharray = mysqli_fetch_array($data_material)) {
                                    $desc_material = $fetcharray['description'];
                                    $material_id = $fetcharray['material_id'];
                            ?>

                            <option value="<?=$material_id;?>"> <?=$material_id;?> - <?=$desc_material?> </option>
                            
                            <?php
                                }
                            ?>
                        </select>
                        
                        <br>
                        <input type="number" name="total_box_in" placeholder="Total Box (In)" class="form-control" required>
                        <br>
                        <input type="number" name="week" placeholder="Week" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="add_material_in">Submit</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

</html>
