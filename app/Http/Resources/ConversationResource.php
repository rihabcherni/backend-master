<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\MessageResource;
class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['auth_user']=$this->auth_user ;
        $data['auth_second_user']=$this->auth_second_user;
        $data['created_at'] = Carbon::parse($this->created_at)->toDateTimeString();
        $msg= $this->messages->isEmpty()? null : MessageResource::collection($this->messages);
        if(is_null($msg)){
            $data['messages'] = null;
        }else{
            $compteur = count($msg);
            for($i = 0;$i < $compteur ; $i++){
                for ($j = $i + 1; $j < $compteur; $j++) {
                    if (isset($msg[$i]->id) && isset($msg[$j]->id) && $msg[$i]->id < $msg[$j]->id){
                        $temp = $msg[$i];
                        $msg[$i] = $msg[$j];
                        $msg[$j] = $temp;
                    }
                }
            }
            $data['messages'] = MessageResource::collection($msg);
        }
        return $data;
    }
}
