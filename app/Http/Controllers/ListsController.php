<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateListRequest;
use Illuminate\Http\Request;

class ListsController extends Controller
{


    public function generateList(GenerateListRequest $request){
        if ($request->ajax()){
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
                    $depth = $this->array_depth($list);
                    $req_depth = $request->depth;
                    if ($req_depth > $depth){
                        return response()->json(['success' => false, 'msg' => 'Wrong depth']);
                    }
                    $items = $list['items'];
                    $background = $request->background_url && $request->has('background_url') ? "background-image: url(" . $request->background_url . ")" : ($request->has('background_color') && $request->background_color ? "background-color: rgb" . $request->background_color : "");
                    $n = 1;
                    $items_html = view('lists.partials.items',compact('items','background','n', 'req_depth'))->render();
                    return response()->json(['success' => true,'html' => $items_html, 'background' => $background]);
                }else{
                    return response()->json(['success' => false, 'msg' => 'Invalid format']);
                }
            }

            return response()->json(['success' => false]);
        }

        $json_input_type = 'input';
        $background_input_type = 'rgb';
        return view('lists.index',compact('json_input_type', 'background_input_type'));

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

    private function array_depth($json_data)
    {
        $max_depth = 1;
        foreach ($json_data['items'] as $item) {
            if (array_key_exists('items', $item)) {
                $max_depth = $this->array_depth($item) + 1;
            }
        }
        return $max_depth;
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
