{{-- @section('style')
    <link rel="stylesheet" href="{{asset('/schools/plugins/tag-editor/jquery.tag-editor.css')}}">
@endsection --}}

@section('scripts')
    <script src="{{asset('/schools/plugins/tag-editor/jquery.caret.min.js')}}"></script>
    <script src="{{asset('/schools/plugins/tag-editor/jquery.tag-editor.min.js')}}"></script>
    <script type="text/javascript">
        var options = {};

        @if ($outflow->exists)
            options = {
                initialTags: {!! $outflow->tags_list !!}
            };
        @endif

        $('input[name=expense_tags]').tagEditor(options);
    </script>
@endsection
