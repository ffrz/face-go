@extends('export.layout', [
    'title' => $title,
])

@section('content')
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Status</th>
        <th>Catatan</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($items as $index => $item)
        <tr>
          <td align="right">{{ $index + 1 }}</td>
          <td>{{ $item->nik }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->phone }}</td>
          <td>{{ $item->address }}</td>
          <td>{{ $item->active ? 'Aktif' : 'Non Aktif' }}</td>
          <td>{{ $item->notes }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" align="center">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
