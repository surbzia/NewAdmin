<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Country, State, City, UserExemption};
class CountryCityStateController extends Controller
{
    public function countries(){
        $countries = Country::where('is_allowed_for_checkout',1)->get();
        return response()->json(['countries'=>$countries]);
    }
    public function states(Country $country){
        $states = $country->states;
        return response()->json(['states'=>$states]);
    }
    public function state(State $state){
        return response()->json(['state'=>$state]);
    }    
    public function cities(State $state){
        $cities = $state->cities;
        return response()->json(['cities'=>$cities]);
    }
    public function exemptions(){
        if(!empty($_GET['state_id'])&&!empty($_GET['user_email'])){
            $query = UserExemption::leftJoin('users','users.id','=','user_exemptions.user_id')
            ->where('state_id',$_GET['state_id'])
            ->where('users.email',$_GET['user_email'])
            ->get();
            return response()->json(['data'=>$query]);
        }
        return response()->json(['data'=>[]]);
    }
}
