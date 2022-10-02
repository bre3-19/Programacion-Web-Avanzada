<?php
session_start();

if(isset($_POST["action"])){
    switch ($_POST["action"]) {
        case 'create':
            $name = strip_tags($_POST["name"]);
            $slug = strip_tags($_POST["slug"]);
            $description = strip_tags($_POST["description"]);
            $features = strip_tags($_POST["features"]);
            $brand_id = strip_tags($_POST["brand_id"]);

            $productController = new ProductController();
            $productController->storeProduct($name, $slug, $description, $features, $brand_id);
            break;
        default:
            # code...
            break;
    }
}
class ProductController {
    public function getProducts(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token'].'',
            'Cookie: XSRF-TOKEN=eyJpdiI6IlFMSFRaYkZrdlVkdklaNmdSNVlFRWc9PSIsInZhbHVlIjoiZHJHelhnUU9IRFRZQ2hva3dqNVRxd2xqYWhUOGREQ0hScDRaekx1YkVtRWJuN29ZenZoMktyMUJuUEl2b3lsZzk0TC92NDZUNnorekE5NnY1T0VabXVYL1RianlRVk1FanpRT0g5ZmE5TE9lcFFwNTUyU2xtKzE4cElGSWFtM0ciLCJtYWMiOiI0NzZkNzI4N2UxNjYwZDJjZmQwODBkMDhmN2EzNzUxYjM1NWY0OWJlNmU5NWZmNjFjNWIyNzRhZDExYjc2OTIwIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IjNQN2NvVzczOElybDUxc0lONmcrSFE9PSIsInZhbHVlIjoieDlWaGduR0ZPVHhVb3Q3ZUhsbDRnVE5JbTlpSUlKaU1MejFjSGNjcTBaMFcvelhqa2VLWTZrdXhzbmE1RFBRejkvYVV5akFGdGVHVnE4R2tzYklYekc5dXN3dHdoTTF6S0pCTVhxeW9oOUQxakdHSGlobVNOSUpMMWdKM1ZQbkoiLCJtYWMiOiJkNTlkYWFjNjU1MTBlZmFkN2Q0YzhmMmFhNjlmZWFhOGJmMTIyMTdiZTAzYzJhNTYxZGExYzdiY2ZkOWVhMzU2IiwidGFnIjoiIn0%3D'
        ),
        ));

        $response = curl_exec($curl);
        
        curl_close($curl);
        $response = json_decode($response, true);
        
        return $response["data"];
    }

    public function storeProduct($name, $slug, $description, $features, $brand_id){
        if(!isset($_FILES["cover"]) || ($_FILES["cover"]["error"] > 0)) {
            header("Location: ../products?error=true");
        }

        $image = $_FILES["cover"]["tmp_name"];
        $token = strip_tags($_SESSION["token"]);
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
            'Authorization: Bearer '.$token
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // $response = json_decode($response);
        // var_dump($response);
        if($response->code == 4){
            header("Location: ../products?success=true");
        }else{
            header("Location: ../products?error=?");
        }

    }
} ?>