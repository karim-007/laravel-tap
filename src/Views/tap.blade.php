<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <div class="row align-items-center">
        <div class="col-sm-4"></div>
        <div class="mt-lg-5 ml-lg-5 col-md-4 col-sm-12">
            <button id="tokenButton" type="button" class="btn btn-primary" onclick="iframeInitiate(this)">Pay Now</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!--<script src="https://merchant-pg-ui-prod.tadlbd.com/script.js"></script>-->
<script src="https://mwstaging.tadlbd.com/merchant-pg-sandbox/pg-ui/script.js"></script>
<script>
    $( document ).ready(function() {
        iframeInitiate()
    });
    function iframeInitiate(param) {
        // 1. Getting the Access Token
        var settings = {
            url: "https://auth-sandbox.tadlbd.com/oauth/token",
            method: "POST",
            timeout: 0,
            headers: {
                Authorization: "Basic {{ config("tap.auth_token$account") }}",
                "Content-Type": "application/x-www-form-urlencoded",
            },
            data: {
                grant_type: "password",
                username: "{{ config("tap.username$account") }}",
                password: "{{ config("tap.password$account") }}",
            },
            async: true,
        };
        $.ajax(settings).done(function (response) {
            // 2. Loading the iFrame
            tapIFrame($('body'), {
                token: response.access_token,
                authAPIKey: "{{ config("tap.authAPIKey$account") }}",
                paymentMode: "iFrame",
                requestorReferenceId: "{{ $data['requestorReferenceId'] }}",
                callBackUrl: "{{ $data['callBackUrl'] }}",
                amount: "{{ $data['amount'] }}",
                invoiceNumber: "{{ $data['invoiceNumber'] }}",
                additionalInformation: "{{ $data['additionalInformation'] }}",
                popUpCloseTimeOut : "{{ $data['popUpCloseTimeOut'] }}"
            });
        })

    }

    function backToApp(){
        let data = getOS();
        if(getOS() == "iOS"){
            window.webkit.messageHandlers.myOwnJSHandler.postMessage(data);
        } else if(getOS() == "Android"){
            cnsJsBridge.returnToApp(data)
        }
    }

    function getOS() {
        var userAgent = window.navigator.userAgent,
            platform = window.navigator.platform,
            macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
            windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
            iosPlatforms = ['iPhone', 'iPad', 'iPod'],
            os = null;

        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'Mac';
        } else if (iosPlatforms.indexOf(platform) !== -1) {
            os = 'iOS';
        } else if (windowsPlatforms.indexOf(platform) !== -1) {
            os = 'Windows';
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
        } else if (!os && /Linux/.test(platform)) {
            os = 'Linux';
        }

        return os;
    }

    function tapTransactionDone(response){
        if(getOS() == "iOS"){
            window.webkit.messageHandlers.myOwnJSHandler.postMessage(response);
        } else if(getOS() == "Android"){
            cnsJsBridge.returnToApp(response)
        }
    }

    function tapWindowClosed(response){
        if(getOS() == "iOS"){
            window.webkit.messageHandlers.myOwnJSHandler.postMessage(response);
        } else if(getOS() == "Android"){
            cnsJsBridge.returnToApp(response)
        }
    }

    function receiver(ev) {
        if(ev.data.func == "tapWindowClosed"){
            tapWindowClosed(ev.data.param)
        } else{
            tapTransactionDone(ev.data.param)
        }
    }

    if (window.addEventListener) {
        window.addEventListener("message", receiver, false);
    } else {
        window.attachEvent("onmessage", receiver);
    }

</script>
</body>
</html>
