@extends('layouts.front.front')

@section('content')

<!DOCTYPE html>
<html>
    <head>
    <div id="fb-root"></div>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }
        hr {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #fff;
            margin: 25px 0;
            clear: both;
        }
        .centered {
            text-align: center;
        }
        .wrapper {
            width: 100%;
            padding: 30px 0;
        }
        .container {
            width: 1200px;
            margin: 0 auto;
        }
        .grid-container {
            display: none;
        }
        /* ----- Image grids ----- */
        ul.rig {
            list-style: none;
            font-size: 0px;
            margin-left: -2.5%; /* should match li left margin */
        }
        ul.rig li {
            display: inline-block;
            padding: 10px;
            margin: 0 0 2.5% 2.5%;
            background: #fff;
            border: 1px solid #ddd;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            vertical-align: top;
            box-shadow: 0 0 5px #ddd;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        ul.rig li img {
            max-width: 100%;
            height: auto;
            margin: 0 0 10px;
        }
        ul.rig li h3 {
            margin: 0 0 5px;
        }
        ul.rig li p {
            text-align:left;
            color: #000;

        }
        /* class for 2 columns */
        ul.rig.columns-2 li {
            width: 47.5%; /* this value + 2.5 should = 50% */
        }
        /* class for 3 columns */
        ul.rig.columns-3 li {
            width: 30.83%; /* this value + 2.5 should = 33% */
        }
        /* class for 4 columns */
        ul.rig.columns-4 li {
            width: 22.5%; /* this value + 2.5 should = 25% */
        }

        @media (max-width: 1199px) {
            .container {
                width: auto;
                padding: 0 10px;
            }
        }

        @media (max-width: 480px) {
            ul.grid-nav li {
                display: block;
                margin: 0 0 5px;
            }
            ul.grid-nav li a {
                display: block;
            }
            ul.rig {
                margin-left: 0;
            }
            ul.rig li {
                width: 100% !important; /* over-ride all li styles */
                margin: 0 0 20px;
            }
        }

        .imgboxes li {
            position:relative;
            text-align:center;
            min-height:500px;
        }

        .imgboxes h3 {
            /*text-align:left;*/
            text-align:center;
        }

        @media (max-width: 480px) {
            .imgboxes li {

                min-height:initial;
            }

        }

        .btn-primary {
            background-color:#548E2A;
            color:#fff;
            border-color:#528A28;
        }

        .btn-primary:hover {
            background-color:#4B7E25;
            border-color:#528A28;
        }
        .icons {
            display:inline-block;float:left;font-size:18px;margin-right:4px;
        }

        .botalignbutt {
            width:100%;
            position:absolute;
            bottom:11px;
            margin-left:auto;
            margin-right:auto;
            left:0;
            right:0;
            padding-left:10px;
            padding-right:10px;
        }

        .fakebuttonbreak {
            width:100%;
            height:60px;
        }
        p span 
        {
            display: block;
        }
    </style>
    <script>
        (function($) {
            /*Browser detection patch*/
            if (!jQuery.browser) {
                jQuery.browser = {};
                jQuery.browser.mozilla = !1;
                jQuery.browser.webkit = !1;
                jQuery.browser.opera = !1;
                jQuery.browser.msie = !1;
                var nAgt = navigator.userAgent;
                jQuery.browser.ua = nAgt;
                jQuery.browser.name = navigator.appName;
                jQuery.browser.fullVersion = "" + parseFloat(navigator.appVersion);
                jQuery.browser.majorVersion = parseInt(navigator.appVersion, 10);
                var nameOffset, verOffset, ix;
                if (-1 != (verOffset = nAgt.indexOf("Opera")))
                    jQuery.browser.opera = !0, jQuery.browser.name = "Opera", jQuery.browser.fullVersion = nAgt.substring(verOffset + 6), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8));
                else if (-1 != (verOffset = nAgt.indexOf("MSIE")))
                    jQuery.browser.msie = !0, jQuery.browser.name = "Microsoft Internet Explorer", jQuery.browser.fullVersion = nAgt.substring(verOffset + 5);
                else if (-1 != nAgt.indexOf("Trident")) {
                    jQuery.browser.msie = !0;
                    jQuery.browser.name = "Microsoft Internet Explorer";
                    var start = nAgt.indexOf("rv:") + 3, end = start + 4;
                    jQuery.browser.fullVersion = nAgt.substring(start, end)
                } else
                    -1 != (verOffset = nAgt.indexOf("Chrome")) ? (jQuery.browser.webkit = !0, jQuery.browser.name = "Chrome", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7)) : -1 != (verOffset = nAgt.indexOf("Safari")) ? (jQuery.browser.webkit = !0, jQuery.browser.name = "Safari", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8))) : -1 != (verOffset = nAgt.indexOf("AppleWebkit")) ? (jQuery.browser.webkit = !0, jQuery.browser.name = "Safari", jQuery.browser.fullVersion = nAgt.substring(verOffset + 7), -1 != (verOffset = nAgt.indexOf("Version")) && (jQuery.browser.fullVersion = nAgt.substring(verOffset + 8))) : -1 != (verOffset = nAgt.indexOf("Firefox")) ? (jQuery.browser.mozilla = !0, jQuery.browser.name = "Firefox", jQuery.browser.fullVersion = nAgt.substring(verOffset + 8)) : (nameOffset = nAgt.lastIndexOf(" ") + 1) < (verOffset = nAgt.lastIndexOf("/")) && (jQuery.browser.name = nAgt.substring(nameOffset, verOffset), jQuery.browser.fullVersion = nAgt.substring(verOffset + 1), jQuery.browser.name.toLowerCase() == jQuery.browser.name.toUpperCase() && (jQuery.browser.name = navigator.appName));
                -1 != (ix = jQuery.browser.fullVersion.indexOf(";")) && (jQuery.browser.fullVersion = jQuery.browser.fullVersion.substring(0, ix));
                -1 != (ix = jQuery.browser.fullVersion.indexOf(" ")) && (jQuery.browser.fullVersion = jQuery.browser.fullVersion.substring(0, ix));
                jQuery.browser.majorVersion = parseInt("" + jQuery.browser.fullVersion, 10);
                isNaN(jQuery.browser.majorVersion) && (jQuery.browser.fullVersion = "" + parseFloat(navigator.appVersion), jQuery.browser.majorVersion = parseInt(navigator.appVersion, 10));
                jQuery.browser.version = jQuery.browser.majorVersion
            }



            $.fn.equalizeCols = function() {
                var height = 0,
                        reset = $.browser.msie && $.browser.version < 7 ? "1%" : "auto";
                var ww = window.innerWidth || $(window).width();
                if (ww <= 480) {
                    return this.css("height", "100%");
                }
                else {
                    return this
                            .css("height", reset)
                            .each(function() {
                                height = Math.max(height, this.offsetHeight);
                            })
                            .css("height", height)
                            .each(function() {
                                var h = this.offsetHeight;
                                if (h > height) {
                                    $(this).css("height", height - (h - height));
                                }
                                ;
                            });
                }
            };



            $(document).ready(function() {

                var $els = $("#col1, #col2, #col3").equalizeCols();

            });

            $(window).bind('resize', function() {

                var $els = $("#col1, #col2, #col3").equalizeCols();
            });
        })(jQuery);
    </script>
</head>

<body>

<body onload="countdown();">
    <div class="wrapper">
        <div class="container">

@if($status == 0)

<h1>Thank you for your sell order...</h1>

            <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-sign icons"></span>You have successfully registered your sale (<b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b>). A confirmation email has been sent to <b>{{ $personal_info['email'] }}</b> (please check your junk folder if you can't find it).</div>

<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign icons"></span>If you haven't received a confirmation email <a href="mailto:support@geckomobilerecycling.co.uk?subject=Confirmation Email Not Received
&body=I'd like to let you know that I have not received my confirmation email.">click here</a>.</div>
<h3>Post your mobile within <div id="countdown_div", style="display: inline">Countdown Timer Loading...</div> to be paid the following day!*</h3>
<h2>How to post...</h2>
<br>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign icons"></span>TO AVOID DELAYED PAYMENT YOU MUST <a href="https://www.geckomobilerecycling.co.uk/erase" target="_blank">REMOVE APPLE'S ICLOUD ACTIVATION LOCK</a> BEFORE SENDING A USED IPHONE OR IPAD TO US.</div>
            <ul class="rig columns-3 imgboxes">
                <li id="col1">
                    <h3>Print </h3>
<i><A HREF="#noprinter">Don't have a printer?</A></i>
                    <img src="/assets/images/delivery_icons/stamp.png" />

                    <p><b>Print a pre-paid Royal Mail postage label.</b></p><p> You’ll need to stick it to your packaging. (Sellotape should do the trick). </p>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a href="http://bit.ly/gecko-postage-label" target="_blank" class="btn btn-primary btn-lg" role="button">Download Postage Label</a>
                    </div>
                </li>
                <li id="col2">
                    <h3>Pack </h3>
<br>
                    <img src="/assets/images/delivery_icons/cardboardbox.png" />

                    <p>
                        <b>Package your mobile.</b></p><p> You may already have packaging at home. If not, you can get some at the Post Office later. To help us process your mobile faster, please include your Packing Slip.</p>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a  href="{{asset("pdf/".$order_id.".pdf")}}" target="_blank" class="btn btn-primary btn-lg" role="button">Download Packing Slip</a>
                    </div>

                </li>
                <li id="col3">
                    <h3>Post</h3>
<br>
                    <img src="/assets/images/delivery_icons/shop.png" />

                    <p> 
                        <b>Take your mobile to a Post Office.</b></p><p> Ask the cashier to place a tracking label on the package. They will give you a receipt with a code that allows you to track your parcel on the Royal Mail website.
                    </p>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a href="http://bit.ly/RMbranchFinder" target="_blank" class="btn btn-primary btn-lg" role="button">Find your nearest Post Office</a>	
                    </div>
                </li>

            </ul>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign icons"></span>You must include your Packing Slip or your <b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b> with your mobile so we know it is yours.</div>



            <A NAME="noprinter"></a>
<h2>Don't have a printer? We will cover your postage.</h2>

            <br>If you can't print our pre-paid postage label, you can still go ahead and post your mobile to us at the following address. When your mobile arrives we will add the cost of your postage to our offer (up to £3.90, the cost of Royal Mail 2nd Class Signed For).</br>
<br>
<i>Post your mobile to:</i>
            <div class="container-fluid">
                <div style="width:194px;display:inline-block;height:116px;">
                    <br><b> Gadget Recycling Ltd.
                        <br>t/a Justin Mobile Recycling
                        <br>Queensgate House
                        <br>48 Queen Street
                        <br>Exeter
                        <br>EX4 3SR</b>
                </div>
                 <!--<div style="padding-left:15px; display:inline-block;height:116px;">
                    <a href="http://bit.ly/parcel2go" target="_blank" class="btn btn-primary btn-lg" role="button" style="float:left;position:relative;top:58px;margin-top:-20px;">Find alternative delivery service</a>
                </div>-->
            </div>



        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign icons"></span>If you have any questions about your sell order, please <a href="https://www.geckomobilerecycling.co.uk/contact" target="_blank">contact us</a> quoting your <b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b>.</div>
    *Excluding weekends and public holidays. Our countdown timer assumes the last collection at your Post Office is 17:30 on a weekday or 12:00 on a Saturday.
  
@elseif ($status == 1)

<h1>Sit back and relax, your welcome pack is on its way!</h2>
<br>
            <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-sign icons"></span>You have successfully registered your sale (<b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b>). A confirmation email has been sent to <b>{{ $personal_info['email'] }}</b> (please check your junk folder if you can't find it).</div>

<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign icons"></span>Your freepost label, packaging and instructions are on their way to your address. If they haven't arrived after a couple of working days please <a href="https://www.geckomobilerecycling.co.uk/contact" target="_blank">contact us</a>.</div>
<br>
<h2>Got a printer and don't want to wait?</h2>
<br>
<div class="alert alert-warning" role="alert"><h3 style="margin:0;">Post your mobile within <div id="countdown_div", style="display: inline">Countdown Timer Loading...</div> to be paid the following day!*</h3></div>
           <h2>How to post...</h2><br>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign icons"></span>You must <a href="https://www.geckomobilerecycling.co.uk/erase" target="_blank">remove Apple's iCloud Activation Lock</a> before sending a used iPhone or iPad to us.</div>
            <ul class="rig columns-3 imgboxes">
                <li id="col1">
                    <h3>Print </h3>
                    <img src="/assets/images/delivery_icons/stamp.png" />

                    <br>
                    <p><b>Print a free Royal Mail postage label.</b></p><p> You’ll need to stick it to your packaging. (Sellotape should do the trick).</p>
                    <br>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a href="http://bit.ly/gecko-postage-label" target="_blank" class="btn btn-primary btn-lg" role="button">Download Postage Label</a>
                    </div>
                </li>
                <li id="col2">
                    <h3>Pack </h3>
                    <img src="/assets/images/delivery_icons/cardboardbox.png" />

                    <p> 
                        <b>Package your mobile.</b></p><p> You may already have packaging at home. If not, you can get some at the Post Office later. To help us process your mobile faster, please include your Packing Slip.</p>
                    <br>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a  href="{{asset("pdf/".$order_id.".pdf")}}" target="_blank" class="btn btn-primary btn-lg" role="button">Download Packing Slip</a>
                    </div>

                </li>
                <li id="col3">
                    <h3>Post</h3>
                    <img src="/assets/images/delivery_icons/shop.png" />

                    <p> 
                        <b>Take your mobile to a Post Office.</b></p><p> Ask the cashier to place a tracking label on the package. They will give you a receipt with a number that allows you to track your parcel on the Royal Mail website.
                    </p>
                    <div class="fakebuttonbreak"></div>
                    <div class="botalignbutt">
                        <a href="http://bit.ly/RMbranchFinder" target="_blank" class="btn btn-primary btn-lg" role="button">Find your nearest Post Office</a>	
                    </div>
                </li>

            </ul>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign icons"></span>You must <a href="https://www.geckomobilerecycling.co.uk/erase" target="_blank">remove Apple's Activation Lock</a> before sending a used iPhone or iPad to us.</div>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign icons"></span>You must include your Packing Slip or your <b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b> with your mobile so we know it is yours.</div>



            <h2>Don't want to use the Post Office?</h2>

            <br>Perhaps the Post Office isn’t open when you’re free, or you’d simply rather not use Royal Mail. No problem! Simply send your mobile to the address below using your preferred delivery service.</br>
            <div class="container-fluid">
                <div style="width:194px;display:inline-block;height:116px;">
                    <br><b> Gadget Recycling Ltd.
                        <br>t/a Justin Mobile Recycling
                        <br>Queensgate House
                        <br>48 Queen Street
                        <br>Exeter
                        <br>EX4 3SR</b>
                </div>
                <div style="padding-left:15px; display:inline-block;height:116px;">
                    <a href="http://bit.ly/parcel2go" target="_blank" class="btn btn-primary btn-lg" role="button" style="float:left;position:relative;top:58px;margin-top:-20px;">Find alternative delivery service</a>
                </div>
            </div>


            <br>

        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign icons"></span>If you have any questions about your sell order, please <a href="https://www.geckomobilerecycling.co.uk/contact" target="_blank">contact us</a> quoting your <b>Sell Order #{{ \Crypt::decrypt($order_id) }}</b>.</div>
    *Excluding weekends and public holidays. Only applies if you chose to be paid 'Same Day'. Our countdown timer assumes the last collection at your Post Office is 17:30 on a weekday or 12:00 on a Saturday.

@endif

<!--Start Townside Affiliate Network Code-->

<img src="http://track.productadmin.co.uk/trackingcode_sale.php?mid=39&sec_id=M_39dcncr24dc&sale=[order_amount]&orderId={{ \Crypt::decrypt($order_id) }}&email={{ $personal_info['email'] }}&name={{ $personal_info['name'] }}" height="1" width="1" alt="">

<!-- End Townside Affiliate Network Code -->

  <!-- Google Code for Registered sale Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 974242067;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "9bL5CKWgmggQk4LH0AM";
        var google_conversion_value = 0;
        var google_remarketing_only = false;
        /* ]]> */
    </script>
    <script type="text/javascript" src=" https://www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src=" https://www.googleadservices.com/pagead/conversion/974242067/?value=0&amp;label=9bL5CKWgmggQk4LH0AM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>

<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.msn.com/mstag/site/296750e9-2288-40dc-a109-f2a7dd499184/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"47006230",type:"1",revenue:"35",actionid:"268115"})</script> <noscript> <iframe src="//flex.msn.com/mstag/tag/296750e9-2288-40dc-a109-f2a7dd499184/analytics.html?dedup=1&domainId=47006230&type=1&revenue=35&actionid=268115" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>

    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
    <script type="text/javascript">
        twttr.conversion.trackPid('l48gi');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l48gi&p_id=Twitter" />
    </noscript>

 <!-- Facebook Conversion Code for Register Sale -->
<script>(function() {
var _fbq = window._fbq || (window._fbq = []);
if (!_fbq.loaded) {
var fbds = document.createElement('script');
fbds.async = true;
fbds.src = '//connect.facebook.net/en_US/fbds.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(fbds, s);
_fbq.loaded = true;
}
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6013263164813', {'value':'0.01','currency':'GBP'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6013263164813&amp;cd[value]=0.01&amp;cd[currency]=GBP&amp;noscript=1" /></noscript>

    <img src="https://www.clixGalore.com/AdvTransaction.aspx?AdID=15240&OID=<?php echo \Crypt::decrypt($order_id); ?>" height="0" width="0" border="0">



</body>
</html>

    @stop