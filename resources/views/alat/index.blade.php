<h1>Data Alat Musik</h1>

<a href="{{ route('alat.create') }}">
    Tambah Alat
</a>

@foreach($alat as $item)

    <p>{{ $item->nama_alat }}</p>
    <p>{{ $item->merk }}</p>
    <p>{{ $item->kategori->nama_kategori }}</p>

@endforeach