<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Struk Transaksi</title>
</head>

<body style=" width: 100%">
  <div class="struk">
    <div class="title-wrapper" style="text-align: center">
      <h1>PWL POS</h1>
      <h3>Struk Transaksi #{{$transaction->penjualan_kode}}</h3>
      <p>
        -------------------------------------------------------------------------------------------
      </p>
      <h4>Tanggal : {{$transaction->penjualan_tanggal}}</h4>
      <h4>Nama Pembeli : {{$transaction->pembeli}}</h4>
      <h4>Nama Kasir : {{$transaction->user->nama}}</h4>
      <p>
        --------------------------------------------------------------------------------------------
      </p>
    </div>
    <div class="body-wrapper" style="text-align: center">
      @php($total = 0)

      @foreach ($transaction->penjualanDetail as $item)
      <div class="barang-info">
        <h4 class="nama" style="margin-bottom: 8px; margin-top: 8px;">{{$item->barang->barang_nama}}</h4>
        <div class="detail-trans">
          <span class="left">{{$item->jumlah}} X Rp {{$item->harga}}</span>
          <span class="right">Rp {{$item->jumlah * $item->harga}}</span>
        </div>
      </div>
      @php($total += $item->jumlah * $item->harga)
      @endforeach
      <p>
        --------------------------------------------------------------------------------------------
      </p>
    </div>
    <div class="footer" style="text-align: center">
      <div class="barang-info">
        <div class="detail-trans">
          <h4 class="left">Total : Rp.{{$total}}</h4>
        </div>
      </div>
    </div>
  </div>
</body>

</html>