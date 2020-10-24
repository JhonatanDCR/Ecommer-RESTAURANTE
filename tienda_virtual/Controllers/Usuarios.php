<?php
    class Usuarios extends Controllers{

        public function __construct()
        {
            parent::__construct();

        }
        public function usuarios()//para la pagina web
        {   
            //$data['page_id'] = 1;
            $data['page_tag']="Usuarios";
            $data['page_title']="Usuarios <small>Tienda Virtual</small>";
            $data['page_name']="usuarios";
            $this->views->getView($this,"usuarios",$data);
        }
        
        public function setUsuario(){
            //dep($_POST);
            if($_POST){
                echo $_POST['txtDNI'];
                dep($_POST);
                die();
                if(empty($_POST['txtDNI']) || empty($_POST['txtNombres']) || empty($_POST['txtApPaterno']) ||
                    empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtPassword']))
                {
                    $arrResponse = array("estado" => false, "msg" => 'Datos incorrectos.');
                }else{
                    $strDNI = strClean($_POST['txtDNI']);
                    $strNombres = ucwords(strClean($_POST['txtNombres']));
                    $strApPaterno = ucwords(strClean($_POST['txtApPaterno']));
                    $strApMaterno = ucwords(strClean($_POST['txtApMaterno']));
                    $strDireccion = strClean($_POST['txtDireccion']);
                    $strTelefono = strClean($_POST['txtTelefono']);
                    $strPassword = strClean($_POST['txtPassword']);
                    //https://youtu.be/yloI2aEnn3k?list=PL3b9xmg86NTKWP3Xzu-1DCwaeO5sftK4V&t=332

                    $request_usuario = $this->model->insertUsuario($strDNI, $strNombres, $strApPaterno, $strApMaterno, $strDireccion, $strTelefono, $strPassword);

                    if($strDNI =="")
                    {
                        $option = 1;
                    }else{
                        $option = 2;
                    }

                    if($request_usuario >= 0)
                    {
                        if($option == 1)
                        {
                            $arrResponse = array('estado' => true, 'msg' => 'Datos guardados correctamente.');
                        }else{
                            $arrResponse = array('estado' => true, 'msg' => 'Datos guardados correctamente.');
                        }
                        
                    }else if($request_usuario == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => '!Atención¡ El DNI ya existe, ingrese otro.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            

            /* $intIdproducto = intval($_POST['IDProducto']);
            $strNombre = strClean($_POST['txtNombre']);
            $dblPrecio = floatval($_POST['txtPrecio']);
            $intStock = intval($_POST['txtStock']);
            $intCategoria = intval($_POST['listCategoria']);

            if($intIdproducto == 0)
            {
                //crea
                $request_producto = $this->model->insertProducto($strNombre, $dblPrecio, $intStock, $intCategoria);
                $option = 1;
            }else{
                //actualiza
                $request_producto = $this->model->updateProducto($intIdproducto, $strNombre, $dblPrecio, $intStock, $intCategoria);
                $option = 2;
            }

            if($request_producto > 0)
            {
                if($option == 1)
                {
                    $arrResponse = array('estado' => true, 'msg' => 'Datos guardados correctamente.');
                }else{
                    $arrResponse = array('estado' => true, 'msg' => 'Datos actualizados correctamente.');
                }
                
            }else if($request_producto == 'exist'){
                $arrResponse = array('status' => false, 'msg' => '!Atención¡ El Producto ya existe.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); */
            die();
        }

        public function getUsuarios()
        {
            $arrData = $this->model->selectUsuarios();
            //dep($arrData);
            
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['estado'] == 1)
                {
                    $arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                $arrData[$i]['opciones'] = '<div class="text-center">
                    <button class="btn btn-secondary btn-sm btnEditUsuario" us="'.$arrData[$i]['DNI'].'" title="Editar"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-sm btnDelUsuario" us="'.$arrData[$i]['DNI'].'" title="Eliminar"><i class="fa fa-trash"></i></button>
                </div>';
            }

            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getUsuario(int $dni)
        {
            $strdni = strClean($dni);
            if($strdni > 0)
            {
                $arrData = $this->model->selectUsuario($strdni);
                if(empty($arrData))
                {
                    $arrResponse = array('estado' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    $arrResponse = array('estado' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delUsuario()
        {
            if($_POST){
                $strDNI = strClean($_POST['DNI']);
                $requestDelete = $this->model->deleteUsuario($strDNI);
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
                //}else if($requestDelete == 'exist'){
                    //$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el Usuario.'); //para evitar eliminar si otros elementos dependen de este
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>