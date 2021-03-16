<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
use App\Models\LogsModel;


class Usuarios extends BaseController
{
    protected $usuarios, $cajas, $roles,$logs;
    protected $reglas;
    protected $reglasLogin;
    protected $reglasCambia,$reglas_editar;
    public  function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();
        $this->logs = new LogsModel();
        helper(['form']);

        // aca lo que se hace es que  se le da la regla del campo y despues en errors se le da el mensaje que aparece en pantalla 
        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'is_unique' => 'El campo {field} debe ser unico'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'matches' => 'Las contraseñas no coinciden.'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'id_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ]

        ];
        $this->reglas_editar = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'is_unique' => 'El campo {field} debe ser unico'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'id_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ]

        ];


        $this->reglasLogin = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]
        ];
        $this->reglasCambia = [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',

                ]
            ],
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'matches' => 'Las contraseñas no coinciden.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        // array de datos que se le envia a la vista 
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/usuarios', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {

        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        // array de datos que se le envia a la vista 
        $data = ['titulo' => 'Usuarios Eliminados', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        // asi se hace una colsulta simplemente se pone la restricion, para ver mas variables de 'findAll()' ver la documentacion 
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();

        $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles];

        echo view('header');
        echo view('usuarios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        // aca es como se validad que los campos esten llenos desde php (mirar la documentacion para mas informacion)
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {


            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);



            // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
            $this->usuarios->save([
                'usuario' => $this->request->getPost('usuario'),
                'password' => $hash,
                'nombre' => $this->request->getPost('nombre'),
                'id_caja' => $this->request->getPost('id_caja'),
                'id_rol' => $this->request->getPost('id_rol'),
                'activo' => 1
            ]);
            return redirect()->to(base_url() . '/usuarios');
        } else {
            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            //esto devuelve las validaciones que no se cumplieron
            $data = ['titulo' => 'Agregar unidad', 'validation' => $this->validator, 'cajas' => $cajas, 'roles' => $roles];
            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        // aca se valida  las reglas para para que todo es correctamente
        $usuario= $this->usuarios->where('id',$id)->first();
        $cajas = $this->cajas->where('activo', 1)->findAll();
        $roles = $this->roles->where('activo', 1)->findAll();
        
        if ($valid != null) {
            $data = ['titulo' => 'Editar usuario', 'cajas' => $cajas,'roles'=>$roles,'usuario'=>$usuario, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Editar usuario','cajas'=>$cajas,'roles'=>$roles,'usuario'=>$usuario];
        }


        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        if ($this->request->getMethod() == "post"  && $this->validate($this->reglas_editar)) {
            $this->usuarios->update($this->request->getPost('id'),
            ['nombre' => $this->request->getPost('nombre'), 
            'usuario' =>$this->request->getPost('usuario'),
            'id_rol'=>$this->request->getPost('id_rol'),
            'id_caja'=>$this->request->getPost('id_caja')
            ]); 

            return redirect()->to(base_url() . '/usuarios');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }
    // cuando una variable no se manda por pos y se manda por get se puede poner como parametro que lo recibe 
    public function eliminar($id)
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->usuarios->update($id, ['activo' => 0]);

        return redirect()->to(base_url() . '/usuarios');
    }




    public function reingresar($id)
    {
        // esto se usa para actualizar el primer campo es el elemento al cual se va a actualizar en esta caso el id , lo de mas son los campos que van a hacer actualizados 
        $this->usuarios->update($id, ['activo' => 1]);

        return redirect()->to(base_url() . '/usuarios');
    }



    
    public function login()
    {   
        
       echo view('login');
    }





    public function valida()
    {

        if ($this->request->getMethod() == "post" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

            if ($datosUsuario != null) {
                // aca se verifican las dos contraseñas , que viene en texto plano y la que esta cifrada en BD
                if (password_verify($password, $datosUsuario['password'])) {

                    $datosSesion = [
                        'id' => $datosUsuario['id'],
                        'nombre' => $datosUsuario['nombre'],
                        'id_caja' => $datosUsuario['id_caja'],
                        'id_rol' => $datosUsuario['id_rol']

                    ];
                    // aca consigo la ip 
                    $ip=$_SERVER['REMOTE_ADDR'];
                    // este me permite saber que navegador se esta usuando 
                    $detalles = $_SERVER['HTTP_USER_AGENT'];
                    $this->logs->save([
                      'id_usuario'=>$datosUsuario['id'],
                      'evento'=>'Inicio de seccion ',
                      
                      'ip'=>$ip,
                      'detalles'=>$detalles,

                    ]);
                        // aca creamos la session de la session del usuario
                    $session = session();
                    $session->set($datosSesion);
                    return redirect()->to(base_url() . '/inicio');
                } else {
                    $data['error'] = "contraseña incorrecta";
                    echo view('login', $data);
                }
            } else {
                $data['error'] = 'El usuario no existe';
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];
            echo view('login', $data);
        }
    }






    public function logout()
    {
        $session = session();
        $ip=$_SERVER['REMOTE_ADDR'];
        // este me permite saber que navegador se esta usuando 
        $detalles = $_SERVER['HTTP_USER_AGENT'];
        $this->logs->save([
          'id_usuario'=>$session->id,
          'evento'=>'Cierre de seccion ',
          
          'ip'=>$ip,
          'detalles'=>$detalles,

        ]);
       
        $session->destroy();
        return redirect()->to(base_url());
    }




    

    public function cambiar_password()
    {

        $session = session();
        $usuario = $this->usuarios->where('id', $session->id)->first();


        $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario];

        echo view('header');
        echo view('usuarios/cambiar_password', $data);
        echo view('footer');
    }




    public function actualizar_password()
    {
        $session = session();
        $id = $session->id;
        if ($this->request->getMethod() == "post" && $this->validate($this->reglasCambia)) {
           

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);



            // esto se usa para guardar en la tabla se una el name de que esta en la tabla  y con el $this->request->gotPost tiene que tener el nombre que esta en from
            $this->usuarios->update($id, ['password' => $hash]);
            $usuario = $this->usuarios->where('id', $session->id)->first();


            $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario,'mensaje'=>'Contraseña actualizada'];

            echo view('header');
            echo view('usuarios/cambiar_password', $data);
            echo view('footer');
        } else {
            $usuario = $this->usuarios->where('id', $session->id)->first();

            $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario,'validation' => $this->validator];

        echo view('header');
        echo view('usuarios/cambiar_password', $data);
        echo view('footer');
        }
    }
}
