<h1>Tambah Alat</h1>

<form action="{{ route('alat.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="text" name="kode_alat" placeholder="Kode">

    <input type="text" name="nama_alat" placeholder="Nama">

    <input type="text" name="merk" placeholder="Merk">

    <input type="number" name="stok" placeholder="Stok">

    <select name="kondisi">

        <option value="baik">Baik</option>
        <option value="rusak ringan">Rusak Ringan</option>
        <option value="rusak berat">Rusak Berat</option>

    </select>

    <select name="kategori_id">

        @foreach($kategori as $item)

            <option value="{{ $item->id }}">
                {{ $item->nama_kategori }}
            </option>

        @endforeach

    </select>

    <input type="file" name="foto">

    <button type="submit">
        Simpan
    </button>

</form>