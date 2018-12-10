
@extends('root')
@section('content')


<section class="content-header">
      <h1>
        Atur Template Kontrak
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Pengaturan</a></li>
        <li class="active">Template Kontrak</li>
      </ol>
</section>
<section class="content">
    <div class="box box-danger">
        <div class="box-body control">
            <div class="controls"> 
            <form method="POST" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group" id="form-html">
                    <label>Template Kontrak</label>
                    <div class="input-group">
                        <h4>Status : {{$is_uploaded?'Uploaded':'-'}}</h4>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('contract_template') ? ' has-error' : '' }} has-feedback ">
                    <label>File</label>
                    <div class="input-group">
                        <input type="file" name="contract_template">
                        </select>    
                    </div>
                    @if ($errors->has('contract_template'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contract_template') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group" id="button-submit-container">
                    <button type="submit" class="btn btn-block btn-primary btn-lg">Simpan</button>
                </div>
            </form>   
            </div> 
        </div>
    </div>
</section>
@endsection

@section('js')
@endsection