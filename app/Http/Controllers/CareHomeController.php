<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBedRequest;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\StoreCareHomeMediaRequest;
use App\Http\Requests\StoreCareHomeRequest;
use App\Http\Requests\StoreFloorRequest;
use App\Http\Requests\UpdateCareHomeRequest;
use App\Models\Bed;
use App\Models\Building;
use App\Models\CareHome;
use App\Models\CareHomeMedia;
use App\Models\Floor;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Validator;

class CareHomeController extends Controller
{
    use ImageUploadTrait;

    function index()
    {
        $carehomes = CareHome::with('media', 'buildings.floors.beds')->get();
        return response()->json(['status'=>true, 'data'=>$carehomes]);
    }

    function store(StoreCareHomeRequest $request)
    {
        $request = $request->validated();
        
        try {
            $request['password'] = bcrypt($request['password']);
            if (!empty($request['image'])) 
            {
                $imageName = $request['image']->getClientOriginalName().'.'.$request['image']->extension();
                $request['image']->move(public_path('uploads/carehome/images'), $imageName);
                $request['image']=$imageName;
            }
            $carehome = CareHome::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeByGet()
    {   
        $request = request()->all();
        $carehome = json_decode($request['data']['carehome']);
        try {
            $carehome->password = bcrypt($carehome->password);
            $carehome = CareHome::create((array) $carehome);
            $request['data']['carehome_id'] = $carehome->id;
            $subscription = (new Subscription())->afterPayCarehome($request);
            return redirect('https://avancarehomes.dev-bt.xyz');
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdateCareHomeRequest $request, $carehome)
    {
        $request = $request->validated();
        
        try {
            if(!empty($request['password'])) $request['password'] = bcrypt($request['password']); 
            else unset($request['password']);
            $carehome = CareHome::find($carehome);
            $carehome->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($carehome)
    {
        $carehome = Carehome::with('media', 'buildings.floors.beds')->find($carehome);
        return response()->json(['status'=>true, 'data'=>$carehome]);
    }

    function destroy($carehome)
    {
        return CareHome::destroy($carehome);
    }

    function bulk()
    {
        $response = (new Carehome())->import(request()->sheet);
        return response()->json(['status'=>$response['status'], 'message'=>$response['status']===true?"Sheet Imported":$response['error']]);
    }

    function activate($carehome)
    {
        $carehome = CareHome::find($carehome);
        if($carehome->status == 0)
        {
            $carehome->update(['status'=>1]);
            
            Mail::raw("https://avanzandojuntos.dev-bt.xyz/carehome/login", function ($message) use ($carehome) 
            {
                $message->to($carehome->email)->subject('Account Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to carehome"]);
        }
        $carehome->update(['status'=>0]);
        return response()->json(['status'=>true, 'response'=>"Account deactivated"]);
    }

    function findByEmail()
    {
        if(empty(request()->email)) return response(['status'=>false, 'error'=>'Email is required']);
        return CareHome::whereEmail(request()->email)->exists();
    }

    function profilePicUpdate()
    {
        $validator = Validator::make(request()->all(),
        [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $media = CareHome::find(auth('carehome_api')->id());
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) 
            {
                $this->deleteImage($media->image);
                $media->update(['image'=>(NULL)]);
            }
    
            // UPLOADING NEW IMAGE
            $filePath = $this->uploadImage(request()->image, 'uploads/carehome/images');
            $media->update(['image'=>$filePath]);
            return response()->json(['status'=>true, 'response'=>'Profile Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteProfilePic()
    {
        $carehome = CareHome::find(auth('carehome_api')->id());
        if (!empty($carehome->image)) 
        {
            $this->deleteImage($carehome->image);
            $carehome->update(['image'=>'']);
        } 
        return response()->json(['status'=>true, 'response'=>'Image Deleted']);
    }

    function addMedia(StoreCareHomeMediaRequest $request)
    {
        $request = $request->validated();
        try {
            $carehome = Carehome::with('media')->find(auth('carehome_api')->id());   
            if (!empty($request['media'])) 
            {
                foreach($request['media'] as $media)
                {
                    switch ($media['type']) {
                        case 'blueprint':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/blueprints');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'hospital':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/hospital');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'personal':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/personal');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'resume':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/resume');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;
                    }
                }
            }
            return response()->json(['status'=>true, 'response'=>'Media Added', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteDocument($document)
    {
        $document = CareHomeMedia::find($document);
        if (!empty($document->document)) 
        {
            $this->deleteImage($document->document);
            $document->destroy($document->id);
        }
        return response()->json(['status'=>true, 'response'=>'Document Deleted']);
    }

    // BLUEPRINT WORK
    function approveBlueprint($blueprint)
    {
        $blueprint = CareHomeMedia::with('carehome')->find($blueprint);
        if($blueprint->type=='blueprint')
        {
            if ($blueprint->status==0) 
            {
                $blueprint->update(['status'=>1]);
                
                Mail::raw("Blueprint Approved.", function ($message) use ($blueprint) 
                {
                    $message->to($blueprint->carehome->email)->subject('Blueprint Approved');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
                return response()->json(['status'=>true, 'response'=>"Blueprint approved and mail sent to carehome"]);
            }
        }
        else return response()->json(['status'=>false, 'response'=>"Incorrect Document Type"]);
    }

    function refuseBlueprint($blueprint)
    {
        $blueprint = CareHomeMedia::with('carehome')->find($blueprint);
        if($blueprint->type=='blueprint')
        {
            if ($blueprint->status==1) $blueprint->update(['status'=>0]);
                return response()->json(['status'=>true, 'response'=>"Blueprint refused"]);
        }
        else return response()->json(['status'=>false, 'response'=>"Incorrect Document Type"]);
    }

    function storeBuilding(StoreBuildingRequest $request)
    {
        $request = $request->validated();
        
        try {
            $request['carehome_id']=request()->carehome_id??auth('carehome_api')->id();
            $building = Building::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$building]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeFloor(StoreFloorRequest $request)
    {
        $request = $request->validated();
        $numberOfFloors = $request['number_of_floors'];
        $floorCount = 1;
        try {
            for ($i=0; $i < $numberOfFloors; $i++) 
            { 
                unset($request['number_of_floors']);
                $request['title']=$floorCount;
                $floor = Floor::create($request);
                $floorCount++;
            }
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$floor]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeBed(StoreBedRequest $request)
    {
        $request = $request->validated();
        $numberOfBeds = $request['number_of_beds'];
        $bedCount = 1;
        try {
            for ($i=0; $i < $numberOfBeds; $i++) 
            { 
                unset($request['number_of_beds']);
                $request['title']=$bedCount;
                $bed = Bed::create($request);
                $bedCount++;
            }
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$bed]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeSingleFloor($building)
    {   
        try {
            $building = Building::with('floors')->find($building);
            if(!$building->floors->isEmpty())
            {
                $lastFloor = $building->floors->last();
                $data = ['building_id'=>$building->id, 'title'=>$lastFloor->title+1];
                $floor = Floor::create($data);
                return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$floor]);
            }
            else 
            {
                $data = ['building_id'=>$building->id, 'title'=>1];
                $floor = Floor::create($data);
                return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$floor]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeSingleBed($floor)
    {   
        try {
            $floor = Floor::with('beds')->find($floor);
            if(!$floor->beds->isEmpty())
            {
                $lastBed = $floor->beds->last();
                $data = ['floor_id'=>$floor->id, 'title'=>$lastBed->title+1];
                $bed = Bed::create($data);
                return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$bed]);
            }
            else 
            {
                $data = ['floor_id'=>$floor->id, 'title'=>1];
                $bed = Bed::create($data);
                return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$bed]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function destroyBuilding($building)
    {
        return Building::destroy($building);
    }

    function destroyFloor($floor)
    {
        return Floor::destroy($floor);
    }

    function destroyBed($bed)
    {
        return Bed::destroy($bed);
    }

    function buildings()
    {
        $carehomeId = request()->carehome_id??auth('carehome_api')->id();
        $buildings = Building::with('carehome')->where('carehome_id', $carehomeId)->get();
        return response()->json(['status'=>true, 'data'=>$buildings]);
    }

    function floors($building)
    {
        $floors = Floor::where('building_id', $building)->get();
        return response()->json(['status'=>true, 'data'=>$floors]);
    }

    function beds($floor)
    {
        $beds = Bed::with('floor.building')->where('floor_id', $floor)->get();
        return response()->json(['status'=>true, 'data'=>$beds]);
    }
}
