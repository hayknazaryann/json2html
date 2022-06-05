@if($type == 'file')
    <label for="file" class="col-form-label text-md-center">{{ __('JSON File') }}</label>
    <div class="col-md-6 form-item">
        <input id="file" type="file" class="form-control" name="json_file" />
    </div>
@elseif($type == 'input')
    <label for="file" class="col-form-label text-md-center">{{ __('JSON Data') }}</label>
    <div class="col-md-6 form-item">
        <textarea class="form-control" id="data" name="json_data" placeholder="JSON Data"></textarea>
    </div>
@endif