@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Ops!</strong> Error <br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
      @csrf
      <input type="hidden" name="data_checkout" class="data-checkout">
      <div class="up">
        <div class="form-wrapper">
          <div class="form-group row">
            <label class="col-2 control-label col-form-label">Barang</label>
            <div class="col-10">
              <select class="select2bs4 form-control" name="barang_id[]" multiple="multiple"
                data-placeholder="Pilih Barang" style="width: 100">
                <option value="">- Pilih Barang -</option>
                @foreach($barang as $item)
                <option value="{{ json_encode($item->barang) }}" @if(old('barang_id')==$item->barang->barang_id)
                  selected
                  @endif>{{
                  $item->barang->barang_nama.' : Rp.'.$item->barang->harga_jual
                  }}</option>
                @endforeach
              </select>
            </div>
          </div>
          @if (auth()->user()->level->level_nama == 'Administrator')
          <div class="form-group row">
            <label class="col-2 control-label col-form-label">Nama Kasir</label>
            <div class="col-10">
              <select class="form-control" id="user_id" name="user_id" required>
                <option value="">- Pilih User -</option>
                @foreach($kasir as $item)
                <option value="{{ $item->user_id }}">{{ $item->nama
                  }}</option>
                @endforeach
              </select>
              @error('user_id')
              <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          @else
          <div class="form-group row">
            <label class="col-2 control-label col-form-label">Nama Kasir</label>
            <div class="col-10">
              <select class="form-control" id="user_id" name="user_id" required>
                <option value="{{ auth()->user()->user_id }}">{{auth()->user()->nama}}</option>
              </select>
              @error('user_id')
              <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          @endif
          <div class="form-group row">
            <label class="col-2 control-label col-form-label">Nama Pembeli</label>
            <div class="col-10">
              <select class="form-control" id="pembeli" name="pembeli" required>
                <option value="">- Pilih Member -</option>
                @foreach($member as $item)
                <option value="{{ $item->username }}">{{ $item->nama
                  }}</option>
                @endforeach
              </select>
              @error('pembeli')
              <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 control-label col-form-label">Tanggal Penjualan</label>
            <div class="col-10">
              <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal"
                value="{{ old('penjualan_tanggal') }}" required>
              @error('penjualan_tanggal')
              <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="counter-wrapper"></div>
        </div>
        <div class="wrapper">
          <div class="form-group row">
            <div class="col-2">
              <label for="">Total QTY</label>
            </div>
            <div class="col-10 row">
              <p class="qty-value">0</p>
              <div class="ml-2">item</div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-2">
              <label for="">Total Bill</label>
            </div>
            <div class="col-10 row">
              <p class="total-value">0</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom">
        <div class="form-group row">
          <label class="col-2 control-label col-form-label"></label>
          <div class="col-10">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('css')
<style>
  span {
    cursor: pointer;
  }

  .minus,
  .plus {
    width: 20px;
    background: #f2f2f2;
    border-radius: 4px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    text-align: center;
  }

  .input-count {
    height: 34px;
    width: 100px;
    text-align: center;
    font-size: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: inline-block;
    vertical-align: middle;
  }
</style>
@endpush

@push('js')
<script>
  let dataCheckout = [];

  function minus(inputId, barangId){
      dataCheckout.map(obj => {
        if(obj.barang_id == barangId){
          obj.qty = obj.qty - 1 <= 0 ? 1 : obj.qty - 1;
        }

          const qty = obj.qty;
          $('#input-count-'+barangId).val(qty).change();
      });

      dataCheckout = dataCheckout.filter(item => item.qty !== 0);


      refreshDataCheckout()
  }

  function plus(inputId, barangId){
    dataCheckout.map(obj => {
      if(obj.barang_id == barangId){
        obj.qty = obj.qty + 1;
      }

        const qty = obj.qty;
        $('#input-count-'+barangId).val(qty).change();
    });

    refreshDataCheckout()
  }

  function onInput(barangId, value){
  
    dataCheckout.map(obj => {
      if(obj.barang_id == barangId){
        obj.qty = parseInt(value);
      }
    });

    let qty = 0;
    let total = 0;
    dataCheckout.forEach(e => {
      qty += e.qty;
      total += (e.harga_jual * e.qty);
    })

    $('.qty-value').html(qty);
    $('.total-value').html(total);

    $('.data-checkout').val(JSON.stringify(dataCheckout));
  }

  function refreshDataCheckout()
  {
    let qty = 0;
    let total = 0;

    $('.counter-wrapper').empty();
  
    dataCheckout.forEach(e => {
      qty += e.qty;
      total += (e.harga_jual * e.qty);
      $('.counter-wrapper').append(`
      <div class="form-group row">
        <label class="col-2 control-label col-form-label">Qty ${e.barang_nama}</label>
        <div class="col-10">
          <div class="number">
            <span class="minus" id="minus-btn-${e.barang_id}" >-</span>
            <input type="number" min="1" class="input-count" id="input-count-${e.barang_id}" value="${e.qty}" required/>
            <span class="plus" id="plus-btn-${e.barang_id}">+</span>
          </div>
        </div>
      </div>
      `);

      $(`#minus-btn-${e.barang_id}`).click(function (x) { 
        minus(`input-count-${e.barang_id}`, `${e.barang_id}`)
      });

      $(`#plus-btn-${e.barang_id}`).click(function (x) { 
        plus(`input-count-${e.barang_id}`, `${e.barang_id}`)
      });
      
      $(`#input-count-${e.barang_id}`).on('input', function (x) {
        if (parseInt(x.target.value) <= 0) return
        onInput(`${e.barang_id}`, x.target.value);

      });


    });

    $('.qty-value').html(qty);
    $('.total-value').html(total);

    $('.data-checkout').val(JSON.stringify(dataCheckout));
  }

  $(document).ready(function() {
    $('.select2bs4').select2();
  
    $('.select2bs4').change(function (e) { 
      e.preventDefault();
      let dataRaw = $('.select2bs4').val();
      let processedData = [];
      
      dataRaw.forEach(e => {
        processedData.push(JSON.parse(e));
      });
  
      let dataTemp = [];
      processedData.forEach(e => {
        let searchValue = dataCheckout.find(o => o.barang_id == e.barang_id);
        if(!searchValue)
        {
          let item = {
            "barang_id" : e.barang_id,
            "barang_nama" : e.barang_nama,
            "harga_jual" : e.harga_jual,
            "qty" : 1,
          };
          dataTemp.push(item);
        }else{
          dataTemp.push(searchValue);
        }
      });
      dataCheckout = dataTemp;

      refreshDataCheckout();
    });

});




</script>
@endpush