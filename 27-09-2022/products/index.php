<html lang="en" dir="ltr">
    <head>
        <?php include  "./../layouts/head.template.php"; ?>
        <?php include "../app/ProductController.php"; ?>
        <?php include "../app/BrandController.php"; ?>
    </head>
    <body>
        <?php $prodController = new ProductController();
        $prods = $prodController->getProducts();
        $brandController = new BrandController();
        $brands = $brandController->getBrands(); ?>

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
                            <span>Productos</span>
                        </div>
                        <div class="col">
                            <button class="btn btn-info float-end mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" name="button">Añadir producto</button>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach($prods as $prod): ?>
                        <div class="col-md-3 p-2">
                            <div class="card" style="width: 18rem;">
                                <img src="<?php echo $prod["cover"]; ?>" class="card-img-top" width="100" height="250" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $prod["name"]; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <?php if(isset($prod["tags"])){
                                            reset($prod["tags"]); 
                                            if(isset($prod["tags"][key($prod["tags"])]["name"]))
                                                echo $prod["tags"][key($prod["tags"])]["name"]; 
                                        } ?>
                                    </h6>
                                    <p class="card-text"><?php echo $prod["description"]; ?></p>
                                    <div class="row">
                                        <a href="#" class="btn btn-warning col-md-6" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</a>
                                        <a href="#" class="btn btn-danger col-md-6" onclick="remove(this)">Eliminar</a>
                                    </div>
                                    <div class="row">
                                        <a href="./detalles.php" class="btn btn-info col-md-12">Detalles</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="../app/ProductController.php" method="POST" id="setForm" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre del producto" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <input type="text" id="slug" name="slug" class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <!--<input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" aria-label="Username" aria-describedby="basic-addon1">-->
                                            <textarea form ="setForm" name="description" id="description" class="form-control" placeholder="Descripción" cols="35" wrap="soft"></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <!--<input type="text" id="features" name="features" class="form-control" placeholder="Features" aria-label="Username" aria-describedby="basic-addon1">-->
                                            <textarea form ="setForm" name="features" id="features" class="form-control" placeholder="Features" cols="35" wrap="soft"></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <!--<input type="text" id="brand_id" name="brand_id" class="form-control" placeholder="Brand" aria-label="Username" aria-describedby="basic-addon1">-->
                                            <select id="brand_id" name="brand_id" class="form-control"aria-label="Username" aria-describedby="basic-addon1">
                                                <option value="" selected disabled hidden> Seleccione una Brand </option>
                                                <?php foreach($brands as $brand): ?>
                                                    <option value="<?php echo $brand["id"] ?>"> <?php echo $brand["name"] ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <input type="file" id="cover" name="cover" class="form-control" accept="image/*" data-max-size="1920000" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="action" value="create">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
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