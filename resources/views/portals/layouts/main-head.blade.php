<script type="text/javascript">


    window.Laravel =  {"csrfToken":'{{csrf_token()}}'};

</script>
@if(!auth()->guest())
        <script type="text/javascript">
            window.Laravel.userId = {{auth()->user()->id}};
            // window.Laravel.following_admin = {{auth()->user()->isFollowing(1)}};
        </script>

@endif

<style>
    body{
        background-color: #516369;
    }
    .wrapper{
        min-height: 100vh;
    }
    .profile-pic:hover{
        transform: scale(1.8);
        transition-duration: 2s;
    }
    .dashiy{
        background-color: #f9f9f9 !important;
    }
    label{
        text-transform: capitalize;
    }
    .dropdown-item:hover{
      background: #434d4e !important;
      cursor: pointer;
  }
  .dropdown-item:active{
      background: #434d4e !important;
  }
    footer{
    background-color: #242b2d !important;
    color: antiquewhite !important;
    border: none !important;

    }
    footer a{
        color: #61e490 !important;
    }
    .main-sidebar{
        max-height: 100vh !important;
    }
    </style>

    <link rel="shortcut icon" href="{{asset('schools/img/favicon.ico')}}" type="image/x-icon">
