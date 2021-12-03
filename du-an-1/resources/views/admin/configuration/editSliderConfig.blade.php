@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="">
                <h3 class="section-title">Chỉnh sửa Slider {{$edit->SliderId}}</h3>
                <p>
                    Thêm đầy đủ các thông tin vào các ô bên dưới.
                </p>
            </div>
            <div class="card">
                @if(session()->has('edit-success'))
                    <div class="alert alert-success col-12">
                        {{session('edit-success')}}
                    </div>
                    @php
                        \Session::forget('edit-success');
                    @endphp
                @endif
                <form action="{{route('update.slider')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="SliderId" value="{{$edit->SliderId}}">
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label>Nội dung khuyến mãi:</label>
                            <input name="SaleContent" type="text" class="form-control date-inputmask" id="" placeholder=""
                                   value="{{$edit->Discount}}" required/>
                        </div>
                        <div class="form-group col-4">
                            <label>Nội dung sự kiện:</label>
                            <input name="EventContent" type="text" class="form-control date-inputmask" id="" placeholder=""
                                   value="{{$edit->Content}}" required/>
                        </div>
                        <div class="form-group col-4">
                            <label>Link đến sự kiện:</label>
                            <input name="LinkToContent" type="text" class="form-control date-inputmask" id="" placeholder=""
                                   value="{{$edit->URL}}" required/>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-12">
                            <label for="formFile" class="form-label">Chọn Banner cho Slider</label>
                            <input name="SliderImage" class="form-control" type="file" id="upload"
                                   onchange="ImagesFileAsURL()">
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-2">
                            <div style="width:100%" id="displayImg">
                                <img src="{{asset('./images/slider/'.$edit->Images)}}" alt="Girl in a jacket">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <label class='col-2' for="">Hoạt Động</label>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="SliderActive" id="flexRadioDefault1"
                                   value="0" @if(old('CatActive')==0) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Ẩn
                            </label>
                        </div>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="SliderActive" id="flexRadioDefault1"
                                   value="1" @if(old('CatActive')==1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Hiện
                            </label>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-3">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        //Load ảnh xem trước
        function ImagesFileAsURL() {
            var fileSelected = document.getElementById('upload').files;
            if(fileSelected.length > 0) {
                var fileToLoad = fileSelected[0];
                var fileReader = new FileReader();
                fileReader.onload = function(fileLoaderEvent) {
                    var scrData = fileLoaderEvent.target.result;
                    var newImage = document.createElement("img");
                    newImage.src = scrData;
                    document.getElementById('displayImg').innerHTML = newImage.outerHTML;
                }
                fileReader.readAsDataURL(fileToLoad);
            }
        }
    </script>
@stop()
