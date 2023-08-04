<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslatorRequest;
use App\Http\Requests\UpdateTranslatorRequest;
use App\Models\Translator;
use App\Traits\ImageUploadTrait;

class TranslatorController extends Controller
{

    use ImageUploadTrait;

    function index()
    {
        $translations = Translator::orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $translations]);
    }

    function store(StoreTranslatorRequest $request)
    {
        $request = $request->validated();

        try {
            foreach ($request['translate'] as $translate) 
            {
                $Translator = Translator::create($translate);
            }
            return response()->json(['status' => true, 'response' => 'Record Created', 'data' => $Translator]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function update(UpdateTranslatorRequest $request, Translator $Translator)
    {
        $request = $request->validated();

        try {
            $Translator->update($request);
            return response()->json(['status' => true, 'response' => 'Record Updated', 'data' => $Translator]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function show($Translator)
    {
        $Translator = Translator::find($Translator);
        return response()->json(['status' => true, 'data' => $Translator]);
    }

    function destroy(Translator $Translator)
    {
        return Translator::destroy($Translator->id);
    }
}