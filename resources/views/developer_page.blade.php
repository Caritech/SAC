<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<style>
.error-template {padding: 200px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">

                <div class="error-details h1">
                    Developer Console
                </div>

                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{session('status')}}
                    </div>
                @endif

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width:1%">Function</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >
                                <form action="/developer/config_cache" method="POST">
                                    @csrf
                                    <input type="submit" value="php artisan config:cache" class="btn btn-sm btn-primary">
                                </form>
                            </td>
                            <td>Use when update .env or files in config directory</td>
                        </tr>
                    </tbody>
                </table>

           
                
                  
              

                <div class="error-details">
                   
                </div>
                <div class="error-actions">
                  <a href="/" class="btn btn-lg btn-primary">Back To Home</a>
                  <!--<a href="/" class="btn btn-lg btn-danger">Contact Support</a>-->
                </div>
            </div>
        </div>
    </div>
</div>
