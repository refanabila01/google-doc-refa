<h1>Buat Document</h1>

<form action="/documents" method="POST">

    @csrf

    <input
        type="text"
        name="title"
        placeholder="Judul Document"
    >

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>