<!doctype html>
<title>CodeMirror: Active Line Demo</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/lib/codemirror.css') }}">
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/addon/dialog/dialog.css') }}">
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/addon/lint/lint.css') }}">
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/addon/search/matchesonscrollbar.css') }}">
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/addon/dialog/dialog.css') }}">
<link rel="stylesheet" href="{{ Helper::vendor('codemirror/theme/monokai.css') }}">
<link href="https://fonts.googleapis.com/css?family=B612+Mono" rel="stylesheet">
<style>
.breakpoints {
    width: .8em;
}

.breakpoint {
    color: #822;
}

.CodeMirror {
    border: 1px solid #aaa;
    font-family: 'B612 Mono', monospace;
    font-size: 14px;
    font-weight: lighter;
}

.cm-matchhighlight {
    border: 0.5px solid grey;
    border-radius: 5px;
    padding: 0px 0.5px;
}

.CodeMirror-focused .cm-matchhighlight {
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAFklEQVQI12NgYGBgkKzc8x9CMDAwAAAmhwSbidEoSQAAAABJRU5ErkJggg==);
    background-position: bottom;
    background-repeat: repeat-x;
}

.CodeMirror-selection-highlight-scrollbar {
    background-color: #272822
}
</style>
</style>
<script src="{{ Helper::vendor('codemirror/lib/codemirror.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/selection/active-line.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/edit/closebrackets.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/edit/closetag.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/edit/matchtags.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/foldcode.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/foldgutter.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/brace-fold.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/xml-fold.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/indent-fold.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/markdown-fold.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/fold/comment-fold.js') }}"></script>

<script src="{{ Helper::vendor('codemirror/addon/lint/lint.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/lint/javascript-lint.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/lint/json-lint.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/lint/css-lint.js') }}"></script>

<script src="{{ Helper::vendor('codemirror/addon/comment/comment.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/display/fullscreen.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/scroll/annotatescrollbar.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/matchesonscrollbar.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/searchcursor.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/match-highlighter.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/searchcursor.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/search.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/dialog/dialog.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/addon/search/jump-to-line.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/keymap/sublime.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/css/css.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/clike/clike.js') }}"></script>
<script src="{{ Helper::vendor('codemirror/mode/php/php.js') }}"></script>
<article>
    <h2>Active Line Demo</h2>
    <form>
        <textarea id="code" name="code">{{ $data }}</textarea>
    </form>
    <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        styleActiveLine: true,
        keyMap: "sublime",
        theme: "monokai",
        lineNumbers: true,
        gutters: ["CodeMirror-linenumbers", "breakpoints"],
        lineWrapping: true,
        autoCloseBrackets: true,
        matchTags: { bothTags: true },
        autoCloseTags: true,
        viewportMargin: Infinity,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        extraKeys: { 
            "Alt-F": "findPersistent",
        },
        highlightSelectionMatches: { showToken: /\w/, annotateScrollbar: true },
    });

    editor.on("gutterClick", function(cm, n) {
        var info = cm.lineInfo(n);
        cm.setGutterMarker(n, "breakpoints", info.gutterMarkers ? null : makeMarker());
    });

    function makeMarker() {
        var marker = document.createElement("div");
        marker.style.color = "#822";
        marker.innerHTML = "●";
        return marker;
    }

    </script>
</article>