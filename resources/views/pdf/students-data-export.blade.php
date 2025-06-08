<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Data Status Tugas Akhir Mahasiswa</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 12px 15px;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    tr:nth-child(even) {
      background-color: #fafafa;
    }

    caption {
      caption-side: top;
      font-size: 1.5em;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>

  <table id="dataTable" class="table table-jquery table-hover" style="width: 100%">
    <thead>
      <tr>
        <th class="text-white fw-medium">No.</th>
        <th class="text-white fw-medium">NIM</th>
        <th class="text-white fw-medium">Nama</th>
        <th class="text-white fw-medium">Program Studi</th>
        <th class="text-white fw-medium">Status</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      @forelse ($students as $student)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$student['nim']}}</td>
        <td class="text-capitalize">{{$student['name']}}</td>
        <td>{{$student['program_study']}}</td>
        <td>{{$student['submission_status']}}</td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center">Data Tidak Ditemukan</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>

</html>