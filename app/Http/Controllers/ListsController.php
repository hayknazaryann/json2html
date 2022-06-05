<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateListRequest;
use Illuminate\Http\Request;

class ListsController extends Controller
{

    public function index()
    {
        $json_input_type = 'input';
        $background_input_type = 'rgb';
        return view('lists.index',compact('json_input_type', 'background_input_type'));
    }

    public function generateList(GenerateListRequest $request){
        $contents = null;
        if ($request->has('json_file')){
            $file = $request->file('json_file');
            $contents = file_get_contents($file);
        }elseif($request->has('json_data')){
            $contents = $request->json_data;
        }

        if ($contents){
            $list = json_decode($contents, true);
            $validated = $this->validateJson($list);
            if ($validated){
                $items = $list['items'];
                $background = $request->has('background_url') ? "background-image: url(" . $request->background_url . ")" : ($request->has('background_color') ? "background-color: rgb" . $request->background_color : "");
                $items_html = view('lists.partials.items',compact('items','background'))->render();
                return response()->json(['success' => true,'html' => $items_html, 'background' => $background]);
            }
        }

        return response()->json(['success' => false]);
    }


    private function validateJson($json_data){
        $validated = true;
        if (array_key_exists('items',$json_data)){
            foreach ($json_data['items'] as $item){
                if(array_key_exists('title',$item) && array_key_exists('type', $item)){
                    if ($item['type'] == 'array'){
                        $this->validateJson($item['items']);
                    }
                }else{
                    $validated = false;
                }
            }
        }else{
            $validated = false;
        }
        return $validated;
    }

    public function renderList($items){

    }

    public function loadInputs(Request $request){
        try{
            $type = $request->type;
            $input_name = $request->property;
            $path = "lists.partials.{$input_name}-input";
            $input = view()->exists($path) ? view($path, compact('type'))->render() : '';
            return response()->json(['success' => true, 'input' => $input, 'parent' => $input_name], 200);

        }catch (\Exception $exception){
            return response()->json(['success' => false, 'msg' => 'something went wrong'], 400);
        }
    }



}
