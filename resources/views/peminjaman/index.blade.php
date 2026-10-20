<h1>Data Peminjaman</h1>

<a href="{{ route('peminjaman.create') }}">
    Ajukan Peminjaman
</a>

@foreach($peminjaman as $item)

    <p>{{ $item->user->name }}</p>

    <p>{{ $item->tanggal_pinjam }}</p>

    <p>{{ $item->status }}</p>

    @if(auth()->user()->role == 'petugas')

    @if($item->status == 'pending')

        <a href="{{ route('peminjaman.approve', $item->id) }}">
            Approve
        </a>

    <form action="{{ route('pengembalian.store', $item->id) }}"
      method="POST">

    @csrf

    <button type="submit">
        Kembalikan
    </button>

</form>

    @endif

@endif

@endforeach