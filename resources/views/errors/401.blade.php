<html>
  <head>
    <title>{{ config('backpack.base.project_name') }} Error 401</title>

    <link href='//fonts.googleapis.com/css?family=sans-serif:100' rel='stylesheet' type='text/css'>

    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: #B0BEC5;
        display: table;
        font-weight: 100;
        font-family: 'sans-serif';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 156px;
      }

      .quote {
        font-size: 36px;
      }

      .explanation {
        font-size: 24px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">401</div>
        <div class="quote" style="color: #0b97c4; font-weight: bold">
          Tài khoản của bạn đã hết thời gian sử dụng dịch vụ. <br> Vui lòng liên hệ hotline: {{\App\Setting::getValue('phonetraphi')}} để được hỗ trợ nâng cấp tài khoản.
        </div>
        <div class="explanation">
          <br>

       </div>
      </div>
    </div>
  </body>
</html>
