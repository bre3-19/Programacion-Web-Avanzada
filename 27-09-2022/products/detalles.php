<html lang="en" dir="ltr">
    <head>
        <?php include "./../layouts/head.template.php"; ?>
        <?php include "../app/ProductController.php"; ?>
    </head>

    <body>
        <?php $prodController = new ProductController();
        $prods = $prodController->getProducts();
        if(isset($_GET["slug"])) {
            foreach($prods as $prod) {
                if($prod["slug"] == $_GET["slug"]) {
                    $prod = $prodController->getProduct($prod['id']);
                    break;
                }
            }
        } else {
            header('Location: index.php?error=true');
        }?>

        <!-- navbar -->
        <?php include "./../layouts/nav.template.php"; ?>
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <?php include "./../layouts/sidebar.template.php"; ?>

                <!-- breadcrumb -->
                <div class="col-lg-10 col-sm-12">
                    <div class="row m-2 border-bottom">
                        <div class="col">
                            <span>Detalle <?php echo $prod["name"] ?></span>
                        </div>
                        <div class="col">
                            <button class="btn btn-info float-end mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" name="button">Añadir producto</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 p-2">
                            <div class="card" style="width: 18rem;">
                                <img src=<?php echo $prod["cover"]?> class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $prod["name"]; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <p class="card-text"><?php echo $prod["description"]; ?></p>
                                        <p>Brand: 
                                        <?php if(isset($prod['brand'])) {
                                            echo $prod['brand']['name'];
                                        } else
                                            echo "No Brand"; ?></p>

                                        <p>Categories: 
                                        <?php $catArray = array();
                                        if(isset($prod['categories'])) {
                                            foreach($prod['categories'] as $cat)
                                                array_push($catArray, $cat['name']);
                                            echo implode( ', ', $catArray ); 
                                        } else
                                            echo "No categories"; ?></p>

                                        <p>Tags: 
                                        <?php $tagArray = array();
                                        if(isset($prod['tags'])) {
                                            foreach($prod['tags'] as $tag)
                                                array_push($tagArray, $tag['name']);
                                            echo implode( ', ', $tagArray );
                                        } else
                                            echo "No tags"; ?></p>
                                    </h6>
                                    <div class="row">
                                        <a href="#" class="btn btn-warning col-md-6" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</a>
                                        <a href="#" class="btn btn-danger col-md-6" onclick="remove(this)">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "./../layouts/scripts.template.php"; ?>

        <script type="text/javascript">
        function remove(target){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        }
        </script>
    </body>
</html>