@if (session('success'))
    <div class="alert alert-success text-center" style="background-color: #d1e7dd">{{session('success')}}</div>
@endif

@if (session('info'))
     <div class="alert alert-info text-center" style="background-color: ##cff4fc">{{session('info')}}</div>
@endif

@if (session('danger'))
    <div class="alert alert-danger text-center" style="background-color: #F8D7DA">{{session('danger')}}</div>
@endif