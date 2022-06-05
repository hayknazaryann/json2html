@if($type == 'url')
    <label for="background-url" class="col-form-label text-md-center">{{ __('Background Image URL') }}</label>
    <div class="col-md-6 form-item">
        <input type="text" class="form-control" id="background-url" name="background_url" placeholder="URL" value="{{request()->has('background') ? request()->get('background') : ''}}" />
    </div>
@elseif($type == 'rgb')
    <label for="background-color" class="col-form-label text-md-center">{{ __('Background Color RGB') }}</label>
    <div class="col-md-6 form-item">
        <input type="text" class="form-control" id="background-color" name="background_color" placeholder="Example - (0,15,25)" value="{{request()->has('background') ? request()->get('background') : ''}}" />
    </div>
@endif