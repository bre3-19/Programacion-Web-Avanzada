<html lang="en" dir="ltr">
    <head>
        <?php include "./../layouts/head.template.php"; ?>
        <?php include "../app/ProductController.php"; ?>
        <?php include "../app/BrandController.php"; ?>
    </head>
    <body>
        <?php include_once "../app/config.php";
        $prodController = new ProductController();
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
                            <button class="btn btn-info float-end mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" name="button" onclick='add()'>Añadir producto</button>
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
                                    <?php if(isset($prod['brand'])) {
                                        echo $prod['brand']['name'];
                                    } else
                                        echo "No Brand"; ?>
                                    </h6>
                                    <p class="card-text"><?php echo $prod["description"]; ?></p>
                                    <div class="row">
                                        <a href="#" data-product='<?php echo json_encode($prod)?>' class="btn btn-warning col-md-6" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick='edit(this)'>Editar</a>
                                        <a href="#" class="btn btn-danger col-md-6" onclick="remove(<?= $prod['id']?>)">Eliminar</a>
                                    </div>
                                    <div class="row">
                                        <a href="./detalles.php?<?php echo "slug=", $prod["slug"]?>" class="btn btn-info col-md-12">Detalles</a>
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
                                        <input type="hidden" name="global_token" value="<?php echo $_SESSION['global_token']?>">
                                        <input type="hidden" name="id" id="id" value="">
                                        <input type="hidden" id="action" name="action" value="create">
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
        function add() {
            document.getElementById('exampleModalLabel').innerText = 'Agregar producto';
            document.getElementById('action').value = "create";
        }

        function edit(target) {
            document.getElementById('exampleModalLabel').innerText = 'Editar producto';
            document.getElementById('action').value = "edit";

            const prod = JSON.parse(target.getAttribute('data-product'));

            document.getElementById('name').value = prod.name;
            document.getElementById('slug').value = prod.slug;
            document.getElementById('description').value = prod.description;
            document.getElementById('features').value = prod.features;
            document.getElementById('brand_id').value = prod.brand_id;
            document.getElementById('id').value = prod.id;
        }

        function remove(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    let data = new FormData();
                    data.append("id", id);
                    data.append("action", "delete");
                    data.append("global_token", '<?php echo $_SESSION["global_token"] ?>');
                    axios.post('../app/ProductController.php', data)
                    .then(function (response) {
                        location.reload();
                    })
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        }
        </script>
    </body>
</html>