<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #fafafa;
    }

    .container {
        text-align: center;
        margin-top: 70px;
    }

    h1 {
        color: #222;
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        background: #667ef5;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn:hover {
        background: #e8437a;
    }

    hr {
        width: 40%;
        margin-top: 30px;
        border: none;
        border-top: 1px solid #eee;
    }
</style>

<div class="container">
    <h1>Nama Dokument</h1>

    <a href="/documents/create" class="btn">
        + Tambah Dokumen
    </a>

    <hr>
</div>
@foreach ($documents as $document)

    <h3>

        <a href="/documents/{{ $document->id }}">

            {{ $document->title }}

        </a>

    </h3>

@endforeach