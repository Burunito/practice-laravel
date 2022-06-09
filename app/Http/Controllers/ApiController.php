<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FederalEntity;
use App\Models\Locality;
use App\Models\Municipality;
use App\Models\PostalCode;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\ZoneType;
use App\Imports\ZipCodeImport;
use Maatwebsite\Excel\Facades\Excel;

class ApiController extends Controller
{   

    private $accents = array('Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
                            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u');
     /**
     * Search zip code
     *
     * @param  string  $zip_code
     * @return Array
     */
    public function importData()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        $data = Excel::toCollection(new ZipCodeImport,'./CPdescarga.xls');
        $collection = $this->reMapData($data);
        $sorted = $collection->sortBy('codigo');
        foreach ($sorted as $zip_code) {
            if (!$estado = FederalEntity::where('name', $zip_code['estado'])->first()) {
                $estado = new FederalEntity(['name' => $zip_code['estado']]);
            }
            $estado->save();
            if (!$municipio = Municipality::where('name', $zip_code['municipio'])->first()) {
                $municipio = new Municipality(['name' => $zip_code['municipio']]);
            }
            $municipio->save();
            if (!$localidad = Locality::where('name', $zip_code['ciudad'])->first()) {
                $localidad = new Locality(['name' => $zip_code['ciudad']]);
            }
            $localidad->save();
            if (!$tipo_colonia = SettlementType::where('name', $zip_code['tipo_asentamiento'])->first()) {
                $tipo_colonia = new SettlementType(['name' => $zip_code['tipo_asentamiento']]);
            }
            $tipo_colonia->save();
            if (!$zona = ZoneType::where('name', $zip_code['zona'])->first()) {
                $zona = new ZoneType(['name' => $zip_code['zona']]);
            }
            $zona->save();
            
            if (!$codigo = PostalCode::where('zip_code', $zip_code['codigo'])->first()) {
                $codigo = new PostalCode(
                    [
                        'zip_code' => $zip_code['codigo'], 
                        'locality_id' => $localidad->id, 
                        'federal_entity_id' => $estado->id, 
                        'municipality_id' => $municipio->id, 
                    ]
                );
            }
            $codigo->save();
            
            $colonia = new Settlement(
                    [
                        'name' => $zip_code['asentamiento'],
                        'postal_code_id' => $codigo->id,
                        'zone_type_id' => $zona->id,
                        'settlement_type_id' => $tipo_colonia->id,
                    ]
                );
            $colonia->save();
        }
    }

    /**
     * Search zip code
     *
     * @param  string  $zip_code
     * @return Array
     */
    public function reMapData($array)
    {
        $collection = [];
        $array->shift();
        foreach ($array as $state) {
            foreach ($state as $code) {
                if (count($code) == 15 && $code[0] != 'd_codigo') {
                    $collection[] = [
                        "codigo" => $code[0],
                        "asentamiento" => strtr($code[1], $this->accents),
                        "key" => $code[12],
                        "tipo_asentamiento" => $code[2],
                        "municipio" => strtr($code[3], $this->accents),
                        "estado" => strtr($code[4], $this->accents),
                        "ciudad" => strtr($code[5], $this->accents),
                        "zona" => $code[13]
                    ];
                }
            }
        }
        return collect($collection);
    }

    /**
     * Search zip code
     *
     * @param  string  $zip_code
     * @return Array
     */
    public function getData($zip_code)
    {
        if (!$zip_code) {
            return response()->json(['error' => 'Zip code cant be found'], 404);
        }
        $postalCodeInfo = PostalCode::with('settlements.settlement_type','federal_entity', 'municipality')
                                ->where('zip_code', $zip_code)
                                ->first();

        return response()->json($postalCodeInfo, 200);
    }
}
