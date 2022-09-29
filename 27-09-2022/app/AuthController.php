<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'access':
        $authController = new AuthController;
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $authController->login($email,$password); break;
    default:
        // code...
        break;
    }
}

class AuthController {
    public function login($email, $password) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $email,'password' => $password),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if (isset ($response->code) && $response->code > 0){
            session_start();
            $_SESSION['name'] = $response->data->name;
            $_SESSION['lastname'] = $response->data->lastname;
            $_SESSION['avatar'] = $response->data->avatar;
            $_SESSION['token'] = $response->data->token;
            header("Location:./../products/index.php");
        } else{
            header("Location:../?error=true");
        }
    }

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
}
?>