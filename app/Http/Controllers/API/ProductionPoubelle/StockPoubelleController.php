<?php
namespace App\Http\Controllers\API\ProductionPoubelle;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\Stock_poubelle as Stock_poubelleResource;
use App\Models\Stock_poubelle;
use App\Http\Requests\ProductionPoubelle\StockPoubelleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StockPoubelleController extends BaseController{
    public function index(){
        $stock_poubelle = Stock_poubelle::all();
        return $this->handleResponse(Stock_poubelleResource::collection($stock_poubelle), 'Affichage stock poubelle');
    }
    public function store(StockPoubelleRequest $request){
        $input = $request->all();
        $stock_poubelle = Stock_poubelle::create($input);
        return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle crée!');
    }
    public function show($id){
        $stock_poubelle = Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle existe.');
        }
    }
    public function update(StockPoubelleRequest $request, Stock_poubelle $stock_poubelle){
        $input = $request->all();
        $stock_poubelle->update($input);
        return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle modifié!');
    }
    public function destroy($id){
        $stock_poubelle =Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }
        else{
            $stock_poubelle->delete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        }
    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_poubelle'=>'required',
            'capacite_poubelle'=>'required'
        ]);
            $stock_poubelle = Stock_poubelle::where("type_poubelle",$request->type_poubelle)->where("capacite_poubelle",$request->capacite_poubelle);
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/stock_poubelle';
                $destination = 'storage/images/stock_poubelle/'.$stock_poubelle->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $stock_poubelle['photo'] =$input['photo'];
                $stock_poubelle->save();
                return response([
                    'status' => 200,
                    'stock_poubelle' =>$stock_poubelle,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
    }
}
