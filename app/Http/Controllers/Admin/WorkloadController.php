<?php

namespace App\Http\Controllers\Admin;

use App\Halls;
use App\HallsSchedules;
use App\Restaurant;
use App\RestaurantsSchedules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WorkloadController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:moderate-restaurants');
    }

    public function index(){
        $data['restaurants'] = Restaurant::with(['languages'])->orderBy('id')->paginate(10);
        return view('admin.restaurant_workload_list', $data);
    }

    public function placeWorkload($id){
        $restaurant = Restaurant::where('id', '=', $id)->with(['languages', 'halls'])->first();
        //dd($restaurant);
        $data['restaurant'] = $restaurant;
        return view('admin.restaurant_workload', $data);
    }

    public function changeStatus(Request $request){
        $request->validate([
            'date'      => 'required|date',
            'hall_id'   => 'required|integer',
            'status'    => 'required|integer'
        ]);
        $old_schedule_string = HallsSchedules::where('halls_id','=',$request->hall_id)->where('date','=',$request->date)->first();
        //save info for hall
        if(isset($old_schedule_string)){
            if($request->status == 0){
                $old_schedule_string->delete();
            }else{
                $old_schedule_string->halls_id = $request->hall_id;
                $old_schedule_string->date = $request->date;
                $old_schedule_string->status = $request->status;
                $old_schedule_string->edited_by = Auth::id();
                $old_schedule_string->save();
            }
        }else{
            if($request->status != 0){
                $schedule_string = new HallsSchedules();
                $schedule_string->halls_id = $request->hall_id;
                $schedule_string->date = $request->date;
                $schedule_string->status = $request->status;
                $schedule_string->edited_by = Auth::id();
                $schedule_string->save();
            }
        }
        //save info for restaurant
        $hall = Halls::where('id', '=', $request->hall_id)->with('restaurant')->first();

        $restaurant = Restaurants::where('id', '=', $hall->restaurant->id)->with('halls')->first();

        $partial_halls = 0;
        $over_halls = 0;
        $total_halls = 0;

        foreach($restaurant->halls as $hall){
            $hall_date_status = HallsSchedules::where([['halls_id', '=', $hall->id], ['date', '=', $request->date]])->first();

            if(isset($hall_date_status)){
                if($hall_date_status->status == 1){
                    $partial_halls++;
                }elseif($hall_date_status->status >= 2){
                    $over_halls++;
                }
            }
            $total_halls++;
        }

        $restaurant_status = 0;
        if($over_halls == $total_halls){
            $restaurant_status = 2;
        }elseif($over_halls > 0 || $partial_halls > 0){
            $restaurant_status = 1;
        }

        $restaurant_schedule_row = RestaurantsSchedules::where([['restaurants_id', '=', $restaurant->id], ['date', '=', $request->date]])->first();

        if(isset($restaurant_schedule_row)){
            $restaurant_schedule_row->status = $restaurant_status;
            $restaurant_schedule_row->save();
        }else{
            $restaurant_schedule_row = new RestaurantsSchedules();
            $restaurant_schedule_row->restaurants_id = $restaurant->id;
            $restaurant_schedule_row->date           = $request->date;
            $restaurant_schedule_row->status         = $restaurant_status;
            $restaurant_schedule_row->save();
        }

        $response['date'] = $request->date;
        $response['status'] = $request->status;
        $response['id'] = $request->hall_id;
        return json_encode($response);
    }
}
