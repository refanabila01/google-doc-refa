<h1>{{ $document->title }}</h1>

<div id="live-cursor" style="margin-bottom:10px;"></div>

<textarea
    id="editor"
    style="width:100%; height:400px;"
>{{ $document->content }}</textarea>

@vite(['resources/js/app.js'])

<script type="module">

window.addEventListener('DOMContentLoaded', () => {

    let editor = document.getElementById('editor');

    console.log("JS REALTIME AKTIF");

    console.log(editor);

    console.log(window.Echo);

    if (window.Echo) {

        window.Echo.connector.pusher.connection.bind('connected', () => {

            console.log('WEBSOCKET CONNECTED');

        });

    }

    // DEBOUNCE
    let timeout;

    // LIVE CURSOR
    editor.addEventListener('click', function () {

        fetch('/cursor', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({

                document_id: {{ $document->id }},

                position: editor.selectionStart

            })

        });

    });

    // SAVE DOCUMENT
    editor.addEventListener('keyup', function () {

        clearTimeout(timeout);

        timeout = setTimeout(() => {

            fetch('/documents/{{ $document->id }}', {

                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: JSON.stringify({
                    content: editor.value
                })

            });

        }, 300);

    });

    // TYPING STATUS
    let isTyping = false;

    editor.addEventListener('keydown', () => {

        isTyping = true;

    });

    editor.addEventListener('keyup', () => {

        setTimeout(() => {

            isTyping = false;

        }, 500);

    });

    // REALTIME LISTENER
    window.Echo.channel('document.{{ $document->id }}')

    .listen('.document.updated', (e) => {

        console.log("EVENT MASUK");

        // Jangan overwrite saat user sedang mengetik
        if (!isTyping) {

            if (editor.value !== e.document.content) {

                editor.value = e.document.content;

            }

        }

    })

    .listen('.cursor.moved', (e) => {

        console.log("CURSOR MOVED");

        document.getElementById('live-cursor').innerHTML =
            e.user + ' cursor di posisi: ' + e.position;

    });

});

</script>

<hr>

<h2>Version History</h2>

@forelse($document->versions ?? [] as $version)
    <div style="
        border:1px solid #ccc;
        padding:10px;
        margin-bottom:10px;
        border-radius:10px;
    ">

        <strong>
            {{ $version->user_name }}
            -
            {{ $version->created_at }}
        </strong>

        <pre>{{ $version->content }}</pre>

    </div>

@empty
    <p>Tidak ada version history</p>
@endforelse