<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
<!--<meta http-equiv="refresh" content="0; url=https://www.geckomobilerecycling.co.uk/away.html" />-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php            
            $url = Request::path() == '/' ? 'geckomobilerecycling.co.uk' : str_replace('https://www.', '', Request::url());
            echo "Hello";
            exit;
            $pageMeta = (object)array();
            $defaultMeta = (object)array();

            try {
                $defaultMeta = DB::connection('mysql2')->select('Select id, slug, title, description, keywords From seo Where id = 32');
                $defaultMeta = $defaultMeta[0];
            } catch (Exception $e) {

            }

            try{
                $pageMeta = DB::connection('mysql2')->select('Select id, slug, title, description, keywords From seo Where slug Like "'.$url.'"');
                $pageMeta = $pageMeta[0];
            } catch (Exception $e) {
                $pageMeta = $defaultMeta;

            }
            $metaTitle = (isset($pageMeta->title) && $pageMeta->title != '') ? $pageMeta->title : $defaultMeta->title;
            $metaKeywords = (isset($pageMeta->keywords) && $pageMeta->keywords != '') ? $pageMeta->keywords : $defaultMeta->keywords;
            $metaDescription = (isset($pageMeta->description) && $pageMeta->description != '') ? $pageMeta->description : $defaultMeta->description;
        ?>
        <meta name="description" content="{{$metaDescription}}">
        <meta name="keywords" content="{{$metaKeywords}}">
        <meta name="author" content="">
        <title>{{$metaTitle}}</title>
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/front.css" rel="stylesheet">
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/front.js"></script>
        <script type='text/javascript' src='/assets/js/countdown.js'></script>
        <link type="text/css" rel="stylesheet" href="/assets/css/responsive-tabs.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/responsive-tabs-style.css" />
        <script src="/assets/js/jquery.responsiveTabs.js" type="text/javascript"></script>
<link rel="shortcut icon" href="https://www.geckomobilerecycling.co.uk/assets/images/favicon.ico" >
<meta property="og:image" content="http://www.geckomobilerecycling.co.uk/assets/images/geckoa.jpg"; />
<meta property="og:image:secure_url" content="https://www.geckomobilerecycling.co.uk/assets/images/geckoa.jpg" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="300" />
<meta property="og:image:height" content="300" />
<meta property="og:description" content="Check out Justin Mobile Recycling!" />

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1tpLHpEz1WXy3TAbRJRsjlxQCT6f3nmF';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
<script type="text/javascript">
    function hideImage(){
        document.getElementById('cgImage').style.display='none';
    }
</script>
</head>
<body>

        <?php // require_once app_path() . '/views/layouts/front/arscode-social-slider/arscode-social-slider.php'; ?>
        <div class="navbar navbar-inverse navbar-gecko" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php $navigation = array(
                           'contact' => array(
                                'route' => 'contact',
                                'label' => 'Contact Us'
                            ),

                            'blog' => array(
                                    'route' => 'blog',
                                    'label' => 'Blog'
                            ),
                            'about-us' => array(
                                'route' => 'why-use-us',
                                'label' => 'Why Use Us'
                            ),
                            'faq' => array(
                                'route' => 'faq',
                                'label' => 'FAQ'
                            )
                        );
                        foreach ($products as $prod) {
                            $navigation[] = array(
                                'route' => 'sell/' . $prod->slug,
                                'label' => 'Sell Your ' . $prod->name
                            );
                        }
                        $navigation = array_reverse($navigation);
                        ?>
                        @foreach ($navigation as $nav_item)
                        <li class="{{ Request::is("{$nav_item['route']}*") ? 'active' : '' }}">
                            <a href="/{{ $nav_item['route'] }}">{{ $nav_item['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <ul class="pull-right social-icons xs-hidden">
                        <li><a href="http://plus.google.com/u/0/b/104124105732445360642/104124105732445360642/posts"target="_blank" ><img src="/assets/images/social/google.png" alt="iPhone recycling"/></a></li>
                        <li><a href="http://twitter.com/Gecko_Mobile"target="_blank" ><img src="/assets/images/social/twitter.png" alt="Mobile recycling"/></a></li>
                        <li><a href="http://www.facebook.com/GeckoMobileRecycling"target="_blank" ><img src="/assets/images/social/facebook.png" alt="Sell my iPhone"/></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <header class="container" id="header">
            <div class="row">
                <div class="col-md-8 logo">
                    <?php $logo =  'logo.png'; if(isset($product->logo) && !empty($product->logo)) { $logo = $product->logo; } ?>
                    <a href="http://{{ Config::get('app.url') }}" alt="{{ Config::get('recycle.name') }}"/>
                        <img src="/assets/images/logo/{{ $logo }}" alt="{{ Config::get('recycle.name') }}" title="{{ Config::get('recycle.name') }}" class="img-responsive"/>
                    </a>
                </div>
                <?php if(isset($product)) { ?>
                <div class="col-lg-4 hidden-xs hidden-md">
                    <h1 class="pull-right" style="margin-top: 70px; color:#AAA; font-size: 41px;">
                        Sell your {{ $product->name }}...
                    </h1>
                </div>
                <?php } ?>
            </div>
            <hr>
        </header>
        <div class="container" id="wrapper">
            <div id="content">
                @yield('content')
            </div>
        </div>
        <footer id="footer" class="container">
<div class="row">
<div class="col-md-12">
            <hr>
<script type="text/javascript">
        $(document).ready(function () {
            $('#horizontalTab').responsiveTabs({
                rotate: false,
                startCollapsed: 'accordion',
                collapsible: 'accordion',
                setHash: true,
                disabled: [],
                activate: function(e, tab) {
                    $('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
                }
            });

            $('#start-rotation').on('click', function() {
                $('#horizontalTab').responsiveTabs('active');
            });
            $('#stop-rotation').on('click', function() {
                $('#horizontalTab').responsiveTabs('stopRotation');
            });
            $('#start-rotation').on('click', function() {
                $('#horizontalTab').responsiveTabs('active');
            });
            $('.select-tab').on('click', function() {
                $('#horizontalTab').responsiveTabs('activate', $(this).val());
            });

        });
    </script>

    <!--Horizontal Tab-->
    <div id="horizontalTab">
        <ul>
            <li><a href="#tab-1">Postage</a></li>
            <li><a href="#tab-2">Tracking your order</a></li>
            <li><a href="#tab-3">Payment</a></li>
            <li><a href="#tab-4">FAQ</a></li>
        </ul>

        <div id="tab-1">
<p>We provide detailed instructions on posting your handset or tablet to us after you have registered your sale. The Royal Mail 1st Class postage label we give you is fully tracked so you know where your mobile is at all times. Postage is always free whether you use our iPhone or our <b>iPad trade in</b> service.
</p>        </div>
        <div id="tab-2">
 <p>You can track your parcel every step of its way to us, and we will text and/or email you once it arrives at our premises and again once we have finished checking your mobile and sent payment. We understand that knowing the whereabouts of your expensive handset or tablet is important to you, especially when using a <b>mobile recycling</b> service you haven’t used before.
</p>        </div>
        <div id="tab-3">
  <p>Our iPad and <b>iPhone trade in</b> service offers the option of same day payment. So if you post your iPhone or iPad today you could have the cash in your account tomorrow!</p>        </div>
        <div id="tab-4">
 <p>Q: I want to <b>sell my mobile</b> but it’s not an iPhone or iPad, will you accept it?</p>
<p>A: We’re happy to take any tech off of your hands for a great price! Please <a href="/contact"target="_blank" >contact us</a>.</p>
<p>Q: I want to <b>sell my iPhone</b>, when will I be paid?</p>
<p>A: We pay you the same day we receive your iPhone, or you can choose to wait a week for even more money!</p>
<p>Q: I want to <b>sell my iPad</b>, will you mark down its value?</p>
<p>A: As long as it is as described, we will not mark down its value. If it is not as described, we will give you an adjusted offer which you can accept, or reject to have your iPad returned to you for free.</p>
</div>

<div class="row">
                <div class="col-md-6">
                    <h1><span class="glyphicon glyphicon-thumbs-up"></span> Read our reviews</h1>
                    <p>
                        Check out our reviews on TrustPilot!
                    </p>
<a href="https://www.trustpilot.co.uk/review/www.geckomobilerecycling.co.uk" title="See reviews on https://trustpilot.co.uk"> <script type="text/javascript"> var tpJsHost = (("https:" == document.location.protocol) ? "https://s3.amazonaws.com/trustbox.trustpilot.com/badge/en/5stars/tp_badge-260.png" : "http://trustbox.trustpilot.com/badge/en/5stars/tp_badge-260.png"); document.write(unescape("%3Cimg src="+ tpJsHost + " alt=Trustpilot Badge %3E%3C/img%3E")); </script> </a>                </div>
                <div class="col-md-6">
                    <h1><span class="glyphicon glyphicon-map-marker"></span> Contact Us</h1>
                    <p>
                        If you have any questions don't hesitate to get in touch!
                    </p>
        <span class="c_icon"><img src="/assets/images/contact/icon_contact_sphone_11.png" alt="phone icon" title="Static Phone"></span>
                        <span>Call: 01392 690189</span>
                <br /><br />
        <span class="c_icon"><img src="/assets/images/contact/icon_contact_location_11.png" alt="Address" title="Address"></span>
                        <span>Mail: Queensgate House, 48 Queen Street, Exeter, EX4 3SR</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4 pull-left">
                    <ul class="social-icons xs-hidden">
                         <li><a href="http://plus.google.com/u/0/b/104124105732445360642/104124105732445360642/posts"target="_blank" ><img src="/assets/images/social/google.png" alt="Sell my mobile"/></a></li>
                        <li><a href="http://twitter.com/Gecko_Mobile"target="_blank" ><img src="/assets/images/social/twitter.png" alt="Sell my mobile reviews"/></a></li>
                        <li><a href="http://www.facebook.com/GeckoMobileRecycling"target="_blank" ><img src="/assets/images/social/facebook.png" alt="iPad recycling"/></a></li>
                    </ul>
                </div>
                <div class="col-lg-4 pull-left" style="padding: 10px;">
                   &copy; 2014 Gadget Recycling Ltd. - <a href="/privacy"target="_blank" >Privacy Policy</a>
<p>Registered in England & Wales (Company No. <b>8765449</b>)</p>
                </div>
                <div class="col-lg-4 pull-right">
                    <script type="text/javascript" src="https://sealserver.trustwave.com/seal.js?style=normal"></script>
                    <a href="http://www.checkmend.com/uk/recycle"target="_blank"><img src="/assets/images/CheckMENDLogo.jpg" alt="CheckMend" style="max-width: 130px" class="pull-left"/> </a>
                </div>
            </div>
        </div>
            <hr>

<p class="center">
<a href="/ipad-recycling"target="_blank" >iPad Recycling</a> - <a href="/sell-my-mobile-reviews"target="_blank" >Sell My Mobile Reviews</a> - <a href="/iphone-recycling"target="_blank" >iPhone Recycling</a> - <a href="/sell-my-iphone"target="_blank" >Sell My iPhone</a> - <a href="/sell-my-ipad"target="_blank" >Sell My iPad</a> - <a href="/iphone-trade-in"target="_blank" >iPhone Trade In</a> - <a href="/mobile-recycling"target="_blank" >Mobile Recycling</a> - <a href="/sell-my-mobile"target="_blank" >Sell My Mobile</a> - <a href="/ipad-trade-in"target="_blank" >iPad Trade In</a>
</p>


<div id="social-tabs"></div>
</div>
</div>
<!-- Start of GetKudos Script -->
<script>
(function(w,t,gk,d,s,fs){if(w[gk])return;d=w.document;w[gk]=function(){
(w[gk]._=w[gk]._||[]).push(arguments)};s=d.createElement(t);s.async=!0;
s.src='//static.getkudos.me/widget.js';fs=d.getElementsByTagName(t)[0];
fs.parentNode.insertBefore(s,fs)})(window,'script','getkudos');




getkudos('create', 'gecko_mobile');
</script>
<!-- End of GetKudos Script -->


<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 974242067;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="unknown" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/974242067/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<script type="text/javascript">
adroll_adv_id = "5RQWSI5V4BB4ZBFUOO7B24";
adroll_pix_id = "E24B5MJSYRFYLPWDBJHVIH";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

</body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46885631-1', 'geckomobilerecycling.co.uk');
  ga('send', 'pageview');
</script>

</html>