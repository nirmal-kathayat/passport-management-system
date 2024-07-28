@extends('layouts.default')
@section('title',isset($position) ? 'Update Job Position' : 'Add Job Postion')
@section('content')
<div class="inner-section-wrapper grey-bg upload-block">
    <form class="form-data" action="{{ isset($position) ? route('admin.position.update', $position->id) : route('admin.position.store') }}" method="post">
        @csrf
        @if(isset($position))
        @method('PUT')
        @endif
        <div class="form-wrapper position-form">
            <div class="form-group group-row align-center">
                <label>Title</label>
                <input type="text" name="title" class="validation-control" data-validation="required" value="{{old('title',$position->title ?? '')}}">
                @error('title')
                <span class="validation-error">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group group-row">
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>
          
    
            <div class="form-group group-row  flex-end">
                <button class="primary-btn" type="submit" id="submit-button">{{isset($position) ? 'Update' : 'Add'}} Job Position</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
@include('scripts.validation')
@endpush