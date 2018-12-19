<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"> -->
    <title>炉石传说卡牌管理系统</title>
</head>
<body style="height: 100%;background-color: #F6F6F6;margin: 0;">
    <div id="app" style="height: 100%;">
        <router-view></router-view>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>