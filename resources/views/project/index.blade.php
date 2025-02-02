@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Project</h1>
        <h5 class="text-secondary">Populate the database</h5>
    </div>

    <hr>

    {{-- PROCESS UNIQUE JSON FILE --}}

    <form method="POST" action="/project/store" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="col-md-12">
                <a href="{{ asset('json_example.json') }}" target="blank">
                    <i class="fas fa-link"></i> JSON example file
                </a>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-8">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="json_file" name="json_file" value="{{ old('json_file') }}" required>
                    <label class="custom-file-label" for="json_file">Select a JSON file (recomended size of 2M)</label>
                    <p class="text-muted">*If there are repeated pages, they will be ignored</p>
                </div>

                @error('json_file')
                    <p class="text-danger">{{ $errors->first('json_file') }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary btn-block" id="btn-json" onclick="start_loading(this)">Process JSON file</button>
            </div>

        </div>

    </form>

    <br>

    {{-- SAVE MULTIPLES PNG FILES --}}

    <form method="POST" action="/project/upload" enctype="multipart/form-data">
        @csrf

        <div class="form-row">

            <div class="form-group col-md-8">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="png_files" name="png_files[]" accept="png/*" multiple required>
                    <label class="custom-file-label" for="png_files">Select PNG files (max of 20 files)</label>
                </div>

                @if($errors->has('png_files.*'))
                    <p class="text-danger">{{ $errors->first('png_files.*') }}</p>
                @endif
            </div>

            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-secondary btn-block" id="btn-pngs" onclick="start_loading(this)">Process PNG files</button>
            </div>

        </div>

    </form>

    {{-- SAVE TEXT FILE --}}

    <form method="POST" action="/project/upload/text" enctype="multipart/form-data">
        @csrf

        <div class="form-row">

            <div class="form-group col-md-8">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="text_file" name="text_file[]" accept="pdf/*" multiple required>
                    <label class="custom-file-label" for="text_file">Select text file</label>
                </div>

                @if($errors->has('text_file.*'))
                    <p class="text-danger">{{ $errors->first('text_file.*') }}</p>
                @endif
            </div>

            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-secondary btn-block" id="btn-text" onclick="start_loading(this)">Process Text file</button>
            </div>

        </div>

    </form>

    <hr>

    {{-- DISPLAY RESPONSE --}}

    <div id="response-text">
        @if(isset($response))
            <div class="{{ Str::contains($response, 'ERROR') ? 'text-danger' : 'text-success' }}" role="alert"> {{ $response }} </div>

            @if(isset($pages) && isset($sentences))
                Total of {{ $pages }} pages inserted, with {{ $sentences }} sentences
            @endif
        @endif
    </div>

</div>
@endsection

@section('scripts')

    <script >
        /* show file value after file selected */
        document.getElementById('json_file').addEventListener('change',function(e){
            var fileName = document.getElementById("json_file").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        })

        /* show number of files selected */
        document.getElementById('png_files').addEventListener('change',function(e){
            var files = document.getElementById("png_files").files.length;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = files + " files selected";
        })

        /* show file value after file selected */
        document.getElementById('text_file').addEventListener('change',function(e){
            var fileName = document.getElementById("text_file").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        })

        $(function(){
            $('form').on('submit', function(event){
                event.preventDefault();
                event.stopPropagation();
        
                $("#btn-json").prop('disabled', true);
                $("#btn-pngs").prop('disabled', true);
                $("#btn-text").prop('disabled', true);
            });
        });

        function start_loading(OBJ) {
            if ((OBJ.id == 'btn-json' && $("#json_file").val() == "") || (OBJ.id == 'btn-pngs' && $("#png_files").val() == "") || (OBJ.id == 'btn-text' && $("#text_file").val() == ""))
                return ;

            OBJ.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

            $("#response-text").html('<div class="text-danger" role="alert">Processing data...</div>');
        };
    </script>

@endsection
