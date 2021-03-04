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

                <div class="error-details">
                    Sorry, an error has occured.
                </div>

                <h2>
                    @yield('code') | @yield('message')</h2>
                <br>

                <div class="error-details">
                    @yield('detail')
                </div>
                <div class="error-actions">
                  <a href="/" class="btn btn-lg btn-primary">Back To Home</a>
                  <!--<a href="/" class="btn btn-lg btn-danger">Contact Support</a>-->
                </div>
            </div>
        </div>
    </div>
</div>
