@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Generate List') }}</div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <p id="msg" class="text-center text-danger"></p>

                                <form method="POST" id="generate-list" action="{{ route('list.generate') }}" data-load-inputs-url="{{route('load.inputs')}}">
                                    @csrf
                                    <div class="row justify-content-center mb-3">
                                        <label class="col-md-3 col-form-label text-md-center pt-0">{{ __('JSON') }}</label>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input json-input-type" name="json_input_type" type="radio" value="file" id="json_file_type" {{$json_input_type == 'file' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="json_file_type">
                                                    File
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input json-input-type" name="json_input_type" type="radio" value="input" id="json_input_type" {{$json_input_type == 'input' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="json_input_type">
                                                    Input
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3" id="json-input-row">
                                    </div>

                                    <div class="row justify-content-center mb-3">
                                        <label class="col-md-3 col-form-label text-md-center pt-0">{{ __('Background') }}</label>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input background-input-type" name="background_input_type" type="radio"  value="url" id="background_url_type" {{$background_input_type == 'url' ? 'checked' : 'url'}}>
                                                <label class="form-check-label" for="background_url_type">
                                                    URL
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input background-input-type" name="background_input_type" type="radio"  value="rgb" id="background_rgb_type" {{$background_input_type == 'rgb' ? 'checked' : 'rgb'}}>
                                                <label class="form-check-label" for="background_rgb_type">
                                                    RGB
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row justify-content-center mb-3" id="background-input-row">
                                    </div>


                                    <div class="row justify-content-center mb-3">
                                        <label for="depth" class="col-form-label text-md-center">{{ __('Depth') }}</label>
                                        <div class="col-md-4 form-item">
                                            <input type="number" class="form-control" name="depth" placeholder="Depth" min="1" value="1"/>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-md-6 text-center">
                                            <button type="submit" id="generate" class="btn btn-primary">
                                                {{ __('Generate') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6" id="list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection