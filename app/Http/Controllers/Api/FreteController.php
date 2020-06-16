<?php

namespace App\Http\Controllers\Api;

use App\Frete;
use App\Http\Controllers\Controller;
use App\Http\Enumerations\TipoVeiculo;
use App\Http\Helpers\DataHelper;
use App\Http\Requests\Api\AgendarFreteRequest;
use App\Http\Requests\Api\CalcularFreteRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FreteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fretes = Frete::all();

        return response()->json($fretes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $frete = Frete::find($id);

            if (!isset($frete)) {
                return response()->json(["error" => "Data not found"], 400);
            }

            return response()->json($frete);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $id = $request->get('id');

            $data = $request->only([
                "origem_latitude",
                "origem_longitude",
                "destino_latitude",
                "destino_longitude",
                "data_agendamento",
                "tipo_veiculo",
                "data_frete"
            ]);

            $data["data_frete"] = DataHelper::stringToCarbonDate($data["data_frete"]);

            if (!TipoVeiculo::isValidEnumValue($data["tipo_veiculo"])) {
                return response()->json(["error" => "Campo 'tipo_veiculo' inválido -
                (1 - Moto, 2 - Pick Up, 3 - Caminhão)"], 400);
            }

            $data["valor"] = rand(0, 100);

            $frete = Frete::find($id);
            if (!isset($frete)) {
                return response()->json(["error" => "Data not found"], 400);
            }

            $frete->update($data);

            return response()->json($frete);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $frete = Frete::find($id);
            if (!isset($frete)) {
                return response()->json(["error" => "Data not found"], 400);
            }
            $frete->delete();

            return response()->json([ "message" => "Data was deleted!" ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * Calcular valor de frete.
     *
     * @param  \Illuminate\Http\Api\CalcularFreteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function calcular(CalcularFreteRequest $request)
    {
        try {
            $data = $request->only([
                "origem_latitude",
                "origem_longitude",
                "destino_latitude",
                "destino_longitude",
                "tipo_veiculo"
            ]);

            if (!TipoVeiculo::isValidEnumValue($data["tipo_veiculo"])) {
                return response()->json(["error" => "Campo 'tipo_veiculo' inválido -
                (1 - Moto, 2 - Pick Up, 3 - Caminhão)"], 400);
            }

            return response()->json(["valor" => rand(0, 100)]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * Agendamento de fretes
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function agendar(AgendarFreteRequest $request)
    {
        try {
            $user = auth('api')->user();

            $data = $request->only([
                "origem_latitude",
                "origem_longitude",
                "destino_latitude",
                "destino_longitude",
                "data_agendamento",
                "tipo_veiculo",
                "data_frete"
            ]);

            $data["usuario_id"] = $user->id;
            $data["data_frete"] = DataHelper::stringToCarbonDate($data["data_frete"]);

            if (!TipoVeiculo::isValidEnumValue($data["tipo_veiculo"])) {
                return response()->json(["error" => "Campo 'tipo_veiculo' inválido -
                (1 - Moto, 2 - Pick Up, 3 - Caminhão)"], 400);
            }

            $data["valor"] = rand(0, 100);

            $user = Frete::create($data);

            return response()->json($user);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }
}
