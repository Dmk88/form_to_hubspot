<div class="form-group">
    <label for="google_doc_fild" class="col-sm-3 control-label">Google Doc Field</label>
    <div class="col-sm-2">
        <select name="exclusions[fild][]" id="google_doc_fild-id" class="form-control">
            @if($google_doc_fields)
                @foreach($google_doc_fields as $google_doc_field)
                    <option value="{{ $google_doc_field }}">
                        {{ $google_doc_field }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-sm-1">
        <select name="exclusions[type][]" id="exclusion_type-id" class="form-control">
            @if($exclusion_types)
                @foreach($exclusion_types as $exclusion_type)
                    <option value="{{ $exclusion_type->id }}">
                        {{ $exclusion_type->view_name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-sm-2">
        <input type="text" name="exclusions[value][]" id="exclusion_value" class="form-control">
    </div>
    <div class="col-sm-2">
        <button class="delete_exclusion btn btn-danger">Del</button>
    </div>
</div>