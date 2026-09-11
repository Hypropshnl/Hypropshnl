<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700" rel="stylesheet" />
    <link href=" {{ asset('public_search_ui/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
  </head>
  <body>
    <div class="s010">
      <form>
        <div class="inner-form">
          <div class="basic-search">
            <div class="input-field">
              <input id="search" type="text" placeholder="Type Keywords" />
              <div class="icon-wrap">
                <i class="fa fa-2x fa-search" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <div class="advance-search">
            <span class="desc">SEARCH RESULT</span>
            <div class="row" id="search_result">
              
            </div>            
            <div class="row third">
              <div class="input-field">
                <div class="result-count">
                  <span>108 </span>results</div>
                <div class="group-btn">
                  <button class="btn-delete" id="delete">Print</button>
                  <button class="btn-search">PDF</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>   
    <script src="{{ asset('public_search_ui/js/extention/choices.js') }}"></script>

    <script>
     

    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
