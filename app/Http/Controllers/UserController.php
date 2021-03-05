<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\JwtAuth;
use App\User;

class UserController extends Controller
{

  public function __construct() {
      $this->middleware('api.auth', ['except' => ['index', 'login']]);
  }

  public function index() {
    $usuarios = User::all();
    return response()->json(['code' => 200, 'status' => 'success', 'usuarios' => $usuarios]);
  }

  public function login(Request $request) {
    $jwtAuth = new \JwtAuth();
    $json = $request->input('json', null);
    $params = json_decode($json);
    $params_array = json_decode($json, true);

    $validate = \Validator::make($params_array, ['email' => 'required|email', 'password' => 'required']);
    if ($validate->fails()) {
      $signup = array('status' => 'error', 'code' => 400, 'message' => 'Usuario no se ha podido identificar', 'errors' => $validate->errors());
    } else {
      //$pwd = hash('sha256', $params->password);
      $pwd = '$2a$13$3UHLVxzXIYag.3zA6gHKp..QG3pQ5hAQKsZ/LGeg4DvhY57PStAWW';
      //Devolver Token / Datos
      $signup = $jwtAuth->signup($params->email, $pwd);
      if (!empty(($params->gettoken))) {
        $signup = $jwtAuth->signup($params->email, $pwd, true);
      }
    }
    return response()->json($signup, 200);
  }

  public function detail($id) {
    $user = User::find($id);
    if (is_object($user)) {
      $data = array('code' => 200, 'status' => 'success', 'user' => $user);
    } else {
      $data = array('code' => 404, 'status' => 'error', 'message' => 'El usuario no existe');
    }
    return response()->json($data, $data['code']);
  }


} // end Controller
