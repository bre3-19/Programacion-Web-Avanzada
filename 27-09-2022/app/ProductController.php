<?php
include_once "config.php";

if(isset($_POST["action"])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']) {
        $name = strip_tags($_POST["name"]);
                $slug = strip_tags($_POST["slug"]);
                $description = strip_tags($_POST["description"]);
                $features = strip_tags($_POST["features"]);
                $brand_id = strip_tags($_POST["brand_id"]);

                $productController = new ProductController();

        switch ($_POST["action"]) {
            case 'create':
                $productController->storeProduct($name, $slug, $description, $features, $brand_id);
                break;
            case 'edit':
                $id = strip_tags($_POST["id"]);
                $productController->updateProduct($id, $name, $slug, $description, $features, $brand_id);
                break;
            case 'delete':
                $productController->deleteProduct($_POST["id"]);
                break;
            default:
                # code...
                break;
        }
    }
}
class ProductController {
    public function getProducts(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].''
        ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);
        $response = json_decode($response, true);
        
        return $response["data"];
    }

    public function getProduct($id){
        $curl = curl_init();
        $_SESSION['prodId'] = $id;

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].''
        ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);
        $response = json_decode($response, true);
        
        return $response["data"];
    }

    public function storeProduct($name, $slug, $description, $features, $brand_id){
        if(!isset($_FILES["cover"]) || ($_FILES["cover"]["error"] > 0)) {
            header("Location:".BASE_PATH."/products?error=true");
        }

        $image = $_FILES["cover"]["tmp_name"];
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('name' => $name,'slug' => $slug,'description' => $description,'features' => $features,'brand_id' => $brand_id, 'cover' => new CURLFILE($image)),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].''
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // $response = json_decode($response);
        // var_dump($response);
        if($response->code == 4){
            header("Location:".BASE_PATH."products?success=true");
        }else{
            header("Location:".BASE_PATH."products?error=?");
        }
    }

    public function updateProduct($id, $name, $slug, $description, $features, $brand_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS => 'id='.$id.'&name='.$name.'&slug='.$slug.'&description='.$description.'&features='.$features.'&brand_id='.$brand_id,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].'',
            'Content-Type: application/x-www-form-urlencoded',
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        // var_dump($response);
        if($response->code == 4){
            header("Location:".BASE_PATH."/products?success=true");
        }else{
            header("Location:".BASE_PATH."/products?error=?");
        }
    }

    public function deleteProduct($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].'',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }
} ?>