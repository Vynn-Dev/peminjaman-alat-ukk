<h1>Ajukan Peminjaman</h1>

<form action="{{ route('peminjaman.store') }}"
      method="POST">

    @csrf

    <input type="date" name="tanggal_pinjam">

    <input type="date" name="tanggal_kembali">

    <select name="alat_id">

        @foreach($alat as $item)

            <option value="{{ $item->id }}">
                {{ $item->nama_alat }}
            </option>

        @endforeach

    </select>

    <input type="number"
           name="jumlah"
           placeholder="Jumlah">

    <button type="submit">
        Ajukan
    </button>

</form>