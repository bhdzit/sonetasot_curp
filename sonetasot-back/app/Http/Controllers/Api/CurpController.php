<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurpStoreRequest;
use App\Models\Curp;
use Illuminate\Http\Request;



/**
 * @OA\Info(title="API Usuarios", version="1.0")
 *
 */
class CurpController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/getAllCURPS",
     *     summary="Muestra todos los Curps registrados ",
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todos los Curps registrados."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {
        return Curp::all();
    }

    /**
     * @OA\post(
     *     path="/api/createCurp",
     *     summary="Agrega Crups",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido_p",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido_m",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="fecha_nacimiento",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="sexo",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="estado",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="curp",
     *                     type="string"
     *                 ),
     *                 example={
     *               "nombre":"Bryan Eliut",
     *               "apellido_p":"Hernandez",
     *               "apellido_m":"Moran",
     *               "fecha_nacimiento":"1997-09-04",
     *               "sexo":"H",
     *               "estado":"HG",
     *               "curp":"HEMB970904HHGRRR00"
     *               }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="El Curp se agrego con exito."
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="El request es invalido"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error."
     *     ),
     * )
     */

    public function create(CurpStoreRequest $request)
    {
        $curp = Curp::create($request->toArray());
        return $curp;
    }
    /**
     * @OA\put(
     *     path="/api/updateCurp",
     *     summary="Actualiza los datos del Crup",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido_p",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido_m",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="fecha_nacimiento",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="sexo",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="estado",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="curp",
     *                     type="string"
     *                 ),
     *                 example={
     *               "id":1,
     *               "nombre":"Bryan Eliud",
     *               "apellido_p":"Hernandez",
     *               "apellido_m":"Moran",
     *               "fecha_nacimiento":"1997-09-04",
     *               "sexo":"H",
     *               "estado":"HG",
     *               "curp":"HEMB970904HHGRRR00"
     *               }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="El Curp se Actualizo con exito."
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="El request es invalido"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error."
     *     ),
     * )
     */

    public function update(CurpStoreRequest $request)
    {
        $curp = Curp::where('curp', $request->curp)->update($request->all());
        $curp = Curp::where('curp', $request->curp)->get();
        return $curp;
    }

    /**
     * @OA\get(
     *     path="/api/getCurp/{curp}",
     *     summary="Obtiene datos de la persona al que tiene asociado un curp",
     *     @OA\Parameter(
     *         description="Obtiene datos de la persona al que tiene asociado un curp",
     *         in="path",
     *         name="curp",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="HEMB970904HHGRRR00", value="HEMB970904HHGRRR00", summary="Curp de la persona")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */

    public function getCurp(Request $request)
    {
        $curp = Curp::where('curp', $request->curp)->get();
        return $curp;
    }

    /**
     * @OA\delete(
     *     path="/api/deleteCurp/{curp}",
     *     summary="Updates a user",
     *     @OA\Parameter(
     *         description="Elimina el curp",
     *         in="path",
     *         name="curp",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="HEMB970904HHGRRR00", value="HEMB970904HHGRRR00", summary="Curp de la persona")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */

    public function deleteCurp(Request $request)
    {

        $curp = Curp::where('curp', $request->curp)->get();
        if (count($curp) > 0) {
            $curp = $curp[0];
            $curp = Curp::find($curp->id);
            $curp->delete();
            return "{msg:'Registro $request->curp  se eliminado con exito'}";
        }
        return "{msg:'Registro no exite'}";
    }


}