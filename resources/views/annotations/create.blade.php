@extends('layouts.app')

@section('include')

    {{-- Test if the user already made the tour --}}
    @if(!Auth::user()->tour)

        <link rel="stylesheet" href="{{ asset('enjoyhint/dist/enjoyhint.css') }}">

        <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
        <script src="{{ asset('enjoyhint/dist/enjoyhint.min.js') }}"></script>

    @endif

@endsection

@section('content')

    <div class="container">
        <form method="POST" action="/annotations/{{ $sentence->id }}">  
            @csrf
            @method('PUT')

            <div class="annotation row">

                <div class="pdf-page col-5">
                    @if(file_exists(public_path()."/texts/".$page->file_name))

                        <!-- <small id="findHelpBlock" class="form-text text-muted">
                            <span class="badge badge-lg badge-light">Ctrl+F</span> can help you to find the sentence in the file
                        </small> -->

                        <embed src="/texts/{{ $page->file_name }}" class="box-pdf-file" frameborder="0" allowfullscreen>
                    @else

                        <div class="card border-secondary mb-3 box-pdf-file">
                            <div class="card-body text-secondary">
                                <h5 class="card-title">Sorry</h5>
                                <p class="card-text">the original image file for the current sentence was not found.</p>
                                <p>The file name should be: "{{ $page->file_name }}"</p>
                            </div>
                        </div>

                    @endif
                </div>
        
                <div class="sentences col-7">

                    <div class="form-group d-flex justify-content-between annotation-info">
                        <div>Page: {{ $page->id }}</div>
                        <div>Sentence: {{ $sentence->id }}</div>
                        <div>Annotations: <strong>{{ $page->annotations.'/'.$page->wrong_words }}</strong></div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="exampleFormControlTextarea1">Sentence</label>
                        <textarea class="form-control" name="sentence" id="sentence" rows="4" readonly>{{ $sentence->sentence }}</textarea>
                    </div> -->

                    <div class="form-group">
                        @if(file_exists(public_path()."/pngs/".$sentence->sentence))
                            <img src="/pngs/{{ $sentence->sentence }}" class="form-control" style="height: 200px">
                        @else

                            <div class="card border-secondary mb-3 box-pdf-file">
                                <div class="card-body text-secondary">
                                    <h5 class="card-title">Sorry</h5>
                                    <p class="card-text">the original image file for the current sentence was not found.</p>
                                    <p>The file name should be: "{{ $sentence->sentence }}"</p>
                                </div>
                            </div>

                        @endif
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Correction*</label>
                        <textarea class="form-control" name="correction" id="correction" rows="4" required>{{ $sentence->correction ? : $sentence->sentence }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observations</label>
                        <textarea class="form-control" name="observation" id="observation" rows="2" placeholder="Optional...">{{ $sentence->observation }}</textarea>
                    </div>

                    <div class="form-group">
                        <small id="findHelpBlock" class="form-text text-muted">
                            *If the sentence is correct, just click on submit.<br>
                            **Since our goal is to improve the quality of the extracted text in relation to the original contents, please,
                            do not correct typos found in the image itself. The corrected version should match the image.
                        </small>
                    </div>

                    @error('correction')
                        <p class="text-danger">{{ $errors->first('correction') }}</p>
                    @enderror

                    @can ('update', $sentence)
                        <div class="d-flex justify-content-between">

                            <button type="submit" class="btn btn-primary col-6" id="btn-submit"><i class="fas fa-check"></i> Submit</button>

                            @if($sentence->illegible)
                                <a href="{{ route('annotations.illegible', $sentence) }}" class="btn btn-danger col-5" id="btn-illgebible" title="Set sentence as legible">
                                    <i class="fas fa-eye"></i> Legible
                                </a>
                            @else
                                <a href="{{ route('annotations.illegible', $sentence) }}" class="btn btn-outline-danger col-5" id="btn-illgebible" title="Set sentence as illegible">
                                    <i class="fas fa-eye-slash"></i> Illegible
                                </a>
                            @endif

                        </div>
                    @endcan

                </div>

            </div>
            
        </form>

    </div>
   
@endsection

@section('scripts')

    {{-- Test if the user already made the tour --}}
    @if(!Auth::user()->tour)

        <script src="{{ asset('js/annotation_tour.js') }}"></script>

    @endif
    
@endsection
