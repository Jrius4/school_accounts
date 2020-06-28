<script type="text/javascript">
    @if(session('access_token'))
        var token = "{{session('access_token')}}"

        localStorage.setItem('access_token',token)
    @endif

</script>

